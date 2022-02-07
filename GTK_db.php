<?php

class GTKdb
{
    private $server = 'localhost';
    private $user = 'f0627228_GTKdb';
    private $pass = '228228228';
    private $db = 'f0627228_GTKdb';
    private $mysqli = null; //Готовое подключение

    function __construct()
    {
        $connect = new mysqli($this->server, $this->user, $this->pass, $this->db);

        if (!empty($connect->connect_errno)) {
            die('Error: Data base connect error (' . $connect->connect_errno . ') ' . $connect->connect_error);
        }

        $this->mysqli = $connect;
    }

    public function selectAll($tableName)
    {
        $sqlQuery = 'SELECT Nickname, Score, Date_reach FROM '.$tableName.' ORDER BY `Score` DESC';

        $obj = $this->mysqli->query($sqlQuery);

        if (!empty($this->mysqli->error_list)) {
            die('Error: Data base error (' . $this->mysqli->errno . ') ' . $this->mysqli->error);
        }

        $result = array();
        while ($row = $obj->fetch_assoc()) {
            $result[] = $row;
        };

        return $result;
    }

    public function Insert($tableName, $Name, $Score)
    {
        $sqlQuery = 'INSERT INTO ' . $tableName . ' (Nickname, Score) VALUES ("' . $Name . '", "' . $Score .'")';
        $this->mysqli->query($sqlQuery);

        if (!empty($this->mysqli->error_list)) {
            die('Error: Data base error (' . $this->mysqli->errno . ') ' . $this->mysqli->error);
        }
    }
}