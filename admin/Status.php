<?php
include 'includes/conn.php';

if(isset($_POST['track'] )){
    $id = mysqli_real_escape_string($conn, $_POST['track']);
    
    $sql = "SELECT q.last_update, q.id, q.vehicle_type, q.status_type as 'status_type', st.name as 'status', q.owner_name, q.vehicle_number from queue q, status_type st where st.id = q.status_type AND (q.vehicle_number = '".$id."' or q.id = '".$id."')";

    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body>
<div class="wrapper">
    <?php include 'includes/nav.php'; ?> <!-- Sidebar -->

    <div class="main">
        <?php include 'includes/navtop.php'; ?> <!-- Top Navbar -->

        <main class="content">
            <div class="container-fluid">
                <!-- Notifications -->
                <div class="d-flex align-items-center justify-content-between bg-dark text-white p-3 rounded mb-3">
                    <div class="notifications">
                        <span class="badge bg-danger">Notifications</span>
                        <span>We are open till 07.00PM from next week</span>
                    </div>
                </div>

                <!-- Search Bar -->
                <form method="POST" action="" class="mb-4">
                    <div class="input-group">
                        <input 
                            type="text" 
                            name="track" 
                            class="form-control" 
                            placeholder="Search Tracking ID or Vehicle Number..."
                            style="background: #ffffff; color: #000;"
                        >
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>

                <!-- Vehicle Status Cards -->
                <div class="row">
                    <?php
                  if (isset($result) && mysqli_num_rows($result) > 0) {
                    while ($track = mysqli_fetch_assoc($result)) {
                        $status = 'primary';

                        if ($track["status_type"] == '2') {
                            $status = 'warning';
                        } else if ($track["status_type"] == '0') {
                            $status = 'danger';
                        } else if ($track["status_type"] == '1') {
                            $status = 'primary';
                        } else if ($track["status_type"] == '4') {
                            $status = 'alert';
                        } else if ($track["status_type"] == '3') {
                            $status = 'success';
                        }
                        echo '<div class="col-12">
                        <div class="card card-' . $status . ' bg-' . $status . '-gradient">
                            <div class="card-body">
                                <h4 class="mb-1 fw-bold text-center">' . $track["vehicle_number"] . ' - ' . $track["status"] . '</h4>
                            </div>
                        </div>
                    </div>';

                    echo '<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Status Updates</div>
                            </div>
                            <div class="card-body">
                                <ol class="activity-feed">';

                    $sqlstatus = "SELECT * FROM status_updates 
                                  JOIN status_type ON status_updates.status_id = status_type.id 
                                  JOIN queue ON status_updates.queue_id = queue.id 
                                  WHERE status_updates.queue_id = '" . $track["id"] . "'";

                    $resultstatus = mysqli_query($conn, $sqlstatus);

                    if (mysqli_num_rows($resultstatus) > 0) {
                        while ($status = mysqli_fetch_assoc($resultstatus)) {
                            $statusId = 'primary';

                            if ($status["status_id"] == '2') {
                                $statusId = 'warning';
                            } else if ($status["status_id"] == '0') {
                                $statusId = 'danger';
                            } else if ($status["status_id"] == '1') {
                                $statusId = 'primary';
                            } else if ($status["status_id"] == '4') {
                                $statusId = 'alert';
                            } else if ($status["status_id"] == '3') {
                                $statusId = 'success';
                            }

                            echo '<li class="feed-item feed-item-' . $statusId . '">
                                <time class="date" datetime="9-25">' . date("F j, Y, g:i a", strtotime($status['time'])) . '</time>
                                <span class="text">Your car wash status is ' . $status["name"] . '. ' . $status['description'] . '</span>
                            </li>';
                        }
                    } else {
                        echo '<li class="feed-item feed-item-' . $status . '">
                            <time class="date" datetime="9-25">' . date("F j, Y, g:i a", strtotime($track['last_update'])) . '</time>
                            <span class="text">Your car wash status is ' . $track["status"] . '</span>
                        </li>';
                    }

                    echo '</ol>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="row" id="dashboard"></div>';
            }
            ?>
                </div>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>
    </div>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>
