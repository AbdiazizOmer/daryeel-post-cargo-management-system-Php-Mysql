<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

function fetchinfo($conn){
    $data = array();
    $message = array();
    //read job info to update
    $search = $_POST['search'];
    $query ="SELECT p.id, p.TrackingID,cus.id as 'cusid',cus.name as 'cname',cus.address,cus.tell,p.re_name,p.re_address,p.re_tell,o.office_id as 'fromid',CONCAT(o.address,',',o.city,',',o.country) as 'departure',aa.id as 'toid', CONCAT(aa.areaname,',',aa.country) as 'destination',c.id as 'courioerid',CONCAT(c.name,',',c.couriorType) as 'name', p.weight_Kg,p.item_name,p.status,p.price,p.status_price FROM pracel p 
    JOIN customer cus
        on p.cust_id=cus.id
    JOIN office o
        on p.departure=o.office_id
    JOIN area aa
        on p.distination=aa.id
    JOIN courior c
        on p.courior=c.id WHERE p.TrackingID='$search'";
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