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

    $stmt = $pdo->prepare("SELECT id, username, password FROM admin WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $enteredPassword === $admin['password']) {
        $_SESSION['username'] = $admin['username'];
        $_SESSION['admin'] = $admin['id'];
        header("Location: admin.php");
        exit();
    } else {
        $errorMessage = "Password verification failed. Invalid username or password.";
    }
}





if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
		$product_id = $_POST['product_id'];

	   
		$delete_query = "DELETE FROM products WHERE  id = :product_id";
		$stmt = $pdo->prepare($delete_query);
		$stmt->bindParam(':product_id', $product_id);

		if ($stmt->execute()) {
			$_SESSION['message'] = "Product has been Deleted successfully!";
			header("Location: admin.php"); 
			exit();
		} else {
			$_SESSION['message'] = "Failed to Delete";
			header("Location: admin.php"); 
			exit();
		}
	
}






if (isset($_POST['logout'])) {
	$_SESSION = array();

	session_destroy();

	header("Location: index.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CollegeGearTrading</title>
  <link rel="stylesheet" href="style0.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

</head>
<body>
<?php if(isset($errorMessage)) { ?>
        <p><?php echo $errorMessage; ?></p>
<?php } ?>
    <section id="header">
        <a  href="index.php"><img src="img/CGT.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a  class="active" href="admin.php"><?php if (isset($_SESSION['admin'])) { ?> Dashboard <?php } ?> <?php if (!isset($_SESSION['admin'])) { ?> Login <?php } ?></a></li>
                <li><a href = "add.php">Add Product</a></li>
                <li><a  href = "list.php">Lists</a></li>
				<li>
				<?php
				if (isset($_SESSION['admin'])) {
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
	if (!isset($_SESSION['admin'])) {
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
	if (isset($_SESSION['admin'])) {
		$admin = $_SESSION['admin'];
	?>
	<section id="product1" class="section-p1" style = "height:1000px;overflow:auto;">
	<h1>Welcome Admin</h1>
		<div class="pro-container">	
		<?php
		$sql = "SELECT * FROM products";
        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "
            <div class='pro'>
                <img src='" . $row['picture'] . "'>
                <div class='des'>
                    <h5>" . $row['name'] . "</h5>
                    <div class='star'>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                    </div>
                    <h4>" . $row['price'] . "</h4>
                </div>
                <form method='post' action='admin.php'> 
                <button style='width:100%;padding:10px;background:orange;cursor:pointer;' type='submit' name='delete'>
                    Delete <i class='fa fa-trash'></i>
                </button>
                    <input type='hidden' name='product_id' value='" . $row['id'] . "'> 
                </form>
            </div>
           ";
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
