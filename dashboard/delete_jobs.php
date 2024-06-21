<?php
include '../connection.php';

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];


    $stmt = $pdo->prepare("SELECT logo FROM jobs WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($job) {
       
        if (file_exists($job['logo'])) {
            unlink($job['logo']);
        }

       
        $stmt = $pdo->prepare("DELETE FROM jobs WHERE job_id = :job_id");
        $stmt->bindParam(':job_id', $job_id);

        try {
            if ($stmt->execute()) {
                echo "<script>alert('Job deleted successfully'); window.location.href = 'view_jobs.php';</script>";
            } else {
                echo "<script>alert('Error: Unable to execute statement');</script>";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Job not found'); window.location.href = 'view_jobs.php';</script>";
    }
} else {
    echo "<script>alert('No job ID provided'); window.location.href = 'view_jobs.php';</script>";
}
?>
