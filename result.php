<?php 
session_start();
include 'db_conn.php';
require 'vendor/autoload.php';
use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use GuzzleHttp\Exception\GuzzleException;

$web3 = new Web3(new HttpProvider(new HttpRequestManager('https://eth-goerli.g.alchemy.com/v2/4fiZBCy5EjqRWJRw9xrYvnA_LL37ge7Q', 100)));
$contractAddress = '0x3e8924F4ed59ED448bb897a2363da22B3F6cb0C8'; // smart contract address
$contractABI = '[
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
]'; // Replace with your contract ABI
$contract = new Contract($web3->provider, $contractABI);
$contract->at($contractAddress);

$candidateVoteCounts = [];
$candidateCount = 2; // Number of candidates 

$sql = "SELECT * FROM candidate";
$result = $conn->query($sql);
$num = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>E-Voting</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <title>Register information at Blockchain</title>

    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="./node_modules/web3/dist/web3.min.js"></script>
    <script src="./vote.js"></script>
	<!--WEB3-CONNECT-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.2.7-rc.0/web3.min.js"></script>
    
    
</head>
<body class="d-flex flex-column">
    <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.html">E-Voting</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            
                        </ul>
                    </div>
                </div>
            </nav>
             <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <!-- Contact form-->
                <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <h1 class="fw-bolder">Voting Result</h1>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">  
                            <div class="form-floating mb-3 text-center">
                            <?php 
                            echo '<table>';
                            echo '<tr><th>Candidate</th><th>Vote Count</th></tr>';
                            for ($i = 1; $i <= $candidateCount; $i++) {
                                $contract->call('candidates', $i, function($err, $result) use ($contract, $i) {
                                    $candidateId = $result['id']->value;
                                    $candidateName = $result['name'];
                                    
                                    // Use the first callback result in the second callback
                                    $contract->call('getCandidateVoteCount', $candidateId, function($err, $result) use ($candidateId, $candidateName) {
                                        $candidateVoteCount = $result[0]->value;
                                        
                                        // Use the results as needed
                                        echo '<tr>';
                                        echo '<td>Candidate ' . $candidateId . ': ' . $candidateName . '</td>';
                                        echo '<td>' . $candidateVoteCount . '</td>';
                                        echo '</tr>';
                                    });
                                });
                            }                            

                            echo '</table>';
                            ?>
                            <div class="text-center mb-3">
                                <br/>
                                <a href="dashboard-student.php"> <button type="button" class="btn btn-secondary">Back</button></a>
                                <!-- <a href="profileUpdate.php"> <button type="button" id="submit" name="submit" class="btn btn-success">Update</button></a> -->
                            </div>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <br/>
                </div>
                <?php
                    
                $conn->close();

                // curl_close($ch);
                ?>
            </div>
        </section>
        </main>
</body>
</html>



