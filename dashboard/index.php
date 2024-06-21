<?php  
session_start();
if (!isset($_SESSION['admin_email'])) {
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

    <title>KOZIRWA</title>
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
        
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            margin: 2px; /* Add margin to separate buttons */
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
        .table-container {
            overflow-x: auto;
        }
        .action-buttons {
            display: flex;
            flex-wrap: wrap; 
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
        
        @media (max-width: 600px) {
            .btn {
                display: block;
                margin: 8px 0;
            }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="index.php" class="brand">
        <img src="../img/logo.png" alt="" style="width:12rem;margin-top:2rem;margin-left:2rem">
            <span class="text"></span>
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
                    <li><a href="hired_seekers.php">Hired Seekers</a></li>
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
            <li>
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-message-dots' ></i>
                    <span class="text">jobs</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                    <li><a href="view_job_provider.php">View Jobs</a></li>
                    <li><a href="register_job_provider.php?role_id=<?php echo $row['role_id'];?>">Register New Jobs</a></li>
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
              
          
                <button type="submit" class="search-btn" style="display: none;"><i class='bx'></i></button>



            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
    </nav>


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
						<p>Employers</p>
					</span>
				</li>
				
			</ul>


			
		
    <div class="form-container">
        <div class="tabs">
            <button class="tablinks" onclick="openTab(event, 'Providers')">Latest Providers</button>
            <button class="tablinks" onclick="openTab(event, 'Seekers')">Latest Seekers</button>
            <button class="tablinks" onclick="openTab(event, 'Agents')">Latest Agents</button>
        </div>
        <div id="Providers" class="tabcontent active">
        
           
            <div class="table-responsive">
                <main>

                <div class="table-data">
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
                   
                    $stmt = $pdo->query("SELECT * FROM job_provider INNER JOIN users ON users.users_id = job_provider.users_id ORDER BY job_provider_id DESC LIMIT 2");

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['province']; ?></td>
                        <td><?php echo $row['district']; ?></td>
                        <td style="width: -56rem">
                            <a class="btn update" href="More_providers.php?job_provider_id=<?php echo $row['job_provider_id']; ?>"><b>More</b></a>
                            <a class="btn update" href="update_job_provider.php?job_provider_id=<?php echo $row['job_provider_id']; ?>"><b>Update</b></a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </table>
                </div>
                </main>
               
                <button class="btn custom-bg shadow-none" style="background-color:#b0b435; margin-top:12px; border: none; cursor: pointer;" id="load-More-btn">Load More</button>
                
            </div>
        </div>
        <div id="Seekers" class="tabcontent">
      
        <div class="table-responsive">
        <div class="table-container">
        <div class="table-data">
            <table class="table">
       
                <tr>
                    <th>ID</th>
                    <th>NAMES</th>
                    <th>SALARY</th>
                    <th>BIO</th>
                    <th>AGE</th>
                    <th>ACTION</th>
                </tr>
         
                <?php 
                $i = 1;
                $stmt = $pdo->query("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id order by job_seeker_id desc LIMIT 2");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                
                <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['first_name']; ?> <?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['salary']; ?> RW</td>
                            <td><?php echo $row['bio']; ?></td>
                            <td><?php echo $row['province']; ?></td>
                            <td style="width: -56rem">
                            <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="details.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>"><b>More</b></a>
                            <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_job_seeker.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>"><b>Update</b></a>
                        </td>
                <?php
                    $i++;
                }
                ?>
            </table>  
            </div>  
            <button class="btn custom-bg shadow-none" style="background-color:#b0b435; margin-top:12px; border: none; cursor: pointer;" id="load-More-seekers-btn">Load More</button>

        </div>
            </div>
    </div>

    <div id="Agents" class="tabcontent">

         
            <p>
            <div class="table-responsive">
            <div class="table-data">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>NAMES</th>
                    <th>PROVINCE</th>
                    <th>DISTRICT</th>
                    <th>ACTION</th>
                </tr>
                <?php 
                $i=1;
                $stmt = $pdo->query("SELECT * FROM agent inner join users on users.users_id=agent.users_id LIMIT 2");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['full_name'];?></td>
                        <td><?php echo $row['province'];?></td>
                        <td><?php echo $row['district'];?></td>
                        <td style="width: -56rem">
                        <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="More_agent.php?agent_id=<?php echo $row['agent_id'];?>"><b>More</b></a>
                        <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_agent.php?agent_id=<?php echo $row['agent_id'];?>"><b>Update</b></a>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </table>
        </div>
        </div>
           


            <button class="btn custom-bg shadow-none" style="background-color:#b0b435; margin-top:12px; border: none; cursor: pointer;" id="load-More-agents-btn">Load More</button>
        </p>
    </div>
</div>
        
    </div>


        </main>
</section>




<script src="script.js"></script>
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

    document.addEventListener("DOMContentLoaded", function() {
        var tabcontents = document.getElementsByClassName("tabcontent");
        for (var i = 0; i < tabcontents.length; i++) {
            tabcontents[i].style.display = "none";
        }

        document.getElementById("load-More-btn").addEventListener("click", function() {
            var loadMoreBtn = this;
            var table = document.getElementById("providers-table");
            var lastRow = table.rows[table.rows.length - 1];
            var lastId = lastRow ? lastRow.cells[0].innerText : 0;
            fetch('load_More_providers.php?lastId=' + lastId)
                .then(response => response.text())
                .then(data => {
                    // Remove existing rows except the header row
                    while (table.rows.length > 1) {
                        table.deleteRow(1);
                    }

                    // Append new rows
                    var newRows = document.createElement('tbody');
                    newRows.innerHTML = data;
                    table.appendChild(newRows);

                    // Remove the "Load More" button after fetching More data
                    loadMoreBtn.parentNode.removeChild(loadMoreBtn);
                });
        });
    });
</script>


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

<!-- job_seeker-->

<script>
document.addEventListener("DOMContentLoaded", function() {
    var loadMoreBtn = document.getElementById("load-More-seekers-btn");
    loadMoreBtn.addEventListener("click", function() {
        var table = document.querySelector("#Seekers table");
        var lastRow = table.rows[table.rows.length - 1];
        var lastId = lastRow ? lastRow.cells[0].innerText : 0;

        fetch('load_More_seekers.php?lastId=' + lastId)
            .then(response => response.text())
            .then(data => {
                // Clear existing rows in the tbody
                var tbody = table.querySelector('tbody');
                if (tbody) {
                    while (tbody.firstChild) {
                        tbody.removeChild(tbody.firstChild);
                    }
                }

                // Append new rows
                var newRows = document.createElement('tbody');
                newRows.innerHTML = data;
                table.appendChild(newRows);

                // Remove the "Load More" button
                loadMoreBtn.parentNode.removeChild(loadMoreBtn);
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    });
});
</script>




<script>
document.addEventListener("DOMContentLoaded", function() {
    var loadMoreBtn = document.getElementById("load-More-agents-btn");
    loadMoreBtn.addEventListener("click", function() {
        var table = document.querySelector("#Agents table");
        var lastRow = table.rows[table.rows.length - 1];
        var lastId = lastRow ? lastRow.cells[0].innerText : 0;

        fetch('load_More_agents.php?lastId=' + lastId)
            .then(response => response.text())
            .then(data => {
                // Clear existing rows in the tbody
                var tbody = table.querySelector('tbody');
                if (tbody) {
                    while (tbody.firstChild) {
                        tbody.removeChild(tbody.firstChild);
                    }
                }

                // Append new rows
                var newRows = document.createElement('tbody');
                newRows.innerHTML = data;
                table.appendChild(newRows);

                // Remove the "Load More" button
                loadMoreBtn.parentNode.removeChild(loadMoreBtn);
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    });
});
</script>


</body>
</html>
