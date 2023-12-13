<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "shop";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $errorMessage = "Passwords do not match. Please try again.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        try {
            $stmt->execute();
            $_SESSION['message'] = "Registered successfully!";
            header("Location:Login.php");
        } catch (PDOException $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CollegeGearTrading</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>
<?php if(isset($errorMessage)) { ?>
        <p><?php echo $errorMessage; ?></p>
<?php } ?>
    <section id="header">
        <a href href="#"><img src="img/CGT.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a  class="active" href="Login.html">Login</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contacts.php">Contact</a></li>
                <li><a href="cart.php"><i class="fab fa-opencart"></i></li>
            </ul>
        </div>
    </section>
<div class="box-form">
	<div class="left">
		<div class="overlay">
      <a href href="#"><img src="img/S2.jpg" class="Pic" alt=""></a>
		</div>
	</div>
	
	
		<div class="right">
		<h2>Register</h2>
		<p><a href="Login.php">Already Have?</a></p>
    <div>
    <div>
	<form method = "post">
		<div class="inputs">
			<input type="text" name="username" placeholder="Username" required>
			<br>
			<input type="password" name="password" placeholder="Password" required>
            <br>
            <input type="password" name="confirm_password" placeholder="Confirm Password">
		</div>
			
			<br><br>
			
		<div class="remember-me--forget-password">

      		<p><a href="index.php">Browse without an account</a></p>
		</div>
			
		<br>
		<button style = "cursor:pointer;" type = "submit">Submit</button>
	</form>
	</div>
	</div>
	
</div>
</body>
</html>
