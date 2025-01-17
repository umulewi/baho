<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../dashboard/style.css">


<meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="../img/apple-touch-icon.png">
    <title>kozi</title>
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
        <img src="../img/logo.png" alt="" style="width:12rem;margin-top:2rem;margin-left:2rem">
            <span class="text"></span>
        </a>
        <ul class="side-menu top">
            <li class="">
                <a href="index.php">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
           
            
            <li class="">
                <a href="#" class="dropdown-toggle" data-nav="top">
                    <i class='bx bxs-group' ></i>
                    <span class="text">MY Profile</span>
                    <i class='bx bx-chevron-down dropdown-icon'></i>
                </a>
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu">
                    <li><a href="view_profile.php">View Profile</a></li>
                    <li><a href="my_profile.php">Edit Profile</a></li>
                </ul>
            </li>

            <li class="">
                <a href="my_application.php">
                    <i class='bx bxs-shopping-bag-alt' ></i>   
                    <span class="text">My Application</span>
                </a>
            </li>
            <li class="">
                <a href="all_jobs.php">
                    <i class='bx bxs-shopping-bag-alt' ></i>   
                    <span class="text">All jobs</span>
                </a>
            </li>
            <li>
                <a href="payment.php">
                    <i class='bx bxs-shopping-bag-alt' ></i>
                    <span class="text"> Payment</span>
                   
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
    <!-- CONTENT -->
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multilingual Website with Google Translate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            position: relative; /* Ensure this is relative for absolute positioning */
        }
        header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .language-switcher {
            margin: 0;
        }
        .language-switcher a {
            padding: 10px;
            cursor: pointer;
            text-decoration: none;
            color: #007bff;
        }
        .language-switcher a:hover {
            text-decoration: underline;
        }
        /* Hide Google Translate toolbar */
        #goog-gt-tt,
        .skiptranslate > .goog-te-gadget-simple,
        .goog-te-banner-frame,
        .goog-te-balloon-frame,
        .goog-tooltip,
        .goog-tooltip:hover,
        .goog-text-highlight {
            display: none !important;
        }
        body {
            top: 0 !important;
        }
        /* Hide the Google Translate element */
        #google_translate_element {
            display: none !important;
        }
    </style>
</head>
<body>


    
    <script>
        function changeLanguage(lang) {
            var selectField = document.querySelector('select.goog-te-combo');
            if (selectField) {
                selectField.value = lang;
                selectField.dispatchEvent(new Event('change'));
            }
        }

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,fr,rw'}, 'google_translate_element');
        }

        (function initGoogleTranslate() {
            var gtElement = document.createElement('div');
            gtElement.id = 'google_translate_element';
            gtElement.style.display = 'none';
            document.body.appendChild(gtElement);
            var translateScript = document.createElement('script');
            translateScript.src = "https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
            document.body.appendChild(translateScript);
        })();
    </script>
</body>
</html>

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
            <div class="language-switcher">
                <a href="#" onclick="changeLanguage('rw')">Kinyarwanda</a>
                <a href="#" onclick="changeLanguage('en')">English</a>
                <a href="#" onclick="changeLanguage('fr')">Français</a>
            </div>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            
        </nav>
        <!-- NAVBAR -->

            <!-- display all content in-->


            <main>

			
		</main>

		
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
