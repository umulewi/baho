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
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
    </style>
</head>
<body>
<?php
include '../connection.php';

?>


    <center><h5 style="color:teal;margin-top:2rem">List Of All JOB SEEKERS</h5></center>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>FIRSTNAME</th>
            <th>LASTNAME</th>
            <th>FATHERS_NAME</th>
            <th>MOTHERS_NAME</th>
            <th>PROVINCE</th>
            <th>DISTRICT</th>
            <th>SECTOR</th>
            <th>CELL</th>
            <th>VILLAGE</th>
            <th>DOB</th>
            <th>ID</th>
            <th>ACTION</th>
        </tr>
        <?php 
        echo $user_email;
        $i=1;
        $stmt = $pdo->prepare("SELECT * FROM job_seeker JOIN users ON job_seeker.users_id = users.users_id WHERE job_seeker.created_by = ?");
        $stmt->execute([$user_email]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['first_name'];?></td>
            <td><?php echo $row['last_name'];?></td>
            <td><?php echo $row['fathers_name'];?></td>
            <td><?php echo $row['mothers_name'];?></td>
            <td><?php echo $row['province'];?></td>
            <td><?php echo $row['district'];?></td>
            <td><?php echo $row['sector'];?></td>
            <td><?php echo $row['cell'];?></td>
            <td><?php echo $row['village'];?></td>
            <td><?php echo $row['date_of_birth'];?></td>
            <td><?php echo $row['ID'];?></td>
        
            
            <td style="width: -56rem">
            <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_job_seeker.php?job_seeker_id=<?php echo $row['job_seeker_id'];?>"><b>Update</b></a>
           
           
            </td>
        </tr>
        <?php
$i++;
    }

        ?>
</table>
</span>

</body>
</html>