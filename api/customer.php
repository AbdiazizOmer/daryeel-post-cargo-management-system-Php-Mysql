<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

//Function redAll shipType to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT `id`, `name`, `tell`, `address`, `user_id`, YEAR(`date_created`) FROM `customer`";
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

// //Function red Customer to update
function readCustomerInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT * FROM customer WHERE id ='$id'";
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

// //Function insert Customer
function CustomerRegister($conn){
    extract($_POST);
    $new_id= generate($conn);
    

    $data = array();

    $query ="INSERT INTO `customer`(`id`, `name`, `tell`, `address`, `user_id`) VALUES 
    ('$new_id','$name','$tell','$address','$u_id')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

// //Function update Customer
function updateCustomer($conn){
    extract($_POST);

    $data = array();
    $query ="UPDATE customer SET name='$name',tell='$tell',address='$address' WHERE id= '$update_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

//Function Delete ShipType
function daleteCustomer($conn){
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM customer WHERE id= '$delete_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Deletted succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

function read_customer_statement($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_customer_statement('$tellphone')";
    $result = $conn->query($query);


    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

//Function generate job id
function generate($conn){
    $new_id= '';
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM customer order by id DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['id'];

        }else{
              
            $new_id= "CUS001";
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