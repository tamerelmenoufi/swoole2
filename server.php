<?php

use Swoole\WebSocket\Server;

// // Crie um novo servidor WebSocket
$server = new Server("0.0.0.0", 9501);

// Configurações do SSL
$server->set([
    'ssl_cert_file' => __DIR__.'/crt/certificate.crt', // Caminho para o arquivo de certificado SSL
    'ssl_key_file' => __DIR__.'/crt/private.key', // Caminho para o arquivo de chave privada
]);


// Evento de conexão
$server->on('open', function (Server $server, $request) {
    //echo "Nova conexão: {$request->fd}\n";
});


// Evento de mensagem
$server->on('message', function (Server $server, $frame) {
    //echo "Mensagem recebida: {$frame->data}\n";
    $conexoes = $server->connections;
    $origem = $frame->fd;

    $content = http_build_query(["idChat" => $frame->fd, "text" => $frame->data]);
              
    $context = stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'content' => $content,
        )
    ));
    
    $result = file_get_contents('https://cron.capitalsolucoesam.com.br/wapp_chat.php', null, $context);

    foreach($conexoes as $conxao){
        // Envie a mensagem de volta para o cliente
        if($conxao == $origem) continue;
        $server->push($conxao, $result);
    }
});

// Evento de fechamento da conexão
$server->on('close', function (Server $server, $fd) {
    echo "Conexão fechada: $fd\n";
});



// Lógica para processar eventos da fila
function processarFila($server) {
    // Aqui você pode acessar o objeto do servidor Swoole e enviar mensagens para os clientes conectados

    $conexoes = $server->connections;

    $content = http_build_query(["idChat" => $frame->fd, "text" => 'update']);
              
    $context = stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'content' => $content,
        )
    ));
    
    $result = file_get_contents('https://cron.capitalsolucoesam.com.br/wapp_chat.php', null, $context);

    foreach($conexoes as $conxao){
        // Envie a mensagem de volta para o cliente
        $server->push($conxao, $result);
    }


}

// Loop para verificar periodicamente a fila
swoole_timer_tick(1000, function () use ($server) {
    processarFila($server);
});


// Inicie o servidor
$server->start();
