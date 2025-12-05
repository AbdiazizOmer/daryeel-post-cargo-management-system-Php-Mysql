<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

//Function redAll office to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT * FROM `payment_methods`;";
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

//Function red accounts to update
function readMethodtInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT * FROM `payment_methods` WHERE id ='$id'";
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
function methodRegister($conn){
    $new_id= generate($conn);
    extract($_POST);

    $data = array();

    $query ="INSERT INTO `payment_methods`(`id`, `name`) VALUES
      ('$new_id','$name')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Register succesFully😂😊😒😎");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

// //Function update office
function updateMethod($conn){
    extract($_POST);

    $data = array();
    $query ="UPDATE payment_methods SET name='$name'  WHERE id= '$update_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully😂😊😒😎");
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
   $query ="SELECT * FROM payment_methods order by id  DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['id'];

        }else{
              
            $new_id= "METH001";
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