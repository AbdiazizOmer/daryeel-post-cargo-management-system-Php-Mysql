<?php
include 'config.php';
session_start();
include 'check_User_Permission.php';
read_actions();
$id=$_SESSION['empid'];
if(!isset($_SESSION['empid'])){
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
        #show{
            width: 90px;
            height: 90px;
            border: solid 1px #744547;
            border-radius: 50%;
            object-fit: cover;
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
                                    <div class="col-3"><h4 class="card-title">USERS</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3  text-right ">
                                        <a class="btn btn-primary" id="btnadd">Add New user</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <table class="table" id="table1">
                                    <thead></thead>
                                    <tbody></tbody>
                                    
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
<div class="modal fade text-left modal-borderless" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">USER MODAL</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="userForm" enctype="multi-part/form-data">
            <div class="modal-body">

                <div class="form-group">
                    <label>Employee</label>
                    <input type="hidden" name="update_id" id="update_id">
                    <select class="form-control" name="emp_id" id="emp_id" ></select>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter UserName" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
                        </div>
                    </div>
                </div>
                        
                
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status" >
                        <option>Active</option>
                        <option>InActive</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-10">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image" id="image" >
                        </div>
                    </div>
                    <div class="col-2"><img id="show"></div>
                </div>
                
               
                    
                
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" onClick="window.location.reload();" data-bs-dismiss="modal">
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
    <script src="js/user.js"></script>
</body>
</html>


