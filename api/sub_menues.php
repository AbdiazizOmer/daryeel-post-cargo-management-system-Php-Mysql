<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];


function readAllFiles(){
    $data = array();
    $data_array = array();

    $search_result = glob('../*.php');
    foreach($search_result as $sr){
        $pure_link = explode("/",$sr);
        $data_array[] = $pure_link[1];
    }
    if(count($search_result) > 0){
        $data = array("status" => true, "data" => $data_array);
    }else{
        $data = array("status" => false, "data" => "Not Found");
    }

    echo json_encode($data);
}


//red employee for select option
function readMainMenuesOption($conn){
    $data = array();
    $array_data = array();
    $query ="SELECT * FROM main_menues ; ";

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

//Function redAll users to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT s.sub_id,m.text as 'mid',s.text,s.url FROM sub_menues s JOIN main_menues m
	ON s.m_id=m.m_id";
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

//Function red menues to update
function readSubInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT s.sub_id,s.m_id,m.text as 'mid',s.text,s.url FROM sub_menues s JOIN main_menues m ON s.m_id=m.m_id WHERE s.sub_id='$id'";
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

// //Function insert Sum Menue
function SubMenuesRegister($conn){
    extract($_POST);
    $data = array();

    //allowed images
    //CALL insert_user('John Doe', 'johndoe@example.com', 'password123')");
    $query ="call insert_sub_menues('$menue','$text','$url')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }
   
    echo json_encode($data);

}

// //Function update Sub menu
function updateSubMenue($conn){
    extract($_POST);
    $data = array();
    $query ="call update_sub_menues('$menue','$text','$url','$update_id')";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
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