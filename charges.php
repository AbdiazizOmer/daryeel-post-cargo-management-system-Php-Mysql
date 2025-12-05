<?php
include 'config.php';
session_start();
include 'check_User_Permission.php';
read_actions();
$id=$_SESSION['empid'];
if(isset($_SESSION['empid'])){

}else{
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("main/head.php")?>
    <style>
        #btnadd{
            float: right;
        }
    </style>
</head>
<body>
    <div id="app">
        <?php include("main/sidebar.php")?>
        <div id="main" class='layout-navbar'>
            <?php include("main/nav.php")?>
            <div id="main-content">
                
                <div class="page-heading">
                    <div class="page-title">
                        
                    </div>
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-3"><h4 class="card-title">CHARGES</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3  text-right ">
                                        <a class="btn btn-primary" id="btnadd">Add New Charge</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID#</th>
                                            <th>EMPLOYEE   NAME</th>
                                            <th>JOB NAME</th>
                                            <th>SALARY</th>
                                            <th>MONTH</th>
                                            <th>YEAR</th>
                                            <th>DISCRIPTION</th>
                                            <th>ACCOUNT NAME</th>
                                            <th>USER</th>
                                            <th class="text-end">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            

                                        </tr>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
                <?php include("main/footer.php")?>
            </div>
        </div>  
    </div>
    

    

 <!-- INSERT MODAL -->
<div class="modal fade text-left modal-borderless" id="chargeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CHARGE MODAL</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="chargeForm">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Month</label>
                            <input type="hidden" name="update_id" id="update_id">
                            <input type="hidden" value="<?php echo $id?>" name="user_id" id="user_id">
                            <select class="form-control contrl" name="month" id="month">
                                <option selected value="0">Select Month</option>
                                <?php
                                
                                $months = array(
                                    "January",
                                    "February",
                                    "March",
                                    "April",
                                    "May",
                                    "June",
                                    "July",
                                    "August",
                                    "September",
                                    "October",
                                    "November",
                                    "December"
                                  );
                                  
                                  // Loop through the array and create a select tag for each month
                                  foreach ($months as $month) {
                                    echo "<option value='$month'>$month</option>";
                                  }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Year</label>
                            <select class="form-control contrl" name="year" id="year">
                            <option selected value="0">Select Year</option>
                                <?php
                                    $start_year = 2000; // set the starting year 
                                    $current_year = date('Y'); // get the current year 
                                    for ($year = $current_year; $year >= $start_year; $year--) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>
                    
                    
                    <div class="form-group">
                        <label>Discription</label>
                        <input type="text" class="form-control contrl" name="dis" id="dis" placeholder="Enter Discription" required>
                    </div>
                    <div class="form-group">
                        <label>Account</label>
                        <select class="form-control" name="account_id" id="account_id">
                            <option selected value="0">Select Account</option>
                        </select>
                    </div>
                
            </div>
            <div class="modal-footer">
                    <button type="button" onClick="window.location.reload();" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">Save & Cahnges</button>
                    </div>
            </form>
        </div>
    </div>
</div>
 <!--END INSERT MODAL -->





    <?php include("main/script.php");?>
    <script src="js/charges.js"></script>
</body>
</html>


