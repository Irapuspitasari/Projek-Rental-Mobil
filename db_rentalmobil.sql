/*
 Navicat Premium Data Transfer

 Source Server         : MySql
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : rental_db

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 22/06/2025 21:32:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bookings
-- ----------------------------
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `city` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `start_date` datetime NULL DEFAULT NULL,
  `end_date` datetime NULL DEFAULT NULL,
  `duration_days` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `region` enum('Jateng','DIY','Luar Provinsi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_option` enum('With Driver','Without Driver') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Confirmed','On Rent','Completed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `base_price` decimal(12, 2) NOT NULL,
  `driver_fee` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `out_of_region_fee` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `overtime_fee` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(12, 2) NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `actual_end_date` datetime NULL DEFAULT NULL,
  `is_overtime` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `bookings_slug_unique`(`slug` ASC) USING BTREE,
  INDEX `bookings_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `bookings_item_id_foreign`(`item_id` ASC) USING BTREE,
  CONSTRAINT `bookings_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bookings
-- ----------------------------
INSERT INTO `bookings` VALUES (1, 'nn6kwwgfow8rq3t6oxsh', 'Umam', 'Ngablak', 'Pati', '59157', '2025-06-23 00:00:00', '2025-06-25 23:30:00', 3, 1, 1, 'Jateng', 'Without Driver', 'Pending', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 0, '2025-06-22 20:31:14', '2025-06-22 20:31:14');
INSERT INTO `bookings` VALUES (2, 'ipwncbyp1wnmbrgmqujw', 'Umam', 'ngablak', 'Pati', '59157', '2025-06-22 20:34:00', '2025-06-25 20:35:00', 4, 1, 5, 'DIY', 'With Driver', 'Pending', 0.00, 0.00, 100000.00, 0.00, 100000.00, NULL, NULL, 0, '2025-06-22 20:35:25', '2025-06-22 20:35:25');
INSERT INTO `bookings` VALUES (3, '2gzsufgsvkufutzlueup', 'Umam', 'Ngablak', 'Pati', '59157', '2025-06-22 20:45:00', '2025-06-24 20:49:00', 3, 1, 12, 'Luar Provinsi', 'With Driver', 'Pending', 0.00, 0.00, 100000.00, 0.00, 100000.00, NULL, NULL, 0, '2025-06-22 20:46:16', '2025-06-22 20:46:16');
INSERT INTO `bookings` VALUES (4, '01zu0q8jjeb7uufddv5j', 'Umam', 'hss', 'Pati', '59157', '2025-06-22 21:27:00', '2025-06-23 21:27:00', 1, 1, 1, 'Jateng', 'With Driver', 'Pending', 500000.00, 200000.00, 0.00, 0.00, 700000.00, NULL, NULL, 0, '2025-06-22 21:27:51', '2025-06-22 21:27:51');
INSERT INTO `bookings` VALUES (5, 'e4z4sdft4p6afclwrvdo', 'hehe', 'hehe', 'Pati', '59157', '2025-06-22 21:29:00', '2025-06-24 21:30:00', 2, 1, 1, 'Luar Provinsi', 'With Driver', 'Pending', 1000000.00, 500000.00, 100000.00, 0.00, 1600000.00, NULL, NULL, 0, '2025-06-22 21:30:24', '2025-06-22 21:30:24');

-- ----------------------------
-- Table structure for brands
-- ----------------------------
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `brands_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of brands
-- ----------------------------
INSERT INTO `brands` VALUES (5, 'Porsche', 'porsche-x3vtu', '2025-06-21 23:03:47', '2025-06-22 14:05:34');
INSERT INTO `brands` VALUES (6, 'BMW', 'bmw-b20vk', '2025-06-22 10:01:12', '2025-06-22 14:05:40');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `photos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `price` int NOT NULL DEFAULT 0,
  `star` double NOT NULL DEFAULT 0,
  `review` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `items_slug_unique`(`slug` ASC) USING BTREE,
  INDEX `items_type_id_foreign`(`type_id` ASC) USING BTREE,
  INDEX `items_brand_id_foreign`(`brand_id` ASC) USING BTREE,
  CONSTRAINT `items_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `items_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES (1, 'Linus Wheeler', 'linus-wheeler-hvzxo', 1, 5, '[\"item-photos\\/Pu8W8YC4iicKvY6EYDxJAyBJ02uLdocxhn6qMN7v.webp\",\"item-photos\\/hVa4bWRa3gzg28So2sEhyqnx3K7O2Y3K7CxkT1mR.webp\",\"item-photos\\/JHsyDrAaCP80Dk6PfspQyJvHXLDMGcpb9togUbWk.webp\"]', 'Earum rerum et ratio\r\n4 Seat People\r\nSupercharge Turbo', 500000, 2, 19, '2025-06-22 10:33:10', '2025-06-22 15:11:26');
INSERT INTO `items` VALUES (5, 'Phillip David', 'phillip-david-nl7fv', 1, 6, '[\"item-photos\\/vhKhbt0WLMGoS50BbQTa4LvzjgUbTYdWdZDap34l.jpg\",\"item-photos\\/ERTJfkbwPhjCDLW7tlhhPYLan1V7aKweYZoTLrSv.png\"]', 'Rerum minus cillum e', 316, 3, 26, '2025-06-22 10:41:54', '2025-06-22 11:05:53');
INSERT INTO `items` VALUES (8, 'Paul Bennett', 'paul-bennett-sajeb', 1, 5, '[\"item-photos\\/p18jWcCJ9OI4gtpkIBaE3YvByolYnwYLWHznhNMt.jpg\",\"item-photos\\/Zk4E4SUAjV7kJL7j43vRhsopFXJFeBBKXVkwvjUA.png\",\"item-photos\\/r3WC9fZcIT7Ut2Tk29hh9WwPOrIiBmFpeJ6k0ulR.png\"]', 'Sit cupidatat occaec', 153, 0, 0, '2025-06-22 11:09:48', '2025-06-22 11:09:48');
INSERT INTO `items` VALUES (9, 'Lee Langley', 'lee-langley-nw9q4', 1, 6, '[\"item-photos\\/uY7s3iy7qeUcnEqLFXNsNDBBSH46obl6h4xVDHsZ.webp\",\"item-photos\\/dC4ycV64uDQT2zGpMG7j9mYhcmsZnXTGpMMlqVoS.webp\",\"item-photos\\/PwzLnDqBh89ROudj7TmbLFzhLfvjdIv5u02IwCX6.webp\"]', 'Aut quia tempor volu, 4 Seat People', 152, 0, 0, '2025-06-22 11:11:11', '2025-06-22 11:11:11');
INSERT INTO `items` VALUES (10, 'Cadman Tillman', 'cadman-tillman-mpbsh', 2, 6, '[\"item-photos\\/L9kSJqYdrPoZWYoRZTHQPEiJk2d5B9flTCSnESrf.webp\",\"item-photos\\/5snQO291Uk5erk4yj37DtA7l5Xrl7EHfAAYIDYRM.webp\"]', 'Quae dolore et quo e, Culpa sunt tempore', 320, 0, 0, '2025-06-22 11:14:23', '2025-06-22 11:14:23');
INSERT INTO `items` VALUES (11, 'Elijah Mclaughlin', 'elijah-mclaughlin-ulldr', 1, 5, '[\"item-photos\\/FRWe276ueTI4DXnLFWTUKgqDmWYNpWPMhMC1xlYl.webp\",\"item-photos\\/hWzVTYybueyVDsZgqXrGmeZm60drvdbWQv10Hxdd.webp\"]', 'Culpa sunt tempore', 130, 0, 0, '2025-06-22 12:48:41', '2025-06-22 12:48:41');
INSERT INTO `items` VALUES (12, 'Driscoll Griffin', 'driscoll-griffin-8pz9a', 2, 5, '[\"item-photos\\/udhTZn2L7nzeNnQbniIPNLtbqIRJXXFTRJ6foqFw.webp\"]', 'Ea ea deserunt adipi', 918, 0, 0, '2025-06-22 12:55:41', '2025-06-22 12:55:41');
INSERT INTO `items` VALUES (13, 'Fiona Fleming', 'fiona-fleming-ckrmi', 1, 6, '[\"item-photos\\/YUzCaxk1pyPrK0RGeCD6EgDstsCK93x6ayKYrojJ.webp\"]', 'Harum culpa ad repre', 506, 0, 0, '2025-06-22 12:55:51', '2025-06-22 12:55:51');
INSERT INTO `items` VALUES (14, 'Jessamine Roberts', 'jessamine-roberts-rxaav', 2, 6, '[\"item-photos\\/ZcBiuedbFvqbEVsB5QCAv0e3eSbhELKDssOZiBza.webp\"]', 'Distinctio Inventor', 898, 0, 0, '2025-06-22 12:56:03', '2025-06-22 12:56:03');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (9, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (10, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (11, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (12, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (13, '2025_06_21_212212_create_brands_table', 2);
INSERT INTO `migrations` VALUES (14, '2025_06_21_212314_create_types_table', 2);
INSERT INTO `migrations` VALUES (15, '2025_06_21_212420_create_items_table', 2);
INSERT INTO `migrations` VALUES (16, '2025_06_22_112013_create_reviews_table', 3);
INSERT INTO `migrations` VALUES (17, '2025_06_22_135608_create_bookings_table', 4);
INSERT INTO `migrations` VALUES (18, '2025_06_22_185353_create_payments_table', 4);
INSERT INTO `migrations` VALUES (19, '2025_06_22_190302_create_overtimes_table', 4);

-- ----------------------------
-- Table structure for overtimes
-- ----------------------------
DROP TABLE IF EXISTS `overtimes`;
CREATE TABLE `overtimes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` bigint UNSIGNED NOT NULL,
  `hours` int NOT NULL,
  `fee_per_hour` decimal(10, 2) NOT NULL,
  `total_fee` decimal(10, 2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `overtimes_booking_id_foreign`(`booking_id` ASC) USING BTREE,
  CONSTRAINT `overtimes_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of overtimes
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` enum('Transfer','Cash') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Paid','Failed','Expired') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12, 2) NOT NULL,
  `payment_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payment_date` datetime NULL DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `payments_slug_unique`(`slug` ASC) USING BTREE,
  INDEX `payments_booking_id_foreign`(`booking_id` ASC) USING BTREE,
  CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payments
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for reviews
-- ----------------------------
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `star` tinyint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `reviews_user_id_item_id_unique`(`user_id` ASC, `item_id` ASC) USING BTREE,
  INDEX `reviews_item_id_foreign`(`item_id` ASC) USING BTREE,
  CONSTRAINT `reviews_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reviews
-- ----------------------------
INSERT INTO `reviews` VALUES (8, 1, 10, 5, 'HHHH', '2025-06-22 11:57:46', '2025-06-22 11:57:46');
INSERT INTO `reviews` VALUES (16, 1, 9, 5, 'Asperiores est sit', '2025-06-22 12:17:30', '2025-06-22 12:17:30');
INSERT INTO `reviews` VALUES (17, 1, 5, 5, 'Nesciunt nostrum la', '2025-06-22 12:39:08', '2025-06-22 12:39:08');
INSERT INTO `reviews` VALUES (19, 1, 13, 5, 'Irure dolorum et qua', '2025-06-22 14:07:59', '2025-06-22 14:07:59');
INSERT INTO `reviews` VALUES (21, 1, 1, 4, 'sukaaaa', '2025-06-22 15:26:10', '2025-06-22 15:26:10');
INSERT INTO `reviews` VALUES (26, 2, 10, 5, 'heloo', '2025-06-22 16:10:42', '2025-06-22 16:10:42');
INSERT INTO `reviews` VALUES (27, 1, 11, 4, 'Fugiat cupiditate d', '2025-06-22 16:16:05', '2025-06-22 16:16:05');

-- ----------------------------
-- Table structure for types
-- ----------------------------
DROP TABLE IF EXISTS `types`;
CREATE TABLE `types`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `types_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of types
-- ----------------------------
INSERT INTO `types` VALUES (1, 'Sport Car', 'sport-car-gvfuj', '2025-06-22 10:13:13', '2025-06-22 14:06:14');
INSERT INTO `types` VALUES (2, 'Family Car', 'family-car-5fok0', '2025-06-22 10:13:18', '2025-06-22 14:06:25');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Admin','User') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Umam', 'umam@gmail.com', NULL, NULL, '$2y$12$Hb3Mjual3t5NIvhjnc8mKu8MrQkrGahho7m9ot3dMksFYOX2OZ6g6', 'Admin', NULL, '2025-06-21 07:34:17', '2025-06-21 07:34:17');
INSERT INTO `users` VALUES (2, 'user', 'user@gmail.com', '0000', NULL, '$2y$12$nMo8lXbx/RQxnl7Suv/2dOxVN8tW4VCoOsBJfCgMA8TlDcjlbZsAu', 'User', NULL, '2025-06-21 10:11:58', '2025-06-21 10:11:58');
INSERT INTO `users` VALUES (3, 'Coba', 'coba@gmail.com', '000', NULL, '$2y$12$4khkL84wtn3LHmp6R66LFOOT.8XyxKCNDlizHtkTlM7fos5OMUZdm', 'User', NULL, '2025-06-21 20:29:44', '2025-06-21 20:29:44');
INSERT INTO `users` VALUES (4, 'Testing', 'testing@gmail.com', '000', NULL, '$2y$12$30tp3yASPnKfFhyGyW67uOO1MK40Kwq8ya3jOSfq962zMqHmrwkCa', 'User', NULL, '2025-06-22 12:30:40', '2025-06-22 12:30:40');

SET FOREIGN_KEY_CHECKS = 1;
