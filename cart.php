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




    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy'])) {
        if (isset($_SESSION['user_id'])) {
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['user_id'];
            $cart_id = $_POST['cart_id'];
            // cart_id
            $insert_query = "INSERT INTO pay(user_id, products_id) VALUES (:user_id, :product_id)";
            $stmt = $pdo->prepare($insert_query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':product_id', $product_id);

            if ($stmt->execute()) {
                $delete_query = "DELETE FROM cart WHERE user_id = :user_id AND id = :cart_id";
		        $stmtDEL = $pdo->prepare($delete_query);
		        $stmtDEL->bindParam(':user_id', $user_id);
		        $stmtDEL->bindParam(':cart_id', $cart_id);
                $stmtDEL->execute();
                $_SESSION['message'] = "Product added to Buy successfully!";
                header("Location: cart.php"); 
                exit();
            } else {
                $_SESSION['message'] = "Failed to add product to Buy";
                header("Location: cart.php"); 
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
  <link rel="stylesheet" href="style3.css">
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
                <li><a href="Login.php"><?php if (isset($_SESSION['user_id'])) { ?> Profile <?php } ?> <?php if (!isset($_SESSION['user_id'])) { ?> Login <?php } ?></a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a class = "active" href="cart.php"><i class="fab fa-opencart"></i></a></li>
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
		<h1>You need to Login First click <a href = "Login.php">Here.</a></h1>
	</div>	
	<?php
	}
	if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
	?>
	<section id="product1" class="section-p1" style = "height:1000px;overflow:auto;">
	<h1>Cart Lists</h1>
		<div class="pro-container">
		<?php











$sql = "SELECT cart.id AS cart_id, products.id AS product_id, products.picture, products.name, products.price
FROM cart
INNER JOIN products ON cart.products_id = products.id
WHERE cart.user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($cart_items) {
foreach ($cart_items as $item) {
echo "
<div class='pro'>
    <img src='" .  $item['picture'] . "'>
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
    <form method='post' action='cart.php'> 
        <button style='width:100%;padding:10px;background:orange;cursor:pointer;' type='submit' name='buy'>
            Buy
        </button>
        <input type='hidden' name='cart_id' value='" . $item['cart_id'] . "'>
        <input type='hidden' name='product_id' value='" . $item['product_id'] . "'> 
    </form>
</div>
";
}
} else {
echo "<p>No items in the cart.</p>";
}
		?>

		</div>
	
	</section>
	
	







	<?php
	}



} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
	?>


	








	
	
</div>
</body>
</html>
