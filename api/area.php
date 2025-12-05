<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];



function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT * FROM area";
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

//Function red job to update
function readAreaInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT * FROM area WHERE id ='$id'";
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

//Function insert office
function areaRegister($conn){
    extract($_POST);

    $data = array();

    $query ="INSERT INTO `area`(`areaname`, `country`) VALUES
     ('$name','$country')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

//Function update office
function updateArea($conn){
    extract($_POST);
    $data = array();
    $query ="UPDATE area SET areaname='$name', country='$country' WHERE id= '$update_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

//Function update office
function daleteOffice($conn){
    $new_id= generate($conn);
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM office WHERE office_id= '$delete_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Deletted succesFully");
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