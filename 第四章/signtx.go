package main

import (
	"context"
	"fmt"
	"math/big"

	ethereum "github.com/ethereum/go-ethereum"
	"github.com/ethereum/go-ethereum/common"
	"github.com/ethereum/go-ethereum/core/types"
	"github.com/ethereum/go-ethereum/crypto"
	"github.com/ethereum/go-ethereum/ethclient"
)

func main() {
	privatekeyStr := "这个地方需要写入的是16进制的私钥字符串"
	chainId := 4需要操作链的chainId
	//infura.io是一个可以免费申请ETH公有节点的网站，大家可以使用
	peerUrl := "https://rinkeby.infura.io/v3/bed852221a3347038fce7d69a7155a41"

	//创建对节点的连接
	client, err := ethclient.Dial(peerUrl)
	if err != nil {
		fmt.Println("Connect Error:", err)
		return
	}

	//把私钥从Hex还原成对象
	privateKey, err := crypto.HexToECDSA(privatekeyStr)
	if err != nil {
		fmt.Println("HexToECDSA Error:", err)
		return
	}

	//构建一个CallMsg结构
	to := common.HexToAddress("0x85Fbb3DA00432aA737Ba1CaA9f3Cc2b07F4B42EF")

	msg := ethereum.CallMsg{}
	msg.From = crypto.PubkeyToAddress(privateKey.PublicKey)
	msg.To = &to
	msg.GasPrice, _ = client.SuggestGasPrice(context.Background())
	msg.Value, _ = big.NewInt(0).SetString("1000000000000000000", 10) //每次转1ETH走

	//获取预估gas
	gasCount, err := client.EstimateGas(context.Background(), msg)
	if err != nil {
		fmt.Println("EstimateGas Error:", err)
		return
	}

	//获取nonce
	nonce, err := client.PendingNonceAt(context.Background(), crypto.PubkeyToAddress(privateKey.PublicKey))
	if err != nil {
		fmt.Println("PendingNonceAt Error:", err)
		return
	}

	//重新构建Transaction
	tx := types.NewTransaction(nonce, to, msg.Value, gasCount, msg.GasPrice, msg.Data)

	//签名
	signer := types.NewEIP155Signer(big.NewInt(chainId)) //这个地方，视频里面讲错了，这个传入的数字不是随机值，而是需要操作的链的ChainId
	tx, err = types.SignTx(tx, signer, privateKey)
	if err != nil {
		fmt.Println("SignTx Error:", err)
		return
	}

	//发送交易
	err = client.SendTransaction(context.Background(), tx)
	if err != nil {
		fmt.Println("SendTransaction Error:", err)
		return
	}

	fmt.Println("Success:", tx.Hash().Hex())
}
