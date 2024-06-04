<?php

$user_email='agent@gmail.com';

include('../connection.php');


$stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
$stmt->execute([$user_email]);
$user_id = $stmt->fetchColumn();
$stmt->closeCursor();
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_seekers FROM job_seeker JOIN users ON job_seeker.users_id = users.users_id WHERE job_seeker.created_by = ?");
$stmt->execute([$user_email]);
$total_seekers = $stmt->fetchColumn();
$stmt->closeCursor();
$pdo = null;
echo "Total Job Seekers Created by You: " . $total_seekers;


?>
