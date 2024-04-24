<?php
// Criar um servidor TCP
$server = new Swoole\Server("0.0.0.0", 9501);

// Configurações do servidor
$server->set([
    'worker_num' => 4, // Número de processos trabalhadores
]);

// Evento para lidar com conexões recebidas
$server->on('connect', function ($server, $fd) {
    echo "Cliente conectado: $fd\n";
});

// Evento para lidar com dados recebidos
$server->on('receive', function ($server, $fd, $from_id, $data) {
    echo "Recebido dados do cliente $fd: $data\n";
    
    // Enviar de volta os dados recebidos para o cliente
    $server->send($fd, "Você enviou: $data");
});

// Evento para lidar com a desconexão de um cliente
$server->on('close', function ($server, $fd) {
    echo "Cliente desconectado: $fd\n";
});

// Iniciar o servidor
echo "Servidor iniciado...\n";
$server->start();
