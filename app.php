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
            $tasks = lerDados();
            
            foreach($tasks as $task) { 
                echo "ID: {$task['id']} | Descrição: {$task['description']} | Status: {$task['status']}".PHP_EOL;
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


    function lerDados(){
        $file = fopen("task-tracker.json", "r") or die("Error: Unable to open data!");
        $a_data = fread($file, filesize("task-tracker.json")); 
        fclose($file);
        return toArray($a_data);
    }
    
    function toArray(String $arr){
        $data = json_decode($arr, true);
        return $data['Tasks'];
    }

