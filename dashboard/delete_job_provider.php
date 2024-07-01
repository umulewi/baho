<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

include('../connection.php');

$job_provider_id = $_GET['job_provider_id'];
$stmt = $pdo->prepare("SELECT users_id FROM job_provider WHERE job_provider_id = ?");
$stmt->execute([$job_provider_id]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor();


$delete2 = $pdo->prepare("DELETE FROM hired_seekers WHERE job_provider_id = ?");
$delete3 = $pdo->prepare("DELETE FROM job_provider WHERE job_provider_id = ?");
$delete4 = $pdo->prepare("DELETE FROM users WHERE users_id = ?");

$pdo->beginTransaction();
try {
   
    $delete2->execute([$job_provider_id]);
    $delete3->execute([$job_provider_id]);
    $delete4->execute([$user_id]);

    $pdo->commit();
    header("Location: view_job_provider.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed to delete: " . $e->getMessage();
}

$pdo = null;
?>
