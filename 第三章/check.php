<?php
require_once "../第二章/db.php";
require_once "../第二章/eth.php";

$db = new db();
$eth = new eth();

for(;;){
    $blockNumber = $eth->blockNumber();

    $sql = "SELECT * FROM add_transaction WHERE status = 5 AND hash is not null";
    $rows = $db->query($sql)->fetchAll();

    if(empty($rows)){
        var_dump(__FILE__,"EMPTY");
        sleep(60);
        continue;
    }

    if(!empty($rows)){
        foreach($rows as $row){
            $reci = $eth->getTransactionReceipt($row["hash"]);
            if(empty($reci)){
                continue;
            }

            if($blockNumber - $reci["blockNumber"] <= 12){
                continue;
            }

            if($reci["status"] === true){
                $sql = "UPDATE add_transaction SET status = 2 WHERE id = '{$row["id"]}'";
                $rs = $db->exec($sql);
            }elseif($reci["status"] === false){
                $sql = "UPDATE add_transaction SET status = 3 WHERE id = '{$row["id"]}'";
                $rs = $db->exec($sql);
            }
            if(!$rs){
                var_dump(__LINE__,"FAILED",$db->errorInfo());
                continue;
            }
        }
    }
}
