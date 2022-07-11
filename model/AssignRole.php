<?php

    include_once '../model/database.php';
    include_once '../model/User.php';

    class Assign {

        public $user_id;
        public $role_id;
        public $position = NULL;

        public function create() 
        {
            
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "INSERT INTO assign VALUES($this->user_id, $this->role_id, '$this->position')";

            if($conn->query($sql) === TRUE) {
                return "success";
            } else {
                return 'failed';
            }

            $conn->close();
        }

        public static function get_role($id,$role)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $id = intval($id);

            $sql = "SELECT * FROM assign WHERE user_id = $id AND role_id = $role";

            $result = $conn->query($sql);

            if($result == TRUE) {
                if($result->num_rows > 0) {
                    $role = $result->fetch_assoc();
                    return $role;
                }else {
                    return NULL;
                }

            }else {
                echo  "Error: " . $sql;
            }

            $conn->close();
        }

        public function removeRole()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "DELETE FROM assign 
            WHERE user_id = $this->user_id AND role_id = $this->role_id";

            session_start();
            if($result = $conn->query($sql) == TRUE) {

                if($conn->affected_rows != 0) {
                    $_SESSION['message'] = "Role removed successfully";
                    $_SESSION['modal'] = 1;
                    echo "<script>window.location.href = history.back();</script>";
                    echo "Role removed successfully";
                }else{
                    echo "<script>alert('Unauthorized data!'); window.location.href = history.back();</script>";
                }
            }else {
                $_SESSION['message'] = "Role was not successfully removed";
                $_SESSION['modal'] = 1;
                echo "<script>window.location.href = history.back();</script>";
                echo  "Error: " . $sql;
            }
        }
    }
?>