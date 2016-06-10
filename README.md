# RabbitMQ com PHP

Explicando linha a linha...

## Configuração

Crie o arquivo de configuração:

```sh
$ cp /caminho/da/app/config/rabbitmq.example /caminho/da/app/config/rabbitmq.php
```

## Simples

Baseado no tutorial "Hello World!" do RabbitMQ: [https://www.rabbitmq.com/tutorials/tutorial-one-php.html](https://www.rabbitmq.com/tutorials/tutorial-one-php.html).

Execute na raiz:

```sh
$ php simples/send.php
```

E em outro shell, rode o receive.php:

```sh
$ php simples/receive.php
```

## Worker

Baseado no tutorial "Work Queues" do RabbitMQ: [https://www.rabbitmq.com/tutorials/tutorial-two-php.html](https://www.rabbitmq.com/tutorials/tutorial-two-php.html).


