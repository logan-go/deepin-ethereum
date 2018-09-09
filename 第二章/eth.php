<?php
require_once './common.php';
class eth extends common{
    public function blockNumber(){
        $rs = $this->jsonrpc('eth_blockNumber',array());
        return hexdec($rs['result']);
    }

    public function gasPrice(){
        $rs = $this->jsonrpc('eth_gasPrice',array());
        return hexdec($rs['result']);
    }

    public function getTransactionByHash($hash){
        $rs = $this->jsonrpc('eth_getTransactionByHash',array($hash));

        if(isset($rs["error"]) && $rs["error"]["code"] != 0){
            return null;
        }

        $rs["result"]["blockNumber"] = hexdec($rs["result"]["blockNumber"]);
        $rs["result"]["chainId"] = hexdec($rs["result"]["chainId"]);
        $rs["result"]["gas"] = hexdec($rs["result"]["gas"]);
        $rs["result"]["gasPrice"] = hexdec($rs["result"]["gasPrice"]);
        $rs["result"]["nonce"] = hexdec($rs["result"]["nonce"]);
        $rs["result"]["transactionIndex"] = hexdec($rs["result"]["transactionIndex"]);
        $rs["result"]["value"] = hexdec($rs["result"]["value"]);
        return $rs["result"];
    }

    public function getTransactionReceipt($hash){
        $rs = $this->jsonrpc('eth_getTransactionReceipt',array($hash));

        if(isset($rs["error"]) && $rs["error"]["code"] != 0){
            return null;
        }
        $rs["result"]["blockNumber"] = hexdec($rs["result"]["blockNumber"]);
        $rs["result"]["cumulativeGasUsed"] = hexdec($rs["result"]["cumulativeGasUsed"]);
        $rs["result"]["gasUsed"] = hexdec($rs["result"]["gasUsed"]);
        $rs["result"]["status"] = (bool)$rs["result"]["status"];
        $rs["result"]["transactionIndex"] = hexdec($rs["result"]["transactionIndex"]);

        if(!empty($rs["result"]["logs"])){
            foreach($rs["result"]["logs"] as &$log){
                $log["blockNumber"] = hexdec($log["blockNumber"]);
                $log["logIndex"] = hexdec($log["logIndex"]);
                $log["transactionIndex"] = hexdec($log["transactionIndex"]);
                $log["transactionLogIndex"] = hexdec($log["transactionLogIndex"]);
            }
        }

        return $rs["result"];
    }
}
