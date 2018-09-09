<?php
require_once './eth.php';

$eth = new eth();

var_dump($eth->blockNumber());
var_dump($eth->gasPrice());
var_dump($eth->getTransactionByHash("0x071a69a33c93206ea84cc991d926d91d3092a70e25a86be5a546cf0b10619e7f"));
var_dump($eth->getTransactionReceipt("0x071a69a33c93206ea84cc991d926d91d3092a70e25a86be5a546cf0b10619e7f"));
var_dump($eth->getTransactionByHash("0x071a69a33c93206ea84cc991d926d91d3092a70e25a86be5a546cf0b10619e"));
