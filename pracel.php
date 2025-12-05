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
        #close{
            margin-top: 80px;
            float: right;
        }
        #closee{
            float: right;
            margin-right: 5px;
        }
        .callout {
            padding: 7px;
            margin: 7px 0;
            border-left: 4px solid #9CA1A2;
            border-right: 1px solid #eee;
            border-bottom: 2px solid #eee;
            border-top: 1px solid #eee;
            border-left-width: 5px;
            border-radius: 3px;
        }
        #update_status:hover { background-color: #fff }
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
                                    <div class="col-3"><h4 class="card-title">PRACELLS</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                    <div class="col-3  text-right ">
                                        <a class="btn btn-primary" id="btnadd">Add New Parcel</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>REF NUMBER</th>
                                            <th>CUSTOMER NAME</th>
                                            <th>WEIGHT</th>
                                            <th>Price</th>
                                            <th>TRACK STATUS</th>
                                            <th>STATUS</th>
                                            <th>ACTION</th>
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
<div class="modal fade text-left modal-borderless" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            
            <form id="jobinsertform">
                <div class="modal-body text-black">
                    
                    <div class="container-fluid">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                <input type="hidden" id="updateid">
                                    <div class="callout callout-info">
                                        <dl>
                                            <dt class="mt-3">Tracking Number:</dt>
                                            <dd> <h4><b id="trid"></b></h4></dd>
                                            
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="callout callout-info">
                                        <b class="border-bottom border-primary  mb-2">Sender Information</b>
                                        <dl>
                                            <dt class=" mt-2">Name:</dt>
                                            <dd><p id="sname"></p></dd>
                                            <dt>Address:</dt>
                                            <dd><p id="add"></p></dd>
                                            <dt>Contact:</dt>
                                            <dd><p id="tel"></p></dd>
                                        </dl>
                                    </div>
                                    <div class="callout callout-info">
                                        <b class="border-bottom border-primary">Recipient Information</b>
                                        <dl>
                                            <dt class=" mt-2">Name:</dt>
                                            <dd><p id="rname"></p></dd>
                                            <dt>Address:</dt>
                                            <dd><p id="radd"></p></dd>
                                            <dt>Contact:</dt>
                                            <dd><p id="rtel"></p></dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="callout callout-info">
                                        <b class="border-bottom border-primary">Parcel Details</b>
                                            <div class="row">
                                                <div class="col-sm-6 mt-2">
                                                    <dl>
                                                        
                                                        <dt>Wight:</dt>                                               
                                                        <dd><p id="weight"></p></dd>
                                                        <dt>Price:</dt>
                                                        <dd><p id="price">$ </p></dd>
                                                    </dl>	
                                                </div>
                                                <div class="col-sm-6 mt-2">
                                                    <dl>
                                                        <dt>Item Name:</dt>
                                                        <dd><p id="height"></p></dd>
                                                        <dt>Courier:</dt>
                                                        <dd><p id="courier"></p></dd>
                                                    </dl>	
                                                </div>
                                            </div>
                                        <dl>
                                            <dt>Origin:</dt>
                                            <dd><p id="fromm"></p></dd>
                                            
                                            <dt>Destination:</dt>
                                            <dd><p id="too"></p></dd>
                                        </dl>
                                        <dl>
                                            <dt>Status:</dt>
                                            <dd><p id="paidd"></p></dd>
                                        </dl>
                                        <div class="row">
                                            <div class="col-6">
                                                
                                                <dl>
                                                    <dt>Tarck Status:</dt>
                                                    <dd><p id="status"></p></dd>
                                                </dl>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <dl>
                                                    <dt></dt>
                                                    <dd><span class="btn badge bg-primary " id='update_status'><i class="fa fa-edit"></i> Update Status</span></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6"></div>
                                        <div class="col-6">
                                            <button type="button" id="close" class="btn btn-primary" onclick="window.location.reload();" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Close</span>
                                            </button>
                                            <a href="javascript:void(0);" class="btn btn-success" onclick="printPageArea('jobinsertform')" style="margin-top: 80px; float: right; margin-right:20px;"><i class="fa fa-print"></i> Print</a>
                                        </div>
                                    
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 <!--END INSERT MODAL -->
 <!--Basic Modal -->
 <div class="modal fade text-left" id="statusUpdate" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel1">Update Status</h5>
            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                aria-label="Close">
                <i data-feather="x"></i>
            </button>
        </div>
        <form id="updatestatus">
        <div class="modal-body">
            <div class="form-group">
                <label>Status</label>
                <input type="hidden" id="update_id" name="update_id">
                <select class="form-control" name="status" id="status" >
                    <option value="1">Pending</option>
                    <option value="2">Order Confirmed</option>
                    <option value="3">Prepare Order</option>
                    <option value="4">On the way</option>
                    <option value="5">Arrived At Destination</option>
                    <option value="6">Delivered</option>
                    <option value="7">Canceled</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" id="btnclose">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Update</span>
            </button>
        </div>
        </form>
    </div>
