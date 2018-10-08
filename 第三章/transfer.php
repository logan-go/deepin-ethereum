<?php
require_once "../第二章/db.php";
require_once "../第二章/eth.php";

$db = new db();
$eth = new eth();

for(;;){
    $sql = "SELECT * FROM add_transaction WHERE status = '1'";
    $rows = $db->query($sql)->fetchAll();

    if(empty($rows)){
        var_dump(__FILE__,"EMPTY");
        sleep(60);
        continue;
    }

    foreach($rows as $row){
        $sql = "UPDATE add_transaction SET status = 4 WHERE id = '{$row["id"]}' AND status = 1";
        $rs = $db->exec($sql);
        if(!$rs){
            var_dump(__LINE__,"FAILED",$db->errorInfo());
            continue;
        }

        $tx = getTx($row["to"],$row["value"]);
        $rs = $eth->sendTransaction($tx,PASSWORD);
        var_dump($rs);
        if(!$rs){
            var_dump(__LINE__,"FAILED");
            continue;
        }

        $sql = "UPDATE add_transaction SET status = 5,hash = '{$rs}' WHERE id = '{$row["id"]}' AND status = 4";
        $rs = $db->exec($sql);
        if(!$rs){
            var_dump(__LINE__,"FAILED",$db->errorInfo());
            continue;
        }
    }
}

function getTx($to,$value){
    $eth = new eth();
    $value = $value * 1000000000000000000;
    $tx = array();
    $tx["from"] = FROM_ACCOUNT;
    $tx["to"] = CONTRACT_ADDRESS;
    $tx["gas"] = '0x' . dechex(60000);
    $tx["gasPrice"] = $eth->gasPrice();
    $tx["input"] = "0xa9059cbb" . $eth->get64LengthAddress($to) . $eth->get64LengthValue($value);

    return $tx;
}
