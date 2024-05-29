<?php
include '../connection.php';

$rowCount = $_GET['rowCount'];

$stmt = $pdo->prepare("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id LIMIT ?, 5");
$stmt->bindValue(1, $rowCount, PDO::PARAM_INT);
$stmt->execute();
$x=1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td> $x</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['salary']} RW</td>";
    echo "<td>{$row['bio']}</td>";
    echo "<td>{$row['province']}</td>";
    echo "</tr>";
    $x++;
}

?>
