<?php
	$addr = '192.168.0.106';
	$port = 7881;
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

	$buffer = 'SOCA NELAS';

	socket_connect($socket, $addr, $port);
	socket_send($socket, $buffer, strlen($buffer), 0);

	socket_close($socket);
