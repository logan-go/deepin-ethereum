//生成子钱包逻辑
package main

import (
	"crypto/rand"
	"fmt"

	"github.com/ethereum/go-ethereum/accounts/keystore"
	"github.com/ethereum/go-ethereum/crypto"
)

func main() {
	k := keystore.NewKeyForDirectICAP(rand.Reader)
	fmt.Println(k.Address.Hex())
	fmt.Printf("%x\n", crypto.FromECDSA(k.PrivateKey))
}
