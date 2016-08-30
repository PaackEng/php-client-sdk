### Get Started ###

```
#!bash

curl -sS https://getcomposer.org/installer | php
composer require paack/php-client
require 'vendor/autoload.php';

```

### API ###

```
#!php

use \Paack\Client;

$client = new Client('API_KEY');
$client->createOrder($order);
$client->getStores();
$client->getStore($id);
$client->getOrders();
$client->getOrders('status');


```