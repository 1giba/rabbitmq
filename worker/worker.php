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
$channel->queue_declare('task_queue', false, true, false, false);

// Printa na tela
echo ' [*] Aguardando mensagem. Para sair, tecle CTRL+C', "\n";

// Criar closure de resposta
$callback = function($msg){
  echo " [x] Mensagem recebida ", $msg->body, "\n";
  sleep(substr_count($msg->body, '.'));
  echo " [x] Fim", "\n";
  $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

// O segundo parametro '1' diz ao rabbit para nao processar mais que 1 por vez
$channel->basic_qos(null, 1, null);

// Indica o que será feito no canal 'task_queue' com a closure de resposta
// assim que chegar a mensagem
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);


// Fica escutando o canal 'hello'
while (count($channel->callbacks)) {
    $channel->wait();
}

// Fecha o canal
$channel->close();

// Fecha a conexão
$connection->close();