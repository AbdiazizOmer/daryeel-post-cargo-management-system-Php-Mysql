<?php
header("content-type: application/json");
include '../config.php';


$action = $_POST['action'];

//red Customer for select option
function readCustomersOption($conn){
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM customer ORDER BY id DESC";
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

//red from for select option
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

//red type for select option
function readTypeOption($conn){
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

///////////////////////////////////////////////////////////////////update section///////////////////////////
// //red office for select option
function redPriceUpdate($conn){
    $data = array();
    extract($_POST);
    $array_data = array();
    $query ="SELECT `price` FROM `tblprice` where `from` = '$dep' and `to` ='$dist' and `shiptype`='$typee'";
    $result = $conn->query($query);


    if($dep == $dist){
        $data = array("status" => false, "data" => "Dublicate Entry");
    }else{
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Fetch the price
            $row = $result->fetch_assoc();
            $pricee = $row["price"];

            // Output the price
            $data = array("status" => true, "data" => $pricee);
        } else {
            $data = array("status" => false, "data" => "This area is not available in the system.");
        }

        // Close the connection
        $conn->close();
    }

    echo json_encode($data);
}

// //Function update Status
function updatePracell($conn){
    extract($_POST);

    $data = array();
    
    $query0="UPDATE `pracel` SET `cust_id`='$cnamee',`re_name`='$renamee',`re_address`='$raddresss',
    `re_tell`='$rtelll',`departure`='$dep',`distination`= '$dist', `courior`= '$typee',
    `weight_Kg`='$weightt',`item_name`='$heightt',`price`='$pricee' WHERE `id` ='$update_idd'";

    $result0 = $conn->query($query0);
    if($result0){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }
    echo json_encode($data);

}
///////////////////////////////////////////////////////////////////End section///////////////////////////


// //red office for select option
function redPrice($conn){
    $data = array();
    extract($_POST);
    $array_data = array();
    $query ="SELECT `price` FROM `tblprice` where `from` = '$from' and `to` ='$to' and `shiptype`='$type'";
    $result = $conn->query($query);


    if($from == $to){
        $data = array("status" => false, "data" => "Dublicate Entry");
    }else{
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Fetch the price
            $row = $result->fetch_assoc();
            $price = $row["price"];

            // Output the price
            $data = array("status" => true, "data" => $price);
        } else {
            $data = array("status" => false, "data" => "This area is not available in the system.");
        }

        // Close the connection
        $conn->close();
    }

    echo json_encode($data);
}

//Function redAll Pracels to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT p.id,p.TrackingID,c.name,p.weight_Kg,p.price,p.status ,p.status_price FROM pracel p join customer c ON p.cust_id=c.id;";
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
function readpracelInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT p.id, p.TrackingID,cus.id as 'cusid',cus.name as 'cname',cus.address,cus.tell,p.re_name,p.re_address,p.re_tell,o.office_id as 'fromid',CONCAT(o.city,'-',o.country) as 'departure',a.id as 'toid', CONCAT(a.areaname,'-',a.country) as 'destination',c.id as 'courioerid',CONCAT(c.name,',',c.couriorType) as 'name', p.weight_Kg,p.item_name,p.status,p.price,p.status_price FROM pracel p 
    JOIN customer cus
        on p.cust_id=cus.id
    JOIN office o
        on p.departure=o.office_id
    JOIN area a
        on p.distination=a.id
    JOIN courior c
        on p.courior=c.id WHERE p.id = '$id'";
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
//Function insert price
function PracelRegister($conn){
   
    $trac_id= generateUniqueID();
    extract($_POST);
    $data = array();

    $query0 ="INSERT INTO `pracel`(`TrackingID`, `cust_id`, `re_name`, `re_address`, `re_tell`, 
    `departure`, `distination`, `courior`, `weight_Kg`, `item_name`, `status`, `price`, `user_id`, `date_created`) VALUES
     ('$trac_id','$cnamee','$renamee','$raddresss','$rtelll','$dep','$dist','$typee','$weightt','$heightt','$status','$pricee','$uid','$date')";
    $result0 = $conn->query($query0);
    if($result0){
        $data = array("status" => true, "data" => "Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }
    echo json_encode($data);

}

// //Function update Status
function updateStatus($conn){
    extract($_POST);

    $data = array();
    
    $query0="UPDATE `pracel` SET `status` = '$status' WHERE `id` ='$update_id'";

    $result0 = $conn->query($query0);
    if($result0){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }
    echo json_encode($data);

}

function read_pracel_statements($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_pracel_statement('$tellphone')";
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



///////////////////////////////////////////////////////////////ref num
function generateUniqueID() {
    // Generate a random number between 1 and 999,999,999
    $randomNumber = mt_rand(1, 999999999);
  
    // Convert the random number to a string
    $id = strval($randomNumber);
  
    // Pad the ID with leading zeros to make it nine digits long
    while (strlen($id) < 9) {
      $id = "0" . $id;
    }
  
    // Return the ID
    return $id;
  }
  
  
///////////////////////////////////////////////////////////////ref num

if(isset($_POST['action'])){
    $action($conn);
}else{
    echo json_encode(array("status" => false, "data"=> "Action Required....."));
}

?>