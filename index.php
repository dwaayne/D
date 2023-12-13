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

<body>
    <section id="header">
        <a href="admin.php"><img src="img/CGT.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="Login.php"><?php if (isset($_SESSION['user_id'])) { ?> Profile <?php } ?> <?php if (!isset($_SESSION['user_id'])) { ?> Login <?php } ?></a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contacts.php">Contact</a></li>
                <li><a href="cart.php"><i class="fab fa-opencart"></i></li>
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
    <section id="hero">
        <h4><a href="contact.html"></a>College Gear Trading</a></h4>
        <h2><a href="contact.html"></a>Trade your Gears</a></h2>
        <h1><a href="contact.html"></a>or Sell it!</a></h1>
        <p><a href="contact.html"></a>you dont want it? trade it!</a></p>
        <a href = "shop.php"><button>Start Trading!</button></a>
    </section>
    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="img/boxes/Laptops.jpg" alt="">
            <H6>Laptops</H6>
        </div>
        <div class="fe-box">
            <img src="img/boxes/Phones.jpg" alt="">
            <H6>Phones</H6>
        </div>
        <div class="fe-box">
            <img src="img/boxes/Books.jpg" alt="">
            <H6>Books</H6>
        </div>
        <div class="fe-box">
            <img src="img/boxes/Apparels.jpg" alt="">
            <H6>Apparels</H6>
        </div>
        <div class="fe-box">
            <img src="img/boxes/Pens.jpg" alt="">
            <H6>Pens</H6>
        </div>
        <div class="fe-box">
            <img src="img/boxes/Notebooks.jpg" alt="">
            <H6>Notebooks</H6>
        </div>
    </section>
    <section id="product1" class="section-p1">
    <h2>Top Products</h2>
    <p>Latest products in our shop</p>
    <div class="pro-container">
    <?php
        $sql = "SELECT * FROM products LIMIT 6";
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
                
            </div>
           ";
        }

        
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
        
    </div>
</section>
    <!-- <script src="script.js"></script> -->
</body>
</html>     