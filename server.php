<?php
	declare(strict_types=1);
	set_time_limit(0);
	//if(!defined('MSG_DONTWAIT')) define('MSG_DONTWAIT', 0x40);

	//>>%id->1223489

	$unknow_clients = [];
	$clients = [];
	$addr = '0.0.0.0';
	$port = 7881;
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

	socket_bind($socket, $addr, $port);
	socket_listen($socket);
    socket_set_nonblock($socket);

    while(1){
    	if(($new_client = socket_accept($socket)) !== false){
	    	echo var_dump($new_client)."\n";
    		array_push($unknow_clients, $new_client);
    	};
    	if(count($unknow_clients)){
	    	foreach ($unknow_clients as $key){
	    		socket_getpeername($key, $ip, $door);
	    		if(($len = socket_recv($key, $buffer, 1024, 0)) !== false){
	    			if($len !== 0){
	    				if(substr($buffer, 0, 7) === '>>%id->'){
	    					$id = substr($buffer, 7, ($len - 7));
	    					if(!array_key_exists($id, $clients)){
	    						$pos = array_search($key, $unknow_clients);
	    						unset($unknow_clients[$pos]);
	    						$clients[$id] = $key;
	    					};
	    				};
	    			};
	    		};
	    	};

	    //var_dump($unknow_clients);
	    //var_dump($clients);
	    //sleep(3);
	    };
	    unset($new_client);
    };
    socket_close($socket);

