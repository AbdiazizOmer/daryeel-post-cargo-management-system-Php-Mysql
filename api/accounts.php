<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

//Function redAll office to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT `id`, `bank_name`, `account_num`, `country`, `status`, `balance` FROM `accounts`;";
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
function readAccountInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT `id`, `bank_name`, `account_num`, `country`, `status`, `balance` FROM `accounts` WHERE id ='$id'";
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
function AccountRegister($conn){
    $new_id= generate($conn);
    extract($_POST);

    $data = array();

    $query ="INSERT INTO `accounts`(`id`, `bank_name`, `account_num`, `country`, `status`, `balance`) VALUES ('$new_id','$name','$accnum','$country','$status','$amount')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

// //Function update office
function updateAccounts($conn){
    extract($_POST);

    $data = array();
    $query ="UPDATE accounts SET bank_name='$name', account_num='$accnum', country='$country', status='$status', balance='$amount'  WHERE id= '$update_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

//Function Delete Account
function daleteAccount($conn){
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM accounts WHERE id= '$delete_id'";

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
   $query ="SELECT * FROM accounts order by id  DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['id'];

        }else{
              
            $new_id= "ACC001";
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