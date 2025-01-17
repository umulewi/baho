<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');

$job_seeker_id = $_GET['job_seeker_id'];
$stmt = $pdo->prepare("SELECT users_id FROM job_seeker WHERE job_seeker_id = ?");
$stmt->execute([$job_seeker_id]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User ID Display</title>
</head>
<body>
    <h2>User ID: <?php echo htmlspecialchars($user_id); ?></h2>
    <h2>User ID: <?php echo htmlspecialchars($job_seeker_id); ?></h2>
</body>
</html>

<?php  
$delete1 = $pdo->query("DELETE from applied where job_seeker_id='$job_seeker_id'");
$delete2 = $pdo->query("DELETE from hired_seekers where job_seeker_id='$job_seeker_id'");
$delete3 = $pdo->query("DELETE from job_seeker where job_seeker_id='$job_seeker_id'");
$delete4 = $pdo->query("DELETE from users where users_id='$user_id'");

if ($delete1 && $delete2 && $delete3 && $delete4) {
   header("location:view_job_seeker.php");
} else {
    echo "Not deleted";
}

$pdo = null;
?>
