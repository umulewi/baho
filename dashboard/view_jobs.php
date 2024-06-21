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
    $stmt = $pdo->prepare("SELECT * FROM jobs 
                           WHERE job_title LIKE :search 
                           OR description LIKE :search OR published_date LIKE :search OR deadline_date LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
} else {
    // If no search query, fetch all records
    $stmt = $pdo->query("SELECT * FROM jobs");
}
$i = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search jobs</title>
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
            <th>JOB TITLE</th>
            <th>LOGO</th>
            <th>DESCRIPTION</th>
            <th>PUBLISHED DATE</th>
            <th>DEADLINE DATE</th>
            <th>ACTION</th>
        </tr>
        <?php 
        // Assuming $stmt is your PDO statement that fetches the job records
        $i = 1; // Initialize the counter
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo htmlspecialchars($row['job_title']); ?></td>
            <td><img src="<?php echo htmlspecialchars($row['logo']); ?>" alt="Job Logo" style="width: 50px; height: 50px;"></td>
            <td><?php echo htmlspecialchars($row['job_description']); ?></td>
            <td><?php echo htmlspecialchars($row['published_date']); ?></td>
            <td><?php echo htmlspecialchars($row['deadline_date']); ?></td>
            <td>
                <div class="action-buttons">
                    <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_jobs.php?job_id=<?php echo $row['job_id']; ?>"><b>Update</b></a>
                    <a class="btn custom-bg shadow-none" style="background-color:red" href="delete_jobs.php?job_id=<?php echo $row['job_id']; ?>"><b>Delete</b></a>
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
