<?php

    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    include_once '../model/database.php';
    include '../model/Club.php';
    include_once '../controller/RoleValidation.php';

    function createClub()
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $club = new Club();
        $club->name = $conn->real_escape_string($_POST['name']);
        $club->created_at = strftime('%Y-%m-%d %H:%M:%S');
        $club->create();

    }
    
    function getAllClub()
    {
        return Club::getAllClubs();
    }

    function getClubByID($id)
    {
        $id = intval($id);
        return Club::getClubByID($id);
    }

    function updateClub($id)
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $club = new Club();
        $club->id = intval($id);
        $club->name = $conn->real_escape_string($_POST['name']);
        $club->updated_at = strftime('%Y-%m-%d %H:%M:%S');
        $club->update();
    }

    function deleteClub($id)
    {
        $id = intval($id);
        Club::deleteByID($id);
    }

    if(isset($_POST['update'])) {
        $id = $_POST['id'];
        updateClub($id);
    }

    if(isset($_POST['delete'])) {
        $id = $_POST['id'];
        deleteClub($id);
    }

    if(isset($_POST['submit'])) {
        createClub($id);
    }
?>