<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');

$agent_id = $_GET['agent_id'];
$stmt = $pdo->prepare("SELECT users_id FROM agent WHERE agent_id = ?");
$stmt->execute([$agent_id]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
echo "User ID: " . $user_id;
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
        /* your CSS styles here */
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
<?php echo $row['email'] ?>





<main>
<h5 style="color:teal;margin-top:2rem">List of all seekers</h5>
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
<button id="load-more-btn" onclick="loadMore()">Load More</button>
</main>

<script>
    function loadMore() {
    var lastRow = document.querySelector("#job-seeker-table tr:last-child td:first-child").innerText;
    var email = "<?php echo $row['email']; ?>";
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "load_more.php?lastRow=" + lastRow + "&email=" + email, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var newRows = xhr.responseText;
            document.querySelector("#job-seeker-table").innerHTML += newRows;
            if (newRows.trim() == "") {
                document.getElementById("load-more-btn").style.display = "none";
            }
        }
    };
    xhr.send();
}



</script>
</body>
</html>
