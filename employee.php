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
                                    <div class="col-3"><h4 class="card-title">List Of Employee</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3  text-right ">
                                        <a class="btn btn-primary" id="btnadd">Add New Employee</a>
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
<div class="modal fade text-left modal-borderless" id="employeeemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EMPLOYEE MODAL</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="Employeeform" enctype="multi-part/form-data">
            <div class="modal-body">

                <div class="form-group">
                    <label>FullName</label>
                    <input type="hidden" name="update_id" id="update_id">
                    <input type="text" class="form-control validate" name="name" id="name" placeholder="Enter fullName" required>
                </div>
                <div class="row">
                    <div class="col-6">
                    <div class="form-group">
                            <label>Adderss</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Enter address" required>
                        </div>
                    </div>
                    <div class="col-6">
                    <div class="form-group">
                            <label>Tell</label>
                            <input type="number" class="form-control numvalidate" name="tell" id="tell" placeholder="Enter Tell" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                    <div class="form-group">
                            <label>Office</label>
                            <select class="form-select" id="office_id" name="office_id"></select>
                        </div>
                    </div>
                    <div class="col-6">
                    <div class="form-group">
                            <label>Job</label>
                            <select class="form-select" id="job_id" name="job_id"></select>
                        </div>
                    </div>
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
    <script src="js/employee.js"></script>
</body>
</html>


