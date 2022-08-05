<?php
$conn = new PDO("mysql:host=127.0.0.1;dbname=dbuser", "root", "");
include_once "index.php";


class PeopleList
{
    /**Данный класс взаимодействует с классом BDPeople и таблицей user.
     * Он может отбирать людей по id и создавать из полученного отбора массив,
     * состоящий из экземпляров класса BDPeople и удалять их из БД.
     */
    private $id;

    public function  __construct($expression)
    {
        $column = "user_".$expression;
        $conn = new PDO("mysql:host=127.0.0.1;dbname=dbuser", "root", "");
        $sql = "SELECT * FROM `user` WHERE $column";
        $people = $conn->query($sql);
        $searchId = array();
        while ($row = $people->fetch()) {
        $this->searchId[] = $row['user_id'];
        }
        
    }

    public function getPeopleById()
    {
        $allPeople = array();
        foreach ($this->searchId as $value) {
            $allPeople[] = new DBPeople($value);
        }
        return $allPeople;
    }

    public function deletePeopleById()
    {
        foreach($this->searchId as $value) {
            $people = new DBPeople($value);
            $people->deletePeople();
        }

    }
    
}