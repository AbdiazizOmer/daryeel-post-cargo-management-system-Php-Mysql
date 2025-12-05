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
                                    <div class="col-3"><h4 class="card-title">PAYMENT</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3  text-right ">
                                        <a class="btn btn-primary" id="btnadd">MAKE PAYMENT</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID#</th>
                                            <th>CUSTOMER NAME</th>
                                            <th>TOTAL</th>
                                            <th>PAID</th>
                                            <th>BALANCE</th>
                                            <th>BANK NAME</th>
                                            <th>METHOD</th>
                                            <th>DATE PAYMENT</th>
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
<div class="modal fade text-left modal-borderless" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PAYMENT</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="paymentForm">
            <div class="modal-body">
                <input type="hidden" name="update_id" id="update_id">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Customer Name</label>
                            <select name="customer_idd" id="customer_idd" class="form-control customer_name contrl">
                                <option value="0">select customer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control amount" readonly>                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Amount Paid</label>
                            <input type="number" name="amount_paid" id="amount_paid" class="form-control amount_paid numvalidate" onkeyup="subt()" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Balance</label>
                            <input type="number" name="balance" id="balance" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Bank Name</label>
                            <select name="Accountt_id" id="Accountt_id" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Method Name</label>
                            <select name="p_method_id" id="p_method_id" class="form-control" required>

                            </select>
                        </div>
                    </div>
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
    <script src="js/payment.js"></script>
</body>
</html>


