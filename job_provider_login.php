
<?php
 session_start();
  include 'connection.php';

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
        case 'job_provider':
          header("Location: job_provider_login/my_profile.php");
          exit();
      }
    } else {
      echo "<script>alert('Incorrect email or password');</script>";
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
            height: auto;
            height: 85%;
        }

        .login-image {
            flex: 1;
            background: url(img/team11.jpg) no-repeat center center/cover;
        }

        .main{
	width: 480px;
	height: 590px;
	background: red;
	overflow: hidden;
	background: url("img/background.jpg") no-repeat center/ cover;
	border-radius: 10px;
    border-top-left-radius: 2px;
}
#chk{
	display: none;
}
.signup{
	position: relative;
	width:100%;
	height: 100%;
	margin-top: 8%;
}
label{
	color: #fff;
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 60px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}
input{
	width: 60%;
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
button{
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
button:hover{
	background: white;
}
.login{
	height: 990px;
	background: #eee;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
    margin-top:-2rem;
	
}
.login label{
	color: #EA60A7;
	transform: scale(.6);
}

#chk:checked ~ .login{
	transform: translateY(-590px);
}
#chk:checked ~ .login label{
	transform: scale(1);	
}
#chk:checked ~ .signup label{
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
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
	width: 50%;
}

.google-login-btn:hover {
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.btn-signup:hover {
    color:#EA60A7;
}

.google-icon {
    width: 24px;
    height: 24px;
    margin-right: 10px;
}

.btn-text {
    font-weight: bold;
}
.btn-text:hover {
    font-weight: bold;
	color: #EA60A7;
}
@media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 95%;
                height: auto;
                height: 80%;
            }
            .login-image{
                display: none;
            }

            .login-form {
                height: 200px;
                background-size: cover;
                width: 100%;
                align-items: center;
                padding-right: -28%;
            }
            .login-form .main{
                align-items: center;
                padding-right: -58%;
            }
            .signup {
                align-items: center;
                margin-left: -11%;
            }
            
            .login{
                align-items: center;
                margin-left: -20%;
            }
            .login input[type="email"],input[type="password"],input[type="text"] {
                align-items: center;
                width: 60%;
            }
            .signup input[type="email"],input[type="password"],input[type="text"] {
                align-items: center;
                width: 60%;
            }
            #chk{
                align-items: center;
                padding-right: -45%;  
            }
        }

        @media (max-width: 480px) {
            .login-form {
                width: 100%;
            }

            
        }

    </style>
</head>

<body>

    <div class="login-container" class="container-fluid">
        <div class="login-image"></div>
        <div class="login-form">
            <div class="main">  	
                <input type="checkbox" id="chk" aria-hidden="true">
        
                    <div class="signup">
                        <form action="" method="post">
                            <label for="chk" aria-hidden="true">Sign up</label>
                                <input type="text" name="first_name" placeholder="First name" required="">
                                <input type="text" name="last_name" placeholder="Last name" required="">
                                <input type="email" name="email" placeholder="Email" >
                                <input type="password" name="password" placeholder="Password" required="">
                                
                        
                            <button  name ="sign_up"class="btn-signup">Sign up</button>
                        </form>
                    </div>
        
                    <div class="login">
                        <form action="" method="post">
                            <label for="chk" aria-hidden="true">Login</label>
                            <input type="email" name="email" placeholder="Email" required>
                            <input type="password" name="password" placeholder="Password" required>
                            <button name="login" class="btn-signup">Login</button>
                        </form>
                                            
                    </div>
            </div>  
        </div>
    </div>
</body>

</html>




<?php
include 'connection.php';

$message = "";

if (isset($_POST['sign_up'])) {
    error_reporting(E_ALL);
ini_set('display_errors', 1);
    
    $role_id = $_GET['role_id'];
    $stmt = $pdo->prepare("INSERT INTO users (role_id, email, first_name, last_name, password) VALUES (:role_id, :email, :first_name, :last_name,  :password)");
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':first_name', $_POST['first_name']);
    $stmt->bindParam(':last_name', $_POST['last_name']);
    
    $stmt->bindParam(':password', $_POST['password']);
    $stmt->bindParam(':role_id', $role_id);
   
    $stmt->execute();
    $users_id = $pdo->lastInsertId();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("INSERT INTO job_provider (users_id, role_id) VALUES (:users_id, :role_id)");
        $stmt->bindParam(':users_id', $users_id);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();
    }
    $pdo = null;
    $message = "provider form submitted successfully!";
    echo "Message: " . $message;
}
?>



<?php
// require_once 'job_provider_login/config.php';
// if (isset($_SESSION['user_token'])) {
//   header("Location: job_provider_login/welcome.php");
// } else {
//   echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
// }

?>
</body>
</html>
