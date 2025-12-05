<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

function read_all_account($conn){
    $data = array();
    $array_data = array();
    $query = "select * from accounts";
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

function register_charge($conn)
{
    extract($_POST);
    $data = array();
    $query = "CALL charge('$month', '$year', '$dis', '$account_id', '$user_id')";

    $result = $conn->query($query);


    if ($result) {

        $row = $result->fetch_assoc();
        if ($row['msg'] == 'Deny') {
            $data = array("status" => false, "dataa" => "Insuficance Balance😜");
        } elseif ($row['msg'] == 'Registered') {
            $data = array("status" => true, "data" => "Transaction Successfully ✅");
        } elseif ($row['msg'] == 'NOt') {
            $data = array("status" => false, "dataa" => "Horay Ayaa loogu dalacay bishaan ❌");
        }
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

//Function redAll office to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT c.charge_id,e.fullName,j.name,c.Amount,c.month_id,c.year,c.description,a.bank_name, substring_index(ee.fullName,' ',1) as 'userName',c.active,c.date
    FROM charge c JOIN employee e
        ON c.employe_id=e.emp_id
    JOIN jobs j
        ON c.job_id=j.job_id
    JOIN accounts A
        ON c.Account_id=a.id
    JOIN users u
        ON c.user_id=u.id
    JOIN employee ee
        ON u.emp_id=ee.emp_id ORDER by charge_id;";
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

if(isset($_POST['action'])){
    $action($conn);
}else{
    echo json_encode(array("status" => false, "data"=> "Action Required....."));
}

?>