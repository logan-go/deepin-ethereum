let Web3 = require("web3")
let solc = require("solc")
let fs = require("fs")

if(typeof web3 != 'undefined'){
    web3=new Web3(web3.currentProvider);
}else{
    web3 = new Web3('http://192.168.3.67:3065');
}
let source=fs.readFileSync("./erc.sol","utf8");
let erc20=solc.compile(source,1);
let abi= JSON.parse(erc20.contracts[':TokenERC20'].interface);

let bytecode=erc20.contracts[':TokenERC20'].bytecode;

var rsContract=new web3.eth.Contract(abi).deploy({
        data:'0x'+bytecode,    //已0x开头
        arguments:[1000000,"Yao's Token","YTK"],    //传递构造函数的参数
}).send({
        from:"0x2582e65e3098ff49c94ea2046f290f467c8e3735",
        gas:1500000,
        gasPrice:'30000000000000'
},function(error,transactionHash){
        console.log("send回调");
        console.log("error:"+error);
        console.log("send transactionHash:"+transactionHash);
})
.on('error', function(error){ console.error(error) })
.then(function(newContractInstance){
        var newContractAddress=newContractInstance.options.address
        console.log("新合约地址:"+newContractAddress);
});

