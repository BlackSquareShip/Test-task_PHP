<?php
$conn = new PDO("mysql:host=127.0.0.1;dbname=dbuser", "root", "");
include_once "index.php";


class PeopleList
{
    private $id;

    public function  __construct($expression){
        $column = "user_".$expression;
        $conn = new PDO("mysql:host=127.0.0.1;dbname=dbuser", "root", "");
        $sql = "SELECT * FROM `user` WHERE $column";
        $people = $conn->query($sql);
        $searchId = array();
        while($row = $people->fetch()){
        $this->searchId[] = $row['user_id'];
        }
        
    }

    public function peopleById(){
        $allPeople = array();
        foreach($this->searchId as $value){
            $allPeople[] = new DBPeople($value);
        }
        return $allPeople;
    }

    public function deletePeopleById(){
        foreach($this->searchId as $value){
            $people = new DBPeople($value);
            $people->deletePeople();
        }

    }
    
}