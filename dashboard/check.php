<div id="Agents" class="tabcontent">
    <h3>Latest Agents</h3>
    <div class="table-container">
        <table class="table">
            <!-- Table headers here -->
            <?php 
            // PHP code to fetch and display initial agent data
            ?>
        </table>
        <button id="load-more-agents-btn">Load More</button>
    </div>
</div>



<div id="Agents" class="tabcontent">
            <h3>Latest Agents</h3>
            <p>
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
                $stmt = $pdo->query("SELECT * FROM agent inner join users on users.users_id=agent.users_id");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['full_name'];?></td>
                        <td><?php echo $row['province'];?></td>
                        <td><?php echo $row['district'];?></td>
                        <td style="width: -56rem">
                        <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="more_agent.php?agent_id=<?php echo $row['agent_id'];?>"><b>More</b></a>
                        <a class="btn custom-bg shadow-none" style="background-color:#b0b435" href="update_agent.php?agent_id=<?php echo $row['agent_id'];?>"><b>Update</b></a>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </table>
            <button id="load-more-agents-btn">Load More</button>
        </p>
    </div>
</div>