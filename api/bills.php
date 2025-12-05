<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];
function read_all_employeeee($conn){
    $data = array();
    $array_data = array();
    $query = "SELECT Distinct e.emp_id,e.fullName as employe_name FROM charge ch JOIN employee e on ch.employe_id=e.emp_id WHERE ch.active =0;";
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

function read_employe_salary($conn){
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "SELECT SUM(Amount) as salary from charge WHERE employe_id=('$employee') and active=0";
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


function register_bills($conn)
{
    extract($_POST);
    $data = array();
    $query = "INSERT INTO `bills`(`employe_id`, `Amount`, `user`)
    VALUES('$emp', '$sal', '$user_id')";
    $result = $conn->query($query);

    if ($result) {

        $data = array("status" => true, "data" => "Transaction Successfully");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }


    echo json_encode($data);
}

function readAll($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "SELECT b.id,e.fullname as employe_name,b.Amount as salary,substring_index(ee.fullName,' ',1) as 'userName',b.date 
    from bills b JOIN employee e on b.employe_id=e.emp_id 
    
    JOIN users u ON u.id=b.user
    
    JOIN employee ee on ee.emp_id=u.emp_id";
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
function read_bills_statement($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_bills_statement('$tellphone')";
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