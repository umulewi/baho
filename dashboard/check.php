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
                            <a class="btn update" href="update_job_provider.php?job_provider_id=<?php echo $row['job_provider_id']; ?>"><b>Update</b></a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </table>
                <button id="load-more-btn">more</button>
            </div>
        </div>
        <div id="Seekers" class="tabcontent">
            <h3>Latest Seekers</h3>
            <p>Content for Latest Seekers...</p>
        </div>
        <div id="Agents" class="tabcontent">
            <h3>Latest Agents</h3>
            <p>Content for Latest Agents...</p>
        </div>
    </div>
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

        document.getElementById("load-more-btn").addEventListener("click", function() {
            var loadMoreBtn = this;
            var table = document.getElementById("providers-table");
            var lastRow = table.rows[table.rows.length - 1];
            var lastId = lastRow ? lastRow.cells[0].innerText : 0;

            fetch('load_more_providers.php?lastId=' + lastId)
                .then(response => response.text())
                .then(data => {
                    var newRows = document.createElement('tbody');
                    newRows.innerHTML = data;
                    table.appendChild(newRows);
                });
        });
    });
</script>
