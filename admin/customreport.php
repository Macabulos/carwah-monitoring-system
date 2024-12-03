<?php
include 'includes/conn.php';

// Handle form submission for custom report filters
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Query to fetch data based on date filter
$sql = "SELECT * FROM queue WHERE 1";

if ($startDate && $endDate) {
    $sql .= " AND last_update BETWEEN '$startDate' AND '$endDate'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
   <?php include 'includes/head.php'; ?>
   <body>
      <div class="wrapper">
         <?php include 'includes/nav.php'; ?>
         <div class="main">
            <?php include 'includes/navtop.php'; ?>
            <main class="content">
               <div class="container-fluid p-0">
                  <div class="row">
                     <!-- Custom Report Section -->
                     <div class="col-12">
                        <div class="card">
                           <div class="card-header">
                              <h5 class="card-title mb-0">Custom Report</h5>
                           </div>
                           <div class="card-body">
                              <!-- Report Filter Form -->
                              <form method="POST" action="">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <label for="start_date">Start Date</label>
                                       <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $startDate; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                       <label for="end_date">End Date</label>
                                       <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $endDate; ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                       <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Generate Report</button>
                                    </div>
                                 </div>
                              </form>
                              <hr>
                              
                              <!-- Custom Report Data Table -->
                              <?php if (mysqli_num_rows($result) > 0): ?>
                              <table class="table table-striped">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Vehicle Number</th>
                                       <th>Owner Name</th>
                                       <th>Status</th>
                                       <th>Last Update</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                       <td><?php echo $row['id']; ?></td>
                                       <td><?php echo $row['vehicle_number']; ?></td>
                                       <td><?php echo $row['owner_name']; ?></td>
                                       <td><?php echo $row['status_type']; ?></td>
                                       <td><?php echo date('F j, Y, g:i a', strtotime($row['last_update'])); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                 </tbody>
                              </table>
                              <?php else: ?>
                                 <p>No records found for the selected date range.</p>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </main>
            <?php include 'includes/footer.php'; ?>
         </div>
      </div>
      <?php include 'includes/scripts.php'; ?>
   </body>
</html>
