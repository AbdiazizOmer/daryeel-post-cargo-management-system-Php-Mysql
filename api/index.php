<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];


function get_total_expense($conn){
    extract($_POST);
    $data = array();
    $array_data = array();
    $query ="select concat('$',format(SUM(amount),'C'))  as expense from expense WHERE type='Expense'";
    $result = $conn->query($query);


    if($result){
        $row = $result->fetch_assoc();
        
        $data = array("status" => true, "data" => $row);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}
function get_total_parcells($conn){
    extract($_POST);
    $data = array();
    $array_data = array();
    $query ="SELECT COUNT(id) 'id' FROM `pracel` ";
    $result = $conn->query($query);


    if($result){
        $row = $result->fetch_assoc();
        
        $data = array("status" => true, "data" => $row);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}

function readPendigPracels($conn){

    $data = array();
    $message = array();
    $query ="SELECT TrackingID,c.name,p.weight_Kg,c.balance,p.status_price 
    FROM pracel p JOIN customer c on p.cust_id=c.id WHERE p.status_price='Pending' GROUP BY c.name
     ORDER BY c.balance DESC  LIMIT 5;";
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
function readPaidPracels($conn){

    $data = array();
    $message = array();
    $query ="SELECT c.name, SUM(p.amount_paid) AS total_balance
    FROM payment p JOIN customer c ON p.customer_id=c.id
    GROUP BY p.customer_id ORDER BY total_balance DESC  LIMIT 5;";
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