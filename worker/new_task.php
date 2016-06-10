<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Captura os dados de config
$configs = include __DIR__ . '/../config/rabbitmq.php';

// Cria a conexão
$connection = new AMQPStreamConnection($configs['host'], $configs['port'], $configs['user'], $configs['password']);

// Instancia o canal
$channel = $connection->channel();

// Adiciona o canal 'task_queue'
// Declarando o terceiro parametro como 'true', 
// o rabbit entende que nunca deverá perder o processo
$channel->queue_declare('task_queue', false, true, false, false);

// Captura mensagens do console
$data = implode(' ', array_slice($argv, 1));

// Caso nao tenha mensagens
if (empty($data)) {
    $data = "Olá Tray!";
}

// Cria a mensagem
// delivery_mode=2: deixa a mensagem persistente
$msg = new AMQPMessage($data, ['delivery_mode' => 2]);

// Publica a mensagem
$channel->basic_publish($msg, '', 'task_queue');

// Printa na tela informando que a mensagem foi enviada
echo " [x] Enviado ", $data, " \n";

// Fecha o canal
$channel->close();

// Fecha a conexão
$connection->close();