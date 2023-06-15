<?php 

session_start();
include 'db_conn.php';

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
                        <h1 class="fw-bolder">Voting</h1>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">  
                            <div class="form-floating mb-3">
                            <?php 
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    $currentId = $row['id'];
                            ?>
                            
                            <table>
                            <tr>
                                <td style="width: 220px; padding-right:8px;">
                                    <p class="detail-subtitle"><strong>Candidate <?php echo $row['id']; ?>:</strong> <?php echo $row['name']; ?></p>
                                </td>
                                <td></td>
                                <td style="padding:5px;" >
                                    <a href="profile_candidate.php?id=<?php echo $currentId ?>">
                                        <button type="button" id="view" name="view" class="btn btn-primary">View</button>
                                    </a>
                                </td>
                                <td style="padding:5px;">
                                    <a href="votingConfirmation.php?id=<?php echo $currentId ?>">
                                        <button type="button" id="vote" name="vote" class="btn btn-success">Vote</button>
                                    </a>
                                </td>
                            </tr>
                            
                                <?php
                                    }
                                }
                                else{
                                    echo "No results found";
                                }
                                ?>
                            </table>
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
                ?>
            </div>
        </section>
        </main>

</body>
</html>


