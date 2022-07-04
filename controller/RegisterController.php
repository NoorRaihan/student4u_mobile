<?php
    include_once '../model/database.php';
    include_once '../model/User.php';
    include_once '../model/AssignRole.php';

    $instance = Database::getInstance();
    $conn = $instance->getDBConnection();


    //check user matrix no if exist

    //try to get the data
    $check = User::get_user(NULL,$conn->real_escape_string($_POST['matrix']));

    if($check == NULL) {
        //create user object
        $user = new User();

        $user->matrix_no = $conn->real_escape_string($_POST['matrix']);
        $user->user_name = $conn->real_escape_string($_POST['fname']);
        $user->user_phone = $conn->real_escape_string($_POST['phone']);
        $user->user_email = $conn->real_escape_string($_POST['email']);
        $user->user_password = $conn->real_escape_string($_POST['password']);
        $user->user_gender = $conn->real_escape_string($_POST['gender']);
        $user->created_at = strftime('%Y-%m-%d %H:%M:%S');

        $options = [
            'memory_cost' => 2048,
            'time_cost' => 4
        ];

        $user->user_password =  password_hash($user->user_password, PASSWORD_ARGON2I,$options);
        $user->create();

        $curr_user = User::get_user(NULL,$user->matrix_no);

        $assign = new Assign();
        $assign->user_id = $curr_user['user_id'];
        $assign->role_id = 1;
        $assign->create();
    }else{
        session_start();
        $_SESSION['err'] = 1;
        echo "<script>window.location.href = history.back();</script>";
        echo "Matrix no already exists!";
    }
?>