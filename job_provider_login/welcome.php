<?php
require_once 'config.php';
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $userinfo = [
    'email' => $google_account_info['email'],
    'first_name' => $google_account_info['givenName'],
    'last_name' => $google_account_info['familyName'],
    'gender' => $google_account_info['gender'],
    'full_name' => $google_account_info['name'],
    'picture' => $google_account_info['picture'],
    'verifiedEmail' => $google_account_info['verifiedEmail'],
    'token' => $google_account_info['id'],
  ];

  $sql = "SELECT * FROM users WHERE email ='{$userinfo['email']}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    // user is exists
    $userinfo = mysqli_fetch_assoc($result);
    $token = $userinfo['token'];
  } else {
    $sql_role = "SELECT role_id FROM role WHERE role_name = 'job_provider'";
    $result_role = mysqli_query($conn, $sql_role);
    if (mysqli_num_rows($result_role) > 0) {
      $role_info = mysqli_fetch_assoc($result_role);
      $role_id = $role_info['role_id'];
    } else {
      echo "Job seeker role does not exist";
      die();
    }
    $sql = "INSERT INTO users (email, first_name, last_name, gender, full_name, picture, verifiedEmail, token,role_id) VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['gender']}', '{$userinfo['full_name']}', '{$userinfo['picture']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}',$role_id)";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $lastInsertedID = mysqli_insert_id($conn);
        $sql_job_provide = "INSERT INTO job_provider (users_id, role_id) VALUES ('{$lastInsertedID}', '{$role_id}')";
        $result_job_provide = mysqli_query($conn, $sql_job_provide);
        if (!$result_job_provide) {
                echo "Error inserting into job_provide table: " . mysqli_error($conn);
                die();
            }
            
      $token = $userinfo['token'];
    } else {
      echo "User is not created";
      die();
    }
  }
  // save user data into session
  $_SESSION['user_token'] = $token;
  $_SESSION['user_email'] = $userinfo['email']; 
} else {
  if (!isset($_SESSION['user_token'])) {
    header("Location: index.php");
    die();
  }

  // checking if user is already exists in database
  $sql = "SELECT * FROM users WHERE token ='{$_SESSION['user_token']}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    // user is exists
    $userinfo = mysqli_fetch_assoc($result);
    $_SESSION['user_email'] = $userinfo['email'];
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../dashboard/style.css">
    <title>Attandance Management System</title>
    <style>
        /* Additional CSS for dropdown icon */
        .dropdown-icon {
            margin-left: auto;
            transform: rotate(0deg);
            transition: transform 0.3s ease;
        }

        .dropdown-icon.open {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.active {
            display: block;
        }

        /* Hide the dropdown icon when the menu is open */
        .dropdown-menu.active + .dropdown-icon {
            display: none;
        }

        /* Add margin to the subsequent nav elements */
        .subsequent-nav.pushed-down {
            margin-top: 50px; /* Adjust this value as needed */
        }

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
    </style>
    </style>
</head>
<body>
<section id="sidebar">
<a href="index.php" class="brand">
        <img src="../img/logo.png" alt="" style="width:12rem;margin-top:2rem;margin-left:2rem">
            <span class="text"></span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="welcome.php">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-shopping-bag-alt' ></i>
                    <span class="text">My Profile</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                    <li><a href="view_profile.php">View Profile</a></li>
                    <li><a href="my_profile.php">Edit Profile</a></li>
                </ul>
            </li>
            <li class="active">
                <a href="all_employees.php">
                    <i class='bx bxs-dashboard' ></i>   
                    <span class="text">All Job Seeker</span>
                </a>
            </li>
            
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>  
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav class="subsequent-nav">
            <i class='bx bx-menu' ></i>
            
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            
        </nav>
        <!-- NAVBAR -->
            <!-- display all content in-->
            <main>
			<div class="form-container" style="margin-left:12px;">
             
            </div>
		</main>	

        <main>
			
         

			<ul class="box-info">
                <li class="job-seeker-count">
                    <i class='bx bxs-group'></i>
                    <?php
                    include'../connection.php';
                    $sql = "SELECT COUNT(job_provider_id) AS total FROM job_provider";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <span class="text">
                        <h3><?php echo $result['total']?></h3>
                        <p> Providers</p>
                    </span>
                </li>
				<li>
					<i class='bx bxs-calendar-check' ></i>
                    <?php
                    include'../connection.php';
                    $sql = "SELECT COUNT(job_seeker_id) AS total FROM job_seeker";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
					<span class="text">
						<h3><?php echo $result['total']?></h3>
						<p>Seekers</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
                    <?php
                    include'../connection.php';
                    $sql = "SELECT COUNT(hired_id) AS total FROM hired_seekers";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
					<span class="text">
						<h3><?php echo $result['total']?></h3>
						<p>Employeees</p>
					</span>
				</li>
				
			</ul>


			
		</main>
    <!-- CONTENT -->
    
    <script src="../dashboard/script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const dropdownToggles = document.querySelectorAll("#sidebar .dropdown-toggle");

    dropdownToggles.forEach(function(dropdownToggle) {
        dropdownToggle.addEventListener("click", function(event) {
            event.preventDefault();

            const clickedDropdownMenu = this.nextElementSibling;

            // Close all active dropdowns except the one being clicked
            const activeDropdownMenus = document.querySelectorAll("#sidebar .dropdown-menu.active");
            activeDropdownMenus.forEach(function(menu) {
                if (menu !== clickedDropdownMenu) {
                    menu.classList.remove("active");
                    menu.previousElementSibling.querySelector(".dropdown-icon").classList.remove("open");
                }
            });

            // Toggle active class for the clicked dropdown menu
            clickedDropdownMenu.classList.toggle("active");
            this.querySelector(".dropdown-icon").classList.toggle("open");

            // Hide other subsequent nav elements
            const otherNavs = document.querySelectorAll("#sidebar .subsequent-nav:not(." + this.getAttribute("data-nav") + ")");
            otherNavs.forEach(function(nav) {
                nav.style.display = "none";
            });

            // Stop the click event from propagating to the subsequent nav elements
            event.stopPropagation();
        });

        // Prevent the dropdown toggle from toggling the dropdown menu
        dropdownToggle.addEventListener("mouseenter", function(event) {
            const clickedDropdownMenu = this.nextElementSibling;

            // Hide other dropdown menus
            const otherDropdownMenus = document.querySelectorAll("#sidebar .dropdown-menu");
            otherDropdownMenus.forEach(function(menu) {
                if (menu !== clickedDropdownMenu) {
                    menu.classList.remove("active");
                    menu.previousElementSibling.querySelector(".dropdown-icon").classList.remove("open");
                }
            });

            // Hide other subsequent nav elements
            const otherNavs = document.querySelectorAll("#sidebar .subsequent-nav:not(." + this.getAttribute("data-nav") + ")");
            otherNavs.forEach(function(nav) {
                nav.style.display = "none";
            });
        });
    });

    // Close dropdown menu when clicking outside of it
    document.addEventListener("click", function(event) {
        const dropdownMenus = document.querySelectorAll("#sidebar .dropdown-menu");
        dropdownMenus.forEach(function(menu) {
            menu.classList.remove("active");
            menu.previousElementSibling.querySelector(".dropdown-icon").classList.remove("open");
        });

        const subsequentNavs = document.querySelectorAll("#sidebar .subsequent-nav");
        subsequentNavs.forEach(function(nav) {
            nav.style.display = "none";
        });
    });
});

function showContent(content) {
      document.getElementById("content").innerHTML = content;
    }

    document.getElementById("sidebarToggleBtn").addEventListener("click", function() {
      document.getElementById("sidebar").classList.toggle("collapsed");
      document.getElementById("mainContent").classList.toggle("collapsed");
    });

    </script>
</body>
</html>