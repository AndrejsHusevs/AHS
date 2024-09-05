-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 07:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahs`
--

-- --------------------------------------------------------

--
-- Table structure for table `ahs_attributes`
--

CREATE TABLE `ahs_attributes` (
  `attribute_id` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_attributes`
--

INSERT INTO `ahs_attributes` (`attribute_id`, `name`, `type`) VALUES
('Capacity', 'Capacity', 'text'),
('Color', 'Color', 'swatch'),
('Size', 'Size', 'text'),
('Touch ID in keyboard', 'Touch ID in keyboard', 'text'),
('With USB 3 ports', 'With USB 3 ports', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `ahs_attribute_items`
--

CREATE TABLE `ahs_attribute_items` (
  `id` varchar(15) NOT NULL,
  `attribute_id` varchar(25) NOT NULL,
  `displayvalue` varchar(15) NOT NULL,
  `value` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_attribute_items`
--

INSERT INTO `ahs_attribute_items` (`id`, `attribute_id`, `displayvalue`, `value`) VALUES
('1T', 'Capacity', '1T', '1T'),
('256GB', 'Capacity', '256GB', '256GB'),
('40', 'Size', '40', '40'),
('41', 'Size', '41', '41'),
('42', 'Size', '42', '42'),
('43', 'Size', '43', '43'),
('512G', 'Capacity', '512G', '512G'),
('Black', 'Color', 'Black', '#000000'),
('Blue', 'Color', 'Blue', '#030BFF'),
('Cyan', 'Color', 'Cyan', '#03FFF7'),
('Extra Large', 'Size', 'Extra Large', 'XL'),
('Green', 'Color', 'Green', '#44FF03'),
('Large', 'Size', 'Large', 'L'),
('Medium', 'Size', 'Medium', 'M'),
('No', 'Touch ID in keyboard', 'No', 'No'),
('No', 'With USB 3 ports', 'No', 'No'),
('Small', 'Size', 'Small', 'S'),
('White', 'Color', 'White', '#FFFFFF'),
('Yes', 'Touch ID in keyboard', 'Yes', 'Yes'),
('Yes', 'With USB 3 ports', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `ahs_categories`
--

CREATE TABLE `ahs_categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_categories`
--

INSERT INTO `ahs_categories` (`id`, `parent_id`) VALUES
(0, 0),
(1, 0),
(2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ahs_category_names`
--

CREATE TABLE `ahs_category_names` (
  `category_id` int(11) NOT NULL,
  `language_id` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_category_names`
--

INSERT INTO `ahs_category_names` (`category_id`, `language_id`, `name`) VALUES
(0, '0', 'all'),
(1, '0', 'clothes'),
(2, '0', 'tech');

-- --------------------------------------------------------

--
-- Table structure for table `ahs_languages`
--

CREATE TABLE `ahs_languages` (
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_languages`
--

INSERT INTO `ahs_languages` (`name`) VALUES
('english');

-- --------------------------------------------------------

--
-- Table structure for table `ahs_products`
--

CREATE TABLE `ahs_products` (
  `id` varchar(50) NOT NULL,
  `instock` tinyint(1) NOT NULL DEFAULT 0,
  `price_amount` float NOT NULL,
  `price_currency_label` varchar(5) NOT NULL,
  `price_currency_symbol` varchar(3) NOT NULL,
  `brand` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_products`
--

INSERT INTO `ahs_products` (`id`, `instock`, `price_amount`, `price_currency_label`, `price_currency_symbol`, `brand`) VALUES
('apple-airpods-pro', 0, 300.23, 'USD', '$', 'Apple'),
('apple-airtag', 1, 120.57, 'USD', '$', 'Apple'),
('apple-imac-2021', 1, 1688.03, 'USD', '$', 'Apple'),
('apple-iphone-12-pro', 0, 1000.76, 'USD', '$', 'Apple'),
('huarache-x-stussy-le', 1, 144.69, 'USD', '$', 'Nike x Stussy'),
('jacket-canada-goosee', 1, 518.47, 'USD', '$', 'Canada Goose'),
('ps-5', 1, 844.02, 'USD', '$', 'Sony'),
('xbox-series-s', 2, 333.99, 'USD', '$', 'Microsoft');

-- --------------------------------------------------------

--
-- Table structure for table `ahs_products_attribute_items`
--

CREATE TABLE `ahs_products_attribute_items` (
  `product_id` varchar(50) NOT NULL,
  `item_id` varchar(15) NOT NULL,
  `attribute_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ahs_products_attribute_items`
--

INSERT INTO `ahs_products_attribute_items` (`product_id`, `item_id`, `attribute_id`) VALUES
('apple-imac-2021', '256GB', 'Capacity'),
('apple-imac-2021', '512GB', 'Capacity'),
('apple-imac-2021', 'No', 'Touch ID in keyboard'),
('apple-imac-2021', 'No', 'With USB 3 ports'),
('apple-imac-2021', 'Yes', 'Touch ID in keyboard'),
('apple-imac-2021', 'Yes', 'With USB 3 ports'),
('apple-iphone-12-pro', '1T', 'Capacity'),
('apple-iphone-12-pro', '512G', 'Capacity'),
('apple-iphone-12-pro', 'Black', 'Color'),
('apple-iphone-12-pro', 'Blue', 'Color'),
('apple-iphone-12-pro', 'Cyan', 'Color'),
('apple-iphone-12-pro', 'Green', 'Color'),
('apple-iphone-12-pro', 'White', 'Color'),
('huarache-x-stussy-le', '40', 'Size'),
('huarache-x-stussy-le', '41', 'Size'),
('huarache-x-stussy-le', '42', 'Size'),
('huarache-x-stussy-le', '43', 'Size'),
('jacket-canada-goosee', 'Extra Large', 'Size'),
('jacket-canada-goosee', 'Large', 'Size'),
('jacket-canada-goosee', 'Medium', 'Size'),
('jacket-canada-goosee', 'Small', 'Size'),
('ps-5', '1T', 'Capacity'),
('ps-5', '512G', 'Capacity'),
('ps-5', 'Black', 'Color'),
('ps-5', 'Blue', 'Color'),
('ps-5', 'Cyan', 'Color'),
('ps-5', 'Green', 'Color'),
('ps-5', 'White', 'Color'),
('xbox-series-s', '1T', 'Capacity'),
('xbox-series-s', '512G', 'Capacity'),
('xbox-series-s', 'Black', 'Color'),
('xbox-series-s', 'Blue', 'Color'),
('xbox-series-s', 'Cyan', 'Color'),
('xbox-series-s', 'Green', 'Color'),
('xbox-series-s', 'White', 'Color');

-- --------------------------------------------------------

--
-- Table structure for table `ahs_products_category`
--

CREATE TABLE `ahs_products_category` (
  `product_id` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_products_category`
--

INSERT INTO `ahs_products_category` (`product_id`, `category_id`) VALUES
('huarache-x-stussy-le', 1),
('jacket-canada-goosee', 1),
('ps-5', 2),
('xbox-series-s', 2),
('apple-imac-2021', 2),
('apple-iphone-12-pro', 2),
('apple-airpods-pro', 2),
('apple-airtag', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ahs_products_gallery`
--

CREATE TABLE `ahs_products_gallery` (
  `id` int(11) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `link` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_products_gallery`
--

INSERT INTO `ahs_products_gallery` (`id`, `product_id`, `link`) VALUES
(1, 'huarache-x-stussy-l', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087'),
(2, 'huarache-x-stussy-l', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087'),
(3, 'huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087'),
(4, 'huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087'),
(5, 'huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087'),
(6, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016105/product-image/2409L_61.jpg'),
(7, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016107/product-image/2409L_61_a.jpg'),
(8, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016108/product-image/2409L_61_b.jpg'),
(9, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016109/product-image/2409L_61_c.jpg'),
(10, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016110/product-image/2409L_61_d.jpg'),
(11, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058169/product-image/2409L_61_o.png'),
(12, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058159/product-image/2409L_61_p.png'),
(13, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/510VSJ9mWDL._SL1262_.jpg'),
(14, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/610%2B69ZsKCL._SL1500_.jpg'),
(15, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/51iPoFwQT3L._SL1230_.jpg'),
(16, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/61qbqFcvoNL._SL1500_.jpg'),
(17, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/51HCjA3rqYL._SL1230_.jpg'),
(18, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),
(19, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),
(20, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),
(21, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),
(22, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),
(23, 'apple-imac-2021', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/imac-24-blue-selection-hero-202104?wid=904&hei=840&fmt=jpeg&qlt=80&.v=1617492405000'),
(24, 'apple-iphone-12-pro', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-12-pro-family-hero?wid=940&amp;hei=1112&amp;fmt=jpeg&amp;qlt=80&amp;.v=1604021663000'),
(25, 'apple-airpods-pro', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),
(26, 'apple-airtag', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/airtag-double-select-202104?wid=445&hei=370&fmt=jpeg&qlt=95&.v=1617761672000');

-- --------------------------------------------------------

--
-- Table structure for table `ahs_products_name_descriptions`
--

CREATE TABLE `ahs_products_name_descriptions` (
  `product_id` varchar(50) NOT NULL,
  `language_id` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ahs_products_name_descriptions`
--

INSERT INTO `ahs_products_name_descriptions` (`product_id`, `language_id`, `name`, `description`) VALUES
('apple-airpods-pro', '0', 'AirPods Pro', '\\n<h3>Magic like you’ve never heard</h3>\\n<p>AirPods Pro have been designed to deliver Active Noise Cancellation for immersive sound, Transparency mode so you can hear your surroundings, and a customizable fit for all-day comfort. Just like AirPods, AirPods Pro connect magically to your iPhone or Apple Watch. And they’re ready to use right out of the case.\\n\\n<h3>Active Noise Cancellation</h3>\\n<p>Incredibly light noise-cancelling headphones, AirPods Pro block out your environment so you can focus on what you’re listening to. AirPods Pro use two microphones, an outward-facing microphone and an inward-facing microphone, to create superior noise cancellation. By continuously adapting to the geometry of your ear and the fit of the ear tips, Active Noise Cancellation silences the world to keep you fully tuned in to your music, podcasts, and calls.\\n\\n<h3>Transparency mode</h3>\\n<p>Switch to Transparency mode and AirPods Pro let the outside sound in, allowing you to hear and connect to your surroundings. Outward- and inward-facing microphones enable AirPods Pro to undo the sound-isolating effect of the silicone tips so things sound and feel natural, like when you’re talking to people around you.</p>\\n\\n<h3>All-new design</h3>\\n<p>AirPods Pro offer a more customizable fit with three sizes of flexible silicone tips to choose from. With an internal taper, they conform to the shape of your ear, securing your AirPods Pro in place and creating an exceptional seal for superior noise cancellation.</p>\\n\\n<h3>Amazing audio quality</h3>\\n<p>A custom-built high-excursion, low-distortion driver delivers powerful bass. A superefficient high dynamic range amplifier produces pure, incredibly clear sound while also extending battery life. And Adaptive EQ automatically tunes music to suit the shape of your ear for a rich, consistent listening experience.</p>\\n\\n<h3>Even more magical</h3>\\n<p>The Apple-designed H1 chip delivers incredibly low audio latency. A force sensor on the stem makes it easy to control music and calls and switch between Active Noise Cancellation and Transparency mode. Announce Messages with Siri gives you the option to have Siri read your messages through your AirPods. And with Audio Sharing, you and a friend can share the same audio stream on two sets of AirPods — so you can play a game, watch a movie, or listen to a song together.</p>\\n'),
('apple-airtag', '0', 'AirTag', '\\n<h1>Lose your knack for losing things.</h1>\\n<p>AirTag is an easy way to keep track of your stuff. Attach one to your keys, slip another one in your backpack. And just like that, they’re on your radar in the Find My app. AirTag has your back.</p>\\n'),
('apple-imac-2021', '0', 'iMac 2021', 'The new iMac!'),
('apple-iphone-12-pro', '0', 'iPhone 12 Pro', 'This is iPhone 12. Nothing else to say.'),
('huarache-x-stussy-le', '0', 'Nike Air Huarache Le', '<p>Great sneakers for everyday use!</p>'),
('jacket-canada-goosee', '0', 'Jacket', '<p>Awesome winter jacket</p>'),
('ps-5', '0', 'PlayStation 5', '<p>A good gaming console. Plays games of PS4! Enjoy if you can buy it mwahahahaha</p>'),
('xbox-series-s', '0', 'Xbox Series S 512GB', '\\n<div>\\n    <ul>\\n        <li><span>Hardware-beschleunigtes Raytracing macht dein Spiel noch realistischer</span></li>\\n        <li><span>Spiele Games mit bis zu 120 Bilder pro Sekunde</span></li>\\n        <li><span>Minimiere Ladezeiten mit einer speziell entwickelten 512GB NVMe SSD und wechsle mit Quick Resume nahtlos zwischen mehreren Spielen.</span></li>\\n        <li><span>Xbox Smart Delivery stellt sicher, dass du die beste Version deines Spiels spielst, egal, auf welcher Konsole du spielst</span></li>\\n        <li><span>Spiele deine Xbox One-Spiele auf deiner Xbox Series S weiter. Deine Fortschritte, Erfolge und Freundesliste werden automatisch auf das neue System übertragen.</span></li>\\n        <li><span>Erwecke deine Spiele und Filme mit innovativem 3D Raumklang zum Leben</span></li>\\n        <li><span>Der brandneue Xbox Wireless Controller zeichnet sich durch höchste Präzision, eine neue Share-Taste und verbesserte Ergonomie aus</span></li>\\n        <li><span>Ultra-niedrige Latenz verbessert die Reaktionszeit von Controller zum Fernseher</span></li>\\n        <li><span>Verwende dein Xbox One-Gaming-Zubehör -einschließlich Controller, Headsets und mehr</span></li>\\n        <li><span>Erweitere deinen Speicher mit der Seagate 1 TB-Erweiterungskarte für Xbox Series X (separat erhältlich) und streame 4K-Videos von Disney+, Netflix, Amazon, Microsoft Movies &amp; TV und mehr</span></li>\\n    </ul>\\n</div>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ahs_attributes`
--
ALTER TABLE `ahs_attributes`
  ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `ahs_attribute_items`
--
ALTER TABLE `ahs_attribute_items`
  ADD PRIMARY KEY (`id`,`attribute_id`);

--
-- Indexes for table `ahs_categories`
--
ALTER TABLE `ahs_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahs_languages`
--
ALTER TABLE `ahs_languages`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `ahs_products`
--
ALTER TABLE `ahs_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahs_products_attribute_items`
--
ALTER TABLE `ahs_products_attribute_items`
  ADD PRIMARY KEY (`product_id`,`item_id`,`attribute_id`);

--
-- Indexes for table `ahs_products_gallery`
--
ALTER TABLE `ahs_products_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahs_products_name_descriptions`
--
ALTER TABLE `ahs_products_name_descriptions`
  ADD PRIMARY KEY (`product_id`,`language_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ahs_categories`
--
ALTER TABLE `ahs_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ahs_products_gallery`
--
ALTER TABLE `ahs_products_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
