<?php

    include_once '../model/database.php';


    class User {

        public $id = NULL;
        public $matrix_no;
        public $user_name;
        public $user_gender;
        public $user_password;
        public $user_phone;
        public $user_email;
        public $created_at;
        public $updated_at;

        public function create() 
        {

            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "INSERT INTO user(matrix_no, user_name, user_gender, user_password, user_phone, user_email, created_at, updated_at)
            VALUES('$this->matrix_no', '$this->user_name', '$this->user_gender', '$this->user_password', '$this->user_phone', '$this->user_email', '$this->created_at', '$this->created_at')";

            session_start();
            if($conn->query($sql) == TRUE) {
                $_SESSION['message'] = "Registration Successful!";
                $_SESSION['modal'] = 1;
                return " user success";
            }else {
                $_SESSION['message'] = "Something went wrong";
                $_SESSION['modal'] = 2;
                return "user failed";
            }

            
        }

        public static function getAllUser()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT user.*, assign.role_id, assign.position, role.role_desc 
            FROM user
            LEFT JOIN assign ON user.user_id = assign.user_id 
            LEFT JOIN role ON assign.role_id = role.role_id
            ORDER BY assign.role_id DESC";

            $result = $conn->query($sql);

            if($result == TRUE) {
                return $result;
            }else {
                echo  "Error: " . $sql;
            }

            $conn->close();
        }

        public static function get_user($id=NULL, $matrix=NULL) 
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            //check if the parameter is empty or not
            $id = !empty($id) ? $id : NULL;
            $matrix = !empty($matrix) ? $matrix : 'NULL';

            //convert to the integer value
            $id = intval($id); 

            $sql = "SELECT user.*, assign.role_id, assign.position, role.role_desc 
            FROM user 
            LEFT JOIN assign ON user.user_id = assign.user_id 
            LEFT JOIN role ON assign.role_id = role.role_id 
            WHERE user.user_id = $id OR user.matrix_no = $matrix
            ORDER BY assign.role_id DESC";

            $result = $conn->query($sql);

            if($result == TRUE) {
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return $user;
                }else {
                    return NULL;
                }

            }else {
                echo  "Error: " . $sql;
            }

            $conn->close();
        }

        public static function get_user_role($id=NULL, $matrix=NULL, $role) 
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            //check if the parameter is empty or not
            $id = !empty($id) ? $id : NULL;
            $matrix = !empty($matrix) ? $matrix : 'NULL';

            //convert to the integer value
            $id = intval($id); 

            $sql = "SELECT user.*, assign.role_id, assign.position, role.role_desc 
            FROM user 
            LEFT JOIN assign ON user.user_id = assign.user_id 
            LEFT JOIN role ON assign.role_id = role.role_id 
            WHERE user.user_id = $id OR user.matrix_no = $matrix
            AND role.role_id = $role";

            $result = $conn->query($sql);

            if($result == TRUE) {
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return $user;
                }else {
                    return NULL;
                }

            }else {
                echo  "Error: " . $sql;
            }

            $conn->close();
        }

        public function update() 
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "UPDATE user 
            SET user_name = '$this->user_name',
            user_password = '$this->user_password',
            user_gender = '$this->user_gender',
            user_phone = '$this->user_phone',
            user_email = '$this->user_email',
            updated_at = '$this->updated_at'
            WHERE matrix_no = $this->matrix_no or user_id = $this->id";

            session_start();
            if($conn->query($sql) == TRUE) {
                if($conn->affected_rows != 0){
                    $_SESSION['message'] = "User updated successfully!";
                    $_SESSION['modal'] = 1;
                    echo "<script>window.location.href = history.back();</script>";
                    echo "User updated successfully!";
                }else{
                    echo "<script>alert('Unauthorized data!'); window.location.href = history.back();</script>";
                }
            }else {
                $_SESSION['message'] = "Update not successfull [TECHNICAL ERROR]";
                $_SESSION['modal'] = 1;
                echo "<script>window.location.href = history.back();</script>";
                echo  "Error: " . $sql;
            }

            $conn->close();
        }

        public function delete($id=NULL)
        {

            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "DELETE FROM user WHERE matrix_no = $matrix_no or user_id = $id";

            if($conn->query($sql) == TRUE) {
                echo "User deleted successfully!";
            }else {
                echo  "Error: " . $sql;
            }

            $conn->close();

        }
    }

?>