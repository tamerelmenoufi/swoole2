<?php

use Swoole\WebSocket\Server;

// Crie um novo servidor WebSocket
$server = new Server('0.0.0.0', 9501);


// Evento de conexão
$server->on('open', function (Server $server, $request) {
    //echo "Nova conexão: {$request->fd}\n";
});


// Evento de mensagem
$server->on('message', function (Server $server, $frame) {
    //echo "Mensagem recebida: {$frame->data}\n";
    $conexoes = $server->connections;
    $origem = $frame->fd;

    foreach($conexoes as $conxao){
        // Envie a mensagem de volta para o cliente
        if($conxao == $origem) continue;
        $server->push($conxao, json_encode(['type' => 'chat', 'text' => $frame->data]));
    }
});

// Evento de fechamento da conexão
$server->on('close', function (Server $server, $fd) {
    echo "Conexão fechada: $fd\n";
});

// Inicie o servidor
$server->start();
