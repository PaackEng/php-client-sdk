<?php

use Paack\Client;
use Paack\Resources\Order;
use Paack\Resources\OrderRequest;
use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Strategy\MockClientStrategy;

class ClientTest extends TestCase {
  public function setUp() {
     $this->client = new Client(getenv('API_KEY'));
  }

  public function testSetsApiKey(){
    $client = $this->client;
    $this->assertEquals(getenv('API_KEY'), $client->getApiKey());
  }

  public function testSetsBaseUrl(){
    $url = "123";
    $client = $this->client;
  	$client->setBaseUri($url);
  	$this->assertEquals($client->getBaseUri(), $url);
  }

  public function testLoadsOrders() {
    $client = $this->client;
    $client->setBaseUri("http://localhost:3000/api/public/v1/");
    $data = $client->getOrders();
    $this->assertNotNull($data);
    foreach ($data as $order) {
      $this->assertNotNull($order['id']);
    }
  }

  public function testCreateOrder(){
    $client = $this->client;
    $client->setBaseUri("http://localhost:3000/api/public/v1/");
    $orderRequest = new OrderRequest();
    $retailer_order_number = rand(10, 50);
    $orderRequest->setRecipientEmail("test@example.com");
    $orderRequest->setRecipientPhone("123123123");
    $orderRequest->setRecipientName("test");
    $orderRequest->setStoreId(14);
    $orderRequest->setDeliveryAddress("Barcelona", "08006", "Barcelona", "Spain");
    $orderRequest->setRetailerOrderNumber($retailer_order_number);
    $orderRequest->setDeliveryWindow(new DateTime(), new DateTime());
    $orderRequest->setPackages([]);
    $data = $client->createOrder($orderRequest);
    $this->assertNotNull($data['id']);
    $this->assertEquals($data['retailer_order_number'], $retailer_order_number);
  }

  public function testLoadsStores(){
    $client = $this->client;
    $client->setBaseUri("http://localhost:3000/api/public/v1/");
    $data = $client->getStores();
    $this->assertNotNull($data);
    foreach ($data as $store) {
      $this->assertNotNull($store['id']);
    }
  }
}
