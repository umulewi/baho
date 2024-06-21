<?php
session_start();

if (!isset($_SESSION['admin_email'])) {
  exit("Session Expired");
}

include '../connection.php';

$lastRow = $_GET['lastRow'];

$stmt = $pdo->prepare("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id WHERE created_by = ? AND job_seeker.job_seeker_id > ? ORDER BY created_at desc");
$stmt->execute([$_SESSION['admin_email'], $lastRow]);

$newRows = "";
$i = (int)$lastRow + 1; // Assuming numbering starts from 1
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $newRows .= "<tr>
                  <td>$i</td>
                  <td>{$row['full_name']}</td>
                  <td>{$row['salary']} RW</td>
                  <td>{$row['bio']}</td>
                  <td>{$row['province']}</td>
                  <td>
                    <div class='action-buttons'>
                      <a class='btn custom-bg shadow-none' style='background-color:#b0b435' href='details.php?job_seeker_id={$row['job_seeker_id']}'><b>MORE</b></a>
                      <a class='btn custom-bg shadow-none' style='background-color:#b0b435' href='update_job_seeker.php?job_seeker_id={$row['job_seeker_id']}'><b>Update</b></a>
                    </div>
                  </td>
                </tr>";
  $lastRow = $row['job_seeker_id'];
  $i++; // Increment $i for next row
}

$pdo = null;

echo $newRows;

?>
