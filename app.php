<?php 

    $sapi = php_sapi_name();

    if($sapi != "cli"){
        exit("Encerrando script.");
    }



    switch($argv[1]) {
        case "add":
            $id = add($argv[2]);
            echo "Task adicionado com sucesso. (ID: $id)".PHP_EOL;

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
    
    function add(string $description) : int {
        
        $tasks = lerDados();
        $id = ultimoId( $tasks ); 
        
        //! Hora, segundo, milesimo está saindo errado. 
        $dt_created = date("Y-m-d G:H:s");
        $data = [
            "id" => $id + 1,
            "description" => $description,
            "status" => "todo",
            "createdAt" => $dt_created,
            "updatedAt" => $dt_created
        ];
        
        array_push($tasks, $data); 
        
        gravarDados($tasks);
        
        return $data['id'];
    }


    function lerDados(){
        $file = fopen("task-tracker.json", "r") or die("Error: Unable to open data!");
        $a_data = fread($file, filesize("task-tracker.json")); 
        fclose($file);
        return toArray($a_data);
    }
    
    function gravarDados(Array $data){
        $file = fopen("task-tracker.json", "w") or die("Error: Unable to open data!");
        $result = toJSON($data);
        fwrite($file, $result); 
        fclose($file);
    }

    function toArray(String $arr){
        $data = json_decode($arr, true);
        return $data['Tasks'];
    }
    function toJSON(Array $arr){
        $arr = [
            "Tasks" => $arr
        ];

        return json_encode($arr);
    }

    function ultimoId(Array $arr) : int {
        $task = $arr[sizeof($arr) - 1];
        return $task['id'];
    }
