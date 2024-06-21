<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("location:login.php");
    exit();
}
?>
<?php
include'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
       .form-container {
            max-width: 750px;
            margin: 0 auto;
          
        }
        .form-container div {
            margin-bottom: 15px;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="password"],
        .form-container input[type="email"],xta
        .form-container input[type="tel"],
        .form-container input[type="number"],
        .form-container input[type="file"],
        select,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            width: 30%;
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
    
</head>
<body>
 
    <div class="form-container">
        <main>
            <div class="table-data">
                <h2 style="text-align:center;margin-top:2rem;color:teal">New job</h2><br>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div>
                        <label for="title">Job Title</label>
                        <input type="text" id="job_title" name="job_title" required>
                    </div>
                    <div>
                        <label for="description">Published Date:</label>
                        <input type="date" id="published" name="published_date" required>
                    </div>
                    
                </div>
                <div class="form-row"> 
             <div>
                <label for="published_date">Deadline Date:</label>
                <input type="date" name="deadline_date" id="deadline_date" required>
            </div>
            <div>
                <label for="id">Logo</label>
                <input type="file" id="logo" name="logo" required>
            </div>
            <div>
                        <label for="job_description">Descption:</label>
                        <textarea style="height:133px;" id="job_description" name="job_description" required ></textarea>
                    </div>
                </div>
                <div>
                <input type="submit" name="register" value="Register" stayle="background-color:red">
            </div>
        </form>
    </div>
    </main>
    </div>
			
			
</body>
</html>
<?php
include '../connection.php';

if (isset($_POST["register"])) {
    

    $created_by = $_SESSION['admin_email'];
    $job_title= $_POST['job_title'];
    $published_date = $_POST['published_date'];
    $deadline_date = $_POST['deadline_date'];
    $created_by=$_SESSION['admin_email'];
    $job_description=$_POST['job_description'];
    
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $id = $_FILES['logo'];
        $upload_dir = './logo/'; // 
        $file_name = basename($id['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($id['tmp_name'], $target_file)) {
            // File is uploaded successfully
        } else {
            echo "Error uploading the file.";
            exit;
        }
    } else {
        echo "File upload error.".mysql_error();
        exit;
    }

   

    // Insert into job_seeker table using the last inserted users_id
    $stmt_job_seeker = $pdo->prepare("INSERT INTO jobs (logo,job_title,job_description,published_date,deadline_date, created_by) VALUES (:logo, :job_title, :job_description,:published_date,:deadline_date,:created_by)");
    $stmt_job_seeker->bindParam(':job_title', $job_title);
    $stmt_job_seeker->bindParam(':job_description', $job_description);
    $stmt_job_seeker->bindParam(':published_date', $published_date);
    $stmt_job_seeker->bindParam(':deadline_date', $deadline_date);
    if ($target_file) {
        $stmt_job_seeker->bindParam(':logo', $target_file);
    }
    $stmt_job_seeker->bindParam(':created_by', $created_by);
    try {
        if ($stmt_job_seeker->execute()) {
            echo "<script>alert('New job seeker has been added');</script>";
        } else {
            echo "<script>alert('Error: Unable to execute statement');</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<script>
    var today = new Date();
    var maxDate = new Date();
    maxDate.setFullYear(today.getFullYear() - 18);
    var maxDateFormatted = maxDate.toISOString().split('T')[0];
    document.getElementById("date_of_birth").setAttribute("max", maxDateFormatted);
</script>

<script>
const idInput = document.getElementById("id");
idInput.addEventListener("input", function() {
  const value = idInput.value;
  if (value.length > 16) {
    idInput.value = value.slice(0, 16); 
  }
  
});
</script>