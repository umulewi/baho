<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');
$user_email = $_SESSION['admin_email'];
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

<?php
include'../connection.php';

// Check if the search query is present
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    // Modify the SQL query to filter by first name or last name
    $stmt = $pdo->prepare("SELECT * FROM  users
                           INNER JOIN messages ON users.users_id = messages.users_id inner join job_seeker on users.users_id=job_seeker.users_id 
                           WHERE full_name LIKE :search 
                           OR last_name LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
} else {
    // If no search query, fetch all records
    $stmt = $pdo->query("SELECT * FROM users INNER JOIN messages ON users.users_id = messages.users_id inner join job_seeker on users.users_id=job_seeker.users_id order by users.users_id desc");
}
$i = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<main>
    <div class="search-bar">
        <form action="#" method="GET">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
    </div>
    <div class="table-data">
        <table class="">
            <tr>
                <th>ID</th>
                <th>NAMES</th>
                <th>MESSAGE</th>
                <th>TELEPHONE</th>
                <th>TIME</th>
               
            </tr>
            <?php 
            $i = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td><?php echo $row['telephone']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    
                </td>
            </tr>
            <?php
                $i++;
            }
            ?>
        </table>
    </div>
</main>

<script>
function confirmDelete(job_seeker_id) {
    if (confirm("Are you sure you want to delete this worker?")) {
        window.location.href = "delete_job_seeker.php?job_seeker_id=" + job_seeker_id;
    }
}
</script>

</body>
</html>
