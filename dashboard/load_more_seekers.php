<?php
include '../connection.php';
$lastId = isset($_GET['lastId']) ? intval($_GET['lastId']) : 0;
$stmt = $pdo->prepare("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id WHERE job_seeker_id > ? LIMIT 2");
$stmt->execute([$lastId]);

$html = '';
$i = $lastId + 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $html .= '<tr>';
    $html .= '<td>' . $i . '</td>';
    $html .= '<td>' . $row['full_name'] . '</td>';
    $html .= '<td>' . $row['salary'] . ' RW</td>';
    $html .= '<td>' . $row['bio'] . '</td>';
    $html .= '<td>' . $row['province'] . '</td>';
    $html .= '<td style="width: -56rem">';
    $html .= '<a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="details.php?job_seeker_id=' . $row['job_seeker_id'] . '"><b>MORE</b></a>';
    $html .= '<a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_job_seeker.php?job_seeker_id=' . $row['job_seeker_id'] . '"><b>Update</b></a>';
    $html .= '</td>';
    $html .= '</tr>';
    $i++;
}

echo $html;
?>
