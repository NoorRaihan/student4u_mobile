<?php

    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    include_once '../model/database.php';
    include_once '../model/Complaint.php';
    //include_once '../controller/RoleValidation.php';
    
    function create_complaint($uid) 
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $uid = intval($uid);

        $complaint = new Complaint();
        $complaint->comp_desc = $conn->real_escape_string($_POST['description']);
        $complaint->created_at = strftime('%Y-%m-%d %H:%M:%S');
        $complaint->user_id = intval($uid);
        $complaint->hide = intval(!empty($_POST['hide']) ? $_POST['hide'] : NULL);

        if($_FILES['file']['tmp_name'] !== '') {

            $file = $_FILES['file'];
            var_dump($file);
            var_dump($_POST['description']);
            var_dump(intval($_POST['hide']));
    
            //file properties;
            $file_ext = array("txt","jpg","zip","rar","gif","png","jpeg");
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
    
                $newDest = "../view/uploads/complaint/" . $newFileName;
    
                if(move_uploaded_file($file_tmp, $newDest)) {
    
                    $complaint->attached_file = $newDest;
                    echo "upload successful!";
                    $complaint->create();

                } else {
                    echo "upload failed!";
                }

            }else{
                echo "filetype not allowed!";
            }

        } else {
            $complaint->attached_file = NULL;
            $complaint->create();
        }
    }

    //edit the complaint
    function edit_complaintByID($id,$uid)
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $id = intval($id);
        $uid = intval($uid);

        $complaint = new Complaint();
        $complaint->comp_id = $id;
        $complaint->comp_desc = $conn->real_escape_string($_POST['description']);
        $complaint->updated_at = strftime('%Y-%m-%d %H:%M:%S');
        $complaint->user_id = $uid;
        $complaint->hide = intval(!empty($_POST['hide']) ? $_POST['hide'] : NULL);

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
    
                $newDest = "../view/uploads/" . $newFileName;
    
                if(move_uploaded_file($file_tmp, $newDest)) {
    
                    $complaint->attached_file = $newDest;
                    $complaint->updateByUID();

                } else {
                    echo "upload failed!";
                }

            }else{
                echo "filetype not allowed!";
            }

        } else {
            if($_POST['curr-file'] != NULL || $_POST != "") {
                $complaint->attached_file = $_POST['curr-file'];
            }else{
                $complaint->attached_file = NULL;
            }
            $complaint->updateByUID();
        }
    }

    //get all the complaint
    function view_all_complaint()
    {
        $comp = Complaint::getAllComplaint();

        if($comp->fetch_assoc() != NULL) {
            while($r = $comp->fetch_assoc()) {
                $data[] = $r;
            }
            return $data;
        }else{
            return null;
        }
    }

    function view_mode_complaint($status)
    {
        return Complaint::getAllComplaintByMode($status);
    }

    function view_mode_complaint_uid($status)
    {
        return Complaint::getAllComplaintByModeUID($status, $_SESSION['user_id']);
    }

    function view_history_complaint()
    {
        return Complaint::getAllComplaintHistory();
    }

    function view_history_complaint_uid()
    {
        return Complaint::getAllComplaintHistoryByUID($_SESSION['user_id']);
    }

    function view_all_complaint_uid($uid)
    {
        $comp = Complaint::getAllComplaintByUID($uid);
        //var_dump($comp->fetch_assoc());
        if($comp->num_rows > 0) {
            while($r = $comp->fetch_assoc()) {
                $data[] = $r;
            }
            return $data;
        }else{
            return null;
        }
    }

    function search_complaint_matric($matric)
    {

        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $matric = $conn->real_escape_string($matric);
        return Complaint::searchComplaintMatric($matric);
    }

    function get_complaint_UID($id)
    {
        $id = intval($id);
        $uid = intval($_SESSION['user_id']);
        return Complaint::getComplaintByUID($id,$uid);
    }

    function get_complaint($id)
    {
        $comp = Complaint::getComplaintByID($id);
        if($comp != NULL) {
            $data[] = $comp;
            return $data;
        }else{
            return null;
        }
    }

    function deleteComplaintByUID($id)
    {
        $id = intval($id);
        $uid = intval($_SESSION['user_id']);

        //get the complaint data
        $complaint = Complaint::getComplaintByUID($id,$uid);

        //try to delete the file if have from the server
        if(!empty($complaint['attached_file'])) {

            if(file_exists($complaint['attached_file'])) {
                if(unlink($complaint['attached_file'])) {
                    Complaint::deleteByUID($id,$uid);
                }else{
                    echo "Deleting complaint went wrong!";
                }
            }else{
                Complaint::deleteByUID($id,$uid);
            }
        }else{
            Complaint::deleteByUID($id,$uid);
        }
    }

    function responseComplaint($id, $status)
    {
        //get a DB connection
        $instance = Database::getInstance();
        $conn = $instance->getDBConnection();

        $id = intval($id);

        $complaint = new Complaint();
        $complaint->comp_id = $id;
        $complaint->updated_at = strftime('%Y-%m-%d %H:%M:%S');
        $complaint->comp_status = $status;
        $complaint->comp_response = $conn->real_escape_string($_POST['response']);

        $complaint->responseByID();
    }

    if(isset($_GET['complaint']) && isset($_GET['uid'])) {
        
        $uid = intval($_GET['uid']);
        $json[] = view_all_complaint_uid($uid);
        echo json_encode($json);

    }else if(isset($_GET['complaint']) && !isset($_GET['uid']) && !isset($_GET['id']) && !isset($_GET['uid'])) {
        $json[] = view_all_complaint();
        echo json_encode($json);

    }else if(isset($_GET['complaint']) && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $json[] = get_complaint($id);
        echo json_encode($json);
    }else if(isset($_GET['complaint']) && isset($_GET['id']) && isset($_GET['uid'])) {
        $id = intval($_GET['id']);
        $uid = intval($_GET['uid']);
        $json[] = get_complaint_UID($id,$uid);
        echo json_encode($json);
    }

    if(isset($_POST['submit'])) {
        create_complaint($_SESSION['user_id']);
    }

    if(isset($_POST['update'])) {

        $id = $_POST['id'];
        $uid = $_SESSION['user_id'];
        edit_complaintByID($id,$uid);
    }

    if(isset($_POST['delete'])) {
        
        $id = $_POST['id'];
        deleteComplaintByUID($id);
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

    if(isset($_GET['mode'])){
        $mode = intval($_GET['mode']);

        if($role == 1) {
            switch ($mode) {
                case 1:
                    $complaints = view_all_complaint_uid();
                    $title = "All Complaints";
                    break;
                case 2:
                    $complaints = view_mode_complaint_uid('IN PROGRESS');
                    $title = "Pending Complaints";
                    break;
                case 3:
                    $complaints = view_history_complaint_uid();
                    $title = "Complaint History";
                    break;
                case 4:
                    $complaints = view_mode_complaint_uid('APPROVED');
                    $title = "Approved Complaints";
                    break;
                case 5:
                    $complaints = view_mode_complaint_uid('REJECTED');
                    $title = "Rejected Complaints";
                    break;
                default:
                    header('Location: 403.php');
            }
        }else if($role == 2) {
            switch ($mode) {
                case 1:
                    $complaints = view_all_complaint();
                    $title = "All Complaints";
                    break;
                case 2:
                    $complaints = view_mode_complaint('IN PROGRESS');
                    $title = "Pending Complaints";
                    break;
                case 3:
                    $complaints = view_history_complaint();
                    $title = "Complaint History";
                    break;
                case 4:
                    $complaints = view_mode_complaint('APPROVED');
                    $title = "Approved Complaints";
                    break;
                case 5:
                    $complaints = view_mode_complaint('REJECTED');
                    $title = "Rejected Complaints";
                    break;
                default:
                    header('Location: 403.php');
            }
        }
    }

?>