<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
}

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "shop";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $enteredPassword = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $enteredPassword === $user['password']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        header("Location: Login.php");
        exit();
    } else {
        $errorMessage = "Password verification failed. Invalid username or password.";
    }
}





if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
	if (isset($_SESSION['user_id'])) {
		$product_id = $_POST['product_id'];
		$user_id = $_SESSION['user_id'];

	   
		$delete_query = "DELETE FROM pay WHERE user_id = :user_id AND id = :product_id";
		$stmt = $pdo->prepare($delete_query);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':product_id', $product_id);

		if ($stmt->execute()) {
			$_SESSION['message'] = "Product has been canceled successfully!";
			header("Location: Login.php"); 
			exit();
		} else {
			$_SESSION['message'] = "Failed to cancel";
			header("Location: Login.php"); 
			exit();
		}
	} else {
		$_SESSION['message'] = "You need to Login First!";
		header("Location: Login.php");
		exit();
	}
}






if (isset($_POST['logout'])) {
	$_SESSION = array();

	session_destroy();

	header("Location: login.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CollegeGearTrading</title>
  <link rel="stylesheet" href="style2.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

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
                <li><a  class="active" href="Login.html"><?php if (isset($_SESSION['user_id'])) { ?> Profile <?php } ?> <?php if (!isset($_SESSION['user_id'])) { ?> Login <?php } ?></a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contacts.php">Contact</a></li>
                <li><a href="cart.php"><i class="fab fa-opencart"></i></a></li>
				<li>
				<?php
				if (isset($_SESSION['user_id'])) {
					?>
				
				<form action="" method="post">
    			    <input  style = "background:orange;color:black;padding:5px;cursor:pointer;border:solid 2px grey;border-radius:20px;" type="submit" name="logout" value="Logout">
    			</form>
				<?php
					}
				?>
				</li>
            </ul>
        </div>
    </section>
	<div class="box-form">
	<?php
	if (!isset($_SESSION['user_id'])) {
		?>
	<div class="left">
	<div class="overlay">
      <a href href="#"><img src="img/S2.jpg" class="Pic" alt=""></a>
		</div>
	</div>
	
	
		<div class="right">
		<h2>Login</h2>
		<p><a href="register.php">Create Your Account</a></p>
    <div>
    <div>
	<form method = "post">
		<div class="inputs">
			<input type="text" name="username" placeholder="Username" required>
			<br>
			<input type="password" name="password" placeholder="Password" required>
		</div>
			
			<br><br>
			
		<div class="remember-me--forget-password">

      		<p><a href="index.php">Browse without an account</a></p>
		</div>
			
		<br>
		<button style = "cursor:pointer;" type = "submit">Login</button>
	</form>
	</div>
	</div>	
	<?php
	}
	if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	?>
	<section id="product1" class="section-p1" style = "height:1000px;overflow:auto;">
	<h1>Product List You Buy That Need to Pay</h1>
		<div class="pro-container">	
		<?php
		$sql = "SELECT pay.id,products.picture, products.name, products.price
		FROM pay
		INNER JOIN products ON pay.products_id = products.id
		WHERE pay.user_id = :user_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();
	$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($cart_items) {
		foreach ($cart_items as $item) {
		echo "
		<div class='pro'>
			<img   src='" .  $item['picture'] . "'>
			<div class='des'>
				<h5>" . $item['name'] . "</h5>
				<div class='star'>
					<i class='fas fa-star'></i>
					<i class='fas fa-star'></i>
					<i class='fas fa-star'></i>
					<i class='fas fa-star'></i>
					<i class='fas fa-star'></i>
				</div>
				<h4>" .  $item['price'] . "</h4>
			</div>
			<form method='post' action='Login.php'> 
			<button style='width:100%;padding:10px;background:orange;cursor:pointer;' type='submit' name='cancel'>
				Cancel
			</button>
				<input type='hidden' name='product_id' value='" . $item['id'] . "'> 
			</form>
		</div>
	   ";
	}
	} else {
		echo "<p>No items that need to pay.</p>";
	}
        }
		?>

		</div>
	
	</section>
	
	







	<?php
	



} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
	?>


	








	
	
</div>
</body>
</html>
