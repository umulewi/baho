<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: ../../../login.php");
    exit();
}
?>
<html>
    <head>
        <style>
            
.body-container {
    display: flex;
    flex-direction: row;
    width: 100%;
    margin-left:5%;
    max-width: 1000px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    overflow: hidden;
    background: white;
    transition: transform 0.3s;
    gap: 20px; /* Added gap between columns */
}

.description {
    flex: 1;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-top:-2%;
}

.description h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
    font-family:'Michroma', sans-serif;
}

.description p {
    font-size: 16px;
    margin-bottom: 20px;
    color: #666;
}

.update-button {
    background-color: #EA60A7;
    color: white;
    width:50%;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
   
}

.update-button:hover {
    background-color: #503141;
}

.picture-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    padding: 40px; /* Added padding to match the description section */
}

.profile-picture {
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}

.profile-picture:hover {
    transform: scale(1.1);
}
.apply-container {
            width: 80%;
            max-width: 1200px;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            margin-left:5%;
        }
.position {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 20px;
            
        }

        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .position-details {
            flex: 1;
        }

        .position-details h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .position-details p {
            margin: 5px 0 10px;
            color: #666;
        }

        .apply-button {
            background-color: #EA60A7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .apply-button:hover {
            background-color: #503141;
        }
         .apply-container {
            width: 80%;
            max-width: 1200px;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .position {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .position:last-child {
            border-bottom: none;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .position-details {
            flex: 1;
        }

        .position-details h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
            text-align:left;
        }

        .position-details p {
            margin: 5px 0 10px;
            color: #666;
        }

        .apply-button {
            background-color: #EA60A7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .apply-button:hover {
            background-color: #503141;
        }

@media (max-width: 768px) {
    .body-container {
        flex-direction: column;
    }

    .description, .picture-container {
        flex: none;
        width: 100%;
        padding: 20px;
    }

    .profile-picture {
        max-width: 100%;
        width: auto;
    }
}
@media (max-width: 768px) {
            .apply-container {
                width: 90%;
            }

            .position-details h3 {
                font-size: 18px;
            }

            .position-details p {
                font-size: 14px;
            }

            .apply-button {
                padding: 10px;
                font-size: 14px;
            }

            .company-logo {
                width: 50px;
                height: 50px;
            }
        }

        @media (max-width: 480px) {
            .apply-container {
                width: 100%;
                padding: 10px;
            }

            .position {
                flex-direction: column;
                align-items: flex-start;
            }

            .company-logo {
                margin-bottom: 10px;
            }

            .apply-button {
                width: 100%;
                padding: 10px 0;
            }
        }
        </style>
    </head>

<?php

include 'dashboard.php';
?>
<div class="form-container">
    <main>
        <h1 style="text-align:center;font-family:'Michroma', sans-serif;">Welcome to Job Seeker Dashboard</h1>
        <hr style="margin: 20px auto;border: 0;height: 1px;width: 50%;background: #EA60A7; ">
        <ul class="box-info">
            <li>
                <i class='bx bxs-group'></i>
                <?php
                include '../connection.php';
                $sql = "SELECT COUNT(job_provider_id) AS total FROM job_provider";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <span class="text">
                    <h3><?php echo $result['total']; ?></h3>
                    <p>All Job Provider</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-group'></i>
                <?php
                include '../connection.php';
                $sql = "SELECT COUNT(job_seeker_id) AS total FROM job_seeker";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <span class="text">
                    <h3><?php echo $result['total']; ?></h3>
                    <p>All Seekers</p>
                </span>
            </li>
        </ul>
    </main>
    <main>
            <div class="body-container">
        <div class="description">
            <h2>Profile Information</h2>
            <p>Welcome to your profile page! Here, you can view and update your personal 
            information. If your profile is not complete, please check the bio section 
            below to add more details and help potential employers learn more about you.</p><br>
            <h3 style="font-family:'Michroma', sans-serif;size:12px">update your bio:</h3>
            <p><br>
                <?php
                include '../connection.php';
                $user_email = $_SESSION['user_email'];

try {
    $sql = "SELECT job_seeker.bio 
            FROM job_seeker
            JOIN users ON job_seeker.users_id = users.users_id
            WHERE users.email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $user_bio = htmlspecialchars($result['bio'], ENT_QUOTES, 'UTF-8');
        echo "<b style='color:#ea60a7'>User Bio:</b> " . $user_bio;
    } else {
        echo "No bio found for this user.";
    }
} catch (PDOException $e) {
    die('Database error: ' . htmlspecialchars($e->getMessage()));
}
?></p>
            <a href="my_profile.php"><button class="update-button">Update My Info</button></a>
        </div>
        <div class="picture-container">
            <img src="sample.png" alt="Profile Picture" class="profile-picture">
        </div>
        
    </div>



    <div class="apply-container">
        <h2 style="font-family:'Michroma', sans-serif; text-align: center;">Open Positions</h2>
        <?php
        $stmt = $pdo->query("SELECT * FROM jobs");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="position">
        <?php
        $folderPath = '../dashboard';
        $logoFilename = $row['logo'];
        $uniqueLogoPath = $folderPath . $logoFilename . '?' . $row['job_id'];
        echo '<td><img class="company-logo" src="' . htmlspecialchars($uniqueLogoPath) . '" alt="Job Logo" style="width: 50px; height: 50px;"></td>';
        ?>
        <div class="position-details">
            <h3><?php echo $row['job_title'] ?></h3>
                <p>
                    <?php echo  $row['job_description']?> | Published on <?php echo  $row['published_date']?> | Deadline <?php echo  $row['deadline_date']?>
                </p>
                <form action="" method="post">
                    <input type="hidden" name="job_id" value="<?php echo $row['job_id']; ?>">
                    <input type="submit" name="apply" value="Apply"  class="apply-button">
                </form>
            </div>
        </div>
        <?php }?>
    </div>

    
</div>

</main>



</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply'])) {
    include '../connection.php';
    $job_id = $_POST['job_id'];

    try {
        $query = $pdo->prepare("SELECT users_id FROM users WHERE email = :email");
        $query->execute(['email' => $user_email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $users_id = $user['users_id'];
            $query = $pdo->prepare("SELECT job_seeker_id FROM job_seeker WHERE users_id = :users_id");
            $query->execute(['users_id' => $users_id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $job_seeker_id = $result['job_seeker_id'];

                // Check if the user has already applied for this job
                $checkQuery = $pdo->prepare("SELECT COUNT(*) FROM applied WHERE job_id = :job_id AND job_seeker_id = :job_seeker_id");
                $checkQuery->execute(['job_id' => $job_id, 'job_seeker_id' => $job_seeker_id]);
                $applicationCount = $checkQuery->fetchColumn();

                if ($applicationCount == 0) {
                    // Insert the application if the user has not applied for this job yet
                    $sql = "INSERT INTO applied (job_id, job_seeker_id) VALUES (:job_id, :job_seeker_id)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
                    $stmt->bindParam(':job_seeker_id', $job_seeker_id, PDO::PARAM_INT);
                    $stmt->execute();
                    echo "Application submitted successfully.";
                } else {
                    echo "You have already applied for this job.";
                }
            } else {
                echo "Job seeker not found.";
                exit();
            }
        } else {
            echo "User not found.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    }
}
?>



