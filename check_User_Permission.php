<?php

function read_actions(){
    $db = new PDO('mysql:host=localhost;dbname=daryeel1_db', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_SESSION['empid'];
    $urll = basename($_SERVER['REQUEST_URI']); // ka saar filename keliya

    $sql = "SELECT s.url, u.user_id 
            FROM user_authority u 
            JOIN sub_menues s ON u.actions = s.sub_id 
            WHERE s.url = ? AND u.user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$urll, $user_id]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // user-ka waa authorized
        $file_name = $row['url'];
        return true;
    } else {
        // user-ka ma laha permission
        header('Location: /daryeel1/index.php');
        exit();
    }
}
