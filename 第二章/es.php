<?php
require_once './eth.php';
require_once './db.php';

$db = new db();
$eth = new eth();

$block_sql = "INSERT INTO es_block SET number = ? , hash = ? , author = ? , miner = ? , difficulty = ? , extraData = ? ,gasLimit = ? , gasUsed = ? , logsBloom = ? , mixHash = ? , nonce = ? , parentHash = ? , receiptsRoot = ? , sealFields = ? , sha3Uncles = ? , stateRoot = ? , size = ? , timestamp = ? , totalDifficulty = ?";
$block_pre = $db->prepare($block_sql);

$transaction_sql = "INSERT INTO es_transaction SET hash = ? , blockNumber = ? , chainId = ? , nonce = ? , `from` = ? , `to` = ? , gas = ? , gasPrice = ? , input = ? , status = ? , timestamp = ? , contract = ?";
$transaction_pre = $db->prepare($transaction_sql);

$logs_sql = "INSERT INTO es_logs SET address = ? , transactionHash = ? , blockHash = ? , blockNumber = ? , data = ? , logIndex = ? , removed = ? , topics = ? , transactionIndex = ? , transactionLogIndex = ? , type = ?";
$logs_pre = $db->prepare($logs_sql);

$contract_sql = "INSERT INTO es_contract SET address = ? , name = ? , symbol = ? , totalSupply = ? , `decimal` = ? , timestamp = ?";
$contract_pre = $db->prepare($contract_sql);

$currentBlock = 6000000;

for(;;){
    $currentBlock++;

    $block = $eth->getBlock($currentBlock);

    $block_arr = array($block['number'],$block['hash'],$block['author'],$block['miner'],$block['difficulty'],$block['extraData'],$block['gasLimit'],$block['gasUsed'],$block['logsBloom'],$block['mixHash'],$block['nonce'],$block['parentHash'],$block['receiptsRoot'],json_encode($block['sealFields']),$block['sha3Uncles'],$block['stateRoot'],$block['size'],$block['timestamp'],$block['totalDifficulty']);
    $rs = $block_pre->execute($block_arr);
    if(!$rs){
        var_dump("BLOCK:",$block_pre->errorInfo(),$block_arr);
    }
    if(!empty($block["transactions"])){
        foreach($block['transactions'] as $tx){
            $reci = $eth->getTransactionReceipt($tx["hash"]);
            $transaction_arr = array($tx["hash"],$tx["blockNumber"],$tx["chainId"],$tx["nonce"],$tx["from"],$tx["to"],$tx["gas"],$tx["gasPrice"],$tx["input"],$reci["status"],$block["timestamp"],$reci["contractAddress"]);
            $rs = $transaction_pre->execute($transaction_arr);
            if(!$rs){
                var_dump("TRANSACTION:",$transaction_pre->errorInfo(),$transaction_arr,$reci);
            }
            if(!empty($reci["logs"])){
                foreach($reci["logs"] as $log){
                    $logs_arr = array($log['address'],$log['transactionHash'],$log['blockHash'],$log['blockNumber'],$log['data'],$log['logIndex'],intval($log['removed']),json_encode($log['topics']),$log['transactionIndex'],$log['transactionLogIndex'],$log['type']);
                    $rs = $logs_pre->execute($logs_arr);
                    if(!$rs){
                        var_dump("LOGS:",$logs_pre->errorInfo(),$logs_arr);
                    }
                }
            }
            if($tx["to"] === null){
                $contract = $eth->getContract($reci["contractAddress"]);
                if(!empty($contract["name"])){
                    $contract_arr = array($reci["contractAddress"],$contract["name"],$contract["symbol"],$contract["totalSupply"],$contract["decimals"],$block['timestamp']);
                    $rs = $contract_pre->execute($contract_arr);
                    if(!$rs){
                        var_dump("CONTRACT:",$contract_pre->errorInfo(),$contract_arr);
                    }
                }
            }
        }
    }
}
