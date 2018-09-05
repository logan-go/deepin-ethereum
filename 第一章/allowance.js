var common = require("./common.js")
let Web3 = require("web3")
var BigNumber = require('bignumber.js');

if(typeof web3 != 'undefined'){
    web3=new Web3(web3.currentProvider);
}else{
    web3 = new Web3('http://192.168.3.67:3065');
}

tx = {}
tx.from = common.fromAccount;
tx.to = common.contractAddress;
tx.gas = 100000;
tx.gasPrice = web3.utils.toWei("1","gwei")
tx.input = common.approve + common.allowAccountLength + common.getValueLength(1000)

web3.eth.sendTransaction(tx,function(error,result){
    console.log("Error:",error)
    console.log("Result:",result)
})
