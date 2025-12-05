<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

function read_customer_ordering($conn){
    $data = array();
    $array_data = array();
    $query = "SELECT p.cust_id,c.name, p.TrackingID 'ref' from pracel p JOIN customer c on p.cust_id=c.id WHERE p.status_price='Pending' GROUP BY p.cust_id;";
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
//Raed payment methods
function read_payment_methods($conn){
    $data = array();
    $array_data = array();
    $query = "SELECT id,name FROM `payment_methods` ";
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
function read_amount($conn){
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_amount('$customer_id')";
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
function register_payment($conn){
    extract($_POST);
    $data = array();
    extract($_POST);
    $data = array();
    $query = "CALL payment_procedure('$customer_idd', '$amount', '$amount_paid', '$balance', '$Accountt_id', '$p_method_id')";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['msg'] == 'Deny') {
            $data = array("status" => false, "dataa" => "Amount_paid is greater than total amount");
        } elseif ($row['msg'] == 'Registered') {
            $data = array("status" => true, "data" => "Transaction has been completed");
        }
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}
function read_all_payment($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT p.payment_id,c.name,p.amount 'Total_amount',p.amount_paid,c.balance,a.bank_name,pm.name 'payment_method',p.date
    from payment p JOIN customer c on p.customer_id=c.id 
        JOIN accounts a on p.Account_id=a.id 
        JOIN payment_methods pm ON p.p_method_id=pm.id
    WHERE
        p.payment_id IN (SELECT 
                MAX(p.payment_id)
            FROM
                payment p
            GROUP BY p.customer_id);";
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
function read_Payment_statements($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_payment_statement('$tellphone')";
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