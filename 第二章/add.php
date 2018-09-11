<?php
require_once './eth.php';
require_once './db.php';

$db = new db();

$sql = "SELECT * FROM transaction WHERE user_id != 0 AND status = 0";

for(;;){
    $rows = $db->query($sql)->fetchAll();
    if(!empty($rows)){
        foreach($rows as $tx){
            $sql_tx = "UPDATE transaction SET status = 1 WHERE id = '" . $tx["id"] . "'";
            $sql_user = "UPDATE user SET token_balance = token_balance + '" . $tx["value"] . "' WHERE id = '" . $tx["user_id"] . "'";

            $db->beginTransaction();

            $rs = $db->exec($sql_tx);
            if(!$rs){
                $db->rollBack();
                contnue;
            }
            $rs = $db->exec($sql_user);
            if(!$rs){
                $db->rollBack();
                contnue;
            }
            $db->commit();
        }
    }else{
        sleep(300);
    }
}
