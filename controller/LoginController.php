<?php

    include_once '../model/database.php';
    include_once '../model/User.php';
    include_once '../model/AssignRole.php';

    //get a DB connection
    $instance = Database::getInstance();
    $conn = $instance->getDBConnection();

    $matrix = $conn->real_escape_string($_POST['matrix']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    $user = User::get_user_role(NULL, $matrix, $role);
    $login = false;
    $matrix_no = null;
    $user_id = null;
    $role = null;
    $session_id = null;

    //var_dump($user['user_password']);
    if(!empty($user)) {

        if(password_verify($password, $user['user_password'])) {

            session_start();
            $session_id = session_create_id();

            $login = True;
            $matrix_no = $user['matrix_no'];
            $user_id = $user['user_id'];
            $role = $user['role_id'];
            $session_id = $session_id;
            $message = "success";
            
        } else {
            $message = "Wrong password";
        }

    } else {
        $message = "Matric number not exist in current role";
    }

    $json = array(
      'status'      => $message,  
      'login'       => $login,
      'matrix_no'   => $matrix_no,
      'uid'         => $user_id,
      'role'        => $role,
      'session'     => $session_id 
    );

    echo json_encode($json);
?>