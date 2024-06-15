
<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
?>
<?php
if (!isset($_SESSION['alert_displayed'])) {
    echo '<script>alert("Remember you have to complete your profile: go to profile and choose Edit profile.");</script>';
    $_SESSION['alert_displayed'] = true;
}
include 'dashboard.php';
?>
<div class="form-container">
    <main>


    
        <ul class="box-info">
            <li>
                <i class='bx bxs-group'></i>
                <?php
                include '../connection.php';
                $sql = "SELECT COUNT(job_provider_id) AS total FROM job_provider";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <span class="text">
                    <h3><?php echo $result['total']; ?></h3>
                    <p>All Job Provider</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-group'></i>
                <?php
                include '../connection.php';
                $sql = "SELECT COUNT(job_seeker_id) AS total FROM job_seeker";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <span class="text">
                    <h3><?php echo $result['total']; ?></h3>
                    <p>All Seekers</p>
                </span>
            </li>
        </ul>
    </main>
</div>
