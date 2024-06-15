<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
include '../connection.php';
$user_email = $_SESSION['user_email'];
try {
    $sql = "SELECT job_seeker.bio 
            FROM job_seeker
            JOIN users ON job_seeker.users_id = users.users_id
            WHERE users.email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $user_bio = htmlspecialchars($result['bio'], ENT_QUOTES, 'UTF-8');
        echo "User Bio: " . $user_bio;
    } else {
        echo "No bio found for this user.";
    }
} catch (PDOException $e) {
    die('Database error: ' . htmlspecialchars($e->getMessage()));
}
?>
