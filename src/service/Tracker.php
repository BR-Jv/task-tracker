<?php 
    require('./src/service/DataManager.php');

    class Tracker {

        private $manager;
        public $msg;

        function __construct()
        {
            $this->manager = new DataManager();
        }


        function add($description)
        {
            $dt_created = date("Y-m-d G:H:s");
            $newTask = [
                "id" => 0,
                "description" => $description,
                "status" => "todo",
                "createdAt" => $dt_created,
                "updatedAt" => $dt_created
            ];
            $this->msg = $this->manager->setData($newTask);
            
        }

        function update()
        {

        }

        function delete()
        {

        }
    }