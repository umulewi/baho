<?php
include'connection.php';
$roleName = "job_provider";
$stmt = $pdo->prepare("SELECT role_id FROM role WHERE role_name = :role_name");
$stmt->execute(array(':role_name' => $roleName));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
    $roleId = $row['role_id'];
    echo $roleId;

?>
