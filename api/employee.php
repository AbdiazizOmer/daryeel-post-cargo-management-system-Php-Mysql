<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

//red jobs for select option
function readJobsOption($conn){
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM jobs";
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

//Function redAll office to table
function readAll($conn){

    $data = array();
    $message = array();
    $query ="SELECT e.image AS 'IMAGE#',e.emp_id AS 'EMPID#',e.fullName AS 'NAME',e.address AS 'ADDRESS',e.tell AS 'TELL',j.name AS 'JOB',o.office_id AS 'OFFID#',YEAR(e.date_created) AS 'DATE'  FROM employee e JOIN office o on e.office_id=o.office_id JOIN jobs j on e.job_id=j.job_id ORDER BY e.emp_id;";
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

// //Function red employee to update
function readEmployeeeInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT * FROM employee  WHERE emp_id ='$id'";
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

// //Function insert Employee
function EmployeeRegister($conn){
    $new_id= generate($conn);
    extract($_POST);
    $data = array();
    $error_array =array();

    $file_name= $_FILES['image']['name'];
    $file_type= $_FILES['image']['type'];
    $file_size= $_FILES['image']['size'];
    $save_name= $new_id . ".png";
    //allowed images
    $allowedImages =  ["image/jpg", "image/jpeg", "image/png"];
    $max_size= 5 * 1024 * 1024;
    if(in_array($file_type, $allowedImages)){
        if($file_size > $max_size){
            $error_array[]=  $file_size/1024/1024 . " MB  file size must be less then" . $max_size/1024/1024 ." MB";
        }
    }else{
        $error_array[]= "this file is not Allowed";
    }
    if(count($error_array) <= 0){
        $query ="INSERT INTO `employee`(`emp_id`, `fullName`, `address`, `tell`, `job_id`, `office_id`, `image`) VALUES
        ('$new_id','$name','$address','$tell','$job_id','$office_id','$save_name')";

        $result = $conn->query($query);
        if($result){
            move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $save_name);
            $data = array("status" => true, "data" => "Register succesFully");
        }else{
            $data = array("status" => false, "data" => $conn->error);
        }
    }else{
        $data = array("status" => false, "data"=> $error_array);
    }
    echo json_encode($data);

}

// //Function update Employee
function updateEmployee($conn){
    extract($_POST);
    $data = array();
    if(!empty($_FILES['image']['tmp_name'])){

        $error_array =array();

        $file_type= $_FILES['image']['type'];
        $file_size= $_FILES['image']['size'];
        $save_name= $update_id . ".png";
        //allowed images
        $allowedImages =  ["image/jpg", "image/jpeg", "image/png"];
        $max_size= 5 * 1024 * 1024;
        if(in_array($file_type, $allowedImages)){
            if($file_size > $max_size){
                $error_array[]=  $file_size/1024/1024 . " MB  file size must be less then" . $max_size/1024/1024 ." MB";
            }
        }else{
            $error_array[]= "this file is not Allowed";
        }
        if(count($error_array) <= 0){
            $query ="UPDATE `employee` SET `fullName`='$name', `address`='$address', `tell`='$tell', `job_id`='$job_id', `office_id`='$office_id', `image`='$save_name' WHERE `emp_id`= '$update_id'";

            $result = $conn->query($query);
            if($result){
                move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $save_name);
                $data = array("status" => true, "data" => "Update succesFully");
            }else{
                $data = array("status" => false, "data" => $conn->error);
            }
        }else{
            $data = array("status" => false, "data"=> $error_array);
        }


    }else{
        $query ="UPDATE `employee` SET `fullName`='$name', `address`='$address', `tell`='$tell', `job_id`='$job_id', `office_id`='$office_id'  WHERE `emp_id`= '$update_id'";

        $result = $conn->query($query);
        if($result){
            $data = array("status" => true, "data" => "Update succesFully");
        }else{
            $data = array("status" => false, "data" => $conn->error);
        }
    }

    echo json_encode($data);

}

// //Function delete employee
function daleteEmployee($conn){
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM employee WHERE emp_id= '$delete_id'";

    $result = $conn->query($query);
    if($result){
        unlink('../img/' .$delete_id. ".png");
        $data = array("status" => true, "data" => "Deletted succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

function read_employe_statement($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_employe_statement('$tellphone')";
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

// //Function generate job id
function generate($conn){
    $new_id= '';
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM employee order by emp_id DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['emp_id'];

        }else{
              
            $new_id= "EMP001";
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