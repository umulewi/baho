<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            margin: 4px;
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
        
        @media (max-width: 600px) {
            .btn {
                display: block;
                margin: 8px 0;
            }
        }
    </style>
</head>
<body>
    
<table class="table" id="providers-table">
                    <tr>
                    <th>ID</th>
                    <th>NAMES</th>
                    <th>SALARY</th>
                    <th>BIO</th>
                    <th>AGE</th>
                    <th>ACTION</th>
                    </tr>

<?php

$lastJobSeekerId = isset($_GET['lastId']) ? intval($_GET['lastId']) : 0;
$stmt = $pdo->prepare("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id WHERE job_seeker_id > ? ORDER BY job_seeker_id ASC ");
$stmt->execute([$lastJobSeekerId]);

$html = '';
$i=1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $html .= '<tr>';
    $html .= '<td>' . $i . '</td>';
   
    $html .= '<td>' . $row['full_name'] . '</td>';
    $html .= '<td>' . $row['salary'] . ' RW</td>';
    $html .= '<td>' . $row['bio'] . '</td>';
    $html .= '<td>' . $row['province'] . '</td>';
    $html .= '<td style="width: -56rem">';
    $html .= '<a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="details.php?job_seeker_id=' . $row['job_seeker_id'] . '"><b>MORE</b></a>';
    $html .= '<a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_job_seeker.php?job_seeker_id=' . $row['job_seeker_id'] . '"><b>Update</b></a>';
    $html .= '</td>';
    $html .= '</tr>';

    $i++;
}

// Output HTML
echo $html;
?>
