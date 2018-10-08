<?php
require_once("config.php");
class common{
    var $rpc;

    public function jsonrpc($method,$data,$password = null){
        $baseArray = array(
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => $data,
            'id' => 0
        );
        if($password != null){
            $baseArray['params'] = array($data,$password);
        }

        $c = curl_init();
        curl_setopt($c,CURLOPT_URL,NODE_RPC_URL);
        curl_setopt($c,CURLOPT_POST,TRUE);
        curl_setopt($c,CURLOPT_HEADER,TRUE);
        curl_setopt($c,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($baseArray));
        curl_setopt($c,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        var_dump(json_encode($baseArray));
        $rs = curl_exec($c);
        curl_close($c);
        $rs = explode("\r",$rs); 
        $rs = trim($rs[count($rs) - 1]);
        return json_decode($rs,TRUE);
    }

    public function get64LengthAddress($address){
        $address = strtolower($address);
        $address = str_replace("0x","",$address);
        return "000000000000000000000000" . $address;
    }

    public function get64LengthValue($value){
        $value = dechex($value);
        return str_repeat("0",64 - strlen($value)) . $value;
    }
}
