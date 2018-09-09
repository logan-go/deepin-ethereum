<?php
require_once("./config.php");
class common{
    var $rpc;

    public function jsonrpc($method,$data){
        $baseArray = array(
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => $data,
            'id' => 0
        );

        $c = curl_init();
        curl_setopt($c,CURLOPT_URL,NODE_RPC_URL);
        curl_setopt($c,CURLOPT_POST,TRUE);
        curl_setopt($c,CURLOPT_HEADER,TRUE);
        curl_setopt($c,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($baseArray));
        curl_setopt($c,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        $rs = curl_exec($c);
        curl_close($c);
        $rs = explode("\r",$rs); 
        $rs = trim($rs[count($rs) - 1]);
        return json_decode($rs,TRUE);
    }
}
