<?php

    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    include_once '../model/database.php';
    include_once '../model/User.php';
    include '../model/AssignRole.php';
    include_once '../controller/RoleValidation.php';

    function assignRole()
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();
        $id = intval($_POST['id']);
        $role = intval($_POST['role']);

        if($role != 2) {
            $assign = new Assign();
            $assign->user_id = $id;
            $assign->role_id = 2;
            $assign->position = $conn->real_escape_string($_POST['position']);
            $assign->create();
        }else{
            session_start();
            $_SESSION['message'] = "Student already MPP";
            $_SESSION['modal'] = 1;
            echo "<script>window.location.href = history.back();</script>";
        }
    }

    function removeRole()
    {
        $id = intval($_POST['id']);
        $role = intval($_POST['role']);

        $assign = new Assign();
        $assign->user_id = $id;
        $assign->role_id = $role;
        $assign->removeRole();
    }

    if(isset($_POST['assign'])) {
        assignRole();
    }

    if(isset($_POST['remove'])) {
        removeRole();
    }

?>