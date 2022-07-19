<?php

    include_once '../model/database.php';

    class Paperwork {

        public $id = NULL;
        public $program_name;
        public $advisor;
        public $sender_role;
        public $attached_file;
        public $response;
        public $returned_file;
        public $created_at;
        public $updated_at;
        public $status;
        public $user_id;
        public $club_id;

        public function create()
        {

            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();
            
            $sql = "INSERT INTO submission(program_name, advisor, sender_role, attached_file, created_at, updated_at, user_id, club_id)
            VALUES('$this->program_name', 
            '$this->advisor', 
            '$this->sender_role', 
            '$this->attached_file', 
            '$this->created_at', 
            '$this->created_at', 
            $this->user_id, 
            $this->club_id)";

            //var_dump($sql);
            if($conn->query($sql) == TRUE) {
               return "success";
            }else {
                return "failed";
            }
        }


        public static function getAllPaperworks()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name 
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            ORDER BY (submission.sub_status = 'IN PROGRESS') DESC, submission.created_at DESC";

            //var_dump($sql);
            $result = $conn->query($sql);
            if($result == TRUE) {
                return $result;
            }else{
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
            }
        }

        public static function getAllPaperworksByUID($uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name 
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE submission.user_id = $uid
            ORDER BY (submission.sub_status = 'IN PROGRESS') DESC ,submission.created_at DESC";

            //var_dump($sql);
            $result = $conn->query($sql);
            if($result == TRUE) {
                return $result;
            }else{
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
            }
        }

        public static function getAllPaperworksByMode($status)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name 
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE submission.sub_status = '$status'
            ORDER BY (submission.sub_status = 'IN PROGRESS') DESC, submission.created_at DESC";

            //var_dump($sql);
            $result = $conn->query($sql);
            if($result == TRUE) {
                return $result;
            }else{
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
            }
        }

        public static function getAllPaperworksByModeUID($status,$uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name 
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE submission.sub_status = '$status'
            AND submission.user_id = $uid
            ORDER BY (submission.sub_status = 'IN PROGRESS') DESC, submission.created_at DESC";

            //var_dump($sql);
            $result = $conn->query($sql);
            if($result == TRUE) {
                return $result;
            }else{
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
            }
        }

        public static function getAllPaperworksHistory()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name 
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE submission.sub_status <> 'IN PROGRESS'
            ORDER BY submission.created_at DESC";

            //var_dump($sql);
            $result = $conn->query($sql);
            if($result == TRUE) {
                return $result;
            }else{
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
            }
        }

        public static function getAllPaperworksHistoryUID($uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name 
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE submission.sub_status <> 'IN PROGRESS'
            AND submission.user_id = $uid
            ORDER BY submission.created_at DESC";

            //var_dump($sql);
            $result = $conn->query($sql);
            if($result == TRUE) {
                return $result;
            }else{
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
            }
        }

        public static function deleteByUID($id, $uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "DELETE FROM submission WHERE sub_id = $id AND user_id = $uid";

            if($conn->query($sql) == TRUE) {
                if($conn->affected_rows != 0) {
                    return "success";
                }else{
                    return "unauthorized data";
                }
            }else {
               return "failed";
            }
        }

        public static function getPaperworkByID($id)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name, user.user_email, user.user_phone
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE submission.sub_id = $id";

            $result = $conn->query($sql);
            if($result == TRUE) {
                if($result->num_rows > 0) {
                    $paperwork = $result->fetch_assoc();
                    return $paperwork;
                }else {
                    return NULL;
                }

            }else {
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
                echo  "Error: " . $sql;
            }

        }

        public static function getPaperworkByUID($id, $uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name, user.user_email, user.user_phone
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE submission.sub_id = $id AND submission.user_id = $uid";

            $result = $conn->query($sql);
            if($result == TRUE) {
                if($result->num_rows > 0) {
                    $paperwork = $result->fetch_assoc();
                    return $paperwork;
                }else {
                    return NULL;
                }

            }else {
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
                echo  "Error: " . $sql;
            }

        }


        public function updateByUID()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "UPDATE submission SET
            program_name = '$this->program_name',
            advisor = '$this->advisor',
            sender_role = '$this->sender_role',
            attached_file = '$this->attached_file',
            updated_at = '$this->updated_at',
            club_id = $this->club_id
            WHERE sub_id = $this->id AND user_id = $this->user_id";

            //var_dump($sql);
            if($conn->query($sql) == TRUE) {
                if($conn->affected_rows != 0){
                   return "success";
                }else{
                    return "unauthorized data";
                }
            }else {
               return "failed";
            }
        }

        public function responseByID()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "UPDATE submission SET
            subs_response = '$this->response',
            returned_file = '$this->returned_file',
            updated_at = '$this->updated_at',
            sub_status = '$this->status'
            WHERE sub_id = $this->id";

            // var_dump($sql);
            if($conn->query($sql) == TRUE) {
                if($conn->affected_rows != 0){
                    return "success";
                }else{
                    return "unauthorized data";
                }
            }else {
              return "failed";
            }
        }

        public static function searchPaperworkClub($club)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name 
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE club.club_name LIKE '%$club%'
            ORDER BY submission.created_at DESC";

            //var_dump($sql);
            $result = $conn->query($sql);
            if($result == TRUE) {
                return $result;
            }else{
                return null;
            }
        }

        public static function searchPaperworkClubUID($event,$uid)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT submission.*, user.matrix_no, user.user_name, club.club_name 
            FROM submission
            JOIN user ON submission.user_id = user.user_id
            JOIN club ON submission.club_id = club.club_id
            WHERE club.club_name LIKE '%'$event'%' AND submission.user_id = $uid
            ORDER BY submission.created_at DESC";

            //var_dump($sql);
            $result = $conn->query($sql);
            if($result == TRUE) {
                return $result;
            }else{
                echo "<script>alert('Extracting submissions went wrong!'); window.location.href = '../view/paperwork_view.php?mode=1'</script>";
            }
        }

        public static function responseTime()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT sub_id, TIMESTAMPDIFF(MINUTE, created_at, updated_at) AS DIFFERENCE 
            FROM submission WHERE week(created_at) = week(now()) AND sub_status <> 'IN PROGRESS'";

            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }else{
               return NAN;
            }
        }
        
    }

?>