</div>
</div>

<!--Basic Modal -->
<div class="modal fade text-left" id="PracelModel" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel1">PARCEL</h5>
            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                aria-label="Close">
                <i data-feather="x"></i>
            </button>
        </div>
        <form id="pracelForm">
            <div class="modal-body">
            <div class="row mt-2">
                <div class="col-md-6">
                    <h5 class="text-center">Customer Detials</h5>
                    <div class="form-group">
                        <label for="basicInput">Customer Name</label>
                        <input type="hidden" id="update_idd" name="update_idd">
                        <input type="hidden" class="form-control"  name="uid" id="uid" value="<?php echo $id ?>" >
                        <input type="hidden" class="form-control" name="status" id="status" value="1">
                        <input type="hidden" class="form-control"  name="date" id="date" value="<?php echo (date("Y-m-d")); ?>" >
                        <select class="form-control contrl" name="cnamee" id="cnamee">
                            <option selected value="0">Select Customer Name</option>
                        </select>
                    </div>

                    
                </div>
                <div class="col-md-6">
                <h5 class="text-center">Reciever Detials</h5>
                <div class="form-group">
                        <label for="basicInput">Reciver Name</label>
                        <input type="text" class="form-control validate" name="renamee" id="renamee" placeholder="Enter Reciver Name" required>
                    </div>

                    <div class="form-group">
                        <label for="basicInput">Reciver Tell</label>
                        <input type="number" class="form-control numvalidate" name="rtelll" id="rtelll" placeholder="Enter Reciver Tell" required>
                    </div>

                    <div class="form-group">
                        <label for="basicInput">Reciver Address</label>
                        <input type="text" class="form-control" name="raddresss" id="raddresss" placeholder="Enter Reciver Address" required>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <h5 class="text-center">Shipping Detials</h5>
                <div class="col-md-4 mt-2">
                    <div class="form-group">
                        <label for="basicInput">Origin Office</label>
                        <select class="form-control contrl" name="dep" id="dep" required>
                            <option selected value="0">Select Origin Office</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="basicInput">Weight</label>
                        <input type="number" class="form-control numvalidate" name="weightt" id="weightt" placeholder="Enter weight" required>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-group">
                        <label for="basicInput">Destination Area</label>
                        <select class="form-control contrl" name="dist" id="dist" required>
                        <option selected value="0">Select Destination Office</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="basicInput">Item Name</label>
                        <input type="text" class="form-control" name="heightt" id="heightt" placeholder="Enter Item Name" required>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-group">
                        <label for="basicInput">Courior</label></label>
                        <select class="form-control contrl" name="typee" id="typee" required>
                        <option selected value="0">Select Courier</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="basicInput">Total Price</label></label>
                        <input type="float" class="form-control" name="pricee" id="pricee" readonly >
                        

                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3"></div>
                <div class="col-3"></div>
                <div class="col-3"></div>
                <div class="col-3 text-right">
                <button type="submit" id="btnadd" class="btn btn-primary">Save & Changes</button>
                    <button type="button" id="closee"class="btn btn-light-primary" onclick="window.location.href='pracel.php'">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
</div>





    <?php include("main/script.php");?>
    <script src="js/pracel.js"></script>
<script>
    function printPageArea(jobinsertform){
    let printContent = document.getElementById(jobinsertform).innerHTML;
    let originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;

    }
</script>
    
</body>
</html>


