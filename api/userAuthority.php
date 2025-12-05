<?php
session_start();
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];


//red employee for select option
function redAllusers($conn){
    $data = array();
    $array_data = array();
    $query ="SELECT u.id,e.fullName FROM users u JOIN employee e ON u.emp_id=e.emp_id";

    $result = $conn->query($query);
    if($result){
        while($row = $result->fetch_assoc()){
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}

//red employee for select option
function readSystemAuthority($conn){
    $data = array();
    $array_data = array();
    $query ="SELECT * FROM `system_authority`";

    $result = $conn->query($query);
    if($result){
        while($row = $result->fetch_assoc()){
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}

//red all authrates
function getUserAuthoretes($conn){
    extract($_POST);
    $data = array();
    $array_data = array();
    $query ="call get_user_authorates('$user_id')";

    $result = $conn->query($query);
    if($result){
        while($row = $result->fetch_assoc()){
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}

function getUserMenue($conn){
    extract($_POST);
    $data = array();
    $idd=$_SESSION['empid'];
    $array_data = array();
    $query ="call get_user_menue_authorates	('$idd')";

    $result = $conn->query($query);
    if($result){
        while($row = $result->fetch_assoc()){
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}

// //Function insert Sum Menue
function userAutorityRegister($conn){
    extract($_POST);
    $data = array();
    $sucess_array=array();
    $error_array = array();

    $del="DELETE FROM `user_authority` WHERE `user_id`='$user_id'";
    $conn = mysqli_connect('localhost','root','','daryeel1_db');
    $res = $conn->query($del);

    if($res){

        for($i = 0; $i < count($action_id);$i ++){
            $query ="INSERT INTO `user_authority`(`user_id`, `actions`) VALUES ('$user_id','$action_id[$i]')";
            $result = $conn->query($query);
            if($result){
                $sucess_array[] = array("status" => true, "data" => "Register succesFully");
            }else{
                $error_array[] = array("status" => false, "data" => $conn->error);
            }
        }
    }else{
        $error_array []=array("status" => true,"data"=>$conn->error);
    }
    if(count($sucess_array) > 0 && count($error_array) == 0){
        $data = array("status" => true, "data" => "User Has Been Authorized");
    }elseif(count($sucess_array) > 0){
        $data = array("status" => false, "data" => $error_array);
    }
   
    if(count($error_array) > 0 && count($sucess_array) == 0){
        $data = array("status" => false, "data" => $error_array);

    }

    echo json_encode($data);

}


if(isset($_POST['action'])){
    $action($conn);
}else{
    echo json_encode(array("status" => false, "data"=> "Action Required....."));
}

?>