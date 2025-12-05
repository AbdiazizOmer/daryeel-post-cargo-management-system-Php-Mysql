<?php
header("content-type: application/json");
include '../config.php';

$action = $_POST['action'];

//red employee for select option
function readEmployeeOption($conn){
    $data = array();
    $array_data = array();
    $query ="SELECT * FROM employee e WHERE e.emp_id NOT IN (SELECT u.emp_id FROM users u) ; ";

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
    $query ="SELECT u.image as 'IMAGE#',u.id as 'USRID#',u.emp_id as 'EMPID#',e.fullName as 'NAME',j.name as 'JOB TYPE',u.username as 'USERNAME',u.status as 'STATUS',YEAR(u.date_created) as 'DATE' FROM `users` u 
    JOIN employee e 
        ON u.emp_id=e.emp_id 
    JOIN jobs j
        ON j.job_id=e.job_id
        ORDER BY u.id ASC;";
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

// //Function red user to update
function readUserInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['id'];
    $query ="SELECT u.id as 'uid',u.emp_id as 'emid',e.job_id,e.fullName as 'name',u.username as 'username',u.password,u.status as 'status',u.image FROM users u 
    join employee e ON u.emp_id=e.emp_id  WHERE u.id='$id'";
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

// //Function insert user
function UserRegister($conn){
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
        $error_array[]= "File Not Have";
    }
    if(count($error_array) <= 0){
        $query ="INSERT INTO `users`(`id`, `emp_id`, `username`, `password`, `image`, `status`) VALUES
    ('$new_id','$emp_id','$username',MD5('$password'),'$save_name','$status')";

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

// //Function update user
function updateUser($conn){
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
            $query ="UPDATE `users` SET `username`='$username', `password`=MD5('$password'), `status`='$status',`image`='$save_name' WHERE `id`= '$update_id'";

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
        $query ="UPDATE `users` SET `username`='$username', `password`=MD5('$password'), `status`='$status' WHERE `id`= '$update_id'";
        $result = $conn->query($query);
        if($result){
            $data = array("status" => true, "data" => "Update succesFully");
        }else{
            $data = array("status" => false, "data" => $conn->error);
        }
    }

    echo json_encode($data);

}

// //Function delete user
function daleteUser($conn){
    $delete_id=$_POST['id'];

    $data = array();

    $query ="DELETE FROM users WHERE id= '$delete_id'";

    $result = $conn->query($query);
    if($result){
        $data = array("status" => true, "data" => "Deletted succesFully");
    }else{
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);

}

// //Function red user to update
function readUserProfileInfo($conn){

    $data = array();
    $message = array();
    //read job info to update
    $id = $_POST['update_id'];
    $query ="SELECT u.id,u.username as 'username',u.image FROM users u 
    join employee e ON u.emp_id=e.emp_id  WHERE u.id='$id'";
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

// //Function update user
function updateUserProfile($conn){
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
            $query ="UPDATE `users` SET `username`='$username', `password`=MD5('$password'),`image`='$save_name' WHERE `id`= '$update_id'";

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
        $query ="UPDATE `users` SET `username`='$username', `password`=MD5('$password') WHERE `id`= '$update_id'";
        $result = $conn->query($query);
        if($result){
            $data = array("status" => true, "data" => "Update succesFully");
        }else{
            $data = array("status" => false, "data" => $conn->error);
        }
    }

    echo json_encode($data);

}


// //Function generate job id
function generate($conn){
    $new_id= '';
    $data = array();
    $array_data = array();
   $query ="SELECT * FROM users order by id DESC limit 1";
    $result = $conn->query($query);


    if($result){
        $num_rows= $result->num_rows;

        if($num_rows > 0){
            $row = $result->fetch_assoc();

            $new_id = ++$row['id'];

        }else{
              
            $new_id= "USR001";
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