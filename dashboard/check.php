<?php
include'dashboard.php';
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