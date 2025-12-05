<?php
include 'config.php';
session_start();
$id=$_SESSION['empid'];
$job=$_SESSION['job'];
if(!isset($_SESSION['empid'])){
   header('location:login.php');
}
?>
<?php
$name= mysqli_query($conn,"SELECT substring_index(e.fullName,' ',1) as name,e.image,j.name as jobname,concat(o.address,', ',o.city,', ',o.country)as 'address',u.date_created FROM users u JOIN employee e on u.emp_id=e.emp_id JOIN jobs j on e.job_id=j.job_id join office o on e.office_id=o.office_id WHERE u.id='$id'") ; 
$row = mysqli_fetch_array($name);
?>
<?php
$ammount =mysqli_query($conn,"select format(SUM(balance),'C')  as amount from accounts");
$price = mysqli_fetch_array($ammount);
?>
<?php
$cust =mysqli_query($conn,"SELECT COUNT(id)as 'Customers' FROM `customer`");
$cus = mysqli_fetch_array($cust);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("main/head.php")?>
</head>
<body>
    <div id="app">
        <?php include("main/sidebar.php")?>
        <div id="main" class='layout-navbar'>
            <?php include("main/nav.php")?>
            <div id="main-content">
                
                <div class="page-heading">
                    <h5>Welcome Back <?php echo $row['name']?></h4>
                    <p class="text-subtitle text-muted">This user was created on <?php echo $row['date_created']?></p>
                    <!-- START -->
                    <div class="col-md-12 ">
                        <div class="row ">
                            <div class="col-xl-3 col-lg-6">
                                <div class="card sh l-bg-cherry">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-shipping-fast"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title mb-0 text-white">Parcels</h5>
                                        </div>
                                        <div class="row align-items-center mb-2 d-flex">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white" id="getparcells">
                                                   
                                                </h2>
                                            </div>
                                            <div class="col-4 text-right text-white">
                                                <span>12.5% <i class="fa fa-arrow-up"></i></span>
                                            </div>
                                        </div>
                                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                            <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card sh l-bg-blue-dark">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title mb-0 text-white">Customers</h5>
                                        </div>
                                        <div class="row align-items-center mb-2 d-flex">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white">
                                                <?php echo $cus['Customers']?>
                                                </h2>
                                            </div>
                                            <div class="col-4 text-right text-white">
                                                <span>9.23% <i class="fa fa-arrow-up"></i></span>
                                            </div>
                                        </div>
                                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                            <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card sh l-bg-green-dark">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title mb-0 text-white">Total Expense</h5>
                                        </div>
                                        <div class="row align-items-center mb-2 d-flex">
                                            <div class="col-8">
                                                <h2 id="getexpense" class="d-flex align-items-center mb-0 text-white">
                                                    
                                                </h2>
                                            </div>
                                            <div class="col-4 text-right text-white">
                                                <span>10% <i class="fa fa-arrow-up"></i></span>
                                            </div>
                                        </div>
                                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                            <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card sh l-bg-orange-dark">
                                    <div class="card-statistic-3 p-4">
                                        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                                        <div class="mb-4">
                                            <h5 class="card-title mb-0 text-white">Total Income</h5>
                                        </div>
                                        <div class="row align-items-center mb-2 d-flex">
                                            <div class="col-8">
                                                <h2 class="d-flex align-items-center mb-0 text-white">
                                                    $<?php echo $price['amount']?>
                                                </h2>
                                            </div>
                                            <div class="col-4 text-right text-white">
                                                <span>2.5% <i class="fa fa-arrow-up"></i></span>
                                            </div>
                                        </div>
                                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                            <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($_SESSION['job']== 'JOB001' ) : ?>
                    <div class="row">
                        <div class="col-8">
                            <section class="section">
                                <div class="card">
                                    <div class="card-header">
                                    <h4 class="card-title">PENDING</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table" id="pending">
                                            <thead>
                                                <tr>
                                                    <th>TRACKING NUM</th>
                                                    <th>CUSTOMER NAME</th>
                                                    <th>KG</th>
                                                    <th>PRICE</th>
                                                    <th>STATUS</th>
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
                    
                        <div class="col-4">
                            <section class="section">
                                <div class="card">
                                    <div class="card-header">
                                        
                                        <h4 class="card-title">TOP 5 PAYMENTS</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table" id="paid">
                                            <thead>
                                                <tr>
                                                    <th>CUSTOMER NAME</th>
                                                    <th>PRICE</th>
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
                    </div>
                    <?php endif; ?>
                    <?php if ( $_SESSION['job'] != 'JOB001' ) : ?>
                    <div class="row">
                        <div class="col-12">
                           <section class="section">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-3"><h4 class="card-title">TABLE PRICES</h4></div>
                                            
                                            </div>
                                        </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="table3">
                                            <thead>
                                                <tr>
                                                    <th>ORIGIN OFFICE</th>
                                                    <th>DESTINATION AREA</th>
                                                    <th>COURIER</th>
                                                    <th>PRICE KG</th>
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
                    </div>
                    <?php endif; ?>
                <?php include("main/footer.php")?>
            </div>
        </div>  
    </div>
    
    <script src="assets/js/pages/dashboard.js"></script>
    <?php include("main/script.php");?>
    <script src="js/index.js"></script>
    
    
</body>
<style>
    .card {
    box-shadow: 0 0.16875rem 1.1875rem rgba(90,97,105,0.1);
}
    .card {
    background-color: #fff;
    border-radius: 10px;
    border: none;
    position: relative;
    margin-bottom: 30px;
}
.sh {
    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
}
.l-bg-cherry {
    background: linear-gradient(to right, #2B2580, #4286f4) !important;
    color: #fff;
}

.l-bg-blue-dark {
    background: linear-gradient(to right, #373b44, #4286f4) !important;
    color: #fff;
}

.l-bg-green-dark {
    background: linear-gradient(to right, #0a504a, #38ef7d) !important;
    color: #fff;
}

.l-bg-orange-dark {
    background: linear-gradient(to right, #a86008, #ffba56) !important;
    color: #fff;
}

.card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
    font-size: 110px;
}

.card .card-statistic-3 .card-icon {
    text-align: center;
    line-height: 50px;
    margin-left: 15px;
    color: #000;
    position: absolute;
    right: -5px;
    top: 20px;
    opacity: 0.1;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #43e794 100%) !important;
    color: #fff;
}

.l-bg-green {
    background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
    color: #fff;
}

.l-bg-orange {
    background: linear-gradient(to right, #f9900e, #ffba56) !important;
    color: #fff;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
}
</style>
</html>
























