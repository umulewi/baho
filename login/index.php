<?php
require_once 'config.php';

if (isset($_SESSION['user_token'])) {
  header("Location: welcome.php");
} else {
  echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
}

?>

<?php
require_once 'config.php';
include'../connection.php';
function getRoleId3($pdo, $roleName) {
    $stmt = $pdo->prepare("SELECT role_id FROM role WHERE role_name = :role_name");
    $stmt->execute(array(':role_name' => $roleName));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['role_id'];
}
if (isset($_SESSION['user_token'])) {
    header("Location: welcome.php");
} else {
    $roleId2 = getRoleId3($pdo, 'job_seeker');
    $googleLoginUrl = $client->createAuthUrl() . "&role_id=$roleId2";
    echo "<a href='" . $googleLoginUrl . "'>Google Login as Job Seeker</a>";
}
?>