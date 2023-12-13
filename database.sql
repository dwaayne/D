CREATE DATABASE IF NOT EXISTS `shop`;

USE `shop`;

CREATE TABLE IF NOT EXISTS `products`(
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `picture` VARCHAR(300) NOT NULL,
    `name` VARCHAR(30) NOT NULL,
    `price` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `users`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(30) NOT NULL UNIQUE,
    `password` VARCHAR(30) NOT NULL
);
CREATE TABLE IF NOT EXISTS `cart`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `products_id` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `pay`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `products_id` INT NOT NULL
);

INSERT INTO `products`(`picture`,`name`,`price`)
VALUES
('img/Products/P1.jpg','Acer Aspire 5',17000),
('img/Products/P2.jpg','Iphone',17000),
('img/Products/P3.jpg','Books',500),
('img/Products/P4.jpg','Shoes',300),
('img/Products/P5.jpg','NoteBooks',50),
('img/Products/P6.jpg','Samsung Phone',10000),
('img/Products/P7.jpg','Sapatos',10),
('img/Products/P8.jpg','Laptop spare parts',100),
('img/Products/P9.png','Battery Car',5000),
('img/Products/P10.png','Jell Photo Card',100000);


CREATE TABLE IF NOT EXISTS `admin`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(30) NOT NULL UNIQUE,
    `password` VARCHAR(30) NOT NULL
);

INSERT INTO `admin`(`username`,`password`)
VALUES
('admin','admin123');


ALTER TABLE `cart` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);
ALTER TABLE `cart` ADD FOREIGN KEY (`products_id`) REFERENCES `products`(`id`);

ALTER TABLE `pay` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);
ALTER TABLE `pay` ADD FOREIGN KEY (`products_id`) REFERENCES `products`(`id`);
