<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminHub</title>
    <!-- Your CSS links and styles go here -->
    <style>
        /* Your CSS styles go here */
        .tabcontent {
            display: none;
        }
        .active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <!-- Your sidebar content goes here -->
    </section>

    <!-- CONTENT -->
    <section id="content">
        <!-- Tab links -->
        <div class="tabs">
            <button class="tablinks" onclick="openTab(event, 'Providers')">Latest Providers</button>
            <button class="tablinks" onclick="openTab(event, 'Seekers')">Latest Seekers</button>
            <button class="tablinks" onclick="openTab(event, 'Agents')">Latest Agents</button>
        </div>

        <!-- Default tab content for "Latest Providers" -->
        <div id="Providers" class="tabcontent active">
            <h3>Latest Providers</h3>
            <!-- Sample table for providers -->
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <!-- Add more table headers as needed -->
                </tr>
                <tr>
                    <td>1</td>
                    <td>Provider 1</td>
                    <!-- Add more table cells as needed -->
                </tr>
                <!-- Add more table rows as needed -->
            </table>
            <!-- "Load More" button for providers -->
            <button class="load-more-btn" onclick="loadMoreProviders()">Load More</button>
        </div>

        <!-- Tab content for "Latest Seekers" -->
        <div id="Seekers" class="tabcontent">
            <h3>Latest Seekers</h3>
            <!-- Sample table for seekers -->
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <!-- Add more table headers as needed -->
                </tr>
                <tr>
                    <td>1</td>
                    <td>Seeker 1</td>
                    <!-- Add more table cells as needed -->
                </tr>
                <!-- Add more table rows as needed -->
            </table>
            <!-- "Load More" button for seekers -->
            <button class="load-more-btn" onclick="loadMoreSeekers()">Load More</button>
        </div>

        <!-- Tab content for "Latest Agents" -->
        <div id="Agents" class="tabcontent">
            <h3>Latest Agents</h3>
            <!-- Sample table for agents -->
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <!-- Add more table headers as needed -->
                </tr>
                <tr>
                    <td>1</td>
                    <td>Agent 1</td>
                    <!-- Add more table cells as needed -->
                </tr>
                <!-- Add more table rows as needed -->
            </table>
            <!-- "Load More" button for agents -->
            <button class="load-more-btn" onclick="loadMoreAgents()">Load More</button>
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

        function loadMoreProviders() {
            // Add logic to fetch and append more provider data
            console.log("Loading more providers...");
        }

        function loadMoreSeekers() {
            // Add logic to fetch and append more seeker data
            console.log("Loading more seekers...");
        }

        function loadMoreAgents() {
            // Add logic to fetch and append more agent data
            console.log("Loading more agents...");
        }
    </script>
</body>
</html>
