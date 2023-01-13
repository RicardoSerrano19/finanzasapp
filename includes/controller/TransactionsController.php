<?php

    include_once '../functions/Database.php';
    include_once '../service/TransactionService.php';
    include_once '../error/GlobalException.php';

    $requestBody = file_get_contents('php://input');
    $body = json_decode($requestBody, true);
    
    if(!isset($body['action'])) {
        $exception = new GlobalException("Not action supported", 400, "Bad Request");
        echo json_encode($exception);
        return;
    }

    // Get database connection
    $database = new Database();
    $db = $database->getConnection();
    $transactionService = new TransactionService($db);

    if($body['action'] == "/findById"){
        // Get request
        $id = $_POST['id'];
    
        $result = $transactionService->getTransactionById($id);
        
        echo json_encode($result);
    }
    
    if($body['action'] == "/findAll"){
        // Get request
    
        $result = $transactionService->getTransactions();
       
        echo json_encode($result);
    }

    if($body['action'] == "/findByType"){
        // Get request
        $type = $body['type'];

        $result = $transactionService->getTransactionsByType($type);
        
        echo json_encode($result);
    }

    if($body['action'] == "create"){
        $category = $body['category'];
        $amount = $body['amount'];
        $date = $body['date'];

    $result = $transactionService->create($category, $amount, $date);
    echo json_encode($result);
    }

?>