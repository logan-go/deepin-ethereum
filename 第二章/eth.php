<?php
require_once 'common.php';
class eth extends common{
    public function blockNumber(){
        $rs = $this->jsonrpc('eth_blockNumber',array());
        return hexdec($rs['result']);
    }

    public function gasPrice(){
        $rs = $this->jsonrpc('eth_gasPrice',array());
        return $rs['result'];
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

        if(isset($rs["error"]) && $rs["error"]["code"] != 0 || $rs["result"] == null){
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

    public function getBlock($number){
        $rs = $this->jsonrpc('eth_getBlockByNumber',array('0x' . dechex($number),TRUE));
        if(isset($rs["error"]) && $rs["error"]["code"] != 0){
            return null;
        }
        $rs["result"]["gasLimit"] = hexdec($rs["result"]["gasLimit"]);
        $rs["result"]["gasUsed"] = hexdec($rs["result"]["gasUsed"]);
        $rs["result"]["nonce"] = hexdec($rs["result"]["nonce"]);
        $rs["result"]["number"] = hexdec($rs["result"]["number"]);
        $rs["result"]["size"] = hexdec($rs["result"]["size"]);
        $rs["result"]["timestamp"] = hexdec($rs["result"]["timestamp"]);
        $rs["result"]["totalDifficulty"] = hexdec($rs["result"]["totalDifficulty"]);

        if(!empty($rs["result"]["transactions"])){
            foreach($rs["result"]["transactions"] as &$tx){
                $tx["blockNumber"] = hexdec($tx["blockNumber"]);
                $tx["gas"] = hexdec($tx["gas"]);
                $tx["gasPrice"] = hexdec($tx["gasPrice"]);
                $tx["chainId"] = hexdec($tx["chainId"]);
                $tx["nonce"] = hexdec($tx["nonce"]);
                $tx["transactionIndex"] = hexdec($tx["transactionIndex"]);
                $tx["value"] = hexdec($tx["value"]);
            }
        }
        return $rs["result"];
    }


    public function getContract($address){
        $name = $this->jsonrpc("eth_call",array(array("to" => $address,"data" =>"0x06fdde03")));
        $symbol = $this->jsonrpc("eth_call",array(array("to" => $address,"data" => "0x95d89b41")));
        $totalSupply = $this->jsonrpc("eth_call",array(array("to" => $address,"data" =>"0x18160ddd")));
        $decimals = $this->jsonrpc("eth_call",array(array("to" => $address,"data" =>"0x313ce567")));

        $name = hex2bin(str_replace("0x","",$name["result"]));
        $symbol = hex2bin(str_replace("0x","",$symbol["result"]));
        $totalSupply = hexdec($totalSupply["result"]);
        $decimals = hexdec($decimals["result"]);

        return array(
            "name" => trim($name),
            "symbol" => trim($symbol),
            "totalSupply" => intval($totalSupply / 1000000000000000000),
            "decimals" => $decimals
        );
    }

    public function sendTransaction($data,$password){
        $rs = $this->jsonrpc('personal_sendTransaction',$data,$password);
        if(isset($rs["error"]) && $rs["error"]["code"] != 0){
            return null;
        }
        return $rs["result"];
    }
}
