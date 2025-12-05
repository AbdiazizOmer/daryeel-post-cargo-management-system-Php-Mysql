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
        .card {
    box-shadow: 0 0.16875rem 1.1875rem rgba(90,97,105,0.1);
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
                                    <div class="col-3"><h4 class="card-title">BILLS REPORT</h4></div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <span class="d-block m-t-5"> <code></code> </span>
                                <form id="pracelform">

                                <div class="row">
                                    <div class="col-sm-4">
                                    <select name="type" id="type" class="form-control">
                                        <option value="0">All</option>
                                        <option value="custom">custom</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-5">
                                    <input type="text" name="tellphone" id="tellphone" class="form-control">
                                    </div>


                                    <div class="col-sm-4">
                                    <button type="submit" id="Adddnew" class="btn btn-primary m-3">Add To Table</button>
                                    </div>
                                </div>
                                </form>

                                <div class="row">
                                <div class="table-responsive" id="prinT_Area">
                                    <img width="100%" ; height="300px" src="img/print.svg" class="mb-3">

                                    <table class="table" id="pracelreport">
                                    <thead>

                                    </thead>
                                    <tbody>


                                    </tbody>

                                    </table>

                                </div>
                                <div class="col-sm-4">
                                    <button id="printtstatement" class="btn btn-success ml-1"><i class="fa fa-print"></i>print</button>
                                    <button id="exporttstatement" class="btn btn-secondary mr-4"><i class="fa fa-file"></i>Export</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <?php include("main/footer.php")?>
            </div>
        </div>  
    </div>

    <?php include("main/script.php");?>
    <script src="js/bills_rpt.js"></script>
</body>
</html>


