<?php
include 'config.php';
session_start();
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
                                    <div class="col-3"><h4 class="card-title">INVOICE</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3  text-right ">
                                        <a class="btn btn-primary" id="btnadd">Make Invoice</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>INVD#</th>
                                            <th>REF NUMBER</th>
                                            <th>CUSTOMER NAME</th>
                                            <th>DUE DATE</th>
                                            <th>TOTAL</th>
                                            <th>STATUS</th>
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
        
        
         <!-- INSERT MODAL -->
    <div class="modal fade text-left modal-borderless" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">INVOICE</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="invoiceForm">
                <div class="modal-body">
                    
                        <div class="form-group">
                            <label>Customer</label>
                            <input type="hidden" name="update_id" id="update_id">
                            <input type="hidden" class="form-control"  name="date_iss" id="date_iss" value="<?php echo (date("Y-m-d")); ?>" >
                            <select class="form-control" name="cname" id="cname" required>
                                <option disabled selected>Select Customer</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Invoice ID</label>
                                    <input type="text" class="form-control" name="idup" id="idup" readonly>
                                    <input type="text" class="form-control" name="id" id="id" readonly required>
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reference Number</label>
                                    <input type="text" class="form-control" name="num" id="num" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Total Invoice</label>
                                    <input type="text" class="form-control" name="price" id="price" readonly required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <select class="form-control" name="currency" id="currency" required>
                                        <option value="USD" selected>USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                                        
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary"  onclick="window.location.href='invoice.php'">
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
    </div>
<!--PRINT///////////////////////////////////////////////////////////////////////-->
<?php
$name= mysqli_query($conn,"SELECT o.phone,concat(o.address,', ',o.city,', ',o.country) as 'address' FROM users u 
JOIN employee e
	ON u.emp_id=e.emp_id
JOIN office o
	ON o.office_id=e.office_id WHERE u.id='$id'"); 
$row = mysqli_fetch_array($name);

?>
<div id="printarea" hidden class="container-fluid w-100">
    <div class="row">
        <div class="col-lg-12">
            <div class="card cards">
                <div class="card-body">
                    <div class="invoice-title">
                        <div class="row">
                            <div class="col-8">
                                <div class="mb-4 img" >
                                    <img src="assets/images/logo/logopr.svg" style="width: 60%;">
                                </div>
                            </div>
                            <div class="col-4">
                                <h1 class="float-end font-size-30 mt-3">INVOICE</h1><br>
                            </div>
                        </div>
                        
                        <div class="text-muted">
                            <p class="mb-1"><?php echo $row['address']?></p>
                            <p class="mb-1"><?php echo $row['phone']?></p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Sender</h5>
                                <p class="mb-1" id="costname"></p>
                                <p class="mb-1" id="costaddress"></p>
                                <p id="costtell"></p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-muted text-sm">
                                <h5 class="font-size-16 mb-3">Reciever</h5>
                                <p class="mb-1" id="rename"></p>
                                <p class="mb-1" id="readd"></p>
                                <p id="retell"></p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">InvoiceID#:</h5>
                                    <p id="inid"></p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                    <p id="indate"></p>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    
                    <div class="py-2">
                        <h5 class="font-size-15">Order Summary</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                    <!--  -->
                                        <th >Departure</th>
                                        <th>Distination</th>
                                        <th>Price per Kg</th>
                                        <th style="width: 70px;">Kg</th>
                                        <th class="text-end" style="width: 120px;">Total</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    <tr>
                                        <td><p id="dep"></p></td>
                                        <td><p id="dis"></p></td>
                                        <td><p id="tbp"></p></td>
                                        <td><p id="kg"></p></td>
                                        <td class="text-end"><p id="totall"></p></td>
                                    </tr>
                                    <!-- end tr -->
                                    <tr>
                                        <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                        <td class="border-0 text-end mt-4"><h5 style="display: inline;">$ <p style="display: inline;" class="mt-3" id="totalll"></p></h5></td>
                                    </tr>
                                    <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div>
</div>          

<style>
body{margin-top:20px;

}
.container {
    width: 100%;
}
.cards {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: 1rem;
}
</style>
    



    <?php include("main/script.php");?>
    <script src="js/invoice.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</body>
</html>


