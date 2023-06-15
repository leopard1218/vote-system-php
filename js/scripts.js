let account;
const connectMetamask = async () => {
    if(window.ethereum !== "undefined") {
        const accounts = await ethereum.request({method: "eth_requestAccounts"});
        account = accounts[0];
        document.getElementById("accountArea").innerHTML = account;
    }
}

const vote = candidateId => {
    if (window.ethereum !== 'undefined') {
        // MetaMask is available
        const web3 = new Web3(window.ethereum);

        // Request account access if needed
        window.ethereum.enable()
            .then(() => {
                // Get the user's selected address
                const senderAddress = account;

                // Set the contract address and ABI
                const contractAddress = '0x3e8924F4ed59ED448bb897a2363da22B3F6cb0C8'; // Replace with the actual contract address
                const contractABI = [
                    {
                        "inputs": [],
                        "stateMutability": "nonpayable",
                        "type": "constructor"
                    },
                    {
                        "inputs": [
                            {
                                "internalType": "uint256",
                                "name": "_candidateId",
                                "type": "uint256"
                            }
                        ],
                        "name": "vote",
                        "outputs": [],
                        "stateMutability": "nonpayable",
                        "type": "function"
                    },
                    {
                        "anonymous": false,
                        "inputs": [
                            {
                                "indexed": true,
                                "internalType": "uint256",
                                "name": "candidateId",
                                "type": "uint256"
                            }
                        ],
                        "name": "Voted",
                        "type": "event"
                    },
                    {
                        "inputs": [
                            {
                                "internalType": "uint256",
                                "name": "",
                                "type": "uint256"
                            }
                        ],
                        "name": "candidates",
                        "outputs": [
                            {
                                "internalType": "uint256",
                                "name": "id",
                                "type": "uint256"
                            },
                            {
                                "internalType": "string",
                                "name": "name",
                                "type": "string"
                            },
                            {
                                "internalType": "string",
                                "name": "program",
                                "type": "string"
                            },
                            {
                                "internalType": "string",
                                "name": "faculty",
                                "type": "string"
                            },
                            {
                                "internalType": "uint256",
                                "name": "voteCount",
                                "type": "uint256"
                            }
                        ],
                        "stateMutability": "view",
                        "type": "function"
                    },
                    {
                        "inputs": [],
                        "name": "candidatesCount",
                        "outputs": [
                            {
                                "internalType": "uint256",
                                "name": "",
                                "type": "uint256"
                            }
                        ],
                        "stateMutability": "view",
                        "type": "function"
                    },
                    {
                        "inputs": [
                            {
                                "internalType": "uint256",
                                "name": "_candidateId",
                                "type": "uint256"
                            }
                        ],
                        "name": "getCandidateVoteCount",
                        "outputs": [
                            {
                                "internalType": "uint256",
                                "name": "",
                                "type": "uint256"
                            }
                        ],
                        "stateMutability": "view",
                        "type": "function"
                    },
                    {
                        "inputs": [
                            {
                                "internalType": "address",
                                "name": "",
                                "type": "address"
                            }
                        ],
                        "name": "voters",
                        "outputs": [
                            {
                                "internalType": "bool",
                                "name": "",
                                "type": "bool"
                            }
                        ],
                        "stateMutability": "view",
                        "type": "function"
                    }
                ]; // Replace with the updated contract ABI

                // Create an instance of the contract
                const contract = new web3.eth.Contract(contractABI, contractAddress);

                // Build the transaction object
                const transactionObject = {
                    from: senderAddress,
                    to: contractAddress,
                    gas: web3.utils.toHex(300000), // Replace with the desired gas limit
                    gasPrice: web3.utils.toHex(1000000000), // Replace with the desired gas price
                    data: contract.methods.vote(candidateId).encodeABI(),
                };

                // Send the transaction using MetaMask
                web3.eth.sendTransaction(transactionObject)
                    .on('transactionHash', (hash) => {
                        console.log('Transaction Hash:', hash);
                    })
                    .on('confirmation', (confirmationNumber, receipt) => {
                        console.log('Confirmation Number:', confirmationNumber);
                        console.log('Receipt:', receipt);
                        location.href = "vote.php"
                    })
                    .on('error', (error) => {
                        console.error('Transaction Error:', error);
                    });
            })
            .catch((error) => {
                console.error('MetaMask Enable Error:', error);
            });
    } else {
        // MetaMask is not available
        console.error('Please install MetaMask to use this feature.');
    }
}