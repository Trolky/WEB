-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 06. led 2025, 02:33
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `mydb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `category`
--

INSERT INTO `category` (`category_id`, `genre_name`) VALUES
(1, 'FPS'),
(2, 'adventure'),
(3, 'RPG'),
(4, 'MMO'),
(5, 'MMO RPG'),
(6, 'strategy'),
(7, 'survival');

-- --------------------------------------------------------

--
-- Struktura tabulky `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(75) NOT NULL,
  `ROLES_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `customer`
--

INSERT INTO `customer` (`customer_id`, `login`, `name`, `surname`, `email`, `phone_number`, `password`, `address`, `ROLES_role_id`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@c.cz', 666666666, '$2y$10$Y7id28jX25Q0WW1nC/umo.Sbweqghab7Q6MGkgNbxAKY8yBDN.DnW', 'asd', 3),
(2, 'seller', 'seller', 'seller', 'seller@c.cz', 555555555, '$2y$10$ewkd.2pU8E3OW/tOmLrWpu7uf5TvVQSdIT.lNi9aqSNQ.v.hjCenO', 'asd', 2),
(3, 'customer', 'customer', 'customer', 'customer@c.cz', 444444444, '$2y$10$s4ZPqu85DraxSqSCPWTTJ.lwfx6gKd1D.IDqTd2jK.ETHG1uM.F1.', 'customer', 1),
(4, 'superadmin', 'superadmin', 'superadmin1', 'superadmin@c.cz', 777777777, '$2y$10$lnMi28bhpEz5sMxJVkFBKOPD2ISI72hx4G5mcRgTXGX34HAD7JomW', 'superadmin', 4);

-- --------------------------------------------------------

--
-- Struktura tabulky `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_price` int(11) NOT NULL,
  `CUSTOMER_customer_id` int(11) NOT NULL,
  `SHIPMENT_shipment_id` int(11) DEFAULT NULL,
  `PAYMENT_payment_id` int(11) DEFAULT NULL,
  `ORDER_STATUS_order_status_id` int(11) NOT NULL,
  `PRODUCT_product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `order_status`
--

CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `order_status`
--

INSERT INTO `order_status` (`order_status_id`, `status_name`) VALUES
(1, 'in_cart'),
(2, 'finished');

-- --------------------------------------------------------

--
-- Struktura tabulky `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` mediumtext NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `CATEGORY_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `product`
--

INSERT INTO `product` (`product_id`, `name`, `description`, `price`, `stock`, `CATEGORY_category_id`) VALUES
(1, 'ARK Survival Ascended', 'Multiplayer survival game, your job is to survive in era where dinosaurs lived', 200, 17, 5),
(4, 'CS:GO', 'FPS GAME OF THE YEAR', 300, 30, 1),
(6, 'WoW', 'GOOD GAME', 500, 300, 5),
(7, 'PUBG', 'Battlegound', 200, 18, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'user'),
(2, 'seller'),
(3, 'admin'),
(4, 'superadmin');

-- --------------------------------------------------------

--
-- Struktura tabulky `shipment`
--

CREATE TABLE `shipment` (
  `shipment_id` int(11) NOT NULL,
  `shipment_date` datetime NOT NULL,
  `adress` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zip_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexy pro tabulku `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `fk_CUSTOMER_ROLES1_idx` (`ROLES_role_id`);

--
-- Indexy pro tabulku `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_ORDER_CUSTOMER_idx` (`CUSTOMER_customer_id`),
  ADD KEY `fk_ORDER_SHIPMENT1_idx` (`SHIPMENT_shipment_id`),
  ADD KEY `fk_ORDER_PAYMENT1_idx` (`PAYMENT_payment_id`),
  ADD KEY `fk_ORDER_ORDER_STATUS1_idx` (`ORDER_STATUS_order_status_id`),
  ADD KEY `fk_ORDER_PRODUCT_idx` (`PRODUCT_product_id`);

--
-- Indexy pro tabulku `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indexy pro tabulku `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexy pro tabulku `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_PRODUCT_CATEGORY1_idx` (`CATEGORY_category_id`);

--
-- Indexy pro tabulku `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexy pro tabulku `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`shipment_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pro tabulku `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pro tabulku `order_status`
--
ALTER TABLE `order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pro tabulku `shipment`
--
ALTER TABLE `shipment`
  MODIFY `shipment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_CUSTOMER_ROLES1` FOREIGN KEY (`ROLES_role_id`) REFERENCES `roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_ORDER_CUSTOMER` FOREIGN KEY (`CUSTOMER_customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ORDER_ORDER_STATUS1` FOREIGN KEY (`ORDER_STATUS_order_status_id`) REFERENCES `order_status` (`order_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ORDER_PAYMENT1` FOREIGN KEY (`PAYMENT_payment_id`) REFERENCES `payment` (`payment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ORDER_PRODUCT` FOREIGN KEY (`PRODUCT_product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ORDER_SHIPMENT1` FOREIGN KEY (`SHIPMENT_shipment_id`) REFERENCES `shipment` (`shipment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_PRODUCT_CATEGORY1` FOREIGN KEY (`CATEGORY_category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
