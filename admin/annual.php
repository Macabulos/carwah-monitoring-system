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
                     <!-- Annual Report Section -->
                     <div class="col-12">
                        <div class="card">
                           <div class="card-header">
                              <h5 class="card-title mb-0">Annual Stats</h5>
                           </div>
                           <div class="card-body">
                               <canvas id="annualChart"></canvas>
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
      <?php include 'includes/loadbarannual.php';?>
   </body>
</html>
