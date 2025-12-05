<?php

@include 'config.php';

session_start();

?>
<?php
if(isset($_POST['submit'])){

  $username = mysqli_real_escape_string($conn, $_POST["username"]);  
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  // $password = md5($password);  

  $query = mysqli_query($conn, "SELECT u.id,e.job_id,u.emp_id,u.username,u.password,u.status FROM users u JOIN employee e on u.emp_id=e.emp_id
   WHERE u.username = '$username' && u.password = md5('$password')");
  $rows = mysqli_num_rows($query);
  $fetch = mysqli_fetch_array($query);

   if($rows > 0){
      $_SESSION['empid'] = $fetch['id'];
      $idd=$_SESSION['empid'];
      $_SESSION['EmpStatus'] = $fetch['status'];
      $_SESSION['job']=$fetch['job_id'];
      if ($_SESSION['EmpStatus'] == 'InActive') {
          header("Location: login.php?error=Username and password is inactive");
            exit();
      }else{
        header('location:index.php');
      } 
   }else{
        header("Location: login.php?error=Incorect Username or password");
            exit();
   }

};
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("main/head.php")?>
    <style>
  body {
    background-image: url('img/hom1.png');
    width: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

  .card {
    font-family: sans-serif;
    width: 27%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 0em;
    margin-bottom: 3em;
    border-radius: 10px;
    background-color: #ffff;
    padding: 1.8rem;
    box-shadow: 2px 5px 20px rgba(0, 0, 0, 0.1);
  }

  .title {
    text-align: center;
    font-weight: bold;
    margin: 0;
  }

  .error {
   background: #F2DEDE;
   color: #A94442;
   padding: 10px;
   width: 100%;
   border-radius: 5px;
   margin: 20px auto;
}
img {
  width: 100px;
}
#developed{
 text-align: right;
 padding-top: 20px;
 font-size: 13px;
}
</style>
  </head>

<body>

<div>
  <div id="auth">
    <div class="bg-img">
      <!-- <div class="img"><img src="img/home.jpg"></div> -->
      <div class="row h-100 mt-5 ">
        <h2 class="p-3 title font-weight-bold mb-2 text-white">&nbsp;Daryeel Logistics</h2>
        <div class="card ">
          <a class="mb-5" href="login.php"><img src="assets/images/logo/daryeel2.svg" width="" height="" alt="Logo"></a>
          <p class="auth-subtitle mb-2">Log in with your data that you entered during registration.</p>
          <form action="login.php" method="post">
            <?php if (isset($_GET['error'])) { ?>
              <p class="error"> <?php echo $_GET['error']; ?></p>
            <?php } ?>
              <div class="form-group position-relative has-icon-left mb-3">
                  <input type="text" name="username" class="form-control form-control-lg" placeholder="Email & Username" required>
                  <div class="form-control-icon">
                      <i class="bi bi-person"></i>
                  </div>
              </div>
              <div class="form-group position-relative has-icon-left mb-2">
                  <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                  <div class="form-control-icon">
                      <i class="bi bi-shield-lock"></i>
                  </div>
              </div>
              <div class="form-check form-check-lg d-flex align-items-end">
                  <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                  <label class="form-check-label text-gray-600" for="flexCheckDefault">
                      Keep me logged in
                  </label>
              </div>
              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4" name="submit">Log in</button>
              
            </form>
            <p id="developed">Developed By Abdiaziiz omar</p>
        </div>
      </div>
      <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">
              
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("main/script.php");?>
</body>



</html>