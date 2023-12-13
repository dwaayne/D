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




    if (isset($_POST['add'])) {
    
        $productName = $_POST['product_name'];
        $productPrice = $_POST['product_price'];
        $productPicture = $_FILES['product_picture']['name'];
    
  
        $targetDirectory = 'img/Products/'; 
        $targetFile = $targetDirectory . basename($_FILES['product_picture']['name']);
    
        if (move_uploaded_file($_FILES['product_picture']['tmp_name'], $targetFile)) {
           
            $insert_query = "INSERT INTO products (picture, name, price) VALUES (:targetFile, :name, :price)";
            $stmt = $pdo->prepare($insert_query);
            $stmt->bindParam(':targetFile', $targetFile); 
            $stmt->bindParam(':name', $productName);
            $stmt->bindParam(':price', $productPrice);
        
            if ($stmt->execute()) {
                $_SESSION['message'] = "Product added successfully!";
                header("Location: add.php");
                exit();
            } else {
                $_SESSION['message'] = "Failed to add product.";
                header("Location: add.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Failed to upload the file.";
            header("Location: add.php");
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
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <style>
.form {
    margin: auto;
    background:grey;
    padding:20px;
    width:50%;
}

.form-input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; 
}


.form-input:focus {
    outline: none;
    border-color: #007bff; 
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

    </style>

</head>
<body>
<?php if(isset($errorMessage)) { ?>
        <p><?php echo $errorMessage; ?></p>
<?php } ?>
    <section id="header">
        <a  href="index.php"><img src="img/CGT.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a   href="admin.php"><?php if (isset($_SESSION['admin'])) { ?> Dashboard <?php } ?> <?php if (!isset($_SESSION['user_id'])) { ?> Login <?php } ?></a></li>
                <li><a class="active" href = "add.php">Add Product</a></li>
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
		<h1>You need to Login First click <a href = "admin.php">Here.</a></h1>
	</div>	
		
	<?php
	}
	if (isset($_SESSION['admin'])) {
		$admin = $_SESSION['admin'];
	?>
	<section id="product1" class="section-p1" style = "height:1000px;width:100%;overflow:auto;">
	<h1>Add Products</h1>
                <form class="form" method="post" enctype="multipart/form-data">
                    <h4 style="color: black">Insert Picture</h4>
                    <input type="file" name="product_picture" class="form-input" required>
                    <br>
                    <h4 style="color: black">Product Name</h4>
                    <input type="text" name="product_name" class="form-input" required>
                    <br>
                    <h4 style="color: black">Product Price</h4>
                    <input type="number" name="product_price" class="form-input" required>
                    <br>
                    <button style='width:100%;padding:10px;background:orange;cursor:pointer;' type='submit' name='add'>
                        ADD
                    </button>
                </form>
    </form>
		
	
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
