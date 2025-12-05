<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

function register_expense($conn)
{

    extract($_POST);

    $data = array();

    // buliding the query and cAll the stored procedures
    $query = "CALL register_expense_sp('','$am','$type','$dis','$user_id', '$account_id')";

    // Excecution

    $result = $conn->query($query);

    // chck if there is an error or not
    if ($result) {

        $row = $result->fetch_assoc();

        if ($row['Message'] == 'Deny') {
            $data = array("status" => false, "dataa" => "Insuficient Balance😊😊😎");
        } elseif ($row['Message'] == 'Registered') {
            $data = array("status" => true, "data" => "Transaction Successfully");
        }
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function readAll($conn)
{

    $data = array();
    $array_data = array();
    $query = "SELECT e.id,e.amount,e.type,e.description,substring_index(ee.fullName,' ',1) as 'userName',ac.bank_name,e.date 
    from expense e JOIN accounts ac on e.Account_id=ac.id JOIN users u on u.id=e.user_id JOIN employee ee ON u.emp_id=ee.emp_id";
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

if(isset($_POST['action'])){
    $action($conn);
}else{
    echo json_encode(array("status" => false, "data"=> "Action Required....."));
}

?>