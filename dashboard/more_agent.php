<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');

$agent_id = $_GET['agent_id'];
$stmt = $pdo->prepare("SELECT users_id FROM agent WHERE agent_id = ?");
$stmt->execute([$agent_id]); 
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
    <title>Update Student</title>
       <style>
        
       .form-container {
        max-width: 750px;
            margin: 0 auto;
        }

        /* Form fields */
        .form-container div {
            margin-bottom: 15px;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="password"],
        .form-container input[type="email"],xta
        .form-container input[type="tel"],
        .form-container input[type="number"],
        select,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: teal;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: darkslategray;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-row > div {
            flex: 1;
            min-width: 300px;
        }


        @media (max-width: 600px) {
            .form-row > div {
                min-width: 100%;
            }
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
    </style>
    
</head>
<body>
<?php
$id = $_GET['agent_id'];
include '../connection.php';
$stmt = $pdo->prepare("SELECT * FROM users JOIN agent ON users.users_id = agent.users_id WHERE agent.agent_id = :agent_id");
$stmt->bindParam(':agent_id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<h2 style="text-align:center"></h2><br>
<div class="form-container">	
		<main>
            <div class="table-data">
                <form action="" method="post">
                    <div class="form-row">
                        <div>
                            <label for="name">Agent's first name:</label>
                            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required readonly>
                        </div>
                        <div>
                        <label for="name">Agent's last name:</label>
                        <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required readonly>
                    </div>
    </div>

                    <div class="form-row">
                        <div>
                            <label for="gender">Gender:</label>
                            <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>" required readonly>
                        </div>
                        <div>
                            <label for="dob">Date of birth:</label>
                            <input type="date" id="dob" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required readonly>
                        </div>
                        
                    </div>
                    
                    <div class="form-row">
                        <div>
                            <label for="province">Province:</label>
                            <input type="text" id="province" name="province" value="<?php echo $row['province']; ?>" required readonly >
                        </div>
                        <div>
                            <label for="district">District:</label>
                            <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" required readonly>
                        </div>
                    </div>


                    <div class="form-row">
                        <div>
                            <label for="sector">sector:</label>
                            <input type="text" id="sector" name="sector" value="<?php echo $row['sector']; ?>" required readonly>
                        </div>
                    <div>
                        <label for="village">Village:</label>
                        <input type="text" id="village" name="village" value="<?php echo $row['village']; ?>" required readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label for="cell">Cell:</label>
                        <input type="text" id="cell" name="cell" value="<?php echo $row['cell']; ?>" required readonly>
                    </div>
                    <div>
                        <label for="id">Id cards:</label>
                        <input type="text" id="ID" name="ID" value="<?php echo $row['ID']; ?>" required readonly>
                    </div>
                </div>
        
    </form>
    </div>
    </main>
    </div>
</div>

</body>
</html>




<main>
<h5 style="color:teal;margin-top:2rem">All seekers registered by  <?php echo $row['first_name'];?> </h5>
<div class="table-data">

    <table id="job-seeker-table">
        <tr>
            <th>ID</th>
            <th>NAMES</th>
            <th>SALARY</th>
            <th>BIO</th>
            <th>AGE</th>
            <th>ACTION</th>
        </tr>
        <?php 
        $stmt = $pdo->prepare("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id WHERE created_by = ? ORDER  BY created_at desc LIMIT 3");
        $stmt->execute([$row['email']]);
        $i = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['salary']; ?> RW</td>
            <td><?php echo $row['bio']; ?></td>
            <td><?php echo $row['province']; ?></td>
            <td>
                <div class="action-buttons">
                <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="details.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>"><b>MORE</b></a>
                <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_job_seeker.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>"><b>Update</b></a>
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
<button class="btn" style="background-color:#b0b435;border:none;cursor:pointer" id="load-more-btn" onclick="loadMore()">Load More</button>

<script>
    function loadMore() {
        var lastRow = document.querySelector("#job-seeker-table tr:last-child td:first-child").innerText;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "load_more.php?lastRow=" + lastRow, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var newRows = xhr.responseText;
                document.querySelector("#job-seeker-table").innerHTML += newRows;
                if (newRows.trim() == "") {
                    document.getElementById("load-more-btn").style.display = "none";
                } else {
                    document.getElementById("load-more-btn").style.display = "none"; // Hide the button after loading the remaining rows
                }
            }
        };
        xhr.send();
    }
</script>

