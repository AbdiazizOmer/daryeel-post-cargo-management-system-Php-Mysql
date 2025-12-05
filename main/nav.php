<?php
$name= mysqli_query($conn,"SELECT substring_index(e.fullName,' ',1) as name,u.image,j.name as jobname,concat(o.address,', ',o.city,', ',o.country)as 'address',u.date_created FROM users u JOIN employee e on u.emp_id=e.emp_id JOIN jobs j on e.job_id=j.job_id join office o on e.office_id=o.office_id WHERE u.id='$id'") ; 
$row = mysqli_fetch_array($name);

?>
<header class='mb-0'>
<nav class="navbar navbar-expand navbar-light navbar-top">
<div class="container-fluid">
    <a href="#" class="burger-btn d-block">
        <i class="bi bi-justify fs-3"></i> Post & cargo Management System
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-lg-0">
            <li class="nav-item dropdown me-1">
                <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class='bi bi-envelope bi-sub fs-4'></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                        <h6 class="dropdown-header">Mail</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">No new mail</a></li>
                </ul>
            </li>
            <li class="nav-item me-3">
                <a class="nav-link active  text-gray-600" onclick="window.open('../../daryeel1/landing/index.php')"  data-bs-toggle="" data-bs-display="static" aria-expanded="false">
                    <i class='bi bi-globe fs-4'></i>
                </a>
                
            </li>
        </ul>
        <div class="dropdown">
            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-menu d-flex">
                    <div class="user-name text-end me-3">
                        <h6 class="mb-0 text-gray-600"><?php echo $row['name']?></h6>
                        <p class="mb-0 text-sm text-gray-600"><?php echo $row['jobname']?></p>
                    </div>
                    <div class="user-img d-flex align-items-center">
                        <div class="avatar avatar-md">
                             <img  src="img/<?php echo $row['image']?>">
                             <span class="avatar-status bg-success"></span>
                        </div>
                    </div>
                </div>
            </a>
            <?php @include 'profile.php'; ?>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">

                <li>
                    <h6 class="dropdown-header">Hello, <?php echo $row['name']?></h6>
                </li>
                <li><a class="dropdown-item" href="profile_user.php" ><i class="icon-mid bi bi-person me-2"></i> Profile</a></li>
                <li>
                    <hr class="dropdown-divider mt-2">
                </li>
                <li><a class="dropdown-item" href="logout.php"><i
                            class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
</nav>
</header>