<?php
include 'includes/head.php';
include 'includes/functions.php';

// Fetch existing vehicle data
$vehicle_list_query = "SELECT q.id, q.vehicle_number, q.owner_name, vt.name AS vehicle_type, st.type AS service_type, q.in_time
                       FROM queue q
                       LEFT JOIN vehicle_type vt ON q.vehicle_type = vt.id
                       LEFT JOIN service_type st ON q.service_type = st.id
                       ORDER BY q.in_time DESC";
$vehicle_list = mysqli_query($conn, $vehicle_list_query);
?>

<!DOCTYPE html>
<html lang="en">
<body>
<div class="wrapper">
    <?php include 'includes/nav.php'; ?>
    <div class="main">
        <?php include 'includes/navtop.php'; ?>
        <main class="content">
            <div class="container-fluid p-0">
                <h1 class="h3 mb-3">Vehicle Dashboard</h1>

                <!-- Vehicle Cards -->
                <div class="row">
                    <?php
                    if (mysqli_num_rows($vehicle_list) > 0) {
                        while ($row = mysqli_fetch_assoc($vehicle_list)) {
                            echo '
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>' . htmlspecialchars($row['vehicle_number']) . '</h5>
                                        <span class="badge bg-primary">' . htmlspecialchars($row['vehicle_type']) . '</span>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Customer:</strong> ' . htmlspecialchars($row['owner_name']) . '</p>
                                        <p><strong>Wash Type:</strong> ' . htmlspecialchars($row['service_type']) . '</p>
                                        <p><strong>Registered On:</strong> ' . htmlspecialchars($row['in_time']) . '</p>
                                    </div>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '<div class="col-12"><p class="text-center">No vehicle data available.</p></div>';
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
