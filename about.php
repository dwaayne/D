
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>College Gear Trading</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link rel="stylesheet" href="style0.css">
</head>

<body>
    <section id="header">
        <a href="admin.php"><img src="img/CGT.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a  href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="Login.php"><?php if (isset($_SESSION['user_id'])) { ?> Profile <?php } ?> <?php if (!isset($_SESSION['user_id'])) { ?> Login <?php } ?></a></li>
                <li><a class="active" href="#">About</a></li>
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
    <section>
        <h1><a href="contact.html"></a>This Page is made by JollyHotdog Group</a></h1>
    </section>