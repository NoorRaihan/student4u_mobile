<?php

    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    include_once '../model/database.php';
    include '../model/Paperwork.php';
    include '../model/Club.php';


    function create_submission($uid)
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $uid = intval($uid);
        //create the paperwork object
        $paperwork = new Paperwork();
        $paperwork->sender_role = $conn->real_escape_string($_POST['event-role']);
        $paperwork->program_name = $conn->real_escape_string($_POST['event-name']);
        $paperwork->advisor = $conn->real_escape_string($_POST['advisor-name']);
        $paperwork->club_id = intval($conn->real_escape_string($_POST['club']));
        $paperwork->user_id = $uid;
        $paperwork->attached_file = $conn->real_escape_string($_POST['glink']);
        $paperwork->created_at = strftime('%Y-%m-%d %H:%M:%S');

        return $paperwork->create();
    }

    function edit_paperworkById($id, $uid)
    {
         //get a DB connection
         $instance = Database::getInstance();
         $conn = $instance->getDBConnection();
 
         $uid = intval($uid);
         $id = intval($id);
         //create the paperwork object
         $paperwork = new Paperwork();
         $paperwork->id = $id;
         $paperwork->sender_role = $conn->real_escape_string($_POST['event-role']);
         $paperwork->program_name = $conn->real_escape_string($_POST['event-name']);
         $paperwork->advisor = $conn->real_escape_string($_POST['advisor-name']);
         $paperwork->club_id = intval($conn->real_escape_string($_POST['club']));
         $paperwork->user_id = $uid;
         $paperwork->attached_file = $conn->real_escape_string($_POST['glink']);
         $paperwork->updated_at = strftime('%Y-%m-%d %H:%M:%S');
         
         return $paperwork->updateByUID();
            
    }

    function getAllClubs()
    {
        return Club::getAllClubs();
    }

    function getAllPaperworks()
    { 
        $paper = Paperwork::getAllPaperworks();

        if($paper->num_rows > 0) {
            while($r = $paper->fetch_assoc()) {
                $data[] = $r;
            }
            return $data;
        }else{
            return null;
        }
    }

    function getAllPaperworksByUID($uid)
    { 
        $paper = Paperwork::getAllPaperworksByUID($uid);
        if($paper->num_rows > 0) {
            while($r = $paper->fetch_assoc()) {
                $data[] = $r;
            }
            return $data;
        }else{
            return null;
        }
    }

    function getAllPaperworksByMode($status) 
    {
        return Paperwork::getAllPaperworksByMode($status);
    }

    function getAllPaperworksByModeUID($status) 
    {
        return Paperwork::getAllPaperworksByModeUID($status,$_SESSION['user_id']);
    }

    function getAllPaperworksHistory()
    {
        return Paperwork::getAllPaperworksHistory();
    }

    function getAllPaperworksHistoryUID()
    {
        return Paperwork::getAllPaperworksHistoryUID($_SESSION['user_id']);
    }

    function getPaperworkByID($id)
    {
        return Paperwork::getPaperworkByID($id);
    }

    function searchPaperworkClub($club)
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $event = $conn->real_escape_string($club);
        $paper = Paperwork::searchPaperworkClub($club);

        if($paper->num_rows > 0) {
            while($r = $paper->fetch_assoc()) {
                $data[] = $r;
            }
            return $data;
        }else{
            return null;
        }
    }

    // function searchPaperworkClubUID($club, $uid)
    // {
    //     //get a DB connection
    //     $instance = Database::getInstance();
    //     $conn = $instance->getDBConnection();

    //     $event = $conn->real_escape_string($club);
    //     return Paperwork::searchPaperworkClubUID($club);
    // }

    function deletePaperworkByUID($id, $uid)
    {
        $id = intval($id);
        $uid = intval($uid);
        //get the file url
        $paperwork = Paperwork::getPaperworkByUID($id, $uid);
        
        return Paperwork::deleteByUID($id,$uid);
    }

    function responseComplaint($id, $status)
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $id = intval($id);

        $paperwork = new Paperwork();
        $paperwork->id = $id;
        $paperwork->updated_at = strftime('%Y-%m-%d %H:%M:%S');
        $paperwork->status = $status;
        $paperwork->response = $conn->real_escape_string($_POST['response']);
        $paperwork->returned_file = $conn->real_escape_string($_POST['rlink']);

        return $paperwork->responseByID();
    }

    if(isset($_GET['paperwork']) && isset($_GET['uid'])) {
        $uid = intval($_GET['uid']);
        $json = getAllPaperworksByUID($uid);
        echo json_encode($json);
    }

    if(isset($_GET['paperwork']) && !isset($_GET['uid'])) {
        $json = getAllPaperworks();
        echo json_encode($json);
    }

    if(isset($_POST['submit'])) {
        $uid = $_GET['uid'];
        $status = create_submission($uid);
        
        $json[] = Array(
            'status' => $status
        );

        echo json_encode($json);
    }

    if(isset($_GET['delete'])) {
        
        $id = $_GET['id'];
        $uid = $_GET['uid'];
        $status = deletePaperworkByUID($id, $uid);

        $json[] = array(
            'status' => $status
        );

        echo json_encode($json);
    }

    if(isset($_GET['update'])) {
        
        $id = $_GET['id'];
        $uid = $_GET['uid'];
        $status = edit_paperworkById($id,$uid);

        $json[] = array(
            'status' => $status
        );

        echo json_encode($json);
    }

    if(isset($_GET['approve']) || isset($_GET['reject'])) {

        if(isset($_GET['approve'])) {
            $status = "APPROVED";
        }else{
            $status = "REJECTED";
        }
        
        $id = $_GET['id'];
        $status = responseComplaint($id, $status);
        $json[] = array(
            'status' => $status
        );

        echo json_encode($json);
    }

    if(isset($_GET['search'])) {
        $club = $_GET['search'];
        $json = searchPaperworkClub($club);
        echo json_encode($json);
    }

?>