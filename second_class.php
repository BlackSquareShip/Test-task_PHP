<?php
try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=dbuser", "root", "");
    echo "DB is connect <br/>";

    
    class PeopleList
    {
        private $id;

        public function  __construct($expression){
            $column = "user_".$expression;
            $conn = new PDO("mysql:host=127.0.0.1;dbname=dbuser", "root", "");
            $sql = "SELECT * FROM `user` WHERE $column";
            $people = $conn->query($sql);
            
            while($row = $people->fetch()){
            echo $row['name'];
            }
        }
        
    }

    $test = new PeopleList("id <> 18");
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}