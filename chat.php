<?php

    declare(strict_types=1);
    
    $address = '192.168.0.105';
    $port = 7881;
    $byte = 1024;

    #"Cria" um soquete indicando o tipo de ip, familia de protocolos e o protocolo
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    # Endereça o socket com o $address e a $port
    socket_bind($socket, $address, $port);

    socket_listen($socket, 1);

    while(true){
        
        $connection = socket_accept($socket);
        $handler_client = socket_read($connection, $byte);

        list($type_request, $request, $protocol) = explode(' ', $handler_client);

        if($request === '/' and $request === ''){
            $request = 'index.php';
        };

        socket_getpeername($connection, $peer_address, $peer_port);

        socket_write($connection, substr($request, 1), 2000);
    };


