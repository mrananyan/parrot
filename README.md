# Parrot #
An Facebook like long polling stack for PHP-based real-time applications

<img src="https://raw.githubusercontent.com/mrananyan/parrot/main/logo.png">

# Demo #
[Demo app](https://lp.hotdot.me/)
[Demo app source](https://github.com/mrananyan/parrot_demo)


# Requirements #
* Redis 
* PHP-FPM
* Nginx

# Installation #
```bash
composer require mrananyan/parrot:1.0.0
```

# How setup #
0. Configuration

If you want to connect via TCP (Recommended for remote server)
```php
$parameters = [
                  'scheme' => 'tcp',
                  'host'   => '127.0.0.1',
                  'port'   => 6379,
              ];
```

If you want to connect via UNIX socket (Recommended if Redis on same server)
```php
$parameters = [
                  'scheme' => 'unix',
                  'path'   => '/var/run/redis/redis.sock',
              ];
```

1. Worker. 
You can subscribe to many channels at once if you need. ('chanel1','chanel2' ...)
```php
use Parrot\Server\Worker;

$parrotWorker = new Worker($parameters);
$messages = $parrotWorker->subscribe('myChanel');
echo json_encode($messages);
```

2. Publisher. Send message to users who subscribed to myChanel chanel
```php
use Parrot\Client\Publisher;

$publisher = new Publisher($parameters);
$publisher->set('myChanel', 'Your message string here');
```