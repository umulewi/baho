<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
include 'connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// function sendVerificationEmail($email, $verification_code) {
//     $verification_link = "http://localhost/baho/job_seeker_login.php?code=$verification_code";
//     $subject = "Email Verification";
//     $message = "Please click the following link to verify your email: $verification_link";

//     $mail = new PHPMailer(true);
//     try {
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com';
//         $mail->SMTPAuth = true;
//         $mail->Username = 'ntegerejimanalewis@gmail.com'; // your email
//         $mail->Password = 'zwhcmifrjmnlnziz'; // your email password
//         $mail->SMTPSecure = 'tls';
//         $mail->Port = 587;
//         $mail->setFrom('your_email@gmail.com', 'Your Name'); // your email and name
//         $mail->addAddress($email);
//         $mail->isHTML(false);
//         $mail->Subject = $subject;
//         $mail->Body = $message;
//         $mail->send();
//         echo "<script>alert('Verification email sent successfully');</script>";
//     } catch (Exception $e) {
//         echo "Email sending failed. Error: {$mail->ErrorInfo}";
//     }
// }

if (isset($_POST['user_signup'])) {
    $role_id = $_GET['role_id'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];
    $verification_code = md5(uniqid(rand(), true));

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<script>alert('This email has an account. Please login or use a different email.');</script>";
    } else {
        // Insert user details into the database
        $stmt = $pdo->prepare("INSERT INTO users (role_id, email, first_name, last_name, password) VALUES (:role_id, :email, :first_name, :last_name, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();
        $users_id = $pdo->lastInsertId();

        // Insert into job_seeker table
        $stmt = $pdo->prepare("INSERT INTO job_seeker (users_id, role_id,telephone) VALUES (:users_id, :role_id,:telephone)");
        $stmt->bindParam(':users_id', $users_id);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->execute();

        // Send verification email
        echo "<script>alert('Account created! now you can login');</script>";
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $statement = $pdo->prepare("SELECT users.*, role.role_name FROM users INNER JOIN role ON users.role_id = role.role_id WHERE email=:email AND password=:password");
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $password);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if ($user) {
        $_SESSION['user_email'] = $email;
        $role_name = $user['role_name'];
        switch ($role_name) {
            case 'job_seeker':
                header("Location: job_seeker_login/index.php");
                exit();
            default:   
                echo "<script>
                    alert('You have registered as a Worker, but you are accessing the wrong side');
                    window.location.href = window.location.href; 
                    </script>";
                exit();
        }
    } else {
        echo "<script>
                alert('Incorrect email or password');
                window.location.href = window.location.href; 
                </script>";
    }
    

}

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_code = :verification_code");
    $stmt->bindParam(':verification_code', $verification_code);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET verifiedEmail = 1 WHERE verification_code = :verification_code");
        $stmt->bindParam(':verification_code', $verification_code);
        $stmt->execute();
        
    } else {
        echo "<script>alert('Invalid verification code');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(img/main.jpg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            display: flex;
            flex-direction: row;
            width: 90%;
            max-width: 900px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            height: 85%;
        }

        .login-image {
            flex: 1;
            background: url(img/team11.jpg) no-repeat center center/cover;
        }

        .main {
            width: 480px;
            height: 590px;
            background: red;
            overflow: hidden;
            background: url("img/background.jpg") no-repeat center/cover;
            border-radius: 10px;
            border-top-left-radius: 2px;
        }

        #chk {
            display: none;
        }

        .signup {
            position: relative;
            width: 100%;
            height: 100%;
            margin-top: 02%;
        }

        label {
            color: #fff;
            font-size: 2.3em;
            justify-content: center;
            display: flex;
            margin: 60px;
            font-weight: bold;
            cursor: pointer;
            transition: .5s ease-in-out;
        }

        input {
            width: 80%;
            height: 20px;
            background: #e0dede;
            justify-content: center;
            display: flex;
            margin: 30px auto;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 5px;
            margin-top: -4%;
        }

        button {
            width: 30%;
            height: 40px;
            margin: 10px auto;
            justify-content: center;
            display: block;
            color: #fff;
            background: #EA60A7;
            font-size: 1em;
            font-weight: bold;
            margin-top: 20px;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: .2s ease-in;
            cursor: pointer;
        }

        button:hover {
            background: white;
        }

        .login {
            height: 990px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-180px);
            transition: .8s ease-in-out;
            margin-top: 1rem;
        }

        .login label {
            color: #EA60A7;
            transform: scale(.6);
        }

        #chk:checked~.login {
            transform: translateY(-590px);
        }

        #chk:checked~.login label {
            transform: scale(1);
        }

        #chk:checked~.signup label {
            transform: scale(.6);
        }

        .google-login-btn {
            display: flex;
            align-items: center;
            background-color: #bdbfc2;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            font-family: 'Arial', sans-serif;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            width: 50%;
            justify-content: center;
            margin: 10px auto;
        }

        .google-login-btn:hover {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-signup:hover {
            color: #EA60A7;
        }

        .google-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }

        .btn-text {
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .btn-text:hover {
            font-weight: bold;
            color: #EA60A7;
        }

        @media (max-width: 768px) {
            .login {
            height: 990px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-180px);
            transition: .8s ease-in-out;
            margin-top: 5rem;
        }
        .google-login-btn {
            display: flex;
            align-items: center;
            background-color: #bdbfc2;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 12px;
            font-family: 'Arial', sans-serif;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            width: 50%;
            justify-content: center;
            margin: 10px auto;
        }
        

            
        }

        
          
        

    </style>
</head>

<body>

<html>
  <head>
    <title>reCAPTCHA demo: Simple page</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <form action="?" method="POST">
      <div class="g-recaptcha" data-sitekey="your_site_key"></div>
      <br/>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>

    <div class="login-container">
        <div class="login-image"></div>
        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">
            <div class="signup" style="margin-top:-2rem">
                
                <form method="POST" action="">
                    
                    <label for="chk" aria-hidden="true" class="btn-signup">Sign up</label>
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="number" name="telephone" placeholder="Telephone" required="">
                    <input type="text" name="first_name" placeholder="First Name" required="">
                    <input type="text" name="last_name" placeholder="Last Name" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button type="submit" name="user_signup">Sign Up</button>
                    <button class="google-login-btn" name="google-login-btn">
                        <img src="img/google.png" alt="Google Icon" class="google-icon">
                        <?php
                            require_once 'job_seeker_login/config.php';
                            if (isset($_SESSION['user_token'])) {
                                header("Location: job_seeker_login/index.php");
                            } else {
                                echo "<a href='" . $client->createAuthUrl() . "' class='btn-text'>Sign Up with Google</a>";
                            }
                        ?>
                    </button>
                </form>
            </div>
            <div class="login">
                <form method="POST" action="">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button type="submit" name="login">Login</button>
                    <button class="google-login-btn" name="google-login-btn">
                        <img src="img/google.png" alt="Google Icon" class="google-icon">
                        <?php
                            require_once 'job_seeker_login/config.php';
                            if (isset($_SESSION['user_token'])) {
                                header("Location: job_seeker_login/index.php");
                            } else {
                                echo "<a href='" . $client->createAuthUrl() . "' class='btn-text'>Sign Up with Google</a>";
                            }
                        ?>

                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
