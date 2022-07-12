<?php

    include_once '../model/database.php';

    class Complaint {

        public $comp_id = NULL;
        public $comp_desc;
        public $attached_file;
        public $comp_response;
        public $created_at;
        public $updated_at;
        public $comp_status;
        public $user_id;
        public $hide;

        public function create()
        {

            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "INSERT INTO complaint(comp_desc,attached_file,created_at,updated_at,user_id,hide)
            VALUES('$this->comp_desc', 
            '$this->attached_file', 
            '$this->created_at', 
            '$this->created_at', 
            $this->user_id, 
            $this->hide)";
            //var_dump($sql);
            if($conn->query($sql) == TRUE) {
                return "success";
            }else {
                echo  "failed";
            }
        }

        public static function getComplaintByID($id)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT complaint.*, user.matrix_no, user.user_id, user.user_name, user.user_email, user.user_phone
            FROM complaint
            JOIN user ON user.user_id = complaint.user_id
            WHERE complaint.comp_id = $id";
            
            $result = $conn->query($sql);

            if($result == TRUE) {
                if($result->num_rows > 0) {
                    $complaint = $result->fetch_assoc();
                    return $complaint;
                }else {
                    return NULL;
                }

            }else {
                
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
                echo  "Error: " . $sql;
            }

            $conn->close();
        }

        public static function getComplaintByUID($id, $uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT complaint.*, user.matrix_no, user.user_id, user.user_name, user.user_email, user.user_phone
            FROM complaint
            JOIN user ON user.user_id = complaint.user_id
            WHERE complaint.comp_id = $id AND complaint.user_id = $uid";

            
            $result = $conn->query($sql);

            if($result == TRUE) {
                if($result->num_rows > 0) {
                    $complaint = $result->fetch_assoc();
                    return $complaint;
                }else {
                    return NULL;
                }

            }else {
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
                echo  "Error: " . $sql;
            }

            $conn->close();
        }



        public static function getAllComplaint()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

           
            $sql = "SELECT complaint.*, user.matrix_no, user.user_name 
            FROM complaint
            JOIN user ON complaint.user_id = user.user_id
            ORDER BY (complaint.comp_status = 'IN PROGRESS') DESC ,complaint.created_at DESC";


            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
            }
        }

        public static function searchComplaintMatric($matric)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

           
            $sql = "SELECT complaint.*, user.matrix_no, user.user_name 
            FROM complaint
            JOIN user ON complaint.user_id = user.user_id
            WHERE user.matrix_no LIKE '$matric%'
            ORDER BY (complaint.comp_status = 'IN PROGRESS') DESC ,complaint.created_at DESC";

            //var_dump($sql);
            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
            }
        }

        public static function getAllComplaintByMode($status)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();
           
            $sql = "SELECT complaint.*, user.matrix_no, user.user_name 
            FROM complaint
            JOIN user ON complaint.user_id = user.user_id
            WHERE complaint.comp_status = '$status'
            ORDER BY (complaint.comp_status = 'IN PROGRESS') DESC, complaint.created_at DESC";

            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
            }
        }

        public static function getAllComplaintByModeUID($status, $uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();
           
            $sql = "SELECT complaint.*, user.matrix_no, user.user_name 
            FROM complaint
            JOIN user ON complaint.user_id = user.user_id
            WHERE complaint.comp_status = '$status'
            AND complaint.user_id = $uid
            ORDER BY (complaint.comp_status = 'IN PROGRESS') DESC, complaint.created_at DESC";

            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
            }
        }

        public static function getAllComplaintHistory()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();
           
            $sql = "SELECT complaint.*, user.matrix_no, user.user_name 
            FROM complaint
            JOIN user ON complaint.user_id = user.user_id
            WHERE complaint.comp_status <> 'IN PROGRESS'
            ORDER BY complaint.created_at DESC";
            
            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
            }
        }

        public static function getAllComplaintHistoryByUID($uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();
           
            $sql = "SELECT complaint.*, user.matrix_no, user.user_name 
            FROM complaint
            JOIN user ON complaint.user_id = user.user_id
            WHERE complaint.comp_status <> 'IN PROGRESS' 
            AND complaint.user_id = $uid
            ORDER BY complaint.created_at DESC";
            
            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
            }
        }

        public static function getAllComplaintByUID($uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT complaint.*, user.matrix_no, user.user_name 
            FROM complaint
            JOIN user ON complaint.user_id = user.user_id
            WHERE complaint.user_id = $uid
            ORDER BY (complaint.comp_status = 'IN PROGRESS') DESC, complaint.created_at DESC";

            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
                echo "<script>alert('Extracting complaint went wrong!'); window.location.href = '../view/complaint_view.php?mode=1'</script>";
            }
        }

        public function updateByUID()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "UPDATE complaint
            SET comp_desc = '$this->comp_desc',
            attached_file = '$this->attached_file',
            updated_at = '$this->updated_at'
            WHERE comp_id = $this->comp_id AND user_id = $this->user_id";

            session_start();
            if($conn->query($sql) == TRUE) {
                if($conn->affected_rows != 0){
                    $_SESSION['message'] = "Complaint updated successfully!";
                    $_SESSION['modal'] = 1;
                    echo "<script>window.location.href = history.back();</script>";
                    echo "Complaint updated successfully!";
                }else{
                    echo "<script>alert('Unauthorized data!'); window.location.href = history.back();</script>";
                }
            }else {
                $_SESSION['message'] = "Update not successfull [TECHNICAL ERROR]";
                $_SESSION['modal'] = 1;
                echo "<script>window.location.href = history.back();</script>";
                echo  "Error: " . $sql;
            }
        }

        public static function deleteByUID($id, $uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "DELETE FROM complaint WHERE comp_id = $id AND user_id = $uid";

            if($result = $conn->query($sql) == TRUE) {

                session_start();
                if($conn->affected_rows != 0) {
                    $_SESSION['message'] = "Complaint deleted successfully!";
                    $_SESSION['modal'] = 1;
                    echo "<script>window.location.href = history.back();</script>";
                    echo "Complaint deleted successfully!";
                }else{
                    echo "<script>alert('Unauthorized data!'); window.location.href = history.back();</script>";
                }
            }else {
                $_SESSION['message'] = "Delete was not successful";
                $_SESSION['modal'] = 1;
                echo "<script>window.location.href = history.back();</script>";
                echo  "Error: " . $sql;
            }
        }

        public function responseByID()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "UPDATE complaint SET
            comp_response = '$this->comp_response',
            updated_at = '$this->updated_at',
            comp_status = '$this->comp_status'
            WHERE comp_id = $this->comp_id";

            session_start();
            if($conn->query($sql) == TRUE) {
                if($conn->affected_rows != 0){
                    $_SESSION['message'] = "Response submitted successfully!";
                    $_SESSION['modal'] = 1;
                    echo "<script>window.location.href = '../view/complaint_view.php?mode=1';</script>";
                    echo "Complaint responded successfully!";
                }else{
                    echo "<script>alert('Unauthorized data!'); window.location.href = history.back();</script>";
                }
            }else {
                $_SESSION['message'] = "Respond was not successfull";
                $_SESSION['modal'] = 1;
                echo "<script>window.location.href = history.back();</script>";
                echo  "Error: " . $sql;
            }
        }

        public static function responseTime()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT comp_id, TIMESTAMPDIFF(MINUTE, created_at, updated_at) AS DIFFERENCE 
            FROM complaint WHERE week(created_at) = week(now()) AND comp_status <> 'IN PROGRESS'";

            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
               return NAN;
            }
        }
    }

?>