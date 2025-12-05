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
                                    <div class="col-3"><h4 class="card-title">Sub Menues</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3  text-right ">
                                        <a class="btn btn-primary" id="btnadd">Add Sub Menues</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID#</th>
                                            <th>MAIN MENU</th>
                                            <th>SUB MENUE </th>
                                            <th>URL</th>
                                            <th class="text-end">ACTION</th>
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
<div class="modal fade text-left modal-borderless" id="SubModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SUB MENUES</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="SubForm" enctype="multi-part/form-data">
            <div class="modal-body">

                <div class="form-group">
                    <label>Main Menu ID</label>
                    <input type="hidden" name="update_id" id="update_id">
                    <select class="form-control" name="menue" id="menue" required>
                        <option selected value="0">Select Main Menue</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Text</label>
                    <input type="text" class="form-control" name="text" id="text" placeholder="Enter Sub Menue Text" required>
                </div>
                <div class="form-group">
                    <label>Url</label>
                    <select class="form-control" name="url" id="url" required>
                        <option selected value="0">Select Url</option>
                    </select>
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
    <script src="js/sub_menues.js"></script>
</body>
</html>


