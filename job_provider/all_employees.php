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

        /* Custom slider */
        .custom-slider {
            position: relative;
            width: 100%;
            height: 25px;
            margin-bottom: 20px;
        }
        .custom-slider input[type="range"] {
            position: absolute;
            width: calc(100% - 20px); /* Reduce the width by 20px to accommodate the thumb size */
            left: 10px; /* Adjusted left position */
            top: 50%;
            transform: translateY(-50%);
            -webkit-appearance: none;
            appearance: none;
            height: 10px;
            background: #ccc;
            border-radius: 5px;
            outline: none;
        }
        .custom-slider input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #4CAF50;
            cursor: pointer;
            border-radius: 50%;
            z-index: 1; /* Ensure the thumb is above the track */
        }
        .custom-slider input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #4CAF50;
            cursor: pointer;
            border-radius: 50%;
            z-index: 1; /* Ensure the thumb is above the track */
        }
        .custom-slider output {
            position: absolute;
            font-size: 14px;
            top: -30px;
            left: 0;
            width: 100%;
            text-align: center;
        }

        /* Positioning for minimum and maximum sliders */
        .custom-slider input[type="range"] {
            z-index: 1;
        }
        .custom-slider input[type="range"] + input[type="range"] {
            margin-top: 20px; /* Add margin between the sliders */
        }

        /* Spacing between minimum and maximum numbers */
        .custom-slider output:first-of-type {
            margin-right: 20px;
        }
    </style>
    
</head>
<body>


<?php
include 'dashboard.php';
?>

<div class="form-container">
    <form action="" method="GET">
        <label for="salary_range">Salary Range(RWF):</label>
        <div class="custom-slider">
            <input type="range" id="min_salary" name="min_salary" min="0" max="100000" step="1000" value="<?php echo isset($_GET['min_salary']) ? $_GET['min_salary'] : 0 ?>">
            <output for="min_salary" id="min_salary_output">0</output>

            <input type="range" id="max_salary" name="max_salary" min="0" max="100000" step="1000" value="<?php echo isset($_GET['max_salary']) ? $_GET['max_salary'] :0?>">
            <output for="max_salary" id="max_salary_output"></output>
        </div>

        <input type="submit" value="Filter">
    </form>
</div>

<div class="card-container"> 
    <?php 
    include '../connection.php';
    $min_salary = isset($_GET['min_salary']) ? $_GET['min_salary'] : 0;
    $max_salary = isset($_GET['max_salary']) ? $_GET['max_salary'] : 100000;

    // Prepare SQL query based on whether a filter is applied or not
    $stmt = $pdo->prepare("SELECT * FROM job_seeker WHERE salary BETWEEN ? AND ?");
    $stmt->execute([$min_salary, $max_salary]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="card">
        <img src="sample.png" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b><?php echo $row['firstname'];?> <?php echo $row['lastname'];?></b></h4>
            <p><?php echo $row['bio'] ?></p>
        </div>
    </div>
    <?php
    }
    ?>
</div>

<script>
    const minSalaryInput = document.getElementById("min_salary");
    const maxSalaryInput = document.getElementById("max_salary");
    const minSalaryOutput = document.getElementById("min_salary_output");
    const maxSalaryOutput = document.getElementById("max_salary_output");

    minSalaryInput.addEventListener("input", function() {
        minSalaryOutput.textContent = minSalaryInput.value;
    });

    maxSalaryInput.addEventListener("input", function() {
        maxSalaryOutput.textContent = maxSalaryInput.value;
    });

    // Initial update
    minSalaryOutput.textContent = minSalaryInput.value;
    maxSalaryOutput.textContent = maxSalaryInput.value;
</script>

</body>
</html>
