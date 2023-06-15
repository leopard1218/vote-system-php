<?php
include 'db_conn.php';
require 'vendor/autoload.php';

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;

$web3 = new Web3('https://eth-goerli.g.alchemy.com/v2/Joo6YAsGyl_MqI8sGUEuGZ45b171PgUa'); // Replace with your Ethereum node URL
$currentId = $_GET['id'];

$sql = "SELECT * FROM candidate WHERE id='$currentId'";
$res = $conn->query($sql);	
$result = $conn->query($sql);
$num = 0;

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){

?>

<!DOCTYPE html>
<html>
<head>
    <title>E-Voting</title>
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
    </main>
    <section class="py-5">
        <div class="container px-5">
            <h1>Voting Confirmation</h1><br>
            <h5><strong></i> Voting Rules and Procedure </strong></h5>
            1. Voter must have a metamask wallet account.<br>
            2. Click on the "Connect to Metamask" to get account address.<br>
            3. Copy and paste address to the voting form.<br>
            4. Recheck the information of chosen candidate.<br>
            4. Click "Vote" to cast the vote.<br><br>

            <strong></i> Metamask Address </strong>
            <p id="accountArea"></p>
            <button class="button-27" style="margin: 2px" onclick="connectMetamask()" role="button">CONNECT TO METAMASK</button>
            <br><br>

            
            <form action="" method="POST">
                <h5><strong></i> Candidate information </strong></h5>
                <strong></i> Name : </strong>  <?php echo $row['name']; ?><br>
                <strong></i> Program : </strong>  <?php echo $row['program']; ?><br>
                <strong></i> Faculty : </strong>  <?php echo $row['faculty']; ?><br>
                <br>
                <h5><strong></i> Voter information </strong></h5>
                <input style="width:50%" type="text" id="address" name="address" placeholder="Paste Metamask Address Here">
                <br><br>
                
                <div class="mb-3">
                    <input class="btn btn-success" type="button" value="Vote" onclick="vote(<?php echo $currentId ?>)">
                    <a href="vote.php"> <button type="button" class="btn btn-danger">Cancel</button></a>
                    <!-- <a href="profileUpdate.php"> <button type="button" id="submit" name="submit" class="btn btn-success">Update</button></a> -->
                </div>
            </form>           
        </div>
    </section>
    <!-- Footer-->
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; E-Voting 2023</div></div>
            
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/web3.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>

<!--METAMASK CONNECTION-->
<!-- <script>
    //connect metamask
    let account;
    const connectMetamask = async () => {
        if(window.ethereum !== "undefined") {
            const accounts = await ethereum.request({method: "eth_requestAccounts"});
            account = accounts[0];
            document.getElementById("accountArea").innerHTML = account;
        }
    }

</script> -->

<?php
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $candidateId = $currentId;
    //     $userAccount = $_POST['address']; // voter's Ethereum account address

    //     $contractAddress = '0x3e8924F4ed59ED448bb897a2363da22B3F6cb0C8'; // smart contract address
    //     $contractAbi = '[
    //         {
    //             "inputs": [],
    //             "stateMutability": "nonpayable",
    //             "type": "constructor"
    //         },
    //         {
    //             "inputs": [
    //                 {
    //                     "internalType": "uint256",
    //                     "name": "_candidateId",
    //                     "type": "uint256"
    //                 }
    //             ],
    //             "name": "vote",
    //             "outputs": [],
    //             "stateMutability": "nonpayable",
    //             "type": "function"
    //         },
    //         {
    //             "inputs": [
    //                 {
    //                     "internalType": "uint256",
    //                     "name": "",
    //                     "type": "uint256"
    //                 }
    //             ],
    //             "name": "candidates",
    //             "outputs": [
    //                 {
    //                     "internalType": "uint256",
    //                     "name": "id",
    //                     "type": "uint256"
    //                 },
    //                 {
    //                     "internalType": "string",
    //                     "name": "name",
    //                     "type": "string"
    //                 },
    //                 {
    //                     "internalType": "string",
    //                     "name": "program",
    //                     "type": "string"
    //                 },
    //                 {
    //                     "internalType": "string",
    //                     "name": "faculty",
    //                     "type": "string"
    //                 },
    //                 {
    //                     "internalType": "uint256",
    //                     "name": "voteCount",
    //                     "type": "uint256"
    //                 }
    //             ],
    //             "stateMutability": "view",
    //             "type": "function"
    //         },
    //         {
    //             "inputs": [],
    //             "name": "candidatesCount",
    //             "outputs": [
    //                 {
    //                     "internalType": "uint256",
    //                     "name": "",
    //                     "type": "uint256"
    //                 }
    //             ],
    //             "stateMutability": "view",
    //             "type": "function"
    //         },
    //         {
    //             "inputs": [
    //                 {
    //                     "internalType": "uint256",
    //                     "name": "_candidateId",
    //                     "type": "uint256"
    //                 }
    //             ],
    //             "name": "getCandidateVoteCount",
    //             "outputs": [
    //                 {
    //                     "internalType": "uint256",
    //                     "name": "",
    //                     "type": "uint256"
    //                 }
    //             ],
    //             "stateMutability": "view",
    //             "type": "function"
    //         },
    //         {
    //             "inputs": [
    //                 {
    //                     "internalType": "address",
    //                     "name": "",
    //                     "type": "address"
    //                 }
    //             ],
    //             "name": "voters",
    //             "outputs": [
    //                 {
    //                     "internalType": "bool",
    //                     "name": "",
    //                     "type": "bool"
    //                 }
    //             ],
    //             "stateMutability": "view",
    //             "type": "function"
    //         }
    //     ]';

    //     // $contract = new Contract($web3->provider, Utils::jsonToArray($contractAbi));
    //     // $contract->at($contractAddress);
    
    //     // Function to send the vote transaction
    //     function sendVoteTransaction($candidateId, $contractAbi, $userAccount ) {
    //         global $contract, $contractAddress, $web3;


    //         $contract = new Contract($web3->provider, $contractAbi);
    //         $contract->at($contractAddress);

    //         // $candidateId = $_POST['candidateId'];
    //         // $userAccount = $_POST['userAccount'];

    //         // $functionSignature = 'vote';
    //         // $arguments = "[" . $candidateId . "]";

    //         // $transactionData = Utils::toHex(Utils::sha3($functionSignature) . Utils::encodeParameters($candidateId));

    //         // // Build the transaction object
    //         // $transactionObject = [
    //         //     'from' => $userAccount,
    //         //     'to' => $contractAddress,
    //         //     'data' => $transactionData,
    //         //     'gas' => '0x' . dechex(300000), // Adjust the gas limit as per your contract requirements
    //         // ];
    //         $transactionHash = $contract->send('vote', $candidateId);
    //         // Send the transaction
    //         // $transactionHash = $web3->eth->sendTransaction($transactionObject);
    
    //         // Return the transaction hash
    //         return $transactionHash;
    //     }
    
    //     try {
    //         $transactionHash = sendVoteTransaction($candidateId, $contractAbi, $userAccount);
    //         echo 'Vote transaction sent. Transaction hash: ' . $transactionHash;
    //     } catch (Exception $e) {
    //         echo 'Error sending vote transaction: ' . $e->getMessage();
    //     }
    // }   
    }  
    }    
    else{
        echo "No results found";
    }

    $conn->close();
?>





