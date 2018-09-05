exports.contractAddress = "0x4148009b5B1723C1B50f5f382D6Ea8ec759a2724";

exports.fromAccount = "0x62e93998ca57414e82ec46fa8f7d40bec8997066";
exports.fromAccountLength = "00000000000000000000000062e93998ca57414e82ec46fa8f7d40bec8997066";
exports.allowAccount = "0x6a1d518a38edf36d5669505f01e2589570da36dc";
exports.allowAccountLength = "0000000000000000000000006a1d518a38edf36d5669505f01e2589570da36dc";
exports.toAccount = "0x90f46dc21cb9931ee55f52053c21604e305e32dc";
exports.toAccountLength = "00000000000000000000000090f46dc21cb9931ee55f52053c21604e305e32dc";

exports.transfer = "0xa9059cbb";
exports.balanceOf = "0x70a08231";
exports.decimals = "0x313ce567";
exports.allowance = "0xdd62ed3e";
exports.symbol = "0x95d89b41";
exports.totalSupply = "0x18160ddd";
exports.name = "0x06fdde03";
exports.approve = "0x095ea7b3";
exports.transferFrom = "0x23b872dd";

exports.getValueLength = function(value){
    value = web3.utils.toWei(value + "","ether")
    value = web3.utils.toHex(value)
    value = value.replace('0x','')

    str = "0".repeat(64 - value.length) + value
    return str
}
