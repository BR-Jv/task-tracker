<?php
class DataManager
{

    private $filename = "task-tracker.json";
    private array $file;


    function __construct()
    {
        $file = fopen($this->filename, "r") or die("Error: Não foi possível acessar o dados!");
        $data = fread($file, filesize($this->filename));
        $this->file = json_decode($data, true);
        fclose($file);
    }


    function getData()
    {
        return $this->file['Tasks'];
    }

    function getLastId()
    {
        $tasks = end($this->file['Tasks']);
        return $tasks['id'];
    }

    function setData($newTask)
    {
        array_push($this->file['Tasks'], $newTask);

        $this->insertData();
    }

    private function insertData()
    {
        $file = fopen($this->filename, "w");
        fwrite($file, json_encode($this->file));
        fclose($file);
    }
}
