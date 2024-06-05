<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(sessions/img/main.jpg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            display: flex;
            flex-direction: row;
            width: 90%;
            max-width: 900px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            height: auto;
            background: white;
            height: 85%;
        }

        .login-image {
            flex: 1;
            background: url(uploads/team11.jpg) no-repeat center center/cover;
        }

        .login-form {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url(uploads/tree-lines.jpg);
        }

        .login-form h2 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
            border-bottom:  2px solid #EA60A7;

        }

        .options-container {
            display: flex;
            justify-content: space-around;
            width: 100%;
            flex-wrap: wrap;
            margin-bottom: 150px;
        }

        .option {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: transform 0.3s ease;
            margin: 20px;
        }

        .option:hover {
            transform: scale(1.1);
        }

        .circle {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background-color: #EA60A7;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        .option:hover .circle {
            background-color: #503141;
        }

        .circle img {
            width: 115px;
            height: 115px;
        }

        .option-title {
            font-size: 16px;
            color: #333;
            text-align: center;
            font-family: 'michroma', sans-serif;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 95%;
                height: auto;
                height: 85%;
            }

            .login-image {
                height: 200px;
                background-size: cover;
            }

            .circle {
                width: 140px;
                height: 140px;
            }

            .circle img {
                width: 115px;
                height: 115px;
            }

            .option-title {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .login-form {
                padding: 20px;
            }

            .login-form h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }

         
            .circle {
                width: 140px;
                height: 140px;
            }

            .circle img {
                width: 115px;
                height: 115px;
            }

            .option-title {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<?php
include 'connection.php';

function getRoleId($pdo, $roleName) {
    $stmt = $pdo->prepare("SELECT role_id FROM role WHERE role_name = :role_name");
    $stmt->execute(array(':role_name' => $roleName));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['role_id'];
}

$workerRoleId = getRoleId($pdo, 'job_seeker'); // Assuming 'job_seeker' is the role name for Worker
$employerRoleId = getRoleId($pdo, 'job_provider'); // Assuming 'employer' is the role name for Employer
?>

    <div class="login-container" class="container-fluid">
        <div class="login-image"></div>
        <div class="login-form">
            <h2 style="font-family: 'michroma';">Continue as</h2>
            <div class="options-container">
        <div class="option" onclick="window.location.href='job_seeker_login.php?role_id=<?php echo $workerRoleId; ?>'">
            <div class="circle">
                <img src="uploads/worker.png" alt="Worker Icon">
            </div>
            <div class="option-title">Worker</div>
        </div>
        <div class="option" onclick="window.location.href='job_provider_login.php?role_id=<?php echo $employerRoleId; ?>'">
            <div class="circle">
                <img src="uploads/employer.png" alt="Employer Icon">
            </div>
            <div class="option-title">Employer</div>
        </div>
    </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <p>
                           
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p>
                            
                        </p>
                    </div>
                </div>
    
            </div>
        </div>
    </div>

    
</body>

</html>
