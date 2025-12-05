<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];
//red Customer for select option
function readCusPracelOption($conn){
    $data = array();
    
    $array_data = array();
   $query ="SELECT p.id, p.TrackingID,c.name ,p.price FROM `pracel` p JOIN customer c
   ON p.cust_id=c.id  WHERE p.id NOT IN (SELECT i.cus_id from invoice i) ORDER BY p.id DESC;";
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
// //red office for select option
function redPrice($conn){
    $data = array();
    $new_id= generate($conn);
    extract($_POST);
    $query ="SELECT `price`,`TrackingID` FROM `pracel` where `id` = '$cname'";
    $result = $conn->query($query);

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Fetch the price
        $row = $result->fetch_assoc();
        $price = $row["price"];
        $refrence=$row["TrackingID"];

        // Output the price
        $data = array("status" => true, "data" => $price,"id"=>$new_id,"refre"=>$refrence);
    } else {
        $data = array("status" => false, "data" => "This Price is not available in the system.");
    }
        

        // Close the connection
    $conn->close();

    echo json_encode($data);
}
// //Function insert invoice
function InvoiceRegister($conn){
    $new_id= generate($conn);
    extract($_POST);
    $data = array();

    //allowed images
    $query ="INSERT INTO `invoice`(`invoice_id`, `ref_id`, `cus_id`, `issued_date`, `invoice_total`, `currency`) VALUES
    ('$new_id','$num','$cname','$date_iss','$price','$currency')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Invoice Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }
   
    echo json_encode($data);

}

//Function redAll office to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT i.invoice_id,i.ref_id, C.name,i.issued_date,i.invoice_total,i.status FROM `invoice` i JOIN pracel  P
	ON I.cus_id=P.id
    JOIN customer c
    ON P.cust_id=C.id";
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

//Function red invoice to update
function readInvoiceInfo($conn){
    extract($_POST);
    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT i.invoice_id,i.ref_id,i.cus_id, C.name,i.issued_date,i.invoice_total,i.status FROM `invoice` i JOIN pracel  P
	ON I.cus_id=P.id
    JOIN customer c
    ON P.cust_id=C.id  WHERE i.invoice_id='$tellphone'";
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

//Function red invoice to Print
function readInvoicePrint($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT i.invoice_id,co.name,co.tell,co.address,p.re_name,p.re_tell,p.re_address, concat(o.address,', ',o.city,', ',o.country) as 'dep',concat(oo.address,', ',oo.city,', ',oo.country) as 'dis',concat(cr.name,', ',cr.couriorType) as 'courier',p.weight_Kg,p.price,i.issued_date,tb.price as 'tbprice'
    FROM invoice i JOIN pracel p
        ON i.ref_id=p.TrackingID
    JOIN customer co
        ON p.cust_id=co.id
    JOIN office o
        ON p.departure=o.office_id
    JOIN office oo
        ON p.distination=oo.office_id
    JOIN courior cr
        ON cr.id=p.courior
    JOIN tblprice tb
        ON tb.from=o.office_id and tb.to=oo.office_id AND tb.shiptype=cr.id WHERE i.invoice_id='$id'";
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

// //Function update invoice
function updateInvoice($conn){
    extract($_POST);
    $data = array();
    //INSERT INTO `invoice`(`invoice_id`, `ref_id`, `cus_id`, `issued_date`, `invoice_total`, `currency`) VALUES
    //('$new_id','$num','$cname','$date_iss','$price','$currency')";
    $query ="UPDATE `invoice` SET `cus_id`='$cname', `ref_id`='$num', `invoice_total`='$price' WHERE `invoice_id`= '$update_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

// //Function delete invoice
function daleteInvoce($conn){
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM `invoice` WHERE `invoice_id`= '$delete_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Deletted succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

// //Function generate job id
function generate($conn){
    $new_id= '';
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM invoice order by invoice_id DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['invoice_id'];

        }else{
              
            $new_id= "INV001";
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