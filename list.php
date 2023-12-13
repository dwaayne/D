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


    $sql = "SELECT pay.id AS pay_id, users.id AS user_id, users.username, products.picture, products.name, products.price
    FROM pay
    INNER JOIN users ON pay.user_id = users.id
    INNER JOIN products ON pay.products_id = products.id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);




    










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




        /* Add your CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
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
                <li><a  href = "add.php">Add Product</a></li>
                <li><a class="active" href = "list.php">Lists</a></li>
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
    <h1>List of all Ongoing Transactions</h1>
            <center>
            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Product Picture</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?php echo $transaction['pay_id']; ?></td>
                            <td><?php echo $transaction['user_id']; ?></td>
                            <td><?php echo $transaction['username']; ?></td>
                            <td>
                                <img src="<?php echo $transaction['picture']; ?>" alt="Product Image">
                            </td>
                            <td><?php echo $transaction['name']; ?></td>
                            <td><?php echo $transaction['price']; ?></td>
                        </tr>
                    <?php endforeach; 
                    if (empty($transactions)) {
                        echo "<tr>
                            <td colspan = '6'>Empty</td>
                        </tr>";
                    }
                    
                    ?>
                </tbody>
            </table>
            </center>
        
    
		
	
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
