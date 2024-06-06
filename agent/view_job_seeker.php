<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
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
            flex-wrap: wrap; 
        }
        .search-bar {
            margin: 20px;
        }
        .form-input {
            display: flex;
            width: 100%;
            max-width: 600px; /* Center and limit the width of the search box */
            margin: 0 auto; /* Center the search box horizontally */
        }
        .form-input input[type="search"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            box-sizing: border-box;
            outline: none;
        }
        .form-input button {
            padding: 10px;
            border: 1px solid #ccc;
            border-left: none;
            background-color: teal;
            color: white;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            outline: none;
        }
        .form-input button i {
            font-size: 16px;
        }
        .form-input input[type="search"]:focus,
        .form-input button:focus {
            border-color: teal;
        }
        .form-input button:hover {
            background-color: darkcyan;
        }
        
    </style>
</head>
<body>
<?php
include '../connection.php';
?>

<main>

    <div class="search-bar">
        <form action="#" method="GET">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
    </div>
    </main>
    <div class="table-container">
        <div class="table-data">
    <?php
    include '../connection.php';
    ?>
    <h5 style="color:teal;margin-top:2rem">ALL JOB SEEKER</h5>
    <table class="">
    <tr>
        <th>ID</th>
        <th>NAMES</th>
        <th>PROVINCE</th>
        <th>DISTRICT</th>
        <th>ACTION</th>
    </tr>
    <?php 
    $i = 1;
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $stmt = $pdo->prepare("
        SELECT * FROM job_seeker 
        JOIN users ON job_seeker.users_id = users.users_id 
        WHERE job_seeker.created_by = ? 
        AND (first_name LIKE ? OR last_name LIKE ?)
    ");
    $stmt->execute([$user_email, "%$search%", "%$search%"]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row['first_name'];?> <?php echo $row['last_name'];?></td>
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
</main>

</body>
</html>
