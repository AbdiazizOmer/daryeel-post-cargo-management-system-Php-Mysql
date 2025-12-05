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
    
</head>

<body>
    <div id="app">
        <?php include("main/sidebar.php")?>
    <style>
        fieldset.authority-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
                    box-shadow: 0px 0px 0px 0px #000;
        }
        legend.authority-border {
            width: inherit;
            padding: 0 10px;
            border-bottom: none;
            font-size: 1.2em !important;
            text-align: left !important;
        }
        /* input[type=checkbox]{
            transform: scale(1.5);
        } */
        #all_authority{
            transform: scale(1.5);
        }
        #all_sub_authority{
            transform: scale(1.1);
        }
    </style>
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
                                    <div class="col-3"><h4 class="card-title">USERS</h4></div>
                                    <div class="col-3"></div>
                                    <div class="col-3"></div>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <form id="userAuthorize">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <select class="form-control m-3" name="user_id" id="user_id" required="">
                                                    <option selected value="0">Select users</option>      
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- //////////////////lagenti////////////////// -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <fieldset class="authority-border">
                                                <legend class="float-none authority-border">
                                                    <input type="checkbox" id="all_authority" name="all_authority">
                                                    All Authoraties
                                                </legend>


                                                <div class="row" id="authorityArea"></div>
                                                <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Authorize User</button>
                                    </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <!-- //////////////////lagenti////////////////// -->
                                    
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                <?php include("main/footer.php")?>
            </div>
        </div>  
    </div>
    
    <?php include("main/script.php");?>
    <script src="js/userAuthority.js"></script>
</body>
</html>


