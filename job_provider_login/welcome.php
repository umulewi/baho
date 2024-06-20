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
        $userinfo = mysqli_fetch_assoc($result);
        $token = $userinfo['token'];
    } else {
        $sql_role = "SELECT role_id FROM role WHERE role_name = 'job_seeker'";
        $result_role = mysqli_query($conn, $sql_role);
        if (mysqli_num_rows($result_role) > 0) {
            $role_info = mysqli_fetch_assoc($result_role);
            $role_id = $role_info['role_id'];
        } else {
            echo "Job seeker role does not exist";
            die();
        }
        $sql = "INSERT INTO users (email, first_name, last_name, gender, full_name, picture, verifiedEmail, token, role_id) 
        VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['gender']}', '{$userinfo['full_name']}', '{$userinfo['picture']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}', '{$role_id}')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $lastInsertedID = mysqli_insert_id($conn); // Get the last inserted ID
            // Now insert the role_id and lastInsertedID into the job_provide table
            $sql_job_provide = "INSERT INTO job_seeker (users_id, role_id) VALUES ('{$lastInsertedID}', '{$role_id}')";
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

    $_SESSION['provider_email'] = $userinfo['email'];
    $_SESSION['user_token'] = $token;
} else {
    if (!isset($_SESSION['user_token'])) {
        header("Location: index.php");
        die();
    }

    $sql = "SELECT * FROM users WHERE token ='{$_SESSION['user_token']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // user exists
        $userinfo = mysqli_fetch_assoc($result);
        $_SESSION['provider_email'] = $userinfo['email']; // Setting email in session
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../dashboard/style.css">
    <title>Attendance Management System</title>
    <style>
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

        .dropdown-menu.active + .dropdown-icon {
            display: none;
        }
        .subsequent-nav.pushed-down {
            margin-top: 50px; 
        }
    </style>
</head>
<body>
<section id="sidebar">
        <a href="index.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">AdminHub</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="index.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
           
            <li class="active">
                <a href="my_profile.php">
                    <i class='bx bxs-dashboard'></i>   
                    <span class="text">My Profile</span>
                </a>
            </li>
            <li class="active">
                <a href="my_application.php">
                    <i class='bx bxs-dashboard'></i>   
                    <span class="text">My Application</span>
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>   
                    <span class="text">All Jobs</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            
            
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>  
    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav class="subsequent-nav">
            <i class='bx bx-menu'></i>
            
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            
        </nav>
        <!-- NAVBAR -->

        <!-- display all content in-->
        <main>
            <div>
                <?php
                $provider_email = $_SESSION['provider_email'];
                include '../connection.php';
                try {
                    $query = $pdo->prepare("SELECT users_id FROM users WHERE email = :email");
                    $query->execute(['email' => $provider_email]);
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

                <!DOCTYPE html>
                <html>
                <head>
                    <title>Application Progress</title>
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
                <div class="form-container">
                    <h2>Job Application Progress</h2>
                    <div class="progress">
                        <div class="progress-bar">
                            <?php echo $progress ? $progress . "%" : "Progress not available"; ?>
                        </div>
                    </div>
                </div>
                </body>
                </html>
            </div>

            <!-- alert -->
            <script>
                window.onload = function() {
                    alert("Remember you have to complete your profile: go to profile and choose Edit profile.");
                };
            </script>
        </main>
    </section>

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
