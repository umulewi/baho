<?php  
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:login.php");
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
    <link rel="stylesheet" href="style.css">

    <title>AdminHub</title>
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

        .tabs {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .tablinks {
            background-color: #f1f1f1;
            border: none;
            outline: none;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
            cursor: pointer;
            flex: 1 1 auto;
            text-align: center;
            margin: 5px;
            border-radius: 5px;
        }

        .tablinks:hover {
            background-color: #ddd;
        }

        .tablinks.active {
            background-color: #ccc;
        }

        .tabcontent {
            display: none;
            padding: 6px 12px;
            border-top: none;
        }

        .tabcontent.active {
            display: block;
        }

        @media screen and (max-width: 768px) {
            .tabs {
                flex-direction: column;
            }

            .tablinks {
                flex: none;
            }
        }

        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            min-width: 600px; 
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: teal;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">AdminHub</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">Job Seekers</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <?php
                    include'../connection.php';
                    $stmt=$pdo->query("SELECT role_id from role where role_name='job_seeker'");
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                    <li><a href="view_job_seeker.php">View Seekers</a></li>
                    <li><a href="register_job_seeker.php?role_id=<?php echo $row['role_id'];?>">Register Seeker</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-message-dots' ></i>
                    <span class="text">Job Provider</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <?php
                    include'../connection.php';
                    $stmt=$pdo->query("SELECT role_id from role where role_name='job_provider'");
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                    <li><a href="view_job_provider.php">View Providers</a></li>
                    <li><a href="register_job_provider.php?role_id=<?php echo $row['role_id'];?>">Register provider</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-shopping-bag-alt' ></i>
                    <span class="text"> Agents</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <?php
                    include'../connection.php';
                    $stmt=$pdo->query("SELECT role_id from role where role_name='agent'");
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <ul class="dropdown-menu">
                    <li><a href="view_agent.php">View Agents</a></li>
                    <li><a href="register_agent.php?role_id=<?php echo $row['role_id'];?>">Register Agent</a></li>
                </ul>
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
    <div class="form-container">
        <div class="tabs">
            <button class="tablinks" onclick="openTab(event, 'Providers')">Latest Providers</button>
            <button class="tablinks" onclick="openTab(event, 'Seekers')">Latest Seekers</button>
            <button class="tablinks" onclick="openTab(event, 'Agents')">Latest Agents</button>
        </div>
        <div id="Providers" class="tabcontent">
            <h3>Latest Providers</h3>
            <div class="table-responsive">
                <table class="table" id="providers-table">
                    <tr>
                        <th>ID</th>
                        <th>NAMES</th>
                        <th>PROVINCE</th>
                        <th>DISTRICT</th>
                        <th>ACTION</th>
                    </tr>
                    <?php 
                    include'../connection.php';
                    $i = 1;
                    $stmt = $pdo->query("SELECT * FROM job_provider INNER JOIN users ON users.users_id = job_provider.users_id LIMIT 2");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['province']; ?></td>
                        <td><?php echo $row['district']; ?></td>
                        <td style="width: -56rem">
                            <a class="btn update" href="more_providers.php?job_provider_id=<?php echo $row['job_provider_id']; ?>"><b>More</b></a>
                            <a class="btn update" href="update_job_provider.php?job_provider_id=<?php echo $row['job_provider_id']; ?>"><b>Update</a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </table>
            </div>
        </div>
        <div id="Seekers" class="tabcontent">
            <h3>Latest Seekers</h3>
            <div class="table-responsive">
                <table class="table" id="seekers-table">
                    <tr>
                        <th>ID</th>
                        <th>NAMES</th>
                        <th>PROVINCE</th>
                        <th>DISTRICT</th>
                        <th>ACTION</th>
                    </tr>
                    <?php 
                    include'../connection.php';
                    $i = 1;
                    $stmt = $pdo->query("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id LIMIT 2");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['province']; ?></td>
                        <td><?php echo $row['district']; ?></td>
                        <td>
                            <a class="btn update" href="more_seeker.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>"><b>More</b></a>
                            <a class="btn update" href="update_job_seeker.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>"><b>Update</b></a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </table>
            </div>
        </div>
        <div id="Agents" class="tabcontent">
            <h3>Latest Agents</h3>
            <div class="table-responsive">
                <table class="table" id="agents-table">
                    <tr>
                        <th>ID</th>
                        <th>NAMES</th>
                        <th>PROVINCE</th>
                        <th>DISTRICT</th>
                        <th>ACTION</th>
                    </tr>
                    <?php 
                    include'../connection.php';
                    $i = 1;
                    $stmt = $pdo->query("SELECT * FROM agent INNER JOIN users ON users.users_id = agent.users_id LIMIT 2");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['province']; ?></td>
                        <td><?php echo $row['district']; ?></td>
                        <td>
                            <a class="btn update" href="more_agent.php?agent_id=<?php echo $row['agent_id']; ?>"><b>More</b></a>
                            <a class="btn update" href="update_agent.php?agent_id=<?php echo $row['agent_id']; ?>"><b>Update</b></a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    </section>
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.dropdown-toggle').forEach(button => {
                button.addEventListener('click', () => {
                    button.nextElementSibling.classList.toggle('active');
                    button.querySelector('.dropdown-icon').classList.toggle('open');
                });
            });

            document.querySelectorAll('.tablinks')[0].click();
        });
    </script>
</body>
</html>
