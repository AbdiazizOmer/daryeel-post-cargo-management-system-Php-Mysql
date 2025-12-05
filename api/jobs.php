<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

//Function redAll jobs to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT * FROM jobs";
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

//Function red job to update
function readJobInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT * FROM jobs WHERE job_id ='$id'";
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

//Function insert job
function jobRegister($conn){
    extract($_POST);
    $new_id= generate($conn);
    

    $data = array();

    $query ="INSERT INTO jobs (job_id, name, fee, description,Date_created) VALUES ('$new_id','$name','$sal','$dis',null)";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Register succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

//Function update job
function updateJob($conn){
    extract($_POST);

    $data = array();

    $query ="UPDATE jobs SET name='$name', fee='$sal', description='$dis' WHERE job_id= '$update_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Update succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

//Function update job
function daletejob($conn){
    $new_id= generate($conn);
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM jobs WHERE job_id= '$delete_id'";

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
   $query ="SELECT * FROM jobs order by job_id DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['job_id'];

        }else{
              
            $new_id= "JOB001";
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