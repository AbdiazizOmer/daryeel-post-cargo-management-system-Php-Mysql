<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

//red office for select option
function readOfficeOption($conn){
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM office";
    $result = $conn->query($query);


    if($result){
        while($row = $result->fetch_assoc()){
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}

function readAreaOption($conn){
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM area";
    $result = $conn->query($query);


    if($result){
        while($row = $result->fetch_assoc()){
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}

//red office for select option
function readCouriorOption($conn){
    $data = array();
    $array_data = array();
    $query ="SELECT * FROM courior";
    $result = $conn->query($query);


    if($result){
        while($row = $result->fetch_assoc()){
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);


    }else{
        $data = array("status" => false, "data"=> $conn->error);
             
    }

    echo json_encode($data);
}

//Function redAll office to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT t.id, CONCAT(o.city,'-',o.country) as 'from', CONCAT(a.areaname,'-',a.country) as 'to',CONCAT(c.name,'-',c.couriorType) as type,t.price FROM `tblprice` t 
    join office o 
        on t.from=o.office_id
    join area a
        on t.to=a.id
    join courior c on t.shiptype=c.id;";
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
function readPriceInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT t.id, CONCAT(o.address,',',o.city,',',o.country) as 'from',o.office_id as 'fromid' ,CONCAT(a.areaname,'-',a.country) as 'to',a.id as 'toid',CONCAT(c.name,',',c.couriorType) as 'type',c.id as 'cid',t.price FROM `tblprice` t 
    join office o 
        on t.from=o.office_id
    join area a
        on t.to=a.id
    join courior c on t.shiptype=c.id WHERE t.id ='$id'";
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

function UpdatePriceOnchane($conn){

    $data = array();
    //read job info to update
    $id = $_POST['id'];
    $price = $_POST['value'];
    $query ="UPDATE tblprice SET `price`='$price' WHERE `id`='$id'";
    $result = $conn->query($query);

    if($result){

        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, $conn->error);
    }

    echo json_encode($data);
}

//Function insert price
function PriceRegister($conn){
    $new_id= generate($conn);
    extract($_POST);
    $data = array();

    if($from == $to){
        $data = array("status" => false, "array_data" => "Dublicate Entry");
    }else{
        $query0 ="INSERT INTO `tblprice`(`id`, `from`, `to`, `shiptype`, `price`) VALUES ('$new_id','$from','$to','$type','$price')";
        $result0 = $conn->query($query0);
        if($result0){
            $data = array("status" => true, "data" => "Register succesFully");
        }else{
            $data = array("status" => false, "data" => $conn->error);
        }
    }
    echo json_encode($data);

}

// //Function update price
function updatePrice($conn){
    extract($_POST);

    $data = array();
    if($from == $to){
        $data = array("status" => false, "arrayData" => "Dublicate Entry");
    }else{
        $query0="UPDATE `tblprice` SET `from` = '$from', `to` = '$to', `shiptype` = '$type',`price`='$price' WHERE `id` ='$update_id'";

        $result0 = $conn->query($query0);
        if($result0){
            $data = array("status" => true, "data" => "Update succesFully");
        }else{
            $data = array("status" => false, "data" => $conn->error);
        }
    }
    echo json_encode($data);

}

//Function Delete price
function daleteAccount($conn){
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM tblprice WHERE id= '$delete_id'";

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
   $query ="SELECT * FROM tblprice order by id  DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['id'];

        }else{
              
            $new_id= "PRI001";
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