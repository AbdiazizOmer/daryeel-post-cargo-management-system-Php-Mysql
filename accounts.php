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
                                    <div class="col-3"><h4 class="card-title">ACCOUNTS</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3  text-right ">
                                        <a class="btn btn-primary" id="btnadd">Add New Accounts</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ACCID#</th>
                                            <th>BANK NAME</th>
                                            <th>ACC-NUM</th>
                                            <th>COUNTRY</th>
                                            <th>STATUS</th>
                                            <th>BALANCE</th>
                                            <th>Action</th>
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
<div class="modal fade text-left modal-borderless" id="accounMoal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ACCOUNTS MODAL</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="accountForm">
            <div class="modal-body">
                
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="hidden" name="update_id" id="update_id">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Bank Name" required>
                    </div>
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="number" class="form-control numvalidate" name="accnum" id="accnum" placeholder="Enter Account Number" required>
                    </div>
                    <div class="form-group">
                        <label>Counry</label>
                        <input type="text" class="form-control" name="country" id="country" placeholder="Enter Country" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" id="status">
                            <option>Active</option>
                            <option>InActive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ammount</label>
                        <input type="number" class="form-control numvalidate" name="amount" id="amount" placeholder="Enter Amount Balance" required>
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
    <script src="js/accounts.js"></script>
</body>
</html>


