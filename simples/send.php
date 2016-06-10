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

// Adiciona o canal 'hello'
$channel->queue_declare('hello', false, false, false, false);

// Cria a mensagem
$msg = new AMQPMessage('Olá Tray!');

// Envia a mensagem para o canal 'hello' criado na linha 13
$channel->basic_publish($msg, '', 'hello');

// Printa na tela informando que a mensagem foi enviada
echo " [x] Mensagem enviada \n";

// Fecha o canal
$channel->close();

// Fecha a conexão
$connection->close();