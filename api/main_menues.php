<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

// //red employee for select option
// function readEmployeeOption($conn){
//     $data = array();
//     $array_data = array();
//     $query ="SELECT * FROM employee e WHERE e.emp_id NOT IN (SELECT u.emp_id FROM users u) ; ";

//     $result = $conn->query($query);


//     if($result){
//         while($row = $result->fetch_assoc()){
//             $array_data[] = $row;
//         }
//         $data = array("status" => true, "data" => $array_data);


//     }else{
//         $data = array("status" => false, "data"=> $conn->error);
             
//     }

//     echo json_encode($data);
// }

//Function redAll users to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT `m_id`,`text`,`icon`,`url`  FROM `main_menues`";
    $result = $conn->query($query);

    if($result){

        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        $message = array("status" => true, "data" => $data);
    }else{
        $message = array("status" => false, $conn->error);
    }

    echo json_encode($message);
}

//Function red menues to update
function readMainInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT `m_id`,`text`,`icon`,`url` from main_menues  WHERE `m_id`='$id'";
    $result = $conn->query($query);

    if($result){

        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        $message = array("status" => true, "data" => $data);
    }else{
        $message = array("status" => false, $conn->error);
    }

    echo json_encode($message);
}

// //Function insert user
function MainMenuesRegister($conn){
    extract($_POST);
    $data = array();

    //allowed images
    //CALL insert_user('John Doe', 'johndoe@example.com', 'password123')");
    $query ="call insert_main_menues('$name','$icon','$url')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }
   
    echo json_encode($data);

}

// //Function update user
function updateMainMenue($conn){
    extract($_POST);
    $data = array();
    $query ="call update_main_menues('$name','$icon','$url','$update_id')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}


if(isset($_POST['action'])){
    $action($conn);
}else{
    echo json_encode(array("status" => false, "data"=> "Action Required....."));
}

?>