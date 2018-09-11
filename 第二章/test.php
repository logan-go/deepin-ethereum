<?php
require_once './eth.php';
require_once './db.php';

$db = new db();

$eth = new eth();

$startBlockNumber = 6306310;
$endBlockNumber = $eth->blockNumber();

$contractAddress = '0x943ed852dadb5c3938ecdc6883718df8142de4c8';

for(;;){
    for($i = $startBlockNumber;$i < $endBlockNumber - 12;$i++){
        $block = $eth->getBlock($i);

            var_dump($i);
        foreach($block["transactions"] as $tx){

            if(strtolower($tx["to"]) != $contractAddress){
                continue;
            }
            if(substr(strtolower($tx["input"]),0,10) != "0xa9059cbb"){
                continue;
            }
            $rec = $eth->getTransactionReceipt($tx["hash"]);
            if($rec["status"] !== TRUE){
                continue;
            }

            $hash = $tx["hash"];
            $from = $tx["from"];
            $to = '0x' . strtolower(substr($tx["input"],34,40));
            $value = hexdec(substr($tx["input"],74,64));
            $value = intval($value / 1000000000);
            $blockNumber = $i;
            $time = $block["timestamp"];
            $status = 0;
            $createTime = time();

            $user_id = intval($db->query("SELECT id FROM user WHERE wallte = '" . $to . "'")->fetch()["id"]);
            

            $sql = "INSERT INTO transaction SET `user_id` = '" . $user_id . "', `hash` = '" . $hash . "',`from` = '" . $from . "',`to` = '" . $to . "',`value` = '" . $value . "',`blockNumber` = '" . $blockNumber . "',`time` = '" . $time . "',`status` = '" . $status . "',`createtime` = '" . $createTime . "'";
            $rs = $db->exec($sql);
            if(!$rs){
                var_dump($db->errorInfo());
            }
        }
    }

    sleep(100);
    $startBlockNumber = $i;
    $endBlockNumber = $eth->blockNumber();
}
