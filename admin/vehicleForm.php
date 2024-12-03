<?php
include 'includes/head.php';
include 'includes/functions.php';

$message = ''; // Initialize $message to avoid undefined variable warning

$vehicle_typesql = "SELECT * FROM vehicle_type";
$service_typesql = "SELECT * FROM service_type";

$vehicle_type = mysqli_query($conn, $vehicle_typesql);
$service_type = mysqli_query($conn, $service_typesql);

if (isset($_POST['submit'])) {
    // Get and sanitize inputs
    $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $owner_address = mysqli_real_escape_string($conn, $_POST['owner_address']);
    $vehicle_type2 = mysqli_real_escape_string($conn, $_POST['vehicle_type']);
    $vehicle_number = mysqli_real_escape_string($conn, $_POST['vehicle_number']);
    $service_type2 = mysqli_real_escape_string($conn, $_POST['service_type']);
    $datum = new DateTime();
    $in_time = $datum->format('Y-m-d H:i:s');

    // Optional fields
    $owner_email = !empty($_POST['owner_email']) ? mysqli_real_escape_string($conn, $_POST['owner_email']) : null;
    $owner_phone = !empty($_POST['owner_phone']) ? mysqli_real_escape_string($conn, $_POST['owner_phone']) : null;

    // Validate the customer name (no numbers allowed)
    if (!preg_match("/^[a-zA-Z\s]+$/", $owner_name)) {
        $message = "Customer name should only contain letters and spaces.";
    }
    // Validate the vehicle number (only alphanumeric characters)
    elseif (!preg_match("/^[a-zA-Z0-9]+$/", $vehicle_number)) {
        $message = "Vehicle number should only contain alphanumeric characters.";
    }
    // Validate the phone number (if provided, maximum length of 15 characters)
    elseif ($owner_phone && strlen($owner_phone) > 15) {
        $message = "Phone number cannot be more than 15 characters.";
    }
    // Check if 'Choose...' was selected for vehicle_type or service_type
    elseif ($vehicle_type2 == 'Choose...' || $service_type2 == 'Choose...') {
        $message = "Please select a valid vehicle type and service type.";
    } else {
        // Insert data into the database
        $insert = "INSERT INTO queue (owner_email, owner_name, owner_phone, owner_address, vehicle_type, vehicle_number, service_type, in_time) 
                   VALUES ('$owner_email', '$owner_name', '$owner_phone', '$owner_address', '$vehicle_type2', '$vehicle_number', '$service_type2', '$in_time')
                   ON DUPLICATE KEY UPDATE owner_email=IFNULL('$owner_email', owner_email), owner_name='$owner_name', owner_phone=IFNULL('$owner_phone', owner_phone), owner_address='$owner_address', service_type='$service_type2'";

        if (mysqli_query($conn, $insert)) {
            $message = "Vehicle Information Added.";

            // Send email if provided
            if (!empty($owner_email)) {
                try {
                    $subject = "Duck'z Detailing & Car Wash | Your Carwash Initialized!";
                    $id_get = mysqli_query($conn, "SELECT * FROM status_type WHERE id='1' LIMIT 1");
                    $id = mysqli_fetch_array($id_get);
                    $description = "The status of your carwash is " . $id['name'];

                    if (sendMail($owner_email, $subject, $owner_name, $description, $vehicle_number)) {
                        $message .= " Tracking information sent to the customer's email.";
                    } else {
                        $message .= " Failed to send tracking information to the customer.";
                    }
                } catch (Exception $e) {
                    $message .= " Email sending failed.";
                }
            }
        } else {
            $message = "Error: " . $insert . "<br>" . mysqli_error($conn);
        }
    }
}


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
                  <h1 class="h3 mb-3">Add New Vehicle</h1>
                  <div class="row">
                     <div class="col-12">
                        <div class="card">
                           <div class="card-header">
                              <h5 class="card-title mb-0"><?php echo $message; ?></h5>
                           </div>
                           <div class="card-body">
                           <form action="" method="POST">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="owner_name">Customer Name</label>
            <input type="text" name="owner_name" class="form-control" placeholder="Customer Name" required>
        </div>
        <div class="form-group col-md-3">
            <label for="vehicle_number">Vehicle Number</label>
            <input type="text" class="form-control" name="vehicle_number" placeholder="Vehicle Number" required>
        </div>
        <div class="form-group col-md-3">
            <label for="vehicle_type">Vehicle Type</label>
            <select name="vehicle_type" class="form-control" required>
                <option selected disabled>Choose...</option>
                <?php
                if (mysqli_num_rows($vehicle_type) > 0) {
                    while ($type = mysqli_fetch_assoc($vehicle_type)) {
                        echo '<option value="' . $type["id"] . '">' . $type["name"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="service_type">Wash Type</label>
            <select name="service_type" class="form-control" required>
                <option selected disabled>Choose...</option>
                <?php
                if (mysqli_num_rows($service_type) > 0) {
                    while ($servicetype = mysqli_fetch_assoc($service_type)) {
                        echo '<option value="' . $servicetype["id"] . '">' . $servicetype["type"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="owner_email">Email</label>
            <input type="email" class="form-control" name="owner_email">
        </div>
        <div class="form-group col-md-2">
            <label for="owner_phone">Phone Number</label>
            <input type="text" class="form-control" name="owner_phone" maxlength="15">
        </div>
    </div>

    <div class="form-group">
        <label for="owner_address">Address</label>
        <textarea class="form-control" name="owner_address" placeholder="" required></textarea>
    </div>
    <button name="submit" type="submit" class="btn btn-primary">Add Vehicle</button>
</form>


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
