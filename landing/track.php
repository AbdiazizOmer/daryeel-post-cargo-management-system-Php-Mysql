<!DOCTYPE html>
<html lang="en">

<head>
<?php include 'include/head.php'?>
</head>

<body>
  

  <!-- ======= Header ======= -->
  <?php include 'include/header.php'?>
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('assets/img/page-header.jpg');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
              <h2>Track</h2>
              <p>Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li>Track</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container" data-aos="fade-up">
        <div class="row gy-4">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <div class="input-group">
                            <input type="search" id="search" name="search" style="margin-right: 5px;" class="form-control form-control-lg" placeholder="Enter Tracking Number">
                            <div class="input-group-append">
                            <button class="btn btn-primary btn-lg mr-2" id="trackbtn" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                            <button class="btn btn-secondary btn-lg" id="btncancel" onclick="ClearFields();" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
                <div class="row mt-3">
                    <!-- ///Track Satrt -->
                    <form id="track">
                      <div class="container">
                          <article class="card cards">
                              <header class="card-header"> My Order Tracking </header>
                              <div class="card-body">
                                  <h6 style="display:inline;">Tracking Number: <p id="trckid" style="display:inline;"></p></h6>
                                  <article class="card">
                                      <div class="card-body row">
                                          <div class="col"> <strong>Customer Name:</strong> <br><p id="cname"></p> </div>
                                          <div class="col"> <strong>Receipt Name:</strong> <br><p id="rname"></p> </div>
                                          <div class="col"> <strong>Customer Phone:</strong> <br><i class="fa fa-phone"></i> <p id="ctell" style="display:inline;"></p> </div>
                                          <div class="col"> <strong>Status:</strong> <br><p id="status"></p> </div>
                                          <div class="col"> <strong>Payment Status #:</strong> <br> <p id="payment"></p></div>
                                      </div>
                                  </article>
                                  <div class="track">
                                      <div class="step " id="step1"> <span class="icon"> <i class="fa fa-clock"></i> </span> <span class="text">Pending</span> </div>
                                      <div class="step " id="step2"> <span class="icon"> <i class="fa fa-clipboard-check"></i> </span> <span class="text">Order confirmed</span> </div>
                                      <div class="step " id="step3"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Prepare Order</span> </div>
                                      <div class="step " id="step4"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text">On the way </span> </div>
                                      <div class="step " id="step5"> <span class="icon"> <i class="fa fa-warehouse"></i> </span> <span class="text">Arrived At Destination</span> </div>
                                      <div class="step " id="step6"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Delivered</span> </div>
                                  </div>
                              </div>
                          </article>
                      </div>
                  </form>
                    <!-- ///Track End -->
                </div>

        </div>

      </div>
    </section><!-- End Pricing Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include 'include/foooter.php'?>
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <?php include 'include/script.php'?>
  <script src="track.js"></script>

</body>
<style>    
        .container{
            margin-top:50px;
            margin-bottom: 50px
        }
        
        
        .track{
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 60px;
            margin-top: 50px
        }
        .track .step{-webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }
        .track .step.active:before{
            background: #2c3e50;
        }
        .track .step::before{
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }
        .track .step.active .icon{
            background: #2c3e50;
            color: #fff
        }
        .track .icon{
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }
        .track .step.active .text{
            font-weight: 400;
            color: #000
        }
        .track .text{
            display: block;
            margin-top: 7px
        }
        
    </style>

</html>