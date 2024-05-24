<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');
$user_email = $_SESSION['user_email'];
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
$stmt->execute([$user_email]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
$pdo = null;
?>

<?php
include'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: teal;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            margin: 2px; /* Add margin to separate buttons */
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
        .table-container {
            overflow-x: auto;
        }
        .action-buttons {
            display: flex;
            flex-wrap: wrap; /* Allows buttons to wrap on small screens */
        }
    </style>
</head>
<body>
<?php
include '../connection.php';
?>

<center><h5 style="color:teal;margin-top:2rem">List Of All JOB SEEKERS</h5></center>
<div class="table-container">
    <table class="table">
        <tr>
            <th>ID</th>
            <th>NAMES</th>
            <th>PROVINCE</th>
            <th>DISTRICT</th>
            <th>ACTION</th>
        </tr>
        <?php 
        $i=1;
        $stmt = $pdo->prepare("SELECT * FROM job_seeker JOIN users ON job_seeker.users_id = users.users_id WHERE job_seeker.created_by = ?");
        $stmt->execute([$user_email]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['first_name'];?> <?php echo $row['last_name'];?>s</td>
            <td><?php echo $row['province'];?></td>
            <td><?php echo $row['district'];?></td>
            <td>
                <div class="action-buttons">
                    <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="more.php?job_seeker_id=<?php echo $row['job_seeker_id'];?>"><b>More</b></a>
                    <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_job_seeker.php?job_seeker_id=<?php echo $row['job_seeker_id'];?>"><b>Update</b></a>
                </div>
            </td>
        </tr>
        <?php
        $i++;
        }
        ?>
    </table>
</div>
</body>
</html>
