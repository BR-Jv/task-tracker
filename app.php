<?php 

    require('./src/service/DataManager.php');

    // $sapi = php_sapi_name();

    // if($sapi != "cli"){
    //     exit("Encerrando script.");
    // }

    $manager = new DataManager();
    $data = [
        "id" => 8,
        "description" =>  "Teste com dado mocado",
        "status" =>  "todo",
        "createdAt" => "2026-07-10 12:12:24",
        "updatedAt" =>  "2026-07-10 12:12:24"
    ];
    $manager->setData($data);


    die();

    switch($argv[1]) {
        case "add":
            $id = add($argv[2]);
            echo "Task adicionado com sucesso. (ID: $id)".PHP_EOL;

            break; 
        case "update": 
            $id = $argv[2]; 
            $newDescription = $argv[3];
            $msg = update($id, $newDescription); 
            echo "{$msg}" ;
            
            break; 
        case "delete": 
            $id = $argv[2];
            $msg = delete($id);
            echo "{$msg}" ;
           
            break;
        case "list":
            
            $tasks = lerDados();
            
            if(isset($argv[2])){
                foreach($tasks as $task) {
                    if($task['status'] == $argv[2]){
                        echo "ID: {$task['id']} | Descrição: {$task['description']} | Status: {$task['status']}".PHP_EOL;
                    }
                } 
            }else {
                foreach($tasks as $task) { 
                    echo "ID: {$task['id']} | Descrição: {$task['description']} | Status: {$task['status']}".PHP_EOL;
                }
            }

            break;
        case "mark-in-progress":
            $id = $argv[2]; 
            $msg = updateStatus($id, 'in-progress'); 
            echo "{$msg}";

            break;
        case "mark-done":
            $id = $argv[2]; 
            $msg = updateStatus($id, 'done'); 
            echo "{$msg}";
            
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

    
    function updateStatus(int $id, String $status) {

        $tasks = lerDados();
        
        foreach($tasks as &$task){
            if($task['id'] == $id) {
                $task['status'] = $status;
            }
        }
        unset($task);

        if ( !gravarDados($tasks) ) {
            return "Erro ao salvar task"; 
        } 

        return "Task salva com sucesso"; 
    }
    

    function update(int $id, String $newDescription) {

        $tasks = lerDados();

        foreach($tasks as &$task){
            if($task['id'] == $id) {
                $task['description'] = $newDescription;
            }
        }
        unset($task);

        if ( !gravarDados($tasks) ) {
            return "Erro ao salvar task"; 
        } 

        return "Task salva com sucesso"; 
    }

    function delete(int $id) {
        $tasks = lerDados();
        $newTasks = []; 

        foreach($tasks as $task) {
            if ($task['id'] != $id) {
                array_push($newTasks, $task);
            }  
        }

        if ( !gravarDados($newTasks) ) {
            return "Erro ao deletar task"; 
        } 

        return "Task deletada com sucesso"; 
        
    }

    
    //! Lógica sendo implementada no constructor da classe Manager
    
    function lerDados(){

        //! Abertura de arquivo é responsabilidade de outra função.
        $file = fopen("task-tracker.json", "r") or die("Error: Unable to open data!");
        
        $a_data = fread($file, filesize("task-tracker.json")); 
        
        fclose($file);
        return toArray($a_data);
    }
    
    function gravarDados(Array $data) {
        
        //! Abertura de arquivo é responsabilidade de outra função. 
        $file = fopen("task-tracker.json", "w"); 

        //! Essa é responsabilidade da função 
        $result = fwrite($file, toJSON($data)); 
        
        fclose($file);

        return gettype($result) == "integer" ? true : false;
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

    //!------------------------------------------------
