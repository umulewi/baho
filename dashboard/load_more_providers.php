<?php
include '../connection.php';

// Check if lastId is set, otherwise set it to 0
$lastId = isset($_GET['lastId']) ? $_GET['lastId'] : 0;

$stmt = $pdo->prepare("SELECT * FROM job_provider INNER JOIN users ON users.users_id = job_provider.users_id WHERE job_provider.job_provider_id > ? ORDER BY job_provider.job_provider_id");
$stmt->execute([$lastId]);

$lastFetchedId = 0; // Initialize last fetched ID

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $lastFetchedId = $row['job_provider_id']; // Update last fetched ID
?>
<tr data-id="<?php echo $row['job_provider_id']; ?>">
    <td><?php echo $row['job_provider_id']; ?></td>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['province']; ?></td>
    <td><?php echo $row['district']; ?></td>
    <td style="width: -56rem">
        <a class="btn update" href="more_providers.php?job_provider_id=<?php echo $row['job_provider_id']; ?>"><b>More</b></a>
        <a class="btn update" href="update_job_provider.php?job_provider_id=<?php echo $row['job_provider_id']; ?>"><b>Update</b></a>
    </td>
</tr>
<?php
}

// Use last fetched ID as the next lastId for the next query
$nextLastId = $lastFetchedId;

?>
