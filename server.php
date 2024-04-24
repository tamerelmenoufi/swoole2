<?php

use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

// Crie um novo servidor WebSocket
$server = new Server('0.0.0.0', 9501);

// Evento de mensagem
$server->on('message', function (Server $server, Frame $mensagem) {
    /** @var \Swoolw\Connection\Iterator $conexoes */
    $conexoes = $server->connections;
    $origem = $mensagem->fd;

    foreach($conexoes as $conexao){
        if($conexao === $origem) continue;
        $server->push(
            $conexao,
            json_encode(['type' => 'chat', 'text' => $mensagem->data])
        );
    }
    
});

// Evento de fechamento da conexão
$server->on('close', function (Server $server, $fd) {
    echo "Conexão fechada: $fd\n";
});

// Inicie o servidor
$server->start();
