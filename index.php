<?php

try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=dbuser", "root", "");
    echo "DB is connect <br/>";

    class DBPeople
    {
        private $id, $name, $surname, $birth_date, $gender, $birth_city;

        public function __construct($id = null, $name = null, $surname = null, $birth_date = null, $gender = null, $birth_city = null)
        {
            $this->id = $id;
            $this->conn = new PDO("mysql:host=127.0.0.1;dbname=dbuser", "root", "");
            if($id != null){
                $sql = "SELECT * FROM `user` WHERE `user_id` = $id";
                $people = $this->conn->query($sql);
                $row = $people->fetch();
                $this->name = $row['name'];
                $this->surname = $row['surname'];
                $this->birth_date = $row['birth_date'];
                $this->gender = $row['gender'];
                $this->birth_city = $row['birth_city'];
            }
            else{
                $sql = "INSERT INTO `user`(`name`, `surname`, `birth_date`, `gender`, `birth_city`) 
                VALUES ('$name', '$surname', '$birth_date', '$gender', '$birth_city')";
                $this->conn->exec($sql);
            }
        }

        public function newPeople($name = null, $surname = null, $birth_date = null, $gender = null, $birth_city = null)
        {
            $sql = "INSERT INTO `user`(`name`, `surname`, `birth_date`, `gender`, `birth_city`) 
            VALUES ('$name', '$surname', '$birth_date', '$gender', '$birth_city')";
            $this->conn->exec($sql);
        }

        public function deletePeople($id)
        {
            $sql = "DELETE FROM `user` WHERE `user_id` = $id";
            $this->conn->exec($sql);
        }

        static function dateToAge($people){
            $birth_date = strtotime($people->birth_date);
            $current_date = strtotime(date('y-m-d'));
            $age =floor(abs($birth_date - $current_date)/60/60/24/365);
            return $age;
        } 

        static function getGender($people){
            $gender = $people->gender;
            if ($gender == 0){
                return "Male";
            } else {
                return "Female";
            }
        } 

        public function formatPeople($isGender = null, $isDate = null){
            $newStd = new stdClass;
            $newStd->name = $this->name;
            $newStd->surname = $this->surname;
            if ($isDate != null){
                $newStd->age = $this::dateToAge($this);
            } else {
                $newStd->birth_date = $this->birth_date;
            };
            if ($isGender != null){
                $newStd->gender = $this::getGender($this);
            } else {
                $newStd->gender = $this->gender;
            };
            $newStd->birth_city = $this->birth_city;

            return $newStd;
        }

    };

    $lil = new DBPeople(18);


} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

