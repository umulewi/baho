<style>
        .form-container {
            max-width: 750px;
            margin: 0 auto;
           
        }

        /* Form fields */
        .form-container div {
            margin-bottom: 5px;
        }
        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="password"],
        .form-container input[type="email"],
        .form-container input[type="tel"],
        .form-container input[type="number"],
        .form-container input[type="file"],

        

        textarea,

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            width: 20%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: teal;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: darkslategray;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-row > div {
            flex: 1;
            min-width: 300px;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .form-row > div {
                min-width: 100%;
            }
        }
        

        
    </style>

<?php
include'dashboard.php';
include '../connection.php';

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    // Fetch the job details from the database
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE job_id = :job_id");
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$job) {
        echo "Job not found!";
        exit;
    }
}

if (isset($_POST['update'])) {
    $job_id = $_POST['job_id'];
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $published_date = $_POST['published_date'];
    $deadline_date = $_POST['deadline_date'];
    
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $file = $_FILES['logo'];
        $upload_dir = './logo/';
        $file_name = basename($file['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // File is uploaded successfully
        } else {
            echo "Error uploading the file.";
            exit;
        }
    } else {
        // If no new file is uploaded, keep the old file
        $target_file = $job['logo'];
    }

    // Update the job details in the database
    $stmt = $pdo->prepare("UPDATE jobs SET job_title = :job_title, job_description = :job_description, published_date = :published_date, deadline_date = :deadline_date, logo = :logo WHERE job_id = :job_id");
    $stmt->bindParam(':job_title', $job_title);
    $stmt->bindParam(':job_description', $job_description);
    $stmt->bindParam(':published_date', $published_date);
    $stmt->bindParam(':deadline_date', $deadline_date);
    $stmt->bindParam(':logo', $target_file);
    $stmt->bindParam(':job_id', $job_id);

    try {
        if ($stmt->execute()) {
            echo "<script>alert('Job updated successfully'); window.location.href = 'view_jobs.php';</script>";
        } else {
            echo "<script>alert('Error: Unable to execute statement');</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Job</title>
</head>
<body>
    
</body>
</html>


<div class="form-container">
		
		<main>
            <div class="table-data">
            <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['job_id']); ?>">
        <div class="form-row">
        <div>
            <label for="job_title">Job Title</label>
            <input type="text" id="job_title" name="job_title" value="<?php echo htmlspecialchars($job['job_title']); ?>" required>
        </div>
        <div>
            <label for="published_date">Published Date</label>
            <input type="date" id="published_date" name="published_date" value="<?php echo htmlspecialchars($job['published_date']); ?>" required>
        </div>
    </div>
    <div class="form-row">
        <div>
            <label for="deadline_date">Deadline Date</label>
            <input type="date" id="deadline_date" name="deadline_date" value="<?php echo htmlspecialchars($job['deadline_date']); ?>" required>
        </div>
        <div>
            <label for="logo">Logo</label>
            <input type="file" id="logo" name="logo">
            <br><br>
            <img src="<?php echo htmlspecialchars($job['logo']); ?>" alt="Job Logo" style="width: 50px; height: 70px;">
        </div>
</div>
        <div>
            <label for="job_description">job_description</label>
            <textarea id="job_description" name="job_description" required><?php echo htmlspecialchars($job['job_description']); ?></textarea>
        </div>
        <div>
            <input type="submit" name="update" value="Update">
        </div>
    </form> 
               
        
    </form>
</div>