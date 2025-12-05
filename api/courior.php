<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

//Function redAll shipType to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT * FROM courior";
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

//Function red shipType to update
function readCouriorInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT * FROM courior WHERE id ='$id'";
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

// //Function insert shipType
function CouriorRegister($conn){
    extract($_POST);
    $new_id= generate($conn);

    $data = array();

    $query ="INSERT INTO courior (id,name, couriorType, phone) VALUES ('$new_id','$name','$type','$phone')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

// //Function update ShipType
function updateCourior($conn){
    extract($_POST);

    $data = array();

    $query ="UPDATE courior SET name='$name',couriorType='$type',phone='$phone' WHERE id= '$update_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

//Function Delete ShipType
function daleteCourior($conn){
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM courior WHERE id= '$delete_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Deletted succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

//Function generate job id
function generate($conn){
    $new_id= '';
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM courior order by id DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['id'];

        }else{
              
            $new_id= "COU001";
        }
    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

  return $new_id;
}

if(isset($_POST['action'])){
    $action($conn);
}else{
    echo json_encode(array("status" => false, "data"=> "Action Required....."));
}

?>