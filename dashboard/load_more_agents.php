<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            margin: 4px;
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
        
        @media (max-width: 600px) {
            .btn {
                display: block;
                margin: 8px 0;
            }
        }

        
    </style>
</head>
<body>
    <table>
    <tr>
                    <th>ID</th>
                    <th>NAMES</th>
                    <th>PROVINCE</th>
                    <th>DISTRICT</th>
                    <th>ACTION</th>
                </tr>
    
</body>
</html>
<?php
include '../connection.php';
$lastId = isset($_GET['lastId']) ? intval($_GET['lastId']) : 0;
$stmt = $pdo->prepare("SELECT * FROM agent INNER JOIN users ON users.users_id = agent.users_id ORDER BY agent_id ");
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['agent_id'] . "</td>";
    echo "<td>" . $row['full_name'] . "</td>";
    echo "<td>" . $row['province'] . "</td>";
    echo "<td>" . $row['district'] . "</td>";
    echo "<td>";
    echo "<a class='btn update' href='more_agent.php?agent_id=" . $row['agent_id'] . "'>More</a>";
    echo "<a class='btn update' href='update_agent.php?agent_id=" . $row['agent_id'] . "'>Update</a>";
    echo "</td>";
    echo "</tr>";
}
?>
