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
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
        if (isset($_SESSION['user_id'])) {
            $product_id = $_POST['product_id'];
            $user_id = $_SESSION['user_id'];

            // Insert the selected product into the cart table
            $insert_query = "INSERT INTO cart (user_id, products_id) VALUES (:user_id, :product_id)";
            $stmt = $pdo->prepare($insert_query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':product_id', $product_id);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Product added to cart successfully!";
                header("Location: shop.php"); // Redirect to the shop page or any desired location
                exit();
            } else {
                $_SESSION['message'] = "Failed to add product to cart";
                header("Location: shop.php"); // Redirect with an error message
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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>College Gear Trading</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link rel="stylesheet" href="style.css">
</head>
<section id="header">
    <a href href="#"><img src="img/CGT.png" class="logo" alt=""></a>

    <div>
        <ul id="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a class="active" href="shop.php">Shop</a></li>
            <li><a href="Login.php"><?php if (isset($_SESSION['user_id'])) { ?> Profile <?php } ?> <?php if (!isset($_SESSION['user_id'])) { ?> Login <?php } ?></a></li>
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
<section id="product1" class="section-p1">
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
                <form method='post' action='shop.php'> 
                <button style='width:100%;padding:10px;background:orange;cursor:pointer;' type='submit' name='add_to_cart'>
                    Add to Cart <i class='fab fa-opencart'></i>
                </button>
                    <input type='hidden' name='product_id' value='" . $row['id'] . "'> 
                </form>
            </div>
           ";
        }

        
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>




    </div>
</section>

</body>
</html>