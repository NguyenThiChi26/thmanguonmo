-- --------------------------------------------------------
-- Máy chủ:                      127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Phiên bản:           12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for my_store
CREATE DATABASE IF NOT EXISTS `my_store` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `my_store`;

-- Dumping structure for table my_store.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.account: ~4 rows (approximately)
INSERT INTO `account` (`id`, `username`, `fullname`, `password`, `role`) VALUES
	(2, 'chi', 'Nguyễn thị chi', '$2y$10$CWRE/EIjgYs/pEk5gp0H5.2gTSFIOF7cVM7DDYamujzG.DILvqW6.', 'admin'),
	(3, 'chi1', 'Nguyễn Linh Chi', '$2y$10$XwsMphYN0DoJWoIHsGBQ4uurySkqvv6Qu3bkq/s4wBpmxXBfo0zTK', 'admin'),
	(4, 'chi2', 'Nguyễn thị chi', '$2y$10$kKo.rzS7uPb2E.z5FBNvnONP4GzGDnLnC22P2VlVw/1p3yYYdqjdO', 'user'),
	(5, 'chi3', 'Nguyễn thị chi', '$2y$10$SvR1ucisqNTPsJmskZy1nO6R55YZDfgOhTuUycYc8KGkpm1bvY3iC', 'user');

-- Dumping structure for table my_store.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.category: ~5 rows (approximately)
INSERT INTO `category` (`id`, `name`, `description`) VALUES
	(1, 'Vợt cầu lông', 'Các loại vợt thi đấu và luyện tập đến từ các thương hiệu nổi tiếng như Yonex, Lining.'),
	(2, 'Quần áo thể thao', 'Áo và quần thi đấu cầu lông cho nam và nữ.'),
	(3, 'Giày cầu lông', 'Giày thi đấu chuyên dụng giúp di chuyển linh hoạt trên sân.'),
	(4, 'Phụ kiện cầu lông', 'Bao vợt, tất, băng quấn tay, dây cước, v.v.'),
	(5, 'Túi đựng đồ', 'Túi chuyên dụng đựng vợt và phụ kiện cầu lông.');

-- Dumping structure for table my_store.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.orders: ~4 rows (approximately)
INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `created_at`, `email`) VALUES
	(1, 'Nguyễn thị chi', '0334794840', '26', '2025-06-19 17:31:26', 'admin@example.com'),
	(2, 'Nguyễn thị chi', '0334794840', 'Yên Thành', '2025-06-19 17:31:49', 'admin@example.com'),
	(3, 'Nguyễn thị chi', '0334794840', 'Yên Thành', '2025-06-19 17:35:28', 'chichi@gmail.com'),
	(4, 'Nguyễn thị chi', '0334794840', '26', '2025-06-19 17:35:49', 'hihihihihih@gmail.com');

-- Dumping structure for table my_store.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.order_details: ~5 rows (approximately)
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
	(1, 1, 17, 1, 1850000.00),
	(2, 1, 18, 1, 329000.00),
	(3, 2, 17, 4, 1850000.00),
	(4, 3, 18, 1, 329000.00),
	(5, 4, 18, 1, 329000.00);

-- Dumping structure for table my_store.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.product: ~5 rows (approximately)
INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
	(10, 'Váy cầu lông Yonex 01 - Trắng xanh', 'Ngoài những chiếc quần cầu lông thoải mái, tạo cá tính mạnh mẽ thì váy cầu lông cũng là sự lựa chọn của nhiều lông thủ nữ khi lên sân. Váy Cầu Lông Yonex 01 - Trắng xanh với kiểu dáng đơn giản, tinh tế, dịu dàng nhưng không kém phần nổi bật trên sân cầu.', 150000.00, 'uploads/68543dcb2b357.webp', 1),
	(11, 'Balo Cầu Lông Yonex B1408 (GC)', 'Ngoài vợt, trang phục cầu lông, có thể bạn sẽ cần đến những vật dụng cần thiết khi đến phòng tập. Để có thể đựng được nhiều đồ nhưng vẫn đảm bảo hợp thời trang, balo cầu lông sẽ đáp ứng những nhu cầu của bạn. Balo Cầu Lông Yonex B1408 (GC) là mẫu balo thời trang, chất liệu sử dụng của balo là da PU cao cấp, có khả năng chống bám bụi bẩn cao và chống thấm nước.', 750000.00, 'uploads/68543e8c2f312.webp', 5),
	(17, 'Giày cầu lông Victor Doraemon P-DRM A', '- Giày cầu lông Victor Doraemon P-DRM A là một trong những mẫu giày thuộc phân khúc trung cấp phục vụ cho người chơi cầu lông phong trào, nằm trong bộ sưu tập Victor x Doraemon, đánh dấu cho sự hợp tác giữa thương hiệu Victor với bộ phim hoạt hình nổi tiếng đến từ Nhật Bản.', 1850000.00, 'uploads/6854404872e0f.webp', 3),
	(18, 'Áo cầu lông Yonex TPM2736 - Cerise chính hãng', 'Cerise chính hãng', 329000.00, 'uploads/685440852d512.webp', 2),
	(20, 'Váy cầu lông Yonex 01 - Trắng xanh', 'Ngoài những chiếc quần cầu lông thoải mái, tạo cá tính mạnh mẽ thì váy cầu lông cũng là sự lựa chọn của nhiều lông thủ nữ khi lên sân. Váy Cầu Lông Yonex 01 - Trắng xanh với kiểu dáng đơn giản, tinh tế, dịu dàng nhưng không kém phần nổi bật trên sân cầu.', 150000.00, 'uploads/68543dcb2b357.webp', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
