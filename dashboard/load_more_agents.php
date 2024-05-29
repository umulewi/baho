<?php
// Include your database connection file
include '../connection.php';

// Get the last agent ID from the request
$lastId = isset($_GET['lastId']) ? intval($_GET['lastId']) : 0;

// Define the number of agents to fetch in each request
$limit = 2;

// Query to fetch more agents starting from the last displayed agent ID
$stmt = $pdo->prepare("SELECT * FROM agent INNER JOIN users ON users.users_id = agent.users_id WHERE agent_id > :lastId ORDER BY agent_id ASC LIMIT :limit");
$stmt->bindParam(':lastId', $lastId, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

// Fetch and output the additional agent rows as HTML
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Output HTML for a single agent row
    echo "<tr>";
    echo "<td>" . $row['agent_id'] . "</td>";
    echo "<td>" . $row['full_name'] . "</td>";
    echo "<td>" . $row['province'] . "</td>";
    echo "<td>" . $row['district'] . "</td>";
    echo "<td style='width: -56rem'>";
    echo "<a class='btn custom-bg shadow-none' style='background-color:#b0b435' href='more_agent.php?agent_id=" . $row['agent_id'] . "'><b>More</b></a>";
    echo "<a class='btn custom-bg shadow-none' style='background-color:#b0b435' href='update_agent.php?agent_id=" . $row['agent_id'] . "'><b>Update</b></a>";
    echo "</td>";
    echo "</tr>";
}
?>
