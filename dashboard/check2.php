


        
    <div id="Seekers" class="tabcontent">
        <h3>Latest Seekers</h3>
        <div class="table-container">
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

                include'../connection.php';
                $i = 1;
                $stmt = $pdo->query("SELECT * FROM job_seeker INNER JOIN users ON users.users_id = job_seeker.users_id LIMIT 2");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                
                <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['salary']; ?> RW</td>
                            <td><?php echo $row['bio']; ?></td>
                            <td><?php echo $row['province']; ?></td>
                            <td style="width: -56rem">
                            <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="details.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>"><b>MORE</b></a>
                            <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_job_seeker.php?job_seeker_id=<?php echo $row['job_seeker_id']; ?>"><b>Update</b></a>
                        </td>
                <?php
                    $i++;
                }
                ?>
            </table>
           
            <button id="load-more-seekers-btn">Load More</button>
        </div>
    </div>


</body>
</html>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("load-more-job_seekers-btn").addEventListener("click", function() {
        var loadMoreBtn = this;
        var table = document.querySelector("#Seekers table");
        var lastRow = table.rows[table.rows.length - 1];
        var lastId = lastRow ? lastRow.cells[0].innerText : 0;
        fetch('load_more_job_seekers.php?lastId=' + lastId)
            .then(response => response.text())
            .then(data => {
                // Append new rows
                var newRows = document.createElement('tbody');
                newRows.innerHTML = data;
                table.appendChild(newRows);
            });
    });
});
</script>
