<?php

//! Classe que gerencia especificamente a base de dados em json
class DataManager
{

    private $filename = "task-tracker.json";
    private array $file;
    private int $lastid;
   

    function __construct()
    {
        $file = fopen($this->filename, "r");
        $data = fread($file, filesize($this->filename));
        $this->file = json_decode($data, true);
        $this->setLastId();
        fclose($file);
    }

    private function setLastId()
    {
        $tasks = end($this->file['Tasks']);
        $this->lastid = $tasks['id'];
    }

    private function insertData()
    {
        $file = fopen($this->filename, "w");
        
        if($file == false){
            throw new Exception("Não foi possível abiri o arquivo");
        };

        fwrite($file, json_encode($this->file));
        
        
        fclose($file);
    }

    function setData($data)
    {
        $data["id"] = $this->getLastId() + 1; 
        array_push($this->file['Tasks'], $data);
        $this->insertData();

    }

    function getData()
    {
        return $this->file['Tasks'];
    }

    function getLastId()
    {
        return $this->lastid;
    }

    
}
