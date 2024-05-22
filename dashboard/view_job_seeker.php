<?php  
session_start();
if (!isset($_SESSION['user_email'])) {
 header("location:../index.php");
}
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
            <th>FULL NAME</th>
           
            <!-- <th>FATHERS_NAME</th>
            <th>MOTHERS_NAME</th> -->
            <th>PROVINCE</th>
            <th>DISTRICT</th>
            <th>SECTOR</th>
            <th>CELL</th>
            <th>VILLAGE</th>
            <th>DOB</th>
            <!-- <th>ID</th> -->
            <th>ACTION</th>

        </tr>
        <?php 
        $i=1;
        $stmt = $pdo->query("SELECT * FROM job_seeker inner join users on users.users_id=job_seeker.users_id");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <!-- <td><?php echo $row['full_name'];?></td>
            <td><?php echo $row['fathers_name'];?></td> -->
            <td><?php echo $row['mothers_name'];?></td>
            <td><?php echo $row['province'];?></td>
            <td><?php echo $row['district'];?></td>
            <td><?php echo $row['sector'];?></td>
            <td><?php echo $row['cell'];?></td>
            <td><?php echo $row['village'];?></td>
            <td><?php echo $row['date_of_birth'];?></td>
            <!-- <td><?php echo $row['ID'];?></td> -->
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