<?php 

    $sapi = php_sapi_name();

    if($sapi != "cli"){
        exit("Encerrando script.");
    }



    switch($argv[1]) {
        case "add":
            $id = add($argv[2]);
            echo "Task adicionado com sucesso. (ID: $id)";

            break; 
        case "update":
            
            break; 
        case "delete": 
            
            break;
        case "list":
            $tasks = getData();
            
            foreach($tasks as $task){
               echo $task[0]["id"];

            }

            break;
        default: 
            exit("Comando não reconhecido");
    }
    
    function add(string $task) : int {
        $id = 0;
        //Adicionando uma nova task, deve retornar o id 
        //! pegar o arquivo json e recuperar o último ID cadastrado

        return $id;
    }


    function getData(){
        $myfile = fopen("task-tracker.json", "r") or die("Error: Unable to open file!");
        $file = fread($myfile, filesize("task-tracker.json")); 
        fclose($myfile);
        return json_decode($file, true);
    }


