<?php
require_once './eth.php';

$eth = new eth();
$rs = $eth->getContract("0x943ED852DadB5C3938ECdC6883718df8142DE4C8");
var_dump($rs);

