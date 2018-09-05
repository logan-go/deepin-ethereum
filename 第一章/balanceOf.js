var common = require("./common.js")
let Web3 = require("web3")
var BigNumber = require('bignumber.js');

if(typeof web3 != 'undefined'){
    web3=new Web3(web3.currentProvider);
}else{
    web3 = new Web3('http://192.168.3.67:3065');
}

tx = {};
tx.to = common.contractAddress;
tx.from = common.fromAccount;
tx.data = common.balanceOf + common.fromAccountLength;
getBalance(tx);

tx.from = common.allowAccount;
tx.data = common.balanceOf + common.allowAccountLength;
getBalance(tx);

tx.from = common.toAccount;
tx.data = common.balanceOf + common.toAccountLength;
getBalance(tx);


tx = {};
tx.to = common.contractAddress;
tx.data = common.allowance + common.fromAccountLength + common.allowAccountLength
getBalance(tx)

function getBalance(tx){
    var addr = tx.from;
    result = web3.eth.call(tx,"latest",function(error,rs){
        a = new BigNumber(rs)
        num = web3.utils.fromWei(a.toString(10),'ether')

        if(addr == undefined) {
            console.log("allowance:",num);
        }else{
            console.log(addr,"Balance:",num);
        }
    });
}
