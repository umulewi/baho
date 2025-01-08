<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <input type="email" name="email" placeholder="EMAIL" required><br>
    <input type="text" name="first_name" placeholder="FIRST NAME" required><br>
    <input type="text" name="last_name" placeholder="LAST NAME" required><br>
    <select name="role_name" required>
        <option value="" disabled selected>Register as:</option>
        <option value="job_seeker">Job Seeker</option>
        <option value="job_provider">Job Provider</option>
    </select><br><br>
    Female:<input type="radio" name="gender" value="female" required>Male:<input type="radio" name="gender" value="male" required><br>
    <input type="password" name="password" placeholder="PASSWORD" required><br><br><br>
    <input type="submit" value="Submit">
</form>


    <?php
include 'connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch role_id based on selected role_name
    $role_name = $_POST['role_name'];
    $stmt = $pdo->prepare("SELECT role_id FROM role WHERE role_name = :role_name");
    $stmt->execute(['role_name' => $role_name]);
    $role = $stmt->fetch();
    $role_id = $role['role_id'];

    // Assign gender based on selected radio button
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $full_name = $first_name . ' ' . $last_name; 

    $sql = "INSERT INTO users (role_id, email, first_name, last_name, full_name, gender, password) 
            VALUES (:role_id, :email, :first_name, :last_name, :full_name, :gender, :password)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            'role_id' => $role_id,
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'full_name' => $full_name, 
            'gender' => $gender,
            'password' => $password,
        ]);
        echo "Record inserted successfully.<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
}
?>

</body>
</html>
