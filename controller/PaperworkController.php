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
        $paperwork->created_at = strftime('%Y-%m-%d %H:%M:%S');

        //start to handle the file upload
        $file = $_FILES['file'];

        //file properties;
        $file_ext = array("txt","jpg","zip","rar","gif","png","jpeg","pdf");
        $filename = $file['name'];
        $file_type = $file['type'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $file_tmp = $file['tmp_name'];

        //check for file format
        $fileExplode = explode(".", $filename);
        $file_format = strtolower(end($fileExplode));

        //sanitize the filename
        $newFileName = md5(time().$filename) . "." . $file_format;

        //check if the file format is allow
        if(in_array($file_format, $file_ext)) {

            $newDest = "../view/uploads/paperwork/" . $newFileName;

            if(move_uploaded_file($file_tmp, $newDest)) {

                $paperwork->attached_file = $newDest;
                
                echo "upload successful!";
                $paperwork->create();

            } else {
                echo "upload failed!";
            }

        }else{
            echo "filetype not allowed!";
        }

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
         $paperwork->updated_at = strftime('%Y-%m-%d %H:%M:%S');
        
         if($_FILES['file']['tmp_name'] == "" && $_POST['curr-file'] == '') {
            echo "<script>alert('Attached file must be included'); window.location.href = document.referrer</script>";

         }else if($_POST['curr-file'] != NULL || $_POST['curr-file'] != ""){
            $paperwork->attached_file = $_POST['curr-file'];
            $paperwork->updateByUID();     
        }else{
            //start to handle the file upload
            $file = $_FILES['file'];

            //file properties;
            $file_ext = array("txt","jpg","zip","rar","gif","png","jpeg","pdf");
            $filename = $file['name'];
            $file_type = $file['type'];
            $file_size = $file['size'];
            $file_error = $file['error'];
            $file_tmp = $file['tmp_name'];

            //check for file format
            $fileExplode = explode(".", $filename);
            $file_format = strtolower(end($fileExplode));

            //sanitize the filename
            $newFileName = md5(time().$filename) . "." . $file_format;

            //check if the file format is allow
            if(in_array($file_format, $file_ext)) {

                $newDest = "../view/uploads/paperwork/" . $newFileName;

                if(move_uploaded_file($file_tmp, $newDest)) {

                    $paperwork->attached_file = $newDest;
                    
                    echo "upload successful!";
                    $paperwork->updateByUID();
                } else {
                    echo "upload failed!";
                }

            }else{
                echo "filetype not allowed!";
            }
        
        }
            
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
        return Paperwork::searchPaperworkClub($club);
    }

    function searchPaperworkClubUID($club,$uid)
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $event = $conn->real_escape_string($club);
        $uid = intval($uid);
        return Paperwork::searchPaperworkClubUID($club);
    }

    function deletePaperworkByUID($id)
    {
        $id = intval($id);
        $uid = intval($_SESSION['user_id']);
        //get the file url
        $paperwork = Paperwork::getPaperworkByUID($id, $uid);
        
        //delete the file and data from database and server
        if(file_exists($paperwork['attached_file'])) {
            
            if(unlink($paperwork['attached_file'])) {
                Paperwork::deleteByUID($id,$uid);
            }else{
                echo "delete process gone wrong!";
            }
        }else{
            Paperwork::deleteByUID($id,$uid);
        }
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
        
        if($_FILES['file']['tmp_name'] !== '') {
            $file = $_FILES['file'];
    
            //file properties;
            $file_ext = array("txt","jpg","zip","rar","gif","png","jpeg","pdf");
            $filename = $file['name'];
            $file_type = $file['type'];
            $file_size = $file['size'];
            $file_error = $file['error'];
            $file_tmp = $file['tmp_name'];
    
            //check for file format
            $fileExplode = explode(".", $filename);
            $file_format = strtolower(end($fileExplode));
    
            //sanitize the filename
            $newFileName = md5(time().$filename) . "." . $file_format;
    
            //check if the file format is allow
            if(in_array($file_format, $file_ext)) {
    
                $newDest = "../view/uploads/return/" . $newFileName;
    
                if(move_uploaded_file($file_tmp, $newDest)) {
    
                    $paperwork->returned_file = $newDest;
                    echo "upload successful!";
                    $paperwork->responseByID();

                } else {
                    echo "upload failed!";
                }

            }else{
                echo "filetype not allowed!";
            }
        }else{
            $paperwork->returned_file = NULL;
            $paperwork->responseByID();
        }
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
        create_submission($_SESSION['user_id']);
    }

    if(isset($_POST['delete'])) {
        
        $id = $_POST['id'];
        deletePaperworkByUID($id);
    }

    if(isset($_POST['update'])) {
        
        $id = $_POST['id'];
        $uid = $_SESSION['user_id'];
        edit_paperworkById($id,$uid);
    }

    if(isset($_POST['approve']) || isset($_POST['reject'])) {

        if(isset($_POST['approve'])) {
            $status = "APPROVED";
        }else{
            $status = "REJECTED";
        }
        
        $id = $_POST['id'];
        responseComplaint($id, $status);
    }

    if(isset($_GET['mode'])) {

        $mode = intval($_GET['mode']);

        if($role == 1) {
            switch ($mode) {
                case 1:
                    $paperwork = getAllPaperworksByUID();
                    $title = "All Submissions";
                    break;
                case 2:
                    $paperwork = getAllPaperworksByModeUID('IN PROGRESS');
                    $title = "Pending Submissions";
                    break;
                case 3:
                    $paperwork = getAllPaperworksHistoryUID();
                    $title = "Submission History";
                    break;
                case 4:
                    $paperwork = getAllPaperworksByModeUID('APPROVED');
                    $title = "Approved Submissions";
                    break;
                case 5:
                    $paperwork = getAllPaperworksByModeUID('REJECTED');
                    $title = "Rejected Submissions";
                    break;
                default:
                    header('Location: 403.php');
    
            }
        }else if($role == 2) {
            switch ($mode) {
                case 1:
                    $paperwork = getAllPaperworks();
                    $title = "All Submissions";
                    break;
                case 2:
                    $paperwork = getAllPaperworksByMode('IN PROGRESS');
                    $title = "Pending Submissions";
                    break;
                case 3:
                    $paperwork = getAllPaperworksHistory();
                    $title = "Submission History";
                    break;
                case 4:
                    $paperwork = getAllPaperworksByMode('APPROVED');
                    $title = "Approved Submissions";
                    break;
                case 5:
                    $paperwork = getAllPaperworksByMode('REJECTED');
                    $title = "Rejected Submissions";
                    break;
                default:
                    header('Location: 403.php');
    
            }
        }
    }

?>