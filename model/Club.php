<?php

    include_once '../model/database.php';

    class Club {

        public $id = NULL;
        public $name;
        public $created_at;
        public $updated_at;

        public function create() 
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "INSERT INTO club(club_name, updated_at, created_at) VALUES('$this->name', '$this->created_at', '$this->created_at')";

            session_start();
            if($conn->query($sql) == TRUE) {
                $_SESSION['message'] = "Club registered successfully!";
                $_SESSION['modal'] = 1;
                echo header("Location: ../view/club_view.php");
                echo "Club created successfully!";
            }else {
                $_SESSION['message'] = "Club registration was not successfull";
                $_SESSION['modal'] = 1;
                echo header("Location: ../view/club_view");
                echo  "Error: " . $sql;
            }
        }

        public static function getAllClubs()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT * FROM club";

            $results = $conn->query($sql);
            if($results == TRUE) {
                return $results; 
            }
        }

        public static function getClubByID($id)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "SELECT * FROM club WHERE club_id = $id";

            $result = $conn->query($sql);
            if($result == TRUE) {
                if($result->num_rows > 0) {
                    $club = $result->fetch_assoc();
                    return $club;
                }else {
                    return NULL;
                }

            }else {
                //echo "<script>alert('Extracting club went wrong!'); window.location.href = '../view/club_view.php'</script>";
                echo  "Error: " . $sql;
            }
        }

        public static function deleteByID($id)
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "DELETE FROM club WHERE club_id = $id";

            session_start();
            if($result = $conn->query($sql) == TRUE) {

                if($conn->affected_rows != 0) {
                    $_SESSION['message'] = "Club deleted successfully!";
                    $_SESSION['modal'] = 1;
                    echo "<script>window.location.href = history.back();</script>";
                    echo "Club deleted successfully!";
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

        public function update()
        {
            //get a DB connection
            $instance = Database::getInstance();
            $conn = $instance->getDBConnection();

            $sql = "UPDATE club SET
            club_name = '$this->name',
            updated_at = '$this->updated_at'
            WHERE club_id = $this->id";

            //var_dump($sql);
            if($conn->query($sql) == TRUE) {
                if($conn->affected_rows != 0){
                    $_SESSION['message'] = "Club updated successfully!";
                    $_SESSION['modal'] = 1;
                    echo "<script>window.location.href = history.back();</script>";
                    echo "Club updated successfully!";
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
    }

?>