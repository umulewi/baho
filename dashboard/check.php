<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');
$user_email = $_SESSION['user_email'];
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
$stmt->execute([$user_email]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
$pdo = null;
?>
<?php
include'dashboard.php';
?>
<main>
<ul class="box-info">
                
				<li>
					<i class='bx bxs-calendar-check' ></i>
                    <?php
                    include'../connection.php';
                    $stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
                    $stmt->execute([$user_email]);
                    $user_id = $stmt->fetchColumn();
                    $stmt->closeCursor();
                    $stmt = $pdo->prepare("SELECT COUNT(*) AS total_seekers FROM job_seeker JOIN users ON job_seeker.users_id = users.users_id WHERE job_seeker.created_by = ?");
                    $stmt->execute([$user_email]);
                    $total_seekers = $stmt->fetchColumn();
                    $stmt->closeCursor();
                    $pdo = null;
                    ?>
					<span class="text">
						<h3><?php echo $total_seekers;  ?></h3>
						<p>My Seekers</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
                    <?php
                    include'../connection.php';
                    $sql = "SELECT COUNT(job_seeker_id) AS total FROM job_seeker";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
					<span class="text">
						<h3><?php echo $result['total']?></h3>
						<p>All Seekers</p>
					</span>
				</li>
				
			</ul>
</main>

<?php
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
$user_email = $_SESSION['user_email']; 
include '../connection.php';
try {
    $query = $pdo->prepare("SELECT users_id FROM users WHERE email = :email");
    $query->execute(['email' => $user_email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $users_id = $user['users_id'];
    } else {

        echo "User not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}


$progress = 0;
$sql = "SELECT 1 FROM users WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $progress += 33;
}

$sql = "SELECT mothers_name, fathers_name, telephone, province, district, sector, cell, village, salary, bio, date_of_birth, ID, created_at FROM job_seeker WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $filledFields = 0;
    $totalFields = 12;
    
    if (!empty($result['mothers_name'])) { $filledFields++; }
    if (!empty($result['fathers_name'])) { $filledFields++; }
    if (!empty($result['telephone'])) { $filledFields++; }
    if (!empty($result['province'])) { $filledFields++; }
    if (!empty($result['district'])) { $filledFields++; }
    if (!empty($result['sector'])) { $filledFields++; }
    if (!empty($result['cell'])) { $filledFields++; }
    if (!empty($result['village'])) { $filledFields++; }
    if (!empty($result['salary'])) { $filledFields++; }
    if (!empty($result['bio'])) { $filledFields++; }
    if (!empty($result['date_of_birth'])) { $filledFields++; }
    if (!empty($result['ID'])) { $filledFields++; }

    $progress += (33 / $totalFields) * $filledFields;
    $created_at = new DateTime($result['created_at']);
    $now = new DateTime();
    $interval = $now->diff($created_at);
    if ($interval->days > 15) {
        $progress += 12;
    }
}
$sql = "SELECT job_seeker_id FROM job_seeker WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':users_id', $users_id, PDO::PARAM_INT);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $job_seeker_id = $result['job_seeker_id'];
    $sql = "SELECT 1 FROM hired_seekers WHERE job_seeker_id = :job_seeker_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':job_seeker_id', $job_seeker_id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $progress = 100; 
    }
}
?>
<style>
        .progress {
            width: 400px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar {
            width: <?php echo $progress; ?>%;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 7px 0;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<div class="">
    <h2>
        Job Application Progress
    </h2>
    <div class="progress">
        <div class="progress-bar">
            <?php echo $progress ? $progress . "%" : "Progress not available"; ?>
        </div>
    </div>
</div>

</body>
</html>
    </main>


<script>
        window.onload = function() {
            alert("remember you have to complete your profile: go to profile and choose Edit profile .");
        };
    </script>