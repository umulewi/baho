<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../dashboard/style.css">
    <title>kozi rwanda</title>
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
        #content main .box-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)  ::  );
    grid-gap: 24px;
    margin-top: 36px;
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
                <a href="index.php">
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
                    <i class='bx bxs-group' ></i>   
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



    <section id="content">
        <!-- NAVBAR -->
        <nav class="subsequent-nav">
            <i class='bx bx-menu' ></i>
            
            <form action="#">
                <div class="form-input">
                    <!-- <input type="search" placeholder="Search..."> -->
                    <button type="submit" class="search-btn" style="display: none;"><i class='bx'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            
           
        </nav>
        <!-- NAVBAR -->
        


            <!-- display all content in-->



            
		
    <!-- CONTENT -->
    

    <script src="script.js"></script>
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
