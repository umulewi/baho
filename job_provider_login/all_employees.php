<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
?>
            <?php
include 'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <style>
        /* Form container */
        .form-container { 
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Form fields */
        .form-container div {
            margin-bottom: 15px;
        }
        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"],
        form select,
        .form-container input[type="email"] {
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
            background-color: teal;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 0 -10px; /* Add negative margin to counteract spacing from cards */
        }

        .card {
            flex: 0 0 calc(100% - 20px); /* Adjust width for one card per row */
            max-width: calc(100% - 20px); /* Adjust width for one card per row */
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin: 10px; 
        }

        @media screen and (min-width: 600px) {
            .card {
                flex-basis: calc(33.33% - 20px); /* Adjust width for three cards per row on larger screens */
                max-width: calc(33.33% - 20px); /* Adjust width for three cards per row on larger screens */
            }
        }

        /* Custom dual slider */
        .dual-slider {
            position: relative;
            width: 100%;
            height: 50px; /* Increased height to accommodate outputs */
        }
        .dual-slider input[type="range"] {
            position: absolute;
            width: 100%;
            -webkit-appearance: none;
            appearance: none;
            background: none;
            pointer-events: none;
            top: 40px; /* Position the sliders below the outputs */
        }
        .dual-slider input[type="range"]::-webkit-slider-thumb {
            pointer-events: all;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: teal;
            cursor: pointer;
            -webkit-appearance: none;
            position: relative;
            z-index: 1;
        }
        .dual-slider input[type="range"]::-moz-range-thumb {
            pointer-events: all;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: teal;
            cursor: pointer;
            z-index: 1;
        }
        .dual-slider .track {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 10px;
            background: #ccc;
            transform: translateY(10px); /* Adjusted to position the track correctly */
            border-radius: 5px;
            z-index: 0;
        }
        .dual-slider .range {
            position: absolute;
            top: 50%;
            height: 10px;
            background: teal;
            transform: translateY(10px); /* Adjusted to position the range correctly */
            border-radius: 5px;
            z-index: 0;
        }
        .dual-slider .output {
            position: absolute;
            top: 0;
            width: 50px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>



    
       
               


<div class="form-container">

    <form action="" method="GET">
    
    
        <label for="salary_range">Salary Range (RWF):</label>
        <div class="dual-slider">
            <div class="track"></div>
            <div class="range" id="range"></div>
            <input type="range" id="min_salary" name="min_salary" min="0" max="300000" step="1000" value="<?php echo isset($_GET['min_salary']) ? $_GET['min_salary'] : 0 ?>">
            <input type="range" id="max_salary" name="max_salary" min="0" max="300000" step="1000" value="<?php echo isset($_GET['max_salary']) ? $_GET['max_salary'] : 300000 ?>">
            <div class="output" id="min_salary_output">0</div>
            <div class="output" id="max_salary_output">300000</div>
        </div>
        <input type="submit" value="Filter">
    </div>
  
    </form>
   
</div>

<main>
<div class="table-data">
<div class="card-container"> 
    <?php 
    include '../connection.php';
    $min_salary = isset($_GET['min_salary']) ? $_GET['min_salary'] : 0;
    $max_salary = isset($_GET['max_salary']) ? $_GET['max_salary'] : 300000;

    $stmt = $pdo->prepare("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['salary']) && strpos($row['salary'], '-') !== false) {
            $salary_range = explode('-', $row['salary']);
            $min = (int)$salary_range[0];
            $max = (int)$salary_range[1];

            if ($min_salary <= $max && $max_salary >= $min) {
    ?>
    <div class="card">
        <img src="sample.png" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b><?php echo $row['full_name']; ?></b></h4><br>
            <p><?php echo $row['bio']; ?></p><br>
            <a href='hire_me.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>' 
               style="display: inline-block; padding: 10px 20px; margin: 10px 0; font-size: 16px; cursor: pointer; text-align: center; text-decoration: none; outline: none; color: #fff; background-color: teal; border: none; border-radius: 5px;">
               HIRE ME
            </a>
        </div>
    </div>
    <?php
            }
        }
    }
    ?>
</div>


            
            </div>
        </main>
   

    <script>
    const minSalaryInput = document.getElementById("min_salary");
    const maxSalaryInput = document.getElementById("max_salary");
    const minSalaryOutput = document.getElementById("min_salary_output");
    const maxSalaryOutput = document.getElementById("max_salary_output");
    const range = document.getElementById("range");

    function updateRange() {
        const min = parseInt(minSalaryInput.value);
        const max = parseInt(maxSalaryInput.value);

        if (min > max) {
            [minSalaryInput.value, maxSalaryInput.value] = [maxSalaryInput.value, minSalaryInput.value];
        }

        minSalaryOutput.textContent = minSalaryInput.value;
        maxSalaryOutput.textContent = maxSalaryInput.value;

        const minPercent = (minSalaryInput.value / minSalaryInput.max) * 100;
        const maxPercent = (maxSalaryInput.value / maxSalaryInput.max) * 100;

        range.style.left = minPercent + "%";
        range.style.width = (maxPercent - minPercent) + "%";

        minSalaryOutput.style.left = `calc(${minPercent}% - 25px)`;
        maxSalaryOutput.style.left = `calc(${maxPercent}% - 25px)`;
    }

    minSalaryInput.addEventListener("input", updateRange);
    maxSalaryInput.addEventListener("input", updateRange);

    // Initial update
    updateRange();
</script>