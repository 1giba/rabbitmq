<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

// Captura os dados de config
$configs = include __DIR__ . '/../config/rabbitmq.php';

// Cria a conexão
$connection = new AMQPStreamConnection($configs['host'], $configs['port'], $configs['user'], $configs['password']);

// Instancia o canal
$channel = $connection->channel();

// Adiciona o canal
$channel->queue_declare('hello', false, false, false, false);

// Printa na tela
echo ' [*] Aguardando mensagem. Para sair, tecle CTRL+C', "\n";

// Criar closure de resposta
$callback = function($msg) {
  echo " [x] Mensagem recebida ", $msg->body, "\n";
};

// Indica o que será feito no canal 'hello' com a closure de resposta
// assim que chegar a mensagem
$channel->basic_consume('hello', '', false, true, false, false, $callback);

// Fica escutando o canal 'hello'
while (count($channel->callbacks)) {
    $channel->wait();
}

// Fecha o canal
$channel->close();

// Fecha a conexão
$connection->close();