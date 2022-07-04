<?php 

    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    include_once '../model/database.php';
    include_once '../model/User.php';
    include_once '../controller/RoleValidation.php';

    function getAllUser()
    {
        return User::getAllUser();
    }

    function getUserByUID($uid)
    {
        return User::get_user($uid);
    }

    function getUserByMatrix($matrix)
    {
        return User::get_user(NULL, $matrix);
    }

    function updateUser($uid)
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $uid = intval($uid);

        //get user data
        $curr_user = User::get_user($uid);

        $user = new User();
        $user->id = $uid;
        $user->matrix_no = $curr_user['matrix_no'];
        $user->user_name = $conn->real_escape_string($_POST['name']);
        $user->user_gender = $conn->real_escape_string($_POST['gender']);
        $user->user_phone = $conn->real_escape_string($_POST['phone']);
        $user->user_email = $conn->real_escape_string($_POST['email']);
        $user->updated_at = strftime('%Y-%m-%d %H:%M:%S');


        if(!empty($_POST['password'])) {
            $user->user_password = $conn->real_escape_string($_POST['password']);

            $options = [
                'memory_cost' => 2048,
                'time_cost' => 4
            ];
            $user->user_password =  password_hash($user->user_password, PASSWORD_ARGON2I,$options);
        }else{
            $user->user_password = $curr_user['user_password'];
        }

        $user->update();
    }


    if(isset($_POST['update'])) {

        $uid = $_POST['id'];
        updateUser($uid);
    }
?>