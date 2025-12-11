-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 09, 2023 at 05:17 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doctro`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `appointment_for` varchar(255) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `report_image` text DEFAULT NULL,
  `drug_effect` text NOT NULL,
  `patient_address` text NOT NULL,
  `phone_no` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `payment_token` text DEFAULT NULL,
  `appointment_status` ENUM('pending','approve','complete','cancel') DEFAULT NULL,
  `scheduled_notification_id_doctor` varchar(50) DEFAULT NULL,
  `scheduled_notification_id_patient` varchar(50) DEFAULT NULL,
  `illness_information` text NOT NULL,
  `note` text NOT NULL,
  `doctor_commission` varchar(255) DEFAULT NULL,
  `admin_commission` varchar(255) DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `cancel_by` varchar(100) DEFAULT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `hospital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_from` tinyint(1) DEFAULT NULL,
  `zoom_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `banner` ADD `description` VARCHAR(255) NULL DEFAULT NULL AFTER `name`;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `name`, `description`, `image`, `link`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Skin care', 'Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget.Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget.Lorem ipsum dolor sit amet.', '63e38df8131a0.png', '#', 1, '2021-05-05 04:14:57', '2024-02-26 06:53:55'),
(2, 'Family care', 'Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget.Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget.Lorem ipsum dolor sit amet.', '63e38e055a4e9.png', '#', 1, '2021-05-05 05:03:01', '2024-02-26 06:54:17'),
(3, 'Baby Care', 'Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget.Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget.Lorem ipsum dolor sit amet.', '63e38e0debd93.png', '#', 1, '2021-05-05 05:03:49', '2024-02-26 06:54:27');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `desc` longtext NOT NULL,
  `blog_ref` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `release_now` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `treatment_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE DIVOIRE', 'Cote DIvoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLES REPUBLIC OF', 'Korea, Democratic Peoples Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLES DEMOCRATIC REPUBLIC', 'Lao Peoples Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `symbol` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `country`, `currency`, `code`, `symbol`) VALUES
(1, 'Albania', 'Leke', 'ALL', 'Lek'),
(2, 'America', 'Dollars', 'USD', '$'),
(3, 'Afghanistan', 'Afghanis', 'AFN', '؋'),
(4, 'Argentina', 'Pesos', 'ARS', '$'),
(5, 'Aruba', 'Guilders', 'AWG', 'Afl'),
(6, 'Australia', 'Dollars', 'AUD', '$'),
(7, 'Azerbaijan', 'New Manats', 'AZN', '₼'),
(8, 'Bahamas', 'Dollars', 'BSD', '$'),
(9, 'Barbados', 'Dollars', 'BBD', '$'),
(10, 'Belarus', 'Rubles', 'BYR', 'p.'),
(11, 'Belgium', 'Euro', 'EUR', '€'),
(12, 'Beliz', 'Dollars', 'BZD', 'BZ$'),
(13, 'Bermuda', 'Dollars', 'BMD', '$'),
(14, 'Bolivia', 'Bolivianos', 'BOB', '$b'),
(15, 'Bosnia and Herzegovina', 'Convertible Marka', 'BAM', 'KM'),
(16, 'Botswana', 'Pula', 'BWP', 'P'),
(17, 'Bulgaria', 'Leva', 'BGN', 'Лв.'),
(18, 'Brazil', 'Reais', 'BRL', 'R$'),
(19, 'Britain (United Kingdom)', 'Pounds', 'GBP', '£\r\n'),
(20, 'Brunei Darussalam', 'Dollars', 'BND', '$'),
(21, 'Cambodia', 'Riels', 'KHR', '៛'),
(22, 'Canada', 'Dollars', 'CAD', '$'),
(23, 'Cayman Islands', 'Dollars', 'KYD', '$'),
(24, 'Chile', 'Pesos', 'CLP', '$'),
(25, 'China', 'Yuan Renminbi', 'CNY', '¥'),
(26, 'Colombia', 'Pesos', 'COP', '$'),
(27, 'Costa Rica', 'Colón', 'CRC', '₡'),
(28, 'Croatia', 'Kuna', 'HRK', 'kn'),
(29, 'Cuba', 'Pesos', 'CUP', '₱'),
(30, 'Cyprus', 'Euro', 'EUR', '€'),
(31, 'Czech Republic', 'Koruny', 'CZK', 'Kč'),
(32, 'Denmark', 'Kroner', 'DKK', 'kr'),
(33, 'Dominican Republic', 'Pesos', 'DOP ', 'RD$'),
(34, 'East Caribbean', 'Dollars', 'XCD', '$'),
(35, 'Egypt', 'Pounds', 'EGP', '£'),
(36, 'El Salvador', 'Colones', 'SVC', '$'),
(37, 'England (United Kingdom)', 'Pounds', 'GBP', '£'),
(38, 'Euro', 'Euro', 'EUR', '€'),
(39, 'Falkland Islands', 'Pounds', 'FKP', '£'),
(40, 'Fiji', 'Dollars', 'FJD', '$'),
(41, 'France', 'Euro', 'EUR', '€'),
(42, 'Ghana', 'Cedis', 'GHC', 'GH₵'),
(43, 'Gibraltar', 'Pounds', 'GIP', '£'),
(44, 'Greece', 'Euro', 'EUR', '€'),
(45, 'Guatemala', 'Quetzales', 'GTQ', 'Q'),
(46, 'Guernsey', 'Pounds', 'GGP', '£'),
(47, 'Guyana', 'Dollars', 'GYD', '$'),
(48, 'Holland (Netherlands)', 'Euro', 'EUR', '€'),
(49, 'Honduras', 'Lempiras', 'HNL', 'L'),
(50, 'Hong Kong', 'Dollars', 'HKD', '$'),
(51, 'Hungary', 'Forint', 'HUF', 'Ft'),
(52, 'Iceland', 'Kronur', 'ISK', 'kr'),
(53, 'India', 'Rupees', 'INR', '₹'),
(54, 'Indonesia', 'Rupiahs', 'IDR', 'Rp'),
(55, 'Iran', 'Rials', 'IRR', '﷼'),
(56, 'Ireland', 'Euro', 'EUR', '€'),
(57, 'Isle of Man', 'Pounds', 'IMP', '£'),
(58, 'Israel', 'New Shekels', 'ILS', '₪'),
(59, 'Italy', 'Euro', 'EUR', '€'),
(60, 'Jamaica', 'Dollars', 'JMD', 'J$'),
(61, 'Japan', 'Yen', 'JPY', '¥'),
(62, 'Jersey', 'Pounds', 'JEP', '£'),
(63, 'Kazakhstan', 'Tenge', 'KZT', '₸'),
(64, 'Korea (North)', 'Won', 'KPW', '₩'),
(65, 'Korea (South)', 'Won', 'KRW', '₩'),
(66, 'Kyrgyzstan', 'Soms', 'KGS', 'Лв'),
(67, 'Laos', 'Kips', 'LAK', '	₭'),
(68, 'Latvia', 'Lati', 'LVL', 'Ls'),
(69, 'Lebanon', 'Pounds', 'LBP', '£'),
(70, 'Liberia', 'Dollars', 'LRD', '$'),
(71, 'Liechtenstein', 'Switzerland Francs', 'CHF', 'CHF'),
(72, 'Lithuania', 'Litai', 'LTL', 'Lt'),
(73, 'Luxembourg', 'Euro', 'EUR', '€'),
(74, 'Macedonia', 'Denars', 'MKD', 'Ден\r\n'),
(75, 'Malaysia', 'Ringgits', 'MYR', 'RM'),
(76, 'Malta', 'Euro', 'EUR', '€'),
(77, 'Mauritius', 'Rupees', 'MUR', '₹'),
(78, 'Mexico', 'Pesos', 'MXN', '$'),
(79, 'Mongolia', 'Tugriks', 'MNT', '₮'),
(80, 'Mozambique', 'Meticais', 'MZN', 'MT'),
(81, 'Namibia', 'Dollars', 'NAD', '$'),
(82, 'Nepal', 'Rupees', 'NPR', '₹'),
(83, 'Netherlands Antilles', 'Guilders', 'ANG', 'ƒ'),
(84, 'Netherlands', 'Euro', 'EUR', '€'),
(85, 'New Zealand', 'Dollars', 'NZD', '$'),
(86, 'Nicaragua', 'Cordobas', 'NIO', 'C$'),
(87, 'Nigeria', 'Nairas', 'NGN', '₦'),
(88, 'North Korea', 'Won', 'KPW', '₩'),
(89, 'Norway', 'Krone', 'NOK', 'kr'),
(90, 'Oman', 'Rials', 'OMR', '﷼'),
(91, 'Pakistan', 'Rupees', 'PKR', 'Rs'),
(92, 'Panama', 'Balboa', 'PAB', 'B/.'),
(93, 'Paraguay', 'Guarani', 'PYG', 'Gs'),
(94, 'Peru', 'Nuevos Soles', 'PEN', 'S/.'),
(95, 'Philippines', 'Pesos', 'PHP', 'Php'),
(96, 'Poland', 'Zlotych', 'PLN', 'zł'),
(97, 'Qatar', 'Rials', 'QAR', '﷼'),
(98, 'Romania', 'New Lei', 'RON', 'lei'),
(99, 'Russia', 'Rubles', 'RUB', '₽'),
(100, 'Saint Helena', 'Pounds', 'SHP', '£'),
(101, 'Saudi Arabia', 'Riyals', 'SAR', '﷼'),
(102, 'Serbia', 'Dinars', 'RSD', 'ع.د'),
(103, 'Seychelles', 'Rupees', 'SCR', '₹'),
(104, 'Singapore', 'Dollars', 'SGD', '$'),
(105, 'Slovenia', 'Euro', 'EUR', '€'),
(106, 'Solomon Islands', 'Dollars', 'SBD', '$'),
(107, 'Somalia', 'Shillings', 'SOS', 'S'),
(108, 'South Africa', 'Rand', 'ZAR', 'R'),
(109, 'South Korea', 'Won', 'KRW', '₩'),
(110, 'Spain', 'Euro', 'EUR', '€'),
(111, 'Sri Lanka', 'Rupees', 'LKR', '₹'),
(112, 'Sweden', 'Kronor', 'SEK', 'kr'),
(113, 'Switzerland', 'Francs', 'CHF', 'CHF'),
(114, 'Suriname', 'Dollars', 'SRD', '$'),
(115, 'Syria', 'Pounds', 'SYP', '£'),
(116, 'Taiwan', 'New Dollars', 'TWD', 'NT$'),
(117, 'Thailand', 'Baht', 'THB', '฿'),
(118, 'Trinidad and Tobago', 'Dollars', 'TTD', 'TT$'),
(119, 'Turkey', 'Lira', 'TRY', 'TL'),
(120, 'Turkey', 'Liras', 'TRL', '₺'),
(121, 'Tuvalu', 'Dollars', 'TVD', '$'),
(122, 'Ukraine', 'Hryvnia', 'UAH', '₴'),
(123, 'United Kingdom', 'Pounds', 'GBP', '£'),
(124, 'United States of America', 'Dollars', 'USD', '$'),
(125, 'Uruguay', 'Pesos', 'UYU', '$U'),
(127, 'Vatican City', 'Euro', 'EUR', '€'),
(128, 'Venezuela', 'Bolivares Fuertes', 'VEF', 'Bs'),
(129, 'Vietnam', 'Dong', 'VND', '₫\r\n'),
(130, 'Yemen', 'Rials', 'YER', '﷼'),
(131, 'Zimbabwe', 'Zimbabwe Dollars', 'ZWD', 'Z$'),
(132, 'Kenya', 'Kenyan Shilling', 'KES', 'KSh'),
(133, 'Ghana', 'Ghanaian Cedi', 'GHS', 'GH₵');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `treatment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expertise_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hospital_id` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `desc` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `certificate` text DEFAULT NULL,
  `appointment_fees` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `timeslot` varchar(100) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `since` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `subscription_status` int(11) DEFAULT NULL,
  `based_on` varchar(255) NOT NULL,
  `is_popular` int(11) NOT NULL DEFAULT 0,
  `commission_amount` varchar(100) DEFAULT NULL,
  `custom_timeslot` int(11) DEFAULT NULL,
  `is_filled` tinyint(1) NOT NULL,
  `language` text DEFAULT NULL,
  `patient_vcall` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_subscription`
--

CREATE TABLE `doctor_subscription` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `duration` int(11) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `booked_appointment` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expertise`
--

CREATE TABLE `expertise` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faviroute`
--

CREATE TABLE `faviroute` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `lat` text NOT NULL,
  `lng` text NOT NULL,
  `facility` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_gallery`
--

CREATE TABLE `hospital_gallery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hospital_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab`
--

CREATE TABLE `lab` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address` text NOT NULL,
  `lat` text NOT NULL,
  `lng` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `commission` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_settle`
--

CREATE TABLE `lab_settle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `report_id` bigint(20) UNSIGNED NOT NULL,
  `admin_amount` int(11) NOT NULL,
  `lab_amount` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `lab_status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_working_hours`
--

CREATE TABLE `lab_working_hours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `day_index` varchar(255) NOT NULL,
  `period_list` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `json_file` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `direction` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `json_file`, `image`, `direction`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'English.json', 'English.png', 'ltr', 1, '2021-08-26 09:20:20', '2022-11-18 04:26:25'),
(2, 'Arabic', 'Arabic.json', 'Arabic.png', 'rtl', 1, '2021-08-26 09:21:20', '2022-11-18 04:25:57');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pharmacy_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_category_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `total_stock` int(11) NOT NULL,
  `use_stock` int(11) DEFAULT 0,
  `incoming_stock` int(11) NOT NULL,
  `price_pr_strip` int(11) NOT NULL,
  `number_of_medicine` int(11) NOT NULL,
  `description` text NOT NULL,
  `works` text NOT NULL,
  `prescription_required` tinyint(1) NOT NULL,
  `meta_info` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_category`
--

CREATE TABLE `medicine_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_child`
--

CREATE TABLE `medicine_child` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_medicine_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_04_14_114114_create_permission_tables', 2),
(5, '2021_04_19_063440_create_treatments_table', 3),
(6, '2021_04_19_122222_create_category_table', 4),
(7, '2021_04_20_055822_create_expertise_table', 5),
(8, '2021_04_20_093227_create_medicine_table', 6),
(9, '2021_04_21_041726_create_hospital_table', 7),
(10, '2021_04_21_084328_create_doctor_table', 8),
(11, '2021_04_23_070033_create_working_hour_table', 9),
(12, '2021_04_24_112427_create_blog_table', 10),
(13, '2021_04_26_111355_create_subscription_table', 11),
(14, '2021_04_28_092927_create_offer_table', 12),
(15, '2021_04_28_192443_create_hospital_gallery_table', 13),
(16, '2021_04_29_090851_create_notification_template_table', 14),
(18, '2021_05_03_092738_create_doctor_subscription_table', 15),
(20, '2021_05_05_090404_create_banner_table', 16),
(21, '2021_05_06_133656_create_appointment_table', 17),
(22, '2021_05_07_170002_create_faviroute_table', 18),
(23, '2021_05_08_173223_create_prescription_table', 19),
(24, '2021_05_10_185108_create_purchase_medicine_table', 20),
(25, '2021_05_10_185841_create_medicine_child_table', 20),
(26, '2021_05_11_124851_create_review_table', 21),
(27, '2021_05_14_104048_create_settle_table', 22),
(28, '2021_05_15_172945_create_pharmacy_table', 23),
(29, '2021_05_15_201146_create_medicine_category_table', 24),
(30, '2016_06_01_000001_create_oauth_auth_codes_table', 25),
(31, '2016_06_01_000002_create_oauth_access_tokens_table', 25),
(32, '2016_06_01_000003_create_oauth_refresh_tokens_table', 25),
(33, '2016_06_01_000004_create_oauth_clients_table', 25),
(34, '2016_06_01_000005_create_oauth_personal_access_clients_table', 25),
(35, '2019_11_18_105032_create_pages_table', 26),
(36, '2019_11_18_105615_create_uploads_table', 26),
(37, '2020_04_18_064412_create_page_translations_table', 26),
(38, '2020_04_18_065546_create_settings_table', 26);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `user_type` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_template`
--

CREATE TABLE `notification_template` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `msg_content` text NOT NULL,
  `mail_content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_template`
--

INSERT INTO `notification_template` (`id`, `subject`, `title`, `msg_content`, `mail_content`, `created_at`, `updated_at`) VALUES
(1, 'Account Verification', 'verification', 'Hello, {{user_name}} your verification code is {{otp}} from {{app_name}}', '<p>Dear {{User_name}},<br>Your account Verification Code Is <b>{{Otp}}.</b></p><p>From,<br>{{App_name}}</p>', NULL, '2024-10-18 09:55:01'),
(2, 'Your Appointment with a Doctor', 'create appointment', 'Hello, {{user_name}} Your appointment with ID {{appointment_id}} is successfully placed for {{date}}{{time}}', '<p>Hello, {{user_name}},<br>Your appointment with ID {{appointment_id}} is successfully&nbsp;placed on {{date}} at {{time}}.</p><p>From,<br>{{app_name}}.</p>', NULL, '2024-10-18 09:54:15'),
(3, 'Password has been changed', 'forgot password', 'Hello {{user_name}}, Your new password is {{password}} from {{app_name}}', '<p>Hello {{user_name}},</p><p>your new password is <b>{{password}}</b></p><p>from,<br>{{app_name}}</p>', NULL, '2024-10-18 09:53:42'),
(4, 'Appointment Status Updated', 'status change', 'Hello {{user_name}} appointment {{appointment_id}} status updated to {{status}} at {{date}}', '<p>Hello {{user_name}},<br>Appointment {{appointment_id}} status updated at {{date}}. Current Status is {{status}}.</p><p>from,<br>{{app_name}}.</p>', NULL, '2024-10-18 09:17:53'),
(5, 'Doctor Book Appointment', 'doctor book appointment', 'Hello {{doctor_name}}, New appointment {{appointment_id}} at{{date}} with {{user_name}}', '<p>Hello {{doctor_name}},<br>New appointment {{appointment_id}} at {{date}} with {{user_name}}.</p><p>from,<br>{{app_name}}</p><p><br></p>', NULL, '2024-10-18 09:54:07'),
(6, 'Zoom Meeting Link', 'zoom meeting link', 'N/A', 'Connect to the Zoom Meeting via <a href="{{join_url}}"><b>This Link</b></a> for your appointment with the {{doctor_name}}.<br>Timing : {{start_time}} <br><br> {{app_name}}', NULL, '2024-10-18 09:54:07');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'JYgWpRDPtOeBB5tvfPNFVlIKg1pjPy7qcFXhuZuF', NULL, 'http://localhost', 1, 0, 0, '2021-05-20 06:31:54', '2021-05-20 06:31:54'),
(2, NULL, 'Laravel Password Grant Client', 'yFf8bF9Y31FNRsmpgthVEMUi0bCg8gHMVQ6inmxl', 'users', 'http://localhost', 0, 1, 0, '2021-05-20 06:31:54', '2021-05-20 06:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-05-20 06:31:54', '2021-05-20 06:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `offer_code` varchar(255) NOT NULL,
  `max_use` int(11) NOT NULL,
  `use_count` int(11) DEFAULT 0,
  `min_discount` int(11) NOT NULL,
  `is_flat` int(11) NOT NULL,
  `flatDiscount` int(11) DEFAULT NULL,
  `start_end_date` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `doctor_id` varchar(255) NOT NULL,
  `discount_type` varchar(255) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `desc` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(50) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pathology`
--

CREATE TABLE `pathology` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `report_days` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `charge` int(11) NOT NULL,
  `pathology_category_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `method` varchar(255) NOT NULL,
  `prescription_required` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pathology_category`
--

CREATE TABLE `pathology_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin_dashboard', 'web', '2021-04-14 23:26:17', '2021-04-14 23:26:17'),
(2, 'superadmin_setting', 'web', '2021-04-14 23:35:55', '2021-04-14 23:35:55'),
(3, 'treatment_access', 'web', '2021-04-18 17:50:49', '2021-04-18 17:50:49'),
(4, 'treatment_add', 'web', '2021-04-18 17:50:49', '2021-04-18 17:50:49'),
(5, 'treatment_edit', 'web', '2021-04-18 17:50:49', '2021-04-18 17:50:49'),
(6, 'treatment_delete', 'web', '2021-04-18 17:50:49', '2021-04-18 17:50:49'),
(7, 'category_access', 'web', '2021-04-19 01:23:48', '2021-04-19 01:23:48'),
(8, 'category_add', 'web', '2021-04-19 01:23:48', '2021-04-19 01:23:48'),
(9, 'category_edit', 'web', '2021-04-19 01:23:48', '2021-04-19 01:23:48'),
(10, 'category_delete', 'web', '2021-04-19 01:23:49', '2021-04-19 01:23:49'),
(11, 'expertise_access', 'web', '2021-04-19 18:55:58', '2021-04-19 18:55:58'),
(12, 'expertise_add', 'web', '2021-04-19 18:55:58', '2021-04-19 18:55:58'),
(13, 'expertise_edit', 'web', '2021-04-19 18:55:58', '2021-04-19 18:55:58'),
(14, 'expertise_delete', 'web', '2021-04-19 18:55:58', '2021-04-19 18:55:58'),
(19, 'hospital_access', 'web', '2021-04-20 17:20:10', '2021-04-20 17:20:10'),
(20, 'hospital_add', 'web', '2021-04-20 17:20:10', '2021-04-20 17:20:10'),
(21, 'hospital_edit', 'web', '2021-04-20 17:20:10', '2021-04-20 17:20:10'),
(22, 'hospital_delete', 'web', '2021-04-20 17:20:10', '2021-04-20 17:20:10'),
(23, 'doctor_access', 'web', '2021-04-20 21:49:43', '2021-04-20 21:49:43'),
(24, 'doctor_add', 'web', '2021-04-20 21:49:43', '2021-04-20 21:49:43'),
(25, 'doctor_edit', 'web', '2021-04-20 21:49:43', '2021-04-20 21:49:43'),
(26, 'doctor_delete', 'web', '2021-04-20 21:49:43', '2021-04-20 21:49:43'),
(27, 'role_access', 'web', '2021-04-23 20:18:46', '2021-04-23 20:18:46'),
(28, 'role_add', 'web', '2021-04-23 20:18:46', '2021-04-23 20:18:46'),
(29, 'role_edit', 'web', '2021-04-23 20:18:46', '2021-04-23 20:18:46'),
(30, 'role_delete', 'web', '2021-04-23 20:18:46', '2021-04-23 20:18:46'),
(31, 'blog_access', 'web', '2021-04-24 00:25:15', '2021-04-24 00:25:15'),
(32, 'blog_add', 'web', '2021-04-24 00:25:15', '2021-04-24 00:25:15'),
(33, 'blog_edit', 'web', '2021-04-24 00:25:15', '2021-04-24 00:25:15'),
(34, 'blog_delete', 'web', '2021-04-24 00:25:15', '2021-04-24 00:25:15'),
(35, 'subscription_access', 'web', '2021-04-26 00:25:03', '2021-04-26 00:25:03'),
(36, 'subscription_add', 'web', '2021-04-26 00:25:03', '2021-04-26 00:25:03'),
(37, 'subscription_edit', 'web', '2021-04-26 00:25:03', '2021-04-26 00:25:03'),
(38, 'subscription_delete', 'web', '2021-04-26 00:25:03', '2021-04-26 00:25:03'),
(39, 'patient_access', 'web', '2021-04-27 08:00:55', '2021-04-27 08:00:55'),
(40, 'patient_add', 'web', '2021-04-27 08:00:55', '2021-04-27 08:00:55'),
(41, 'patient_edit', 'web', '2021-04-27 08:00:55', '2021-04-27 08:00:55'),
(42, 'patient_delete', 'web', '2021-04-27 08:00:55', '2021-04-27 08:00:55'),
(43, 'offer_access', 'web', '2021-04-27 22:24:35', '2021-04-27 22:24:35'),
(44, 'offer_add', 'web', '2021-04-27 22:24:35', '2021-04-27 22:24:35'),
(45, 'offer_edit', 'web', '2021-04-27 22:24:35', '2021-04-27 22:24:35'),
(46, 'offer_delete', 'web', '2021-04-27 22:24:35', '2021-04-27 22:24:35'),
(47, 'appointment_calendar_access', 'web', '2021-04-28 06:23:52', '2021-04-28 06:23:52'),
(48, 'hospital_gallery_access', 'web', '2021-04-28 08:19:03', '2021-04-28 08:19:03'),
(49, 'hospital_gallery_add', 'web', '2021-04-28 08:19:03', '2021-04-28 08:19:03'),
(50, 'hospital_gallery_edit', 'web', '2021-04-28 08:19:03', '2021-04-28 08:19:03'),
(51, 'hospital_gallery_delete', 'web', '2021-04-28 08:19:03', '2021-04-28 08:19:03'),
(52, 'doctor_home', 'web', '2021-05-01 03:40:25', '2021-05-01 03:40:25'),
(54, 'doctor_subscription_purchase', 'web', '2021-05-03 00:04:25', '2021-05-03 00:04:25'),
(56, 'subscription_history', 'web', '2021-05-03 06:46:47', '2021-05-03 06:46:47'),
(57, 'doctor_schedule', 'web', '2021-05-03 07:32:29', '2021-05-03 07:32:29'),
(58, 'doctor_profile', 'web', '2021-05-03 07:52:10', '2021-05-03 07:52:10'),
(59, 'commission_details', 'web', '2021-05-04 03:47:37', '2021-05-04 03:47:37'),
(60, 'appointment_access', 'web', '2021-05-04 04:09:17', '2021-05-04 04:09:17'),
(61, 'banner_add', 'web', '2021-05-04 22:11:34', '2021-05-04 22:11:34'),
(62, 'banner_access', 'web', '2021-05-04 22:11:34', '2021-05-04 22:11:34'),
(63, 'banner_edit', 'web', '2021-05-04 22:11:34', '2021-05-04 22:11:34'),
(64, 'banner_delete', 'web', '2021-05-04 22:11:34', '2021-05-04 22:11:34'),
(65, 'report_access', 'web', '2021-05-14 22:33:20', '2021-05-14 22:33:20'),
(67, 'pharmacy_access', 'web', '2021-05-15 06:24:06', '2021-05-15 06:24:06'),
(68, 'pharmacy_add', 'web', '2021-05-15 06:24:52', '2021-05-15 06:24:52'),
(69, 'pharmacy_edit', 'web', '2021-05-15 06:24:52', '2021-05-15 06:24:52'),
(70, 'pharmacy_delete', 'web', '2021-05-15 06:24:53', '2021-05-15 06:24:53'),
(71, 'medicine_category_access', 'web', '2021-05-15 09:27:48', '2021-05-15 09:27:48'),
(72, 'medicine_category_add', 'web', '2021-05-15 09:27:48', '2021-05-15 09:27:48'),
(73, 'medicine_category_edit', 'web', '2021-05-15 09:27:48', '2021-05-15 09:27:48'),
(74, 'medicine_category_delete', 'web', '2021-05-15 09:27:48', '2021-05-15 09:27:48'),
(75, 'pharmacy_dashboard', 'web', '2021-05-17 01:32:44', '2021-05-17 01:32:44'),
(76, 'admin_medicine_access', 'web', '2021-05-17 01:41:24', '2021-05-17 01:41:24'),
(77, 'admin_medicine_add', 'web', '2021-05-17 01:41:24', '2021-05-17 01:41:24'),
(78, 'admin_medicine_edit', 'web', '2021-05-17 01:41:25', '2021-05-17 01:41:25'),
(79, 'admin_medicine_delete', 'web', '2021-05-17 01:41:25', '2021-05-17 01:41:25'),
(80, 'medicine_add', 'web', '2021-05-17 01:45:54', '2021-05-17 01:45:54'),
(81, 'medicine_edit', 'web', '2021-05-17 01:46:10', '2021-05-17 01:46:10'),
(82, 'medicine_delete', 'web', '2021-05-17 01:46:26', '2021-05-17 01:46:26'),
(83, 'medicine_access', 'web', '2021-05-17 01:46:42', '2021-05-17 01:46:42'),
(84, 'pharmacy_schedule', 'web', '2021-05-18 10:38:52', '2021-05-18 10:38:52'),
(85, 'pharmacy_commission_access', 'web', '2021-05-19 22:45:38', '2021-05-19 22:45:38'),
(86, 'pharmacy_profile', 'web', '2021-05-19 23:32:50', '2021-05-19 23:32:50'),
(87, 'pharmacy_purchase_medicine', 'web', '2021-05-21 09:44:21', '2021-05-21 09:44:21'),
(88, 'language_access', 'web', '2021-08-20 06:57:38', '2021-08-20 06:57:38'),
(89, 'language_add', 'web', '2021-08-20 06:57:38', '2021-08-20 06:57:38'),
(90, 'language_edit', 'web', '2021-08-20 06:57:38', '2021-08-20 06:57:38'),
(91, 'language_delete', 'web', '2021-08-20 06:57:39', '2021-08-20 06:57:39'),
(92, 'doctor_review', 'web', '2021-08-26 04:59:59', '2021-08-26 04:59:59'),
(93, 'lab_access', 'web', NULL, NULL),
(94, 'lab_add', 'web', NULL, NULL),
(95, 'lab_edit', 'web', NULL, NULL),
(96, 'lab_delete', 'web', NULL, NULL),
(97, 'pathology_category_access', 'web', NULL, NULL),
(98, 'pathology_category_add', 'web', NULL, NULL),
(99, 'pathology_category_edit', 'web', NULL, NULL),
(100, 'pathology_category_delete', 'web', NULL, NULL),
(101, 'radiology_category_access', 'web', NULL, NULL),
(102, 'radiology_category_add', 'web', NULL, NULL),
(103, 'radiology_category_edit', 'web', NULL, NULL),
(104, 'radiology_category_delete', 'web', NULL, NULL),
(105, 'laboratory_home', 'web', NULL, NULL),
(106, 'pathology_access', 'web', NULL, NULL),
(107, 'pathology_add', 'web', NULL, NULL),
(108, 'pathology_edit', 'web', NULL, NULL),
(109, 'pathology_delete', 'web', NULL, NULL),
(110, 'radiology_access', 'web', NULL, NULL),
(111, 'radiology_add', 'web', NULL, NULL),
(112, 'radiology_edit', 'web', NULL, NULL),
(113, 'radiology_delete', 'web', NULL, NULL),
(114, 'test_report', 'web', NULL, NULL),
(115, 'lab_commission', 'web', NULL, NULL),
(116, 'lab_timeslot', 'web', NULL, NULL),
(118, 'admin_user_access', 'web', NULL, NULL),
(119, 'admin_user_add', 'web', NULL, NULL),
(120, 'admin_user_edit', 'web', NULL, NULL),
(121, 'admin_user_delete', 'web', NULL, NULL),
(124, 'zoom_setting', 'web', NULL, NULL),
(125, 'insurer_access', 'web', NULL, NULL),
(126, 'insurer_add', 'web', NULL, NULL),
(127, 'insurer_edit', 'web', NULL, NULL),
(128, 'insurer_delete', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pharamacy_settle`
--

CREATE TABLE `pharamacy_settle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_medicine_id` bigint(20) UNSIGNED NOT NULL,
  `pharamacy_id` bigint(20) UNSIGNED NOT NULL,
  `admin_amount` int(11) NOT NULL,
  `pharamacy_amount` int(11) DEFAULT NULL,
  `payment` int(11) NOT NULL,
  `pharamacy_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharamacy_working_hour`
--

CREATE TABLE `pharamacy_working_hour` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pharamacy_id` bigint(20) UNSIGNED NOT NULL,
  `day_index` varchar(255) NOT NULL,
  `period_list` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `commission_amount` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `is_shipping` int(11) NOT NULL DEFAULT 0,
  `delivery_charges` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `language` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_settle`
--

CREATE TABLE `pharmacy_settle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_medicine_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacy_id` bigint(20) UNSIGNED NOT NULL,
  `admin_amount` int(11) NOT NULL,
  `pharmacy_amount` int(11) DEFAULT NULL,
  `payment` int(11) NOT NULL,
  `pharmacy_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_working_hour`
--

CREATE TABLE `pharmacy_working_hour` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pharmacy_id` bigint(20) UNSIGNED NOT NULL,
  `day_index` varchar(255) NOT NULL,
  `period_list` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `medicines` text NOT NULL,
  `pdf` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_medicine`
--

CREATE TABLE `purchase_medicine` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `admin_commission` int(11) NOT NULL,
  `pharmacy_commission` int(11) NOT NULL,
  `pharmacy_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_at` varchar(100) NOT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_charge` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radiology`
--

CREATE TABLE `radiology` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `radiology_category_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `report_days` int(11) NOT NULL,
  `charge` int(11) NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `screening_for` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radiology_category`
--

CREATE TABLE `radiology_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_id` varchar(255) NOT NULL,
  `lab_id` bigint(20) UNSIGNED NOT NULL,
  `pathology_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pathology_id` varchar(255) DEFAULT NULL,
  `radiology_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `radiology_id` varchar(255) DEFAULT NULL,
  `amount` int(20) NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `phone_no` text NOT NULL,
  `age` int(20) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `payment_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` int(11) NOT NULL,
  `upload_report` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review` text NOT NULL,
  `rate` int(11) NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `default` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `default`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'web', 1, '2021-04-14 07:31:07', '2021-04-14 07:31:07'),
(2, 'doctor', 'web', 1, '2021-04-22 00:21:13', '2021-04-22 00:21:13'),
(5, 'pharmacy', 'web', 1, '2021-05-15 11:52:41', '2021-05-15 11:52:41'),
(6, 'laboratory', 'web', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(35, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(47, 2),
(52, 2),
(54, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(75, 5),
(80, 5),
(81, 5),
(82, 5),
(83, 5),
(84, 5),
(85, 5),
(86, 5),
(87, 5),
(92, 2),
(105, 6),
(106, 6),
(107, 6),
(108, 6),
(109, 6),
(110, 6),
(111, 6),
(112, 6),
(113, 6),
(114, 6),
(115, 6),
(116, 6);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `company_white_logo` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_favicon` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(10) DEFAULT NULL,
  `currency_code` varchar(100) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `color` varchar(100) DEFAULT NULL,
  `website_color` varchar(100) DEFAULT NULL,
  `cod` tinyint(1) DEFAULT NULL,
  `stripe` tinyint(1) DEFAULT NULL,
  `paypal` tinyint(1) DEFAULT NULL,
  `razor` tinyint(1) DEFAULT NULL,
  `flutterwave` tinyint(1) DEFAULT NULL,
  `paystack` tinyint(1) DEFAULT NULL,
  `stripe_public_key` text DEFAULT NULL,
  `stripe_secret_key` text DEFAULT NULL,
  `paypal_secret_key` varchar(255) DEFAULT NULL,
  `paypal_client_id` varchar(255) DEFAULT NULL,
  `razor_key` text DEFAULT NULL,
  `flutterwave_key` text DEFAULT NULL,
  `flutterwave_encryption_key` text DEFAULT NULL,
  `isLiveKey` tinyint(1) NOT NULL DEFAULT 0,
  `paystack_public_key` text DEFAULT NULL,
  `timezone` text DEFAULT NULL,
  `default_commission` int(11) DEFAULT NULL,
  `pharmacy_commission` int(11) DEFAULT NULL,
  `pharamacy_commission` int(11) DEFAULT NULL,
  `default_base_on` varchar(255) DEFAULT NULL,
  `map_key` text DEFAULT NULL,
  `verification` tinyint(1) DEFAULT NULL,
  `using_mail` tinyint(1) DEFAULT NULL,
  `using_msg` tinyint(1) DEFAULT NULL,
  `twilio_auth_token` varchar(255) DEFAULT NULL,
  `twilio_acc_id` varchar(255) DEFAULT NULL,
  `twilio_phone_no` varchar(255) DEFAULT NULL,
  `mail_mailer` text DEFAULT NULL,
  `mail_host` text DEFAULT NULL,
  `mail_port` text DEFAULT NULL,
  `mail_username` text DEFAULT NULL,
  `mail_password` text DEFAULT NULL,
  `mail_encryption` text DEFAULT NULL,
  `mail_from_address` text DEFAULT NULL,
  `mail_from_name` text DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `radius` int(11) NOT NULL DEFAULT 50,
  `clinic_content` text DEFAULT NULL,
  `doctor_content` text DEFAULT NULL,
  `footer_content` text DEFAULT NULL,
  `doctor_mail` text DEFAULT NULL,
  `patient_mail` text DEFAULT NULL,
  `patient_notification` text DEFAULT NULL,
  `doctor_notification` text DEFAULT NULL,
  `patient_app_id` text DEFAULT NULL,
  `patient_auth_key` text DEFAULT NULL,
  `patient_api_key` text DEFAULT NULL,
  `doctor_app_id` text DEFAULT NULL,
  `doctor_auth_key` text DEFAULT NULL,
  `doctor_api_key` text DEFAULT NULL,
  `license_code` text DEFAULT NULL,
  `client_name` text DEFAULT NULL,
  `license_verify` tinyint(1) DEFAULT NULL,
  `language` varchar(250) DEFAULT NULL,
  `auto_cancel` text DEFAULT NULL,
  `playstore` text DEFAULT NULL,
  `appstore` text DEFAULT NULL,
  `privacy_policy` text DEFAULT NULL,
  `about_us` text DEFAULT NULL,
  `agora_app_id` text DEFAULT NULL,
  `agora_app_certificate` text DEFAULT NULL,
  `zoom_switch` tinyint(1) DEFAULT '0',
  `zoom_client_id` text DEFAULT NULL,
  `zoom_client_secret` text DEFAULT NULL,
  `zoom_redirect_url` varchar(255) DEFAULT NULL,
  `zoom_page_content` text DEFAULT NULL,
  `banner_image` text DEFAULT NULL,
  `banner_url` text DEFAULT NULL,
  `pathologist_commission` int(11) DEFAULT NULL,
  `facebook_url` text DEFAULT NULL,
  `linkdin_url` text DEFAULT NULL,
  `instagram_url` text DEFAULT NULL,
  `twitter_url` text DEFAULT NULL,
  `home_content` varchar(255) DEFAULT NULL,
  `home_content_desc` text DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lang` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `business_name`, `email`, `phone`, `company_white_logo`, `company_logo`, `company_favicon`, `currency_symbol`, `currency_code`,
`currency_id`, `color`, `website_color`, `cod`, `stripe`, `paypal`, `razor`, `flutterwave`, `paystack`, `stripe_public_key`, `stripe_secret_key`, `paypal_secret_key`, `paypal_client_id`, `razor_key`, `flutterwave_key`, `flutterwave_encryption_key`, `isLiveKey`, `paystack_public_key`,
 `timezone`, `default_commission`, `pharmacy_commission`, `pharamacy_commission`, `default_base_on`, `map_key`, `verification`, `using_mail`, `using_msg`,
  `twilio_auth_token`, `twilio_acc_id`, `twilio_phone_no`, `mail_mailer`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`,
  `mail_from_address`, `mail_from_name`, `cancel_reason`, `radius`, `clinic_content`, `doctor_content`, `footer_content`, `doctor_mail`, `patient_mail`,
   `patient_notification`, `doctor_notification`, `patient_app_id`, `patient_auth_key`, `patient_api_key`, `doctor_app_id`, `doctor_auth_key`, `doctor_api_key`,
   `license_code`, `client_name`, `license_verify`, `language`, `auto_cancel`, `playstore`, `appstore`, `privacy_policy`, `about_us`, `agora_app_id`,
   `agora_app_certificate`, `banner_image`, `banner_url`, `pathologist_commission`, `facebook_url`, `linkdin_url`, `instagram_url`, `twitter_url`,
   `home_content`, `home_content_desc`, `lat`, `lang`, `created_at`, `updated_at`) VALUES
(1, 'Doctro', 'doctro@example.com', '774455662211', '63e38d29b18f4.png', '63e38d29b1d7f.png', '63f6efb85dbc2.png', '$', 'USD', 2, '#1f8ced', '#2782ff', 1, 0, 0, 0, 0, 0,
 ' ', ' ', ' ', ' ', ' ', ' ', ' ', 0, ' ', 'Asia/Kolkata', 10, 10, 10, 'commission', '', 0, 0, 0, ' ', ' ', ' ', ' ',
 ' ', ' ', ' ', ' ', ' ', ' ', ' ', '[\"appointment time doctor not available.\",\"Now I am perfectly alright.\",\"Hospital not find and I missed appointment time.\",\"Personal Reasons\"]', 100, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br></p>', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p><p><br></p><p>web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes</p>', '<p><span style=\"color: rgb(255, 255, 255);\"><span style=\"font-family: Helvetica;\">﻿</span><span style=\"font-family: Helvetica; text-transform: none;\">In layman\'s terms,&nbsp;</span><span style=\"font-family: Helvetica;\">﻿</span><span style=\"font-family: Helvetica;\"><b style=\"font-family: arial, sans-serif; text-transform: none;\">Lorem Ipsu</b></span><span style=\"font-family: Helvetica;\">﻿</span><b style=\"font-family: arial, sans-serif; text-transform: none;\"><span style=\"font-family: Helvetica;\">m</span></b><span style=\"font-family: Helvetica; text-transform: none;\">&nbsp;is a dummy or placeho</span><span style=\"font-family: Helvetica;\">﻿</span><span style=\"font-family: Helvetica; text-transform: none;\">ld</span><span style=\"font-family: Helvetica;\">﻿</span><span style=\"font-family: Helvetica; text-transform: none;\">er text. It\'s often used in laying out print, infographics, or web design</span><span style=\"font-family: Helvetica;\">﻿</span></span></p>', '0', '0', '0', '0', ' ', ' ', ' ', ' ', ' ', ' ', '', '', 0, 'English', '60', 'https://doctro.saasmonks.in', 'https://doctro.saasmonks.in', NULL, '<p><br></p><div id=\"bannerR\" style=\"margin: 0px -160px 0px 0px; padding: 0px; position: sticky; top: 20px; width: 160px; height: 10px; float: right; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-transform: none;\"><div id=\"div-gpt-ad-1474537762122-3\" data-google-query-id=\"CLSL_tr4gfkCFTq9SwUd2xcE-w\" style=\"margin: 0px; padding: 0px;\"><div id=\"google_ads_iframe_/15188745,22440292294/Lipsum-Unit4_0__container__\" style=\"margin: 0px; padding: 0px; border: 0pt none; width: 160px; height: 600px;\"></div></div></div><div class=\"boxed\" style=\"margin: 10px 28.7969px; padding: 0px; clear: both; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: center; text-transform: none;\"><div id=\"lipsum\" style=\"margin: 0px; padding: 0px; text-align: justify;\"><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vestibulum, velit quis pretium egestas, lorem dui finibus mauris, a lacinia orci quam nec metus. Nam ut dui enim. Vestibulum lorem turpis, dictum sit amet sollicitudin ut, sagittis non massa. Praesent mollis tortor non dapibus porttitor. Nam pretium metus nunc, sit amet placerat tellus semper at. Duis pretium elit eu eros cursus, sit amet aliquam neque rutrum. Nulla facilisi. Phasellus condimentum pharetra enim nec tempor. Mauris non cursus velit. Vestibulum venenatis elementum tellus non condimentum. Curabitur at ultricies arcu. Integer pharetra ante ac magna luctus, sit amet ullamcorper nunc bibendum. Aenean hendrerit consectetur massa ac fringilla. Mauris tristique nulla eu eleifend dignissim. Cras consequat faucibus arcu, non semper velit gravida tincidunt.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Duis quam augue, semper non felis tincidunt, cursus suscipit elit. Curabitur quis iaculis enim. Nulla facilisi. Nam nec orci a mauris condimentum dictum. Maecenas eros diam, aliquet eget lorem eget, aliquam fermentum tortor. Vivamus vehicula mauris est, id rhoncus arcu pellentesque vel. Vestibulum id hendrerit nunc. Sed purus leo, faucibus vitae tincidunt in, auctor sed mi.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Pellentesque risus arcu, luctus in lectus et, finibus eleifend tellus. Praesent mauris ex, consectetur quis egestas vitae, auctor sed libero. Nulla commodo, orci malesuada accumsan vehicula, ex leo tempus magna, id cursus sem dui eget nunc. In fringilla magna quis purus pulvinar varius. Proin non libero lectus. Sed non aliquet purus. Cras cursus ullamcorper eros, et rhoncus odio pharetra ac. Aliquam posuere tellus a accumsan imperdiet. Vivamus tristique erat maximus ornare maximus. In hac habitasse platea dictumst. Praesent at tempor lacus. Donec gravida neque non blandit auctor. Vivamus nec tincidunt lectus.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Nam quis risus mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus vehicula nisi non urna mattis, at vulputate nisi cursus. Aenean in quam eu odio pellentesque imperdiet. Morbi sed nulla non urna tempor gravida. Aenean at vehicula enim. Donec volutpat vulputate mattis.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Morbi placerat, dolor ac mollis tincidunt, erat ligula mattis ligula, et ultricies mi nisi et elit. Curabitur ornare a nunc et fermentum. Suspendisse potenti. Proin vel pulvinar dolor. Nulla justo ante, efficitur a elementum sit amet, egestas fringilla ante. Nulla vitae placerat neque, eget sollicitudin augue. Aliquam quis ante id lacus euismod facilisis non a sapien. Sed vitae ante non justo dignissim venenatis. Quisque maximus eleifend est, vitae malesuada turpis ultrices at. Aliquam pulvinar urna sed dui mollis, a bibendum lectus consequat. Ut condimentum dolor et efficitur lobortis. Morbi tempor tincidunt felis, pretium congue mi. Maecenas finibus, massa vel blandit volutpat, velit nisl finibus elit, id hendrerit tortor tortor nec purus. Sed venenatis, turpis a luctus gravida, odio magna sodales neque, nec consequat odio odio sed libero. Aliquam erat volutpat. Fusce imperdiet, quam vel dignissim dictum, sapien velit convallis risus, vitae porttitor velit ex quis arcu.</p></div></div>', NULL, NULL, '63e38dd64a28a.png', 'https://doctro.saasmonks.in', 10, 'https://doctro.saasmonks.in', 'https://doctro.saasmonks.in', 'https://doctro.saasmonks.in', 'https://doctro.saasmonks.in', 'Browse by Specialities', '<p>Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget.Lorem ipsum dolor sit amet, elit. Euismod habitasse pulvinar faucibus eget.<br></p>', '40.7127281', '-74.0060152', '2021-04-16 07:59:47', '2023-02-08 17:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `settle`
--

CREATE TABLE `settle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_amount` int(11) NOT NULL,
  `admin_amount` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `doctor_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `plan` text DEFAULT NULL,
  `total_appointment` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `name`, `plan`, `total_appointment`, `created_at`, `updated_at`) VALUES
(1, 'basic', '[{\"month\":\"3\",\"price\":\"600\"},{\"month\":\"6\",\"price\":\"800\"}]', 1000, '2021-04-26 01:29:44', '2021-04-26 01:29:44'),
(2, 'Advantager', '[{\"month\":\"6\",\"price\":\"5000\"}]', 5000, '2021-04-26 01:41:37', '2021-04-27 07:44:02'),
(5, 'free', '[{\"month\":null,\"price\":null}]', 500, '2021-05-02 23:09:49', '2021-05-02 23:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `CountryCode` char(2) NOT NULL,
  `Coordinates` char(15) NOT NULL,
  `TimeZone` char(32) NOT NULL,
  `Comments` varchar(85) NOT NULL,
  `UTC_offset` char(8) NOT NULL,
  `UTC_DST_offset` char(8) NOT NULL,
  `Notes` varchar(79) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`CountryCode`, `Coordinates`, `TimeZone`, `Comments`, `UTC_offset`, `UTC_DST_offset`, `Notes`) VALUES
('CI', '+0519-00402', 'Africa/Abidjan', '', '+00:00', '+00:00', ''),
('GH', '+0533-00013', 'Africa/Accra', '', '+00:00', '+00:00', ''),
('ET', '+0902+03842', 'Africa/Addis_Ababa', '', '+03:00', '+03:00', ''),
('DZ', '+3647+00303', 'Africa/Algiers', '', '+01:00', '+01:00', ''),
('ER', '+1520+03853', 'Africa/Asmara', '', '+03:00', '+03:00', ''),
('', '', 'Africa/Asmera', '', '+03:00', '+03:00', 'Link to Africa/Asmara'),
('ML', '+1239-00800', 'Africa/Bamako', '', '+00:00', '+00:00', ''),
('CF', '+0422+01835', 'Africa/Bangui', '', '+01:00', '+01:00', ''),
('GM', '+1328-01639', 'Africa/Banjul', '', '+00:00', '+00:00', ''),
('GW', '+1151-01535', 'Africa/Bissau', '', '+00:00', '+00:00', ''),
('MW', '-1547+03500', 'Africa/Blantyre', '', '+02:00', '+02:00', ''),
('CG', '-0416+01517', 'Africa/Brazzaville', '', '+01:00', '+01:00', ''),
('BI', '-0323+02922', 'Africa/Bujumbura', '', '+02:00', '+02:00', ''),
('EG', '+3003+03115', 'Africa/Cairo', '', '+02:00', '+02:00', 'DST has been canceled since 2011'),
('MA', '+3339-00735', 'Africa/Casablanca', '', '+00:00', '+01:00', ''),
('ES', '+3553-00519', 'Africa/Ceuta', 'Ceuta & Melilla', '+01:00', '+02:00', ''),
('GN', '+0931-01343', 'Africa/Conakry', '', '+00:00', '+00:00', ''),
('SN', '+1440-01726', 'Africa/Dakar', '', '+00:00', '+00:00', ''),
('TZ', '-0648+03917', 'Africa/Dar_es_Salaam', '', '+03:00', '+03:00', ''),
('DJ', '+1136+04309', 'Africa/Djibouti', '', '+03:00', '+03:00', ''),
('CM', '+0403+00942', 'Africa/Douala', '', '+01:00', '+01:00', ''),
('EH', '+2709-01312', 'Africa/El_Aaiun', '', '+00:00', '+00:00', ''),
('SL', '+0830-01315', 'Africa/Freetown', '', '+00:00', '+00:00', ''),
('BW', '-2439+02555', 'Africa/Gaborone', '', '+02:00', '+02:00', ''),
('ZW', '-1750+03103', 'Africa/Harare', '', '+02:00', '+02:00', ''),
('ZA', '-2615+02800', 'Africa/Johannesburg', '', '+02:00', '+02:00', ''),
('SS', '+0451+03136', 'Africa/Juba', '', '+03:00', '+03:00', ''),
('UG', '+0019+03225', 'Africa/Kampala', '', '+03:00', '+03:00', ''),
('SD', '+1536+03232', 'Africa/Khartoum', '', '+03:00', '+03:00', ''),
('RW', '-0157+03004', 'Africa/Kigali', '', '+02:00', '+02:00', ''),
('CD', '-0418+01518', 'Africa/Kinshasa', 'west Dem. Rep. of Congo', '+01:00', '+01:00', ''),
('NG', '+0627+00324', 'Africa/Lagos', '', '+01:00', '+01:00', ''),
('GA', '+0023+00927', 'Africa/Libreville', '', '+01:00', '+01:00', ''),
('TG', '+0608+00113', 'Africa/Lome', '', '+00:00', '+00:00', ''),
('AO', '-0848+01314', 'Africa/Luanda', '', '+01:00', '+01:00', ''),
('CD', '-1140+02728', 'Africa/Lubumbashi', 'east Dem. Rep. of Congo', '+02:00', '+02:00', ''),
('ZM', '-1525+02817', 'Africa/Lusaka', '', '+02:00', '+02:00', ''),
('GQ', '+0345+00847', 'Africa/Malabo', '', '+01:00', '+01:00', ''),
('MZ', '-2558+03235', 'Africa/Maputo', '', '+02:00', '+02:00', ''),
('LS', '-2928+02730', 'Africa/Maseru', '', '+02:00', '+02:00', ''),
('SZ', '-2618+03106', 'Africa/Mbabane', '', '+02:00', '+02:00', ''),
('SO', '+0204+04522', 'Africa/Mogadishu', '', '+03:00', '+03:00', ''),
('LR', '+0618-01047', 'Africa/Monrovia', '', '+00:00', '+00:00', ''),
('KE', '-0117+03649', 'Africa/Nairobi', '', '+03:00', '+03:00', ''),
('TD', '+1207+01503', 'Africa/Ndjamena', '', '+01:00', '+01:00', ''),
('NE', '+1331+00207', 'Africa/Niamey', '', '+01:00', '+01:00', ''),
('MR', '+1806-01557', 'Africa/Nouakchott', '', '+00:00', '+00:00', ''),
('BF', '+1222-00131', 'Africa/Ouagadougou', '', '+00:00', '+00:00', ''),
('BJ', '+0629+00237', 'Africa/Porto-Novo', '', '+01:00', '+01:00', ''),
('ST', '+0020+00644', 'Africa/Sao_Tome', '', '+00:00', '+00:00', ''),
('', '', 'Africa/Timbuktu', '', '+00:00', '+00:00', 'Link to Africa/Bamako'),
('LY', '+3254+01311', 'Africa/Tripoli', '', '+01:00', '+02:00', ''),
('TN', '+3648+01011', 'Africa/Tunis', '', '+01:00', '+01:00', ''),
('NA', '-2234+01706', 'Africa/Windhoek', '', '+01:00', '+02:00', ''),
('', '', 'AKST9AKDT', '', 'âˆ’09:00', 'âˆ’08:00', 'Link to America/Anchorage'),
('US', '+515248-1763929', 'America/Adak', 'Aleutian Islands', 'âˆ’10:00', 'âˆ’09:00', ''),
('US', '+611305-1495401', 'America/Anchorage', 'Alaska Time', 'âˆ’09:00', 'âˆ’08:00', ''),
('AI', '+1812-06304', 'America/Anguilla', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('AG', '+1703-06148', 'America/Antigua', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('BR', '-0712-04812', 'America/Araguaina', 'Tocantins', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-3436-05827', 'America/Argentina/Buenos_Aires', 'Buenos Aires (BA, CF)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-2828-06547', 'America/Argentina/Catamarca', 'Catamarca (CT), Chubut (CH)', 'âˆ’03:00', 'âˆ’03:00', ''),
('', '', 'America/Argentina/ComodRivadavia', '', 'âˆ’03:00', 'âˆ’03:00', 'Link to America/Argentina/Catamarca'),
('AR', '-3124-06411', 'America/Argentina/Cordoba', 'most locations (CB, CC, CN, ER, FM, MN, SE, SF)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-2411-06518', 'America/Argentina/Jujuy', 'Jujuy (JY)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-2926-06651', 'America/Argentina/La_Rioja', 'La Rioja (LR)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-3253-06849', 'America/Argentina/Mendoza', 'Mendoza (MZ)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-5138-06913', 'America/Argentina/Rio_Gallegos', 'Santa Cruz (SC)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-2447-06525', 'America/Argentina/Salta', '(SA, LP, NQ, RN)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-3132-06831', 'America/Argentina/San_Juan', 'San Juan (SJ)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-3319-06621', 'America/Argentina/San_Luis', 'San Luis (SL)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-2649-06513', 'America/Argentina/Tucuman', 'Tucuman (TM)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AR', '-5448-06818', 'America/Argentina/Ushuaia', 'Tierra del Fuego (TF)', 'âˆ’03:00', 'âˆ’03:00', ''),
('AW', '+1230-06958', 'America/Aruba', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('PY', '-2516-05740', 'America/Asuncion', '', 'âˆ’04:00', 'âˆ’03:00', ''),
('CA', '+484531-0913718', 'America/Atikokan', 'Eastern Standard Time - Atikokan, Ontario and Southampton I, Nunavut', 'âˆ’05:00', 'âˆ’05:00', ''),
('', '', 'America/Atka', '', 'âˆ’10:00', 'âˆ’09:00', 'Link to America/Adak'),
('BR', '-1259-03831', 'America/Bahia', 'Bahia', 'âˆ’03:00', 'âˆ’03:00', ''),
('MX', '+2048-10515', 'America/Bahia_Banderas', 'Mexican Central Time - Bahia de Banderas', 'âˆ’06:00', 'âˆ’05:00', ''),
('BB', '+1306-05937', 'America/Barbados', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('BR', '-0127-04829', 'America/Belem', 'Amapa, E Para', 'âˆ’03:00', 'âˆ’03:00', ''),
('BZ', '+1730-08812', 'America/Belize', '', 'âˆ’06:00', 'âˆ’06:00', ''),
('CA', '+5125-05707', 'America/Blanc-Sablon', 'Atlantic Standard Time - Quebec - Lower North Shore', 'âˆ’04:00', 'âˆ’04:00', ''),
('BR', '+0249-06040', 'America/Boa_Vista', 'Roraima', 'âˆ’04:00', 'âˆ’04:00', ''),
('CO', '+0436-07405', 'America/Bogota', '', 'âˆ’05:00', 'âˆ’05:00', ''),
('US', '+433649-1161209', 'America/Boise', 'Mountain Time - south Idaho & east Oregon', 'âˆ’07:00', 'âˆ’06:00', ''),
('', '', 'America/Buenos_Aires', '', 'âˆ’03:00', 'âˆ’03:00', 'Link to America/Argentina/Buenos_Aires'),
('CA', '+690650-1050310', 'America/Cambridge_Bay', 'Mountain Time - west Nunavut', 'âˆ’07:00', 'âˆ’06:00', ''),
('BR', '-2027-05437', 'America/Campo_Grande', 'Mato Grosso do Sul', 'âˆ’04:00', 'âˆ’03:00', ''),
('MX', '+2105-08646', 'America/Cancun', 'Central Time - Quintana Roo', 'âˆ’06:00', 'âˆ’05:00', ''),
('VE', '+1030-06656', 'America/Caracas', '', 'âˆ’04:30', 'âˆ’04:30', ''),
('', '', 'America/Catamarca', '', 'âˆ’03:00', 'âˆ’03:00', 'Link to America/Argentina/Catamarca'),
('GF', '+0456-05220', 'America/Cayenne', '', 'âˆ’03:00', 'âˆ’03:00', ''),
('KY', '+1918-08123', 'America/Cayman', '', 'âˆ’05:00', 'âˆ’05:00', ''),
('US', '+415100-0873900', 'America/Chicago', 'Central Time', 'âˆ’06:00', 'âˆ’05:00', ''),
('MX', '+2838-10605', 'America/Chihuahua', 'Mexican Mountain Time - Chihuahua away from US border', 'âˆ’07:00', 'âˆ’06:00', ''),
('', '', 'America/Coral_Harbour', '', 'âˆ’05:00', 'âˆ’05:00', 'Link to America/Atikokan'),
('', '', 'America/Cordoba', '', 'âˆ’03:00', 'âˆ’03:00', 'Link to America/Argentina/Cordoba'),
('CR', '+0956-08405', 'America/Costa_Rica', '', 'âˆ’06:00', 'âˆ’06:00', ''),
('CA', '+4906-11631', 'America/Creston', 'Mountain Standard Time - Creston, British Columbia', 'âˆ’07:00', 'âˆ’07:00', ''),
('BR', '-1535-05605', 'America/Cuiaba', 'Mato Grosso', 'âˆ’04:00', 'âˆ’03:00', ''),
('CW', '+1211-06900', 'America/Curacao', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('GL', '+7646-01840', 'America/Danmarkshavn', 'east coast, north of Scoresbysund', '+00:00', '+00:00', ''),
('CA', '+6404-13925', 'America/Dawson', 'Pacific Time - north Yukon', 'âˆ’08:00', 'âˆ’07:00', ''),
('CA', '+5946-12014', 'America/Dawson_Creek', 'Mountain Standard Time - Dawson Creek & Fort Saint John, British Columbia', 'âˆ’07:00', 'âˆ’07:00', ''),
('US', '+394421-1045903', 'America/Denver', 'Mountain Time', 'âˆ’07:00', 'âˆ’06:00', ''),
('US', '+421953-0830245', 'America/Detroit', 'Eastern Time - Michigan - most locations', 'âˆ’05:00', 'âˆ’04:00', ''),
('DM', '+1518-06124', 'America/Dominica', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('CA', '+5333-11328', 'America/Edmonton', 'Mountain Time - Alberta, east British Columbia & west Saskatchewan', 'âˆ’07:00', 'âˆ’06:00', ''),
('BR', '-0640-06952', 'America/Eirunepe', 'W Amazonas', 'âˆ’04:00', 'âˆ’04:00', ''),
('SV', '+1342-08912', 'America/El_Salvador', '', 'âˆ’06:00', 'âˆ’06:00', ''),
('', '', 'America/Ensenada', '', 'âˆ’08:00', 'âˆ’07:00', 'Link to America/Tijuana'),
('BR', '-0343-03830', 'America/Fortaleza', 'NE Brazil (MA, PI, CE, RN, PB)', 'âˆ’03:00', 'âˆ’03:00', ''),
('', '', 'America/Fort_Wayne', '', 'âˆ’05:00', 'âˆ’04:00', 'Link to America/Indiana/Indianapolis'),
('CA', '+4612-05957', 'America/Glace_Bay', 'Atlantic Time - Nova Scotia - places that did not observe DST 1966-1971', 'âˆ’04:00', 'âˆ’03:00', ''),
('GL', '+6411-05144', 'America/Godthab', 'most locations', 'âˆ’03:00', 'âˆ’02:00', ''),
('CA', '+5320-06025', 'America/Goose_Bay', 'Atlantic Time - Labrador - most locations', 'âˆ’04:00', 'âˆ’03:00', ''),
('TC', '+2128-07108', 'America/Grand_Turk', '', 'âˆ’05:00', 'âˆ’04:00', ''),
('GD', '+1203-06145', 'America/Grenada', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('GP', '+1614-06132', 'America/Guadeloupe', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('GT', '+1438-09031', 'America/Guatemala', '', 'âˆ’06:00', 'âˆ’06:00', ''),
('EC', '-0210-07950', 'America/Guayaquil', 'mainland', 'âˆ’05:00', 'âˆ’05:00', ''),
('GY', '+0648-05810', 'America/Guyana', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('CA', '+4439-06336', 'America/Halifax', 'Atlantic Time - Nova Scotia (most places), PEI', 'âˆ’04:00', 'âˆ’03:00', ''),
('CU', '+2308-08222', 'America/Havana', '', 'âˆ’05:00', 'âˆ’04:00', ''),
('MX', '+2904-11058', 'America/Hermosillo', 'Mountain Standard Time - Sonora', 'âˆ’07:00', 'âˆ’07:00', ''),
('US', '+394606-0860929', 'America/Indiana/Indianapolis', 'Eastern Time - Indiana - most locations', 'âˆ’05:00', 'âˆ’04:00', ''),
('US', '+411745-0863730', 'America/Indiana/Knox', 'Central Time - Indiana - Starke County', 'âˆ’06:00', 'âˆ’05:00', ''),
('US', '+382232-0862041', 'America/Indiana/Marengo', 'Eastern Time - Indiana - Crawford County', 'âˆ’05:00', 'âˆ’04:00', ''),
('US', '+382931-0871643', 'America/Indiana/Petersburg', 'Eastern Time - Indiana - Pike County', 'âˆ’05:00', 'âˆ’04:00', ''),
('US', '+375711-0864541', 'America/Indiana/Tell_City', 'Central Time - Indiana - Perry County', 'âˆ’06:00', 'âˆ’05:00', ''),
('US', '+384452-0850402', 'America/Indiana/Vevay', 'Eastern Time - Indiana - Switzerland County', 'âˆ’05:00', 'âˆ’04:00', ''),
('US', '+384038-0873143', 'America/Indiana/Vincennes', 'Eastern Time - Indiana - Daviess, Dubois, Knox & Martin Counties', 'âˆ’05:00', 'âˆ’04:00', ''),
('US', '+410305-0863611', 'America/Indiana/Winamac', 'Eastern Time - Indiana - Pulaski County', 'âˆ’05:00', 'âˆ’04:00', ''),
('', '', 'America/Indianapolis', '', 'âˆ’05:00', 'âˆ’04:00', 'Link to America/Indiana/Indianapolis'),
('CA', '+682059-1334300', 'America/Inuvik', 'Mountain Time - west Northwest Territories', 'âˆ’07:00', 'âˆ’06:00', ''),
('CA', '+6344-06828', 'America/Iqaluit', 'Eastern Time - east Nunavut - most locations', 'âˆ’05:00', 'âˆ’04:00', ''),
('JM', '+1800-07648', 'America/Jamaica', '', 'âˆ’05:00', 'âˆ’05:00', ''),
('', '', 'America/Jujuy', '', 'âˆ’03:00', 'âˆ’03:00', 'Link to America/Argentina/Jujuy'),
('US', '+581807-1342511', 'America/Juneau', 'Alaska Time - Alaska panhandle', 'âˆ’09:00', 'âˆ’08:00', ''),
('US', '+381515-0854534', 'America/Kentucky/Louisville', 'Eastern Time - Kentucky - Louisville area', 'âˆ’05:00', 'âˆ’04:00', ''),
('US', '+364947-0845057', 'America/Kentucky/Monticello', 'Eastern Time - Kentucky - Wayne County', 'âˆ’05:00', 'âˆ’04:00', ''),
('', '', 'America/Knox_IN', '', 'âˆ’06:00', 'âˆ’05:00', 'Link to America/Indiana/Knox'),
('BQ', '+120903-0681636', 'America/Kralendijk', '', 'âˆ’04:00', 'âˆ’04:00', 'Link to America/Curacao'),
('BO', '-1630-06809', 'America/La_Paz', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('PE', '-1203-07703', 'America/Lima', '', 'âˆ’05:00', 'âˆ’05:00', ''),
('US', '+340308-1181434', 'America/Los_Angeles', 'Pacific Time', 'âˆ’08:00', 'âˆ’07:00', ''),
('', '', 'America/Louisville', '', 'âˆ’05:00', 'âˆ’04:00', 'Link to America/Kentucky/Louisville'),
('SX', '+180305-0630250', 'America/Lower_Princes', '', 'âˆ’04:00', 'âˆ’04:00', 'Link to America/Curacao'),
('BR', '-0940-03543', 'America/Maceio', 'Alagoas, Sergipe', 'âˆ’03:00', 'âˆ’03:00', ''),
('NI', '+1209-08617', 'America/Managua', '', 'âˆ’06:00', 'âˆ’06:00', ''),
('BR', '-0308-06001', 'America/Manaus', 'E Amazonas', 'âˆ’04:00', 'âˆ’04:00', ''),
('MF', '+1804-06305', 'America/Marigot', '', 'âˆ’04:00', 'âˆ’04:00', 'Link to America/Guadeloupe'),
('MQ', '+1436-06105', 'America/Martinique', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('MX', '+2550-09730', 'America/Matamoros', 'US Central Time - Coahuila, Durango, Nuevo LeÃ³n, Tamaulipas near US border', 'âˆ’06:00', 'âˆ’05:00', ''),
('MX', '+2313-10625', 'America/Mazatlan', 'Mountain Time - S Baja, Nayarit, Sinaloa', 'âˆ’07:00', 'âˆ’06:00', ''),
('', '', 'America/Mendoza', '', 'âˆ’03:00', 'âˆ’03:00', 'Link to America/Argentina/Mendoza'),
('US', '+450628-0873651', 'America/Menominee', 'Central Time - Michigan - Dickinson, Gogebic, Iron & Menominee Counties', 'âˆ’06:00', 'âˆ’05:00', ''),
('MX', '+2058-08937', 'America/Merida', 'Central Time - Campeche, YucatÃ¡n', 'âˆ’06:00', 'âˆ’05:00', ''),
('US', '+550737-1313435', 'America/Metlakatla', 'Metlakatla Time - Annette Island', 'âˆ’08:00', 'âˆ’08:00', ''),
('MX', '+1924-09909', 'America/Mexico_City', 'Central Time - most locations', 'âˆ’06:00', 'âˆ’05:00', ''),
('PM', '+4703-05620', 'America/Miquelon', '', 'âˆ’03:00', 'âˆ’02:00', ''),
('CA', '+4606-06447', 'America/Moncton', 'Atlantic Time - New Brunswick', 'âˆ’04:00', 'âˆ’03:00', ''),
('MX', '+2540-10019', 'America/Monterrey', 'Mexican Central Time - Coahuila, Durango, Nuevo LeÃ³n, Tamaulipas away from US border', 'âˆ’06:00', 'âˆ’05:00', ''),
('UY', '-3453-05611', 'America/Montevideo', '', 'âˆ’03:00', 'âˆ’02:00', ''),
('CA', '+4531-07334', 'America/Montreal', 'Eastern Time - Quebec - most locations', 'âˆ’05:00', 'âˆ’04:00', ''),
('MS', '+1643-06213', 'America/Montserrat', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('BS', '+2505-07721', 'America/Nassau', '', 'âˆ’05:00', 'âˆ’04:00', ''),
('US', '+404251-0740023', 'America/New_York', 'Eastern Time', 'âˆ’05:00', 'âˆ’04:00', ''),
('CA', '+4901-08816', 'America/Nipigon', 'Eastern Time - Ontario & Quebec - places that did not observe DST 1967-1973', 'âˆ’05:00', 'âˆ’04:00', ''),
('US', '+643004-1652423', 'America/Nome', 'Alaska Time - west Alaska', 'âˆ’09:00', 'âˆ’08:00', ''),
('BR', '-0351-03225', 'America/Noronha', 'Atlantic islands', 'âˆ’02:00', 'âˆ’02:00', ''),
('US', '+471551-1014640', 'America/North_Dakota/Beulah', 'Central Time - North Dakota - Mercer County', 'âˆ’06:00', 'âˆ’05:00', ''),
('US', '+470659-1011757', 'America/North_Dakota/Center', 'Central Time - North Dakota - Oliver County', 'âˆ’06:00', 'âˆ’05:00', ''),
('US', '+465042-1012439', 'America/North_Dakota/New_Salem', 'Central Time - North Dakota - Morton County (except Mandan area)', 'âˆ’06:00', 'âˆ’05:00', ''),
('MX', '+2934-10425', 'America/Ojinaga', 'US Mountain Time - Chihuahua near US border', 'âˆ’07:00', 'âˆ’06:00', ''),
('PA', '+0858-07932', 'America/Panama', '', 'âˆ’05:00', 'âˆ’05:00', ''),
('CA', '+6608-06544', 'America/Pangnirtung', 'Eastern Time - Pangnirtung, Nunavut', 'âˆ’05:00', 'âˆ’04:00', ''),
('SR', '+0550-05510', 'America/Paramaribo', '', 'âˆ’03:00', 'âˆ’03:00', ''),
('US', '+332654-1120424', 'America/Phoenix', 'Mountain Standard Time - Arizona', 'âˆ’07:00', 'âˆ’07:00', ''),
('HT', '+1832-07220', 'America/Port-au-Prince', '', 'âˆ’05:00', 'âˆ’04:00', ''),
('', '', 'America/Porto_Acre', '', 'âˆ’04:00', 'âˆ’04:00', 'Link to America/Rio_Branco'),
('BR', '-0846-06354', 'America/Porto_Velho', 'Rondonia', 'âˆ’04:00', 'âˆ’04:00', ''),
('TT', '+1039-06131', 'America/Port_of_Spain', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('PR', '+182806-0660622', 'America/Puerto_Rico', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('CA', '+4843-09434', 'America/Rainy_River', 'Central Time - Rainy River & Fort Frances, Ontario', 'âˆ’06:00', 'âˆ’05:00', ''),
('CA', '+624900-0920459', 'America/Rankin_Inlet', 'Central Time - central Nunavut', 'âˆ’06:00', 'âˆ’05:00', ''),
('BR', '-0803-03454', 'America/Recife', 'Pernambuco', 'âˆ’03:00', 'âˆ’03:00', ''),
('CA', '+5024-10439', 'America/Regina', 'Central Standard Time - Saskatchewan - most locations', 'âˆ’06:00', 'âˆ’06:00', ''),
('CA', '+744144-0944945', 'America/Resolute', 'Central Standard Time - Resolute, Nunavut', 'âˆ’06:00', 'âˆ’05:00', ''),
('BR', '-0958-06748', 'America/Rio_Branco', 'Acre', 'âˆ’04:00', 'âˆ’04:00', ''),
('', '', 'America/Rosario', '', 'âˆ’03:00', 'âˆ’03:00', 'Link to America/Argentina/Cordoba'),
('BR', '-0226-05452', 'America/Santarem', 'W Para', 'âˆ’03:00', 'âˆ’03:00', ''),
('MX', '+3018-11452', 'America/Santa_Isabel', 'Mexican Pacific Time - Baja California away from US border', 'âˆ’08:00', 'âˆ’07:00', ''),
('CL', '-3327-07040', 'America/Santiago', 'most locations', 'âˆ’04:00', 'âˆ’03:00', ''),
('DO', '+1828-06954', 'America/Santo_Domingo', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('BR', '-2332-04637', 'America/Sao_Paulo', 'S & SE Brazil (GO, DF, MG, ES, RJ, SP, PR, SC, RS)', 'âˆ’03:00', 'âˆ’02:00', ''),
('GL', '+7029-02158', 'America/Scoresbysund', 'Scoresbysund / Ittoqqortoormiit', 'âˆ’01:00', '+00:00', ''),
('US', '+364708-1084111', 'America/Shiprock', 'Mountain Time - Navajo', 'âˆ’07:00', 'âˆ’06:00', 'Link to America/Denver'),
('US', '+571035-1351807', 'America/Sitka', 'Alaska Time - southeast Alaska panhandle', 'âˆ’09:00', 'âˆ’08:00', ''),
('BL', '+1753-06251', 'America/St_Barthelemy', '', 'âˆ’04:00', 'âˆ’04:00', 'Link to America/Guadeloupe'),
('CA', '+4734-05243', 'America/St_Johns', 'Newfoundland Time, including SE Labrador', 'âˆ’03:30', 'âˆ’02:30', ''),
('KN', '+1718-06243', 'America/St_Kitts', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('LC', '+1401-06100', 'America/St_Lucia', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('VI', '+1821-06456', 'America/St_Thomas', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('VC', '+1309-06114', 'America/St_Vincent', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('CA', '+5017-10750', 'America/Swift_Current', 'Central Standard Time - Saskatchewan - midwest', 'âˆ’06:00', 'âˆ’06:00', ''),
('HN', '+1406-08713', 'America/Tegucigalpa', '', 'âˆ’06:00', 'âˆ’06:00', ''),
('GL', '+7634-06847', 'America/Thule', 'Thule / Pituffik', 'âˆ’04:00', 'âˆ’03:00', ''),
('CA', '+4823-08915', 'America/Thunder_Bay', 'Eastern Time - Thunder Bay, Ontario', 'âˆ’05:00', 'âˆ’04:00', ''),
('MX', '+3232-11701', 'America/Tijuana', 'US Pacific Time - Baja California near US border', 'âˆ’08:00', 'âˆ’07:00', ''),
('CA', '+4339-07923', 'America/Toronto', 'Eastern Time - Ontario - most locations', 'âˆ’05:00', 'âˆ’04:00', ''),
('VG', '+1827-06437', 'America/Tortola', '', 'âˆ’04:00', 'âˆ’04:00', ''),
('CA', '+4916-12307', 'America/Vancouver', 'Pacific Time - west British Columbia', 'âˆ’08:00', 'âˆ’07:00', ''),
('', '', 'America/Virgin', '', 'âˆ’04:00', 'âˆ’04:00', 'Link to America/St_Thomas'),
('CA', '+6043-13503', 'America/Whitehorse', 'Pacific Time - south Yukon', 'âˆ’08:00', 'âˆ’07:00', ''),
('CA', '+4953-09709', 'America/Winnipeg', 'Central Time - Manitoba & west Ontario', 'âˆ’06:00', 'âˆ’05:00', ''),
('US', '+593249-1394338', 'America/Yakutat', 'Alaska Time - Alaska panhandle neck', 'âˆ’09:00', 'âˆ’08:00', ''),
('CA', '+6227-11421', 'America/Yellowknife', 'Mountain Time - central Northwest Territories', 'âˆ’07:00', 'âˆ’06:00', ''),
('AQ', '-6617+11031', 'Antarctica/Casey', 'Casey Station, Bailey Peninsula', '+11:00', '+08:00', ''),
('AQ', '-6835+07758', 'Antarctica/Davis', 'Davis Station, Vestfold Hills', '+05:00', '+07:00', ''),
('AQ', '-6640+14001', 'Antarctica/DumontDUrville', 'Dumont-dUrville Station, Terre Adelie', '+10:00', '+10:00', ''),
('AQ', '-5430+15857', 'Antarctica/Macquarie', 'Macquarie Island Station, Macquarie Island', '+11:00', '+11:00', ''),
('AQ', '-6736+06253', 'Antarctica/Mawson', 'Mawson Station, Holme Bay', '+05:00', '+05:00', ''),
('AQ', '-7750+16636', 'Antarctica/McMurdo', 'McMurdo Station, Ross Island', '+12:00', '+13:00', ''),
('AQ', '-6448-06406', 'Antarctica/Palmer', 'Palmer Station, Anvers Island', 'âˆ’04:00', 'âˆ’03:00', ''),
('AQ', '-6734-06808', 'Antarctica/Rothera', 'Rothera Station, Adelaide Island', 'âˆ’03:00', 'âˆ’03:00', ''),
('AQ', '-9000+00000', 'Antarctica/South_Pole', 'Amundsen-Scott Station, South Pole', '+12:00', '+13:00', 'Link to Antarctica/McMurdo'),
('AQ', '-690022+0393524', 'Antarctica/Syowa', 'Syowa Station, E Ongul I', '+03:00', '+03:00', ''),
('AQ', '-7824+10654', 'Antarctica/Vostok', 'Vostok Station, Lake Vostok', '+06:00', '+06:00', ''),
('SJ', '+7800+01600', 'Arctic/Longyearbyen', '', '+01:00', '+02:00', 'Link to Europe/Oslo'),
('YE', '+1245+04512', 'Asia/Aden', '', '+03:00', '+03:00', ''),
('KZ', '+4315+07657', 'Asia/Almaty', 'most locations', '+06:00', '+06:00', ''),
('JO', '+3157+03556', 'Asia/Amman', '', '+03:00', '+03:00', ''),
('RU', '+6445+17729', 'Asia/Anadyr', 'Moscow+08 - Bering Sea', '+12:00', '+12:00', ''),
('KZ', '+4431+05016', 'Asia/Aqtau', 'Atyrau (Atirau, Guryev), Mangghystau (Mankistau)', '+05:00', '+05:00', ''),
('KZ', '+5017+05710', 'Asia/Aqtobe', 'Aqtobe (Aktobe)', '+05:00', '+05:00', ''),
('TM', '+3757+05823', 'Asia/Ashgabat', '', '+05:00', '+05:00', ''),
('', '', 'Asia/Ashkhabad', '', '+05:00', '+05:00', 'Link to Asia/Ashgabat'),
('IQ', '+3321+04425', 'Asia/Baghdad', '', '+03:00', '+03:00', ''),
('BH', '+2623+05035', 'Asia/Bahrain', '', '+03:00', '+03:00', ''),
('AZ', '+4023+04951', 'Asia/Baku', '', '+04:00', '+05:00', ''),
('TH', '+1345+10031', 'Asia/Bangkok', '', '+07:00', '+07:00', ''),
('LB', '+3353+03530', 'Asia/Beirut', '', '+02:00', '+03:00', ''),
('KG', '+4254+07436', 'Asia/Bishkek', '', '+06:00', '+06:00', ''),
('BN', '+0456+11455', 'Asia/Brunei', '', '+08:00', '+08:00', ''),
('', '', 'Asia/Calcutta', '', '+05:30', '+05:30', 'Link to Asia/Kolkata'),
('MN', '+4804+11430', 'Asia/Choibalsan', 'Dornod, Sukhbaatar', '+08:00', '+08:00', ''),
('CN', '+2934+10635', 'Asia/Chongqing', 'central China - Sichuan, Yunnan, Guangxi, Shaanxi, Guizhou, etc.', '+08:00', '+08:00', 'Covering historic Kansu-Szechuan time zone.'),
('', '', 'Asia/Chungking', '', '+08:00', '+08:00', 'Link to Asia/Chongqing'),
('LK', '+0656+07951', 'Asia/Colombo', '', '+05:30', '+05:30', ''),
('', '', 'Asia/Dacca', '', '+06:00', '+06:00', 'Link to Asia/Dhaka'),
('SY', '+3330+03618', 'Asia/Damascus', '', '+02:00', '+03:00', ''),
('BD', '+2343+09025', 'Asia/Dhaka', '', '+06:00', '+06:00', ''),
('TL', '-0833+12535', 'Asia/Dili', '', '+09:00', '+09:00', ''),
('AE', '+2518+05518', 'Asia/Dubai', '', '+04:00', '+04:00', ''),
('TJ', '+3835+06848', 'Asia/Dushanbe', '', '+05:00', '+05:00', ''),
('PS', '+3130+03428', 'Asia/Gaza', 'Gaza Strip', '+02:00', '+03:00', ''),
('CN', '+4545+12641', 'Asia/Harbin', 'Heilongjiang (except Mohe), Jilin', '+08:00', '+08:00', 'Covering historic Changpai time zone.'),
('PS', '+313200+0350542', 'Asia/Hebron', 'West Bank', '+02:00', '+03:00', ''),
('HK', '+2217+11409', 'Asia/Hong_Kong', '', '+08:00', '+08:00', ''),
('MN', '+4801+09139', 'Asia/Hovd', 'Bayan-Olgiy, Govi-Altai, Hovd, Uvs, Zavkhan', '+07:00', '+07:00', ''),
('VN', '+1045+10640', 'Asia/Ho_Chi_Minh', '', '+07:00', '+07:00', ''),
('RU', '+5216+10420', 'Asia/Irkutsk', 'Moscow+05 - Lake Baikal', '+09:00', '+09:00', ''),
('', '', 'Asia/Istanbul', '', '+02:00', '+03:00', 'Link to Europe/Istanbul'),
('ID', '-0610+10648', 'Asia/Jakarta', 'Java & Sumatra', '+07:00', '+07:00', ''),
('ID', '-0232+14042', 'Asia/Jayapura', 'west New Guinea (Irian Jaya) & Malukus (Moluccas)', '+09:00', '+09:00', ''),
('IL', '+3146+03514', 'Asia/Jerusalem', '', '+02:00', '+03:00', ''),
('AF', '+3431+06912', 'Asia/Kabul', '', '+04:30', '+04:30', ''),
('RU', '+5301+15839', 'Asia/Kamchatka', 'Moscow+08 - Kamchatka', '+12:00', '+12:00', ''),
('PK', '+2452+06703', 'Asia/Karachi', '', '+05:00', '+05:00', ''),
('CN', '+3929+07559', 'Asia/Kashgar', 'west Tibet & Xinjiang', '+08:00', '+08:00', 'Covering historic Kunlun time zone.'),
('NP', '+2743+08519', 'Asia/Kathmandu', '', '+05:45', '+05:45', ''),
('', '', 'Asia/Katmandu', '', '+05:45', '+05:45', 'Link to Asia/Kathmandu'),
('IN', '+2232+08822', 'Asia/Kolkata', '', '+05:30', '+05:30', 'Note: Different zones in history, see Time in India.'),
('RU', '+5601+09250', 'Asia/Krasnoyarsk', 'Moscow+04 - Yenisei River', '+08:00', '+08:00', ''),
('MY', '+0310+10142', 'Asia/Kuala_Lumpur', 'peninsular Malaysia', '+08:00', '+08:00', ''),
('MY', '+0133+11020', 'Asia/Kuching', 'Sabah & Sarawak', '+08:00', '+08:00', ''),
('KW', '+2920+04759', 'Asia/Kuwait', '', '+03:00', '+03:00', ''),
('', '', 'Asia/Macao', '', '+08:00', '+08:00', 'Link to Asia/Macau'),
('MO', '+2214+11335', 'Asia/Macau', '', '+08:00', '+08:00', ''),
('RU', '+5934+15048', 'Asia/Magadan', 'Moscow+08 - Magadan', '+12:00', '+12:00', ''),
('ID', '-0507+11924', 'Asia/Makassar', 'east & south Borneo, Sulawesi (Celebes), Bali, Nusa Tenggara, west Timor', '+08:00', '+08:00', ''),
('PH', '+1435+12100', 'Asia/Manila', '', '+08:00', '+08:00', ''),
('OM', '+2336+05835', 'Asia/Muscat', '', '+04:00', '+04:00', ''),
('CY', '+3510+03322', 'Asia/Nicosia', '', '+02:00', '+03:00', ''),
('RU', '+5345+08707', 'Asia/Novokuznetsk', 'Moscow+03 - Novokuznetsk', '+07:00', '+07:00', ''),
('RU', '+5502+08255', 'Asia/Novosibirsk', 'Moscow+03 - Novosibirsk', '+07:00', '+07:00', ''),
('RU', '+5500+07324', 'Asia/Omsk', 'Moscow+03 - west Siberia', '+07:00', '+07:00', ''),
('KZ', '+5113+05121', 'Asia/Oral', 'West Kazakhstan', '+05:00', '+05:00', ''),
('KH', '+1133+10455', 'Asia/Phnom_Penh', '', '+07:00', '+07:00', ''),
('ID', '-0002+10920', 'Asia/Pontianak', 'west & central Borneo', '+07:00', '+07:00', ''),
('KP', '+3901+12545', 'Asia/Pyongyang', '', '+09:00', '+09:00', ''),
('QA', '+2517+05132', 'Asia/Qatar', '', '+03:00', '+03:00', ''),
('KZ', '+4448+06528', 'Asia/Qyzylorda', 'Qyzylorda (Kyzylorda, Kzyl-Orda)', '+06:00', '+06:00', ''),
('MM', '+1647+09610', 'Asia/Rangoon', '', '+06:30', '+06:30', ''),
('SA', '+2438+04643', 'Asia/Riyadh', '', '+03:00', '+03:00', ''),
('', '', 'Asia/Saigon', '', '+07:00', '+07:00', 'Link to Asia/Ho_Chi_Minh'),
('RU', '+4658+14242', 'Asia/Sakhalin', 'Moscow+07 - Sakhalin Island', '+11:00', '+11:00', ''),
('UZ', '+3940+06648', 'Asia/Samarkand', 'west Uzbekistan', '+05:00', '+05:00', ''),
('KR', '+3733+12658', 'Asia/Seoul', '', '+09:00', '+09:00', ''),
('CN', '+3114+12128', 'Asia/Shanghai', 'east China - Beijing, Guangdong, Shanghai, etc.', '+08:00', '+08:00', 'Covering historic Chungyuan time zone.'),
('SG', '+0117+10351', 'Asia/Singapore', '', '+08:00', '+08:00', ''),
('TW', '+2503+12130', 'Asia/Taipei', '', '+08:00', '+08:00', ''),
('UZ', '+4120+06918', 'Asia/Tashkent', 'east Uzbekistan', '+05:00', '+05:00', ''),
('GE', '+4143+04449', 'Asia/Tbilisi', '', '+04:00', '+04:00', ''),
('IR', '+3540+05126', 'Asia/Tehran', '', '+03:30', '+04:30', ''),
('', '', 'Asia/Tel_Aviv', '', '+02:00', '+03:00', 'Link to Asia/Jerusalem'),
('', '', 'Asia/Thimbu', '', '+06:00', '+06:00', 'Link to Asia/Thimphu'),
('BT', '+2728+08939', 'Asia/Thimphu', '', '+06:00', '+06:00', ''),
('JP', '+353916+1394441', 'Asia/Tokyo', '', '+09:00', '+09:00', ''),
('', '', 'Asia/Ujung_Pandang', '', '+08:00', '+08:00', 'Link to Asia/Makassar'),
('MN', '+4755+10653', 'Asia/Ulaanbaatar', 'most locations', '+08:00', '+08:00', ''),
('', '', 'Asia/Ulan_Bator', '', '+08:00', '+08:00', 'Link to Asia/Ulaanbaatar'),
('CN', '+4348+08735', 'Asia/Urumqi', 'most of Tibet & Xinjiang', '+08:00', '+08:00', 'Covering historic Sinkiang-Tibet time zone.'),
('LA', '+1758+10236', 'Asia/Vientiane', '', '+07:00', '+07:00', ''),
('RU', '+4310+13156', 'Asia/Vladivostok', 'Moscow+07 - Amur River', '+11:00', '+11:00', ''),
('RU', '+6200+12940', 'Asia/Yakutsk', 'Moscow+06 - Lena River', '+10:00', '+10:00', ''),
('RU', '+5651+06036', 'Asia/Yekaterinburg', 'Moscow+02 - Urals', '+06:00', '+06:00', ''),
('AM', '+4011+04430', 'Asia/Yerevan', '', '+04:00', '+04:00', ''),
('PT', '+3744-02540', 'Atlantic/Azores', 'Azores', 'âˆ’01:00', '+00:00', ''),
('BM', '+3217-06446', 'Atlantic/Bermuda', '', 'âˆ’04:00', 'âˆ’03:00', ''),
('ES', '+2806-01524', 'Atlantic/Canary', 'Canary Islands', '+00:00', '+01:00', ''),
('CV', '+1455-02331', 'Atlantic/Cape_Verde', '', 'âˆ’01:00', 'âˆ’01:00', ''),
('', '', 'Atlantic/Faeroe', '', '+00:00', '+01:00', 'Link to Atlantic/Faroe'),
('FO', '+6201-00646', 'Atlantic/Faroe', '', '+00:00', '+01:00', ''),
('', '', 'Atlantic/Jan_Mayen', '', '+01:00', '+02:00', 'Link to Europe/Oslo'),
('PT', '+3238-01654', 'Atlantic/Madeira', 'Madeira Islands', '+00:00', '+01:00', ''),
('IS', '+6409-02151', 'Atlantic/Reykjavik', '', '+00:00', '+00:00', ''),
('GS', '-5416-03632', 'Atlantic/South_Georgia', '', 'âˆ’02:00', 'âˆ’02:00', ''),
('FK', '-5142-05751', 'Atlantic/Stanley', '', 'âˆ’03:00', 'âˆ’03:00', ''),
('SH', '-1555-00542', 'Atlantic/St_Helena', '', '+00:00', '+00:00', ''),
('', '', 'Australia/ACT', '', '+10:00', '+11:00', 'Link to Australia/Sydney'),
('AU', '-3455+13835', 'Australia/Adelaide', 'South Australia', '+09:30', '+10:30', ''),
('AU', '-2728+15302', 'Australia/Brisbane', 'Queensland - most locations', '+10:00', '+10:00', ''),
('AU', '-3157+14127', 'Australia/Broken_Hill', 'New South Wales - Yancowinna', '+09:30', '+10:30', ''),
('', '', 'Australia/Canberra', '', '+10:00', '+11:00', 'Link to Australia/Sydney'),
('AU', '-3956+14352', 'Australia/Currie', 'Tasmania - King Island', '+10:00', '+11:00', ''),
('AU', '-1228+13050', 'Australia/Darwin', 'Northern Territory', '+09:30', '+09:30', ''),
('AU', '-3143+12852', 'Australia/Eucla', 'Western Australia - Eucla area', '+08:45', '+08:45', ''),
('AU', '-4253+14719', 'Australia/Hobart', 'Tasmania - most locations', '+10:00', '+11:00', ''),
('', '', 'Australia/LHI', '', '+10:30', '+11:00', 'Link to Australia/Lord_Howe'),
('AU', '-2016+14900', 'Australia/Lindeman', 'Queensland - Holiday Islands', '+10:00', '+10:00', ''),
('AU', '-3133+15905', 'Australia/Lord_Howe', 'Lord Howe Island', '+10:30', '+11:00', ''),
('AU', '-3749+14458', 'Australia/Melbourne', 'Victoria', '+10:00', '+11:00', ''),
('', '', 'Australia/North', '', '+09:30', '+09:30', 'Link to Australia/Darwin'),
('', '', 'Australia/NSW', '', '+10:00', '+11:00', 'Link to Australia/Sydney'),
('AU', '-3157+11551', 'Australia/Perth', 'Western Australia - most locations', '+08:00', '+08:00', ''),
('', '', 'Australia/Queensland', '', '+10:00', '+10:00', 'Link to Australia/Brisbane'),
('', '', 'Australia/South', '', '+09:30', '+10:30', 'Link to Australia/Adelaide'),
('AU', '-3352+15113', 'Australia/Sydney', 'New South Wales - most locations', '+10:00', '+11:00', ''),
('', '', 'Australia/Tasmania', '', '+10:00', '+11:00', 'Link to Australia/Hobart'),
('', '', 'Australia/Victoria', '', '+10:00', '+11:00', 'Link to Australia/Melbourne'),
('', '', 'Australia/West', '', '+08:00', '+08:00', 'Link to Australia/Perth'),
('', '', 'Australia/Yancowinna', '', '+09:30', '+10:30', 'Link to Australia/Broken_Hill'),
('', '', 'Brazil/Acre', '', 'âˆ’04:00', 'âˆ’04:00', 'Link to America/Rio_Branco'),
('', '', 'Brazil/DeNoronha', '', 'âˆ’02:00', 'âˆ’02:00', 'Link to America/Noronha'),
('', '', 'Brazil/East', '', 'âˆ’03:00', 'âˆ’02:00', 'Link to America/Sao_Paulo'),
('', '', 'Brazil/West', '', 'âˆ’04:00', 'âˆ’04:00', 'Link to America/Manaus'),
('', '', 'Canada/Atlantic', '', 'âˆ’04:00', 'âˆ’03:00', 'Link to America/Halifax'),
('', '', 'Canada/Central', '', 'âˆ’06:00', 'âˆ’05:00', 'Link to America/Winnipeg'),
('', '', 'Canada/East-Saskatchewan', '', 'âˆ’06:00', 'âˆ’06:00', 'Link to America/Regina'),
('', '', 'Canada/Eastern', '', 'âˆ’05:00', 'âˆ’04:00', 'Link to America/Toronto'),
('', '', 'Canada/Mountain', '', 'âˆ’07:00', 'âˆ’06:00', 'Link to America/Edmonton'),
('', '', 'Canada/Newfoundland', '', 'âˆ’03:30', 'âˆ’02:30', 'Link to America/St_Johns'),
('', '', 'Canada/Pacific', '', 'âˆ’08:00', 'âˆ’07:00', 'Link to America/Vancouver'),
('', '', 'Canada/Saskatchewan', '', 'âˆ’06:00', 'âˆ’06:00', 'Link to America/Regina'),
('', '', 'Canada/Yukon', '', 'âˆ’08:00', 'âˆ’07:00', 'Link to America/Whitehorse'),
('', '', 'CET', '', '+01:00', '+02:00', ''),
('', '', 'Chile/Continental', '', 'âˆ’04:00', 'âˆ’03:00', 'Link to America/Santiago'),
('', '', 'Chile/EasterIsland', '', 'âˆ’06:00', 'âˆ’05:00', 'Link to Pacific/Easter'),
('', '', 'CST6CDT', '', 'âˆ’06:00', 'âˆ’05:00', ''),
('', '', 'Cuba', '', 'âˆ’05:00', 'âˆ’04:00', 'Link to America/Havana'),
('', '', 'EET', '', '+02:00', '+03:00', ''),
('', '', 'Egypt', '', '+02:00', '+02:00', 'Link to Africa/Cairo'),
('', '', 'Eire', '', '+00:00', '+01:00', 'Link to Europe/Dublin'),
('', '', 'EST', '', 'âˆ’05:00', 'âˆ’05:00', ''),
('', '', 'EST5EDT', '', 'âˆ’05:00', 'âˆ’04:00', ''),
('', '', 'Etc./GMT', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'Etc./GMT+0', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'Etc./UCT', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'Etc./Universal', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'Etc./UTC', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'Etc./Zulu', '', '+00:00', '+00:00', 'Link to UTC'),
('NL', '+5222+00454', 'Europe/Amsterdam', '', '+01:00', '+02:00', ''),
('AD', '+4230+00131', 'Europe/Andorra', '', '+01:00', '+02:00', ''),
('GR', '+3758+02343', 'Europe/Athens', '', '+02:00', '+03:00', ''),
('', '', 'Europe/Belfast', '', '+00:00', '+01:00', 'Link to Europe/London'),
('RS', '+4450+02030', 'Europe/Belgrade', '', '+01:00', '+02:00', ''),
('DE', '+5230+01322', 'Europe/Berlin', '', '+01:00', '+02:00', 'In 1945, the Trizone did not follow Berlins switch to DST, see Time in Germany'),
('SK', '+4809+01707', 'Europe/Bratislava', '', '+01:00', '+02:00', 'Link to Europe/Prague'),
('BE', '+5050+00420', 'Europe/Brussels', '', '+01:00', '+02:00', ''),
('RO', '+4426+02606', 'Europe/Bucharest', '', '+02:00', '+03:00', ''),
('HU', '+4730+01905', 'Europe/Budapest', '', '+01:00', '+02:00', ''),
('MD', '+4700+02850', 'Europe/Chisinau', '', '+02:00', '+03:00', ''),
('DK', '+5540+01235', 'Europe/Copenhagen', '', '+01:00', '+02:00', ''),
('IE', '+5320-00615', 'Europe/Dublin', '', '+00:00', '+01:00', ''),
('GI', '+3608-00521', 'Europe/Gibraltar', '', '+01:00', '+02:00', ''),
('GG', '+4927-00232', 'Europe/Guernsey', '', '+00:00', '+01:00', 'Link to Europe/London'),
('FI', '+6010+02458', 'Europe/Helsinki', '', '+02:00', '+03:00', ''),
('IM', '+5409-00428', 'Europe/Isle_of_Man', '', '+00:00', '+01:00', 'Link to Europe/London'),
('TR', '+4101+02858', 'Europe/Istanbul', '', '+02:00', '+03:00', ''),
('JE', '+4912-00207', 'Europe/Jersey', '', '+00:00', '+01:00', 'Link to Europe/London'),
('RU', '+5443+02030', 'Europe/Kaliningrad', 'Moscow-01 - Kaliningrad', '+03:00', '+03:00', ''),
('UA', '+5026+03031', 'Europe/Kiev', 'most locations', '+02:00', '+03:00', ''),
('PT', '+3843-00908', 'Europe/Lisbon', 'mainland', '+00:00', '+01:00', ''),
('SI', '+4603+01431', 'Europe/Ljubljana', '', '+01:00', '+02:00', 'Link to Europe/Belgrade'),
('GB', '+513030-0000731', 'Europe/London', '', '+00:00', '+01:00', ''),
('LU', '+4936+00609', 'Europe/Luxembourg', '', '+01:00', '+02:00', ''),
('ES', '+4024-00341', 'Europe/Madrid', 'mainland', '+01:00', '+02:00', ''),
('MT', '+3554+01431', 'Europe/Malta', '', '+01:00', '+02:00', ''),
('AX', '+6006+01957', 'Europe/Mariehamn', '', '+02:00', '+03:00', 'Link to Europe/Helsinki'),
('BY', '+5354+02734', 'Europe/Minsk', '', '+03:00', '+03:00', ''),
('MC', '+4342+00723', 'Europe/Monaco', '', '+01:00', '+02:00', ''),
('RU', '+5545+03735', 'Europe/Moscow', 'Moscow+00 - west Russia', '+04:00', '+04:00', ''),
('', '', 'Europe/Nicosia', '', '+02:00', '+03:00', 'Link to Asia/Nicosia'),
('NO', '+5955+01045', 'Europe/Oslo', '', '+01:00', '+02:00', ''),
('FR', '+4852+00220', 'Europe/Paris', '', '+01:00', '+02:00', ''),
('ME', '+4226+01916', 'Europe/Podgorica', '', '+01:00', '+02:00', 'Link to Europe/Belgrade'),
('CZ', '+5005+01426', 'Europe/Prague', '', '+01:00', '+02:00', ''),
('LV', '+5657+02406', 'Europe/Riga', '', '+02:00', '+03:00', ''),
('IT', '+4154+01229', 'Europe/Rome', '', '+01:00', '+02:00', ''),
('RU', '+5312+05009', 'Europe/Samara', 'Moscow+00 - Samara, Udmurtia', '+04:00', '+04:00', ''),
('SM', '+4355+01228', 'Europe/San_Marino', '', '+01:00', '+02:00', 'Link to Europe/Rome'),
('BA', '+4352+01825', 'Europe/Sarajevo', '', '+01:00', '+02:00', 'Link to Europe/Belgrade'),
('UA', '+4457+03406', 'Europe/Simferopol', 'central Crimea', '+02:00', '+03:00', ''),
('MK', '+4159+02126', 'Europe/Skopje', '', '+01:00', '+02:00', 'Link to Europe/Belgrade'),
('BG', '+4241+02319', 'Europe/Sofia', '', '+02:00', '+03:00', ''),
('SE', '+5920+01803', 'Europe/Stockholm', '', '+01:00', '+02:00', ''),
('EE', '+5925+02445', 'Europe/Tallinn', '', '+02:00', '+03:00', ''),
('AL', '+4120+01950', 'Europe/Tirane', '', '+01:00', '+02:00', ''),
('', '', 'Europe/Tiraspol', '', '+02:00', '+03:00', 'Link to Europe/Chisinau'),
('UA', '+4837+02218', 'Europe/Uzhgorod', 'Ruthenia', '+02:00', '+03:00', ''),
('LI', '+4709+00931', 'Europe/Vaduz', '', '+01:00', '+02:00', ''),
('VA', '+415408+0122711', 'Europe/Vatican', '', '+01:00', '+02:00', 'Link to Europe/Rome'),
('AT', '+4813+01620', 'Europe/Vienna', '', '+01:00', '+02:00', ''),
('LT', '+5441+02519', 'Europe/Vilnius', '', '+02:00', '+03:00', ''),
('RU', '+4844+04425', 'Europe/Volgograd', 'Moscow+00 - Caspian Sea', '+04:00', '+04:00', ''),
('PL', '+5215+02100', 'Europe/Warsaw', '', '+01:00', '+02:00', ''),
('HR', '+4548+01558', 'Europe/Zagreb', '', '+01:00', '+02:00', 'Link to Europe/Belgrade'),
('UA', '+4750+03510', 'Europe/Zaporozhye', 'Zaporozhye, E Lugansk / Zaporizhia, E Luhansk', '+02:00', '+03:00', ''),
('CH', '+4723+00832', 'Europe/Zurich', '', '+01:00', '+02:00', ''),
('', '', 'GB', '', '+00:00', '+01:00', 'Link to Europe/London'),
('', '', 'GB-Eire', '', '+00:00', '+01:00', 'Link to Europe/London'),
('', '', 'GMT', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'GMT+0', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'GMT-0', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'GMT0', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'Greenwich', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'Hong Kong', '', '+08:00', '+08:00', 'Link to Asia/Hong_Kong'),
('', '', 'HST', '', 'âˆ’10:00', 'âˆ’10:00', ''),
('', '', 'Iceland', '', '+00:00', '+00:00', 'Link to Atlantic/Reykjavik'),
('MG', '-1855+04731', 'Indian/Antananarivo', '', '+03:00', '+03:00', ''),
('IO', '-0720+07225', 'Indian/Chagos', '', '+06:00', '+06:00', ''),
('CX', '-1025+10543', 'Indian/Christmas', '', '+07:00', '+07:00', ''),
('CC', '-1210+09655', 'Indian/Cocos', '', '+06:30', '+06:30', ''),
('KM', '-1141+04316', 'Indian/Comoro', '', '+03:00', '+03:00', ''),
('TF', '-492110+0701303', 'Indian/Kerguelen', '', '+05:00', '+05:00', ''),
('SC', '-0440+05528', 'Indian/Mahe', '', '+04:00', '+04:00', ''),
('MV', '+0410+07330', 'Indian/Maldives', '', '+05:00', '+05:00', ''),
('MU', '-2010+05730', 'Indian/Mauritius', '', '+04:00', '+04:00', ''),
('YT', '-1247+04514', 'Indian/Mayotte', '', '+03:00', '+03:00', ''),
('RE', '-2052+05528', 'Indian/Reunion', '', '+04:00', '+04:00', ''),
('', '', 'Iran', '', '+03:30', '+04:30', 'Link to Asia/Tehran'),
('', '', 'Israel', '', '+02:00', '+03:00', 'Link to Asia/Jerusalem'),
('', '', 'Jamaica', '', 'âˆ’05:00', 'âˆ’05:00', 'Link to America/Jamaica'),
('', '', 'Japan', '', '+09:00', '+09:00', 'Link to Asia/Tokyo'),
('', '', 'JST-9', '', '+09:00', '+09:00', 'Link to Asia/Tokyo'),
('', '', 'Kwajalein', '', '+12:00', '+12:00', 'Link to Pacific/Kwajalein'),
('', '', 'Libya', '', '+02:00', '+02:00', 'Link to Africa/Tripoli'),
('', '', 'MET', '', '+01:00', '+02:00', ''),
('', '', 'Mexico/BajaNorte', '', 'âˆ’08:00', 'âˆ’07:00', 'Link to America/Tijuana'),
('', '', 'Mexico/BajaSur', '', 'âˆ’07:00', 'âˆ’06:00', 'Link to America/Mazatlan'),
('', '', 'Mexico/General', '', 'âˆ’06:00', 'âˆ’05:00', 'Link to America/Mexico_City'),
('', '', 'MST', '', 'âˆ’07:00', 'âˆ’07:00', ''),
('', '', 'MST7MDT', '', 'âˆ’07:00', 'âˆ’06:00', ''),
('', '', 'Navajo', '', 'âˆ’07:00', 'âˆ’06:00', 'Link to America/Denver'),
('', '', 'NZ', '', '+12:00', '+13:00', 'Link to Pacific/Auckland'),
('', '', 'NZ-CHAT', '', '+12:45', '+13:45', 'Link to Pacific/Chatham'),
('WS', '-1350-17144', 'Pacific/Apia', '', '+13:00', '+14:00', ''),
('NZ', '-3652+17446', 'Pacific/Auckland', 'most locations', '+12:00', '+13:00', ''),
('NZ', '-4357-17633', 'Pacific/Chatham', 'Chatham Islands', '+12:45', '+13:45', ''),
('FM', '+0725+15147', 'Pacific/Chuuk', 'Chuuk (Truk) and Yap', '+10:00', '+10:00', ''),
('CL', '-2709-10926', 'Pacific/Easter', 'Easter Island & Sala y Gomez', 'âˆ’06:00', 'âˆ’05:00', ''),
('VU', '-1740+16825', 'Pacific/Efate', '', '+11:00', '+11:00', ''),
('KI', '-0308-17105', 'Pacific/Enderbury', 'Phoenix Islands', '+13:00', '+13:00', ''),
('TK', '-0922-17114', 'Pacific/Fakaofo', '', '+13:00', '+13:00', ''),
('FJ', '-1808+17825', 'Pacific/Fiji', '', '+12:00', '+13:00', ''),
('TV', '-0831+17913', 'Pacific/Funafuti', '', '+12:00', '+12:00', ''),
('EC', '-0054-08936', 'Pacific/Galapagos', 'Galapagos Islands', 'âˆ’06:00', 'âˆ’06:00', ''),
('PF', '-2308-13457', 'Pacific/Gambier', 'Gambier Islands', 'âˆ’09:00', 'âˆ’09:00', ''),
('SB', '-0932+16012', 'Pacific/Guadalcanal', '', '+11:00', '+11:00', ''),
('GU', '+1328+14445', 'Pacific/Guam', '', '+10:00', '+10:00', ''),
('US', '+211825-1575130', 'Pacific/Honolulu', 'Hawaii', 'âˆ’10:00', 'âˆ’10:00', ''),
('UM', '+1645-16931', 'Pacific/Johnston', 'Johnston Atoll', 'âˆ’10:00', 'âˆ’10:00', ''),
('KI', '+0152-15720', 'Pacific/Kiritimati', 'Line Islands', '+14:00', '+14:00', ''),
('FM', '+0519+16259', 'Pacific/Kosrae', 'Kosrae', '+11:00', '+11:00', ''),
('MH', '+0905+16720', 'Pacific/Kwajalein', 'Kwajalein', '+12:00', '+12:00', ''),
('MH', '+0709+17112', 'Pacific/Majuro', 'most locations', '+12:00', '+12:00', ''),
('PF', '-0900-13930', 'Pacific/Marquesas', 'Marquesas Islands', 'âˆ’09:30', 'âˆ’09:30', ''),
('UM', '+2813-17722', 'Pacific/Midway', 'Midway Islands', 'âˆ’11:00', 'âˆ’11:00', ''),
('NR', '-0031+16655', 'Pacific/Nauru', '', '+12:00', '+12:00', ''),
('NU', '-1901-16955', 'Pacific/Niue', '', 'âˆ’11:00', 'âˆ’11:00', ''),
('NF', '-2903+16758', 'Pacific/Norfolk', '', '+11:30', '+11:30', ''),
('NC', '-2216+16627', 'Pacific/Noumea', '', '+11:00', '+11:00', ''),
('AS', '-1416-17042', 'Pacific/Pago_Pago', '', 'âˆ’11:00', 'âˆ’11:00', ''),
('PW', '+0720+13429', 'Pacific/Palau', '', '+09:00', '+09:00', ''),
('PN', '-2504-13005', 'Pacific/Pitcairn', '', 'âˆ’08:00', 'âˆ’08:00', ''),
('FM', '+0658+15813', 'Pacific/Pohnpei', 'Pohnpei (Ponape)', '+11:00', '+11:00', ''),
('', '', 'Pacific/Ponape', '', '+11:00', '+11:00', 'Link to Pacific/Pohnpei'),
('PG', '-0930+14710', 'Pacific/Port_Moresby', '', '+10:00', '+10:00', ''),
('CK', '-2114-15946', 'Pacific/Rarotonga', '', 'âˆ’10:00', 'âˆ’10:00', ''),
('MP', '+1512+14545', 'Pacific/Saipan', '', '+10:00', '+10:00', ''),
('', '', 'Pacific/Samoa', '', 'âˆ’11:00', 'âˆ’11:00', 'Link to Pacific/Pago_Pago'),
('PF', '-1732-14934', 'Pacific/Tahiti', 'Society Islands', 'âˆ’10:00', 'âˆ’10:00', ''),
('KI', '+0125+17300', 'Pacific/Tarawa', 'Gilbert Islands', '+12:00', '+12:00', ''),
('TO', '-2110-17510', 'Pacific/Tongatapu', '', '+13:00', '+13:00', ''),
('', '', 'Pacific/Truk', '', '+10:00', '+10:00', 'Link to Pacific/Chuuk'),
('UM', '+1917+16637', 'Pacific/Wake', 'Wake Island', '+12:00', '+12:00', ''),
('WF', '-1318-17610', 'Pacific/Wallis', '', '+12:00', '+12:00', ''),
('', '', 'Pacific/Yap', '', '+10:00', '+10:00', 'Link to Pacific/Chuuk'),
('', '', 'Poland', '', '+01:00', '+02:00', 'Link to Europe/Warsaw'),
('', '', 'Portugal', '', '+00:00', '+01:00', 'Link to Europe/Lisbon'),
('', '', 'PRC', '', '+08:00', '+08:00', 'Link to Asia/Shanghai'),
('', '', 'PST8PDT', '', 'âˆ’08:00', 'âˆ’07:00', ''),
('', '', 'ROC', '', '+08:00', '+08:00', 'Link to Asia/Taipei'),
('', '', 'ROK', '', '+09:00', '+09:00', 'Link to Asia/Seoul'),
('', '', 'Singapore', '', '+08:00', '+08:00', 'Link to Asia/Singapore'),
('', '', 'Turkey', '', '+02:00', '+03:00', 'Link to Europe/Istanbul'),
('', '', 'UCT', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'Universal', '', '+00:00', '+00:00', 'Link to UTC'),
('', '', 'US/Alaska', '', 'âˆ’09:00', 'âˆ’08:00', 'Link to America/Anchorage'),
('', '', 'US/Aleutian', '', 'âˆ’10:00', 'âˆ’09:00', 'Link to America/Adak'),
('', '', 'US/Arizona', '', 'âˆ’07:00', 'âˆ’07:00', 'Link to America/Phoenix'),
('', '', 'US/Central', '', 'âˆ’06:00', 'âˆ’05:00', 'Link to America/Chicago'),
('', '', 'US/East-Indiana', '', 'âˆ’05:00', 'âˆ’04:00', 'Link to America/Indiana/Indianapolis'),
('', '', 'US/Eastern', '', 'âˆ’05:00', 'âˆ’04:00', 'Link to America/New_York'),
('', '', 'US/Hawaii', '', 'âˆ’10:00', 'âˆ’10:00', 'Link to Pacific/Honolulu'),
('', '', 'US/Indiana-Starke', '', 'âˆ’06:00', 'âˆ’05:00', 'Link to America/Indiana/Knox'),
('', '', 'US/Michigan', '', 'âˆ’05:00', 'âˆ’04:00', 'Link to America/Detroit'),
('', '', 'US/Mountain', '', 'âˆ’07:00', 'âˆ’06:00', 'Link to America/Denver'),
('', '', 'US/Pacific', '', 'âˆ’08:00', 'âˆ’07:00', 'Link to America/Los_Angeles'),
('', '', 'US/Pacific-New', '', 'âˆ’08:00', 'âˆ’07:00', 'Link to America/Los_Angeles'),
('', '', 'US/Samoa', '', 'âˆ’11:00', 'âˆ’11:00', 'Link to Pacific/Pago_Pago'),
('', '', 'UTC', '', '+00:00', '+00:00', ''),
('', '', 'W-SU', '', '+04:00', '+04:00', 'Link to Europe/Moscow'),
('', '', 'WET', '', '+00:00', '+01:00', ''),
('', '', 'Zulu', '', '+00:00', '+00:00', 'Link to UTC');

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `phone_code` varchar(100) DEFAULT NULL,
  `verify` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_token` text DEFAULT NULL,
  `language` text DEFAULT NULL,
  `channel_name` text DEFAULT NULL,
  `agora_token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `phone_code`, `verify`, `remember_token`, `otp`, `dob`, `gender`, `image`, `status`, `doctor_id`, `device_token`, `language`, `channel_name`, `agora_token`, `created_at`, `updated_at`) VALUES
(1, 'admin doctro', 'admindoctro@gmail.com', NULL, '$2y$10$g/L/W4ID9zR6bB6QQPtmhOc6.jeMbT9gZx.Wy9dOMqRhSk6YOW3Qi', '7788994455', '+91', 1, NULL, NULL, NULL, NULL, 'defaultUser.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-08 12:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` text NOT NULL,
  `lat` varchar(100) NOT NULL,
  `lang` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `videocall_history`
--

CREATE TABLE `videocall_history` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `working_hour`
--

CREATE TABLE `working_hour` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `day_index` varchar(255) NOT NULL,
  `period_list` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctorId` (`doctor_id`),
  ADD KEY `fk_userId` (`user_id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name_unique` (`name`),
  ADD KEY `fk_treatment_id` (`treatment_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tretment_id` (`treatment_id`),
  ADD KEY `fk_category_id` (`category_id`),
  ADD KEY `fk_expertise_id` (`expertise_id`),
  ADD KEY `fk_hospital_id` (`hospital_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `doctor_subscription`
--
ALTER TABLE `doctor_subscription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctor` (`doctor_id`) USING BTREE,
  ADD KEY `fk_subscription` (`subscription_id`);

--
-- Indexes for table `expertise`
--
ALTER TABLE `expertise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_expertise` (`category_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faviroute`
--
ALTER TABLE `faviroute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctorId` (`doctor_id`),
  ADD KEY `userId` (`user_id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital_gallery`
--
ALTER TABLE `hospital_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hospital` (`hospital_id`);

--
-- Indexes for table `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lab_settle`
--
ALTER TABLE `lab_settle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `lab_working_hours`
--
ALTER TABLE `lab_working_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_medicine_pharamacy_id` (`pharmacy_id`),
  ADD KEY `fk_medicine_category_id` (`medicine_category_id`);

--
-- Indexes for table `medicine_category`
--
ALTER TABLE `medicine_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_child`
--
ALTER TABLE `medicine_child`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_purchase_medicine_id` (`purchase_medicine_id`),
  ADD KEY `fk_medicineId` (`medicine_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `notification_ibfk_2` (`user_id`);

--
-- Indexes for table `notification_template`
--
ALTER TABLE `notification_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pathology`
--
ALTER TABLE `pathology`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `pathology_category_id` (`pathology_category_id`);

--
-- Indexes for table `pathology_category`
--
ALTER TABLE `pathology_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `pharamacy_settle`
--
ALTER TABLE `pharamacy_settle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_settle_pharamacy_id` (`pharamacy_id`),
  ADD KEY `fk_settle_medicine_id` (`purchase_medicine_id`);

--
-- Indexes for table `pharamacy_working_hour`
--
ALTER TABLE `pharamacy_working_hour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pharamcy_working` (`pharamacy_id`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_pharamacy` (`user_id`);

--
-- Indexes for table `pharmacy_settle`
--
ALTER TABLE `pharmacy_settle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_settle_pharamacy_id` (`pharmacy_id`),
  ADD KEY `fk_settle_medicine_id` (`purchase_medicine_id`);

--
-- Indexes for table `pharmacy_working_hour`
--
ALTER TABLE `pharmacy_working_hour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pharamcy_working` (`pharmacy_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Appointment` (`appointment_id`),
  ADD KEY `fk_pre_doctorId` (`doctor_id`);

--
-- Indexes for table `purchase_medicine`
--
ALTER TABLE `purchase_medicine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_medicine_user_id` (`user_id`),
  ADD KEY `fk_pharamacy_id` (`pharmacy_id`),
  ADD KEY `fk_medicine_address_id` (`address_id`);

--
-- Indexes for table `radiology`
--
ALTER TABLE `radiology`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `radiology_ibfk_1` (`radiology_category_id`);

--
-- Indexes for table `radiology_category`
--
ALTER TABLE `radiology_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `pathology_category_id` (`pathology_category_id`),
  ADD KEY `radiology_category_id` (`radiology_category_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pathology_id` (`pathology_id`),
  ADD KEY `radiology_id` (`radiology_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_doctor_id` (`doctor_id`),
  ADD KEY `fk_review_appointment_id` (`appointment_id`),
  ADD KEY `fk_review_user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settle`
--
ALTER TABLE `settle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_settle_doctor_id` (`doctor_id`),
  ADD KEY `fk_settle_appointment_id` (`appointment_id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`TimeZone`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `fk_doctor` (`doctor_id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userAddress_userId` (`user_id`);

--
-- Indexes for table `videocall_history`
--
ALTER TABLE `videocall_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `working_hour`
--
ALTER TABLE `working_hour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_subscription`
--
ALTER TABLE `doctor_subscription`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expertise`
--
ALTER TABLE `expertise`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faviroute`
--
ALTER TABLE `faviroute`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospital_gallery`
--
ALTER TABLE `hospital_gallery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab`
--
ALTER TABLE `lab`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_settle`
--
ALTER TABLE `lab_settle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_working_hours`
--
ALTER TABLE `lab_working_hours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_category`
--
ALTER TABLE `medicine_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_child`
--
ALTER TABLE `medicine_child`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_template`
--
ALTER TABLE `notification_template`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathology`
--
ALTER TABLE `pathology`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathology_category`
--
ALTER TABLE `pathology_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `pharamacy_settle`
--
ALTER TABLE `pharamacy_settle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharamacy_working_hour`
--
ALTER TABLE `pharamacy_working_hour`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacy`
--
ALTER TABLE `pharmacy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacy_settle`
--
ALTER TABLE `pharmacy_settle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacy_working_hour`
--
ALTER TABLE `pharmacy_working_hour`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_medicine`
--
ALTER TABLE `purchase_medicine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radiology`
--
ALTER TABLE `radiology`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radiology_category`
--
ALTER TABLE `radiology_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settle`
--
ALTER TABLE `settle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videocall_history`
--
ALTER TABLE `videocall_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `working_hour`
--
ALTER TABLE `working_hour`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_doctorId` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_treatment_id` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expertise_id` FOREIGN KEY (`expertise_id`) REFERENCES `expertise` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tretment_id` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctor_subscription`
--
ALTER TABLE `doctor_subscription`
  ADD CONSTRAINT `fk_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_subscription` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expertise`
--
ALTER TABLE `expertise`
  ADD CONSTRAINT `fk_expertise` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faviroute`
--
ALTER TABLE `faviroute`
  ADD CONSTRAINT `doctorId` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userId` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hospital_gallery`
--
ALTER TABLE `hospital_gallery`
  ADD CONSTRAINT `fk_hospital` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lab`
--
ALTER TABLE `lab`
  ADD CONSTRAINT `lab_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lab_settle`
--
ALTER TABLE `lab_settle`
  ADD CONSTRAINT `lab_settle_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `lab` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lab_settle_ibfk_2` FOREIGN KEY (`report_id`) REFERENCES `report` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lab_working_hours`
--
ALTER TABLE `lab_working_hours`
  ADD CONSTRAINT `lab_working_hours_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `lab` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicine`
--
ALTER TABLE `medicine`
  ADD CONSTRAINT `fk_medicine_category_id` FOREIGN KEY (`medicine_category_id`) REFERENCES `medicine_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_ibfk_1` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicine_child`
--
ALTER TABLE `medicine_child`
  ADD CONSTRAINT `fk_medicineId` FOREIGN KEY (`medicine_id`) REFERENCES `medicine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_purchase_medicine_id` FOREIGN KEY (`purchase_medicine_id`) REFERENCES `purchase_medicine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pathology`
--
ALTER TABLE `pathology`
  ADD CONSTRAINT `pathology_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `lab` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pathology_ibfk_2` FOREIGN KEY (`pathology_category_id`) REFERENCES `pathology_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pharamacy_settle`
--
ALTER TABLE `pharamacy_settle`
  ADD CONSTRAINT `pharamacy_settle_ibfk_1` FOREIGN KEY (`purchase_medicine_id`) REFERENCES `purchase_medicine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pharamacy_settle_ibfk_2` FOREIGN KEY (`pharamacy_id`) REFERENCES `pharmacy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Update v5.2.0 -- DB Modification Queries
--
ALTER TABLE `settings` ADD `landing_popup_image` VARCHAR(255) NOT NULL AFTER `banner_url`, ADD `popup_timer_seconds` INT(11) NOT NULL AFTER `landing_popup_image`;
ALTER TABLE `settings` CHANGE `popup_timer_seconds` `popup_timer_seconds` INT(11) NOT NULL DEFAULT '5';
ALTER TABLE `settings` ADD `popup_target_url` TEXT NOT NULL AFTER `popup_timer_seconds`;
ALTER TABLE `settings` ADD `landing_popup_switch` TINYINT(1) NOT NULL DEFAULT '0' AFTER `popup_target_url`;

--
-- Update v5.3.0 -- DB Amount Type Change
--
ALTER TABLE `appointment` CHANGE `amount` `amount` DECIMAL(11,2) NOT NULL;
ALTER TABLE `doctor` CHANGE `commission_amount` `commission_amount` DECIMAL(11,2) NULL DEFAULT NULL;
ALTER TABLE `doctor_subscription` CHANGE `amount` `amount` DECIMAL(11,2) NULL DEFAULT NULL;
ALTER TABLE `lab_settle` CHANGE `admin_amount` `admin_amount` DECIMAL(11,2) NOT NULL;
ALTER TABLE `lab_settle` CHANGE `lab_amount` `lab_amount` DECIMAL(11,2) NOT NULL;
ALTER TABLE `pharamacy_settle` CHANGE `admin_amount` `admin_amount` DECIMAL(11,2) NOT NULL;
ALTER TABLE `pharamacy_settle` CHANGE `pharamacy_amount` `pharamacy_amount` DECIMAL(11,2) NULL DEFAULT NULL;
ALTER TABLE `pharmacy` CHANGE `commission_amount` `commission_amount` DECIMAL(11,2) NOT NULL;
ALTER TABLE `pharmacy_settle` CHANGE `admin_amount` `admin_amount` DECIMAL(11,2) NOT NULL;
ALTER TABLE `pharmacy_settle` CHANGE `pharmacy_amount` `pharmacy_amount` DECIMAL(11,2) NULL DEFAULT NULL;
ALTER TABLE `purchase_medicine` CHANGE `amount` `amount` DECIMAL(11,2) NOT NULL;
ALTER TABLE `report` CHANGE `amount` `amount` DECIMAL(20,2) NOT NULL;
ALTER TABLE `settle` CHANGE `doctor_amount` `doctor_amount` DECIMAL(11,2) NOT NULL;
ALTER TABLE `settle` CHANGE `admin_amount` `admin_amount` DECIMAL(11,2) NOT NULL;

--
-- Constraints for table `pharmacy_settle`
--
ALTER TABLE `pharmacy_settle`
  ADD CONSTRAINT `pharmacy_settle_ibfk_1` FOREIGN KEY (`purchase_medicine_id`) REFERENCES `purchase_medicine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pharmacy_settle_ibfk_2` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Update v5.4.0 -- DB Modification Queries
--
ALTER TABLE `appointment`
    ADD `is_insured` BOOLEAN NOT NULL DEFAULT FALSE AFTER `zoom_url`, ADD `policy_insurer_name` VARCHAR(100) NULL COMMENT 'Name of the insurer' AFTER `is_insured`, ADD `policy_number` VARCHAR(20) NULL AFTER `policy_insurer_name`;

--
-- Table structure for table `insurers`
--

CREATE TABLE `insurers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'Name of the insurer',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Status of the insurer',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `insurers`
--
ALTER TABLE `insurers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `insurers_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `insurers`
--
ALTER TABLE `insurers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Update v8.4.0 -- DB Modification Queries
--
CREATE TABLE `zoom_oauth` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `refresh_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `zoom_oauth` ADD `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

-- Foreign Keys
ALTER TABLE `zoom_oauth`
  ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--   Insert into zoom_oauth table as much as user in users table
INSERT INTO `zoom_oauth` (`user_id`) SELECT `id` FROM `users`;

INSERT INTO
    `role_has_permissions` (`permission_id`, `role_id`)
VALUES
    (1, 1),
    (2, 1),
    (3, 1),
    (4, 1),
    (5, 1),
    (6, 1),
    (7, 1),
    (8, 1),
    (9, 1),
    (10, 1),
    (11, 1),
    (12, 1),
    (13, 1),
    (14, 1),
    (15, 1),
    (16, 1),
    (17, 1),
    (18, 1),
    (19, 1),
    (20, 1),
    (21, 1),
    (22, 1),
    (23, 1),
    (24, 1),
    (25, 1),
    (26, 1),
    (27, 1),
    (28, 1),
    (29, 1),
    (30, 1),
    (31, 1),
    (32, 1),
    (33, 1),
    (34, 1),
    (35, 1),
    (36, 1),
    (37, 1),
    (38, 1),
    (39, 1),
    (40, 1),
    (41, 1),
    (42, 1),
    (43, 1),
    (44, 1),
    (45, 1),
    (46, 1),
    (47, 1),
    (48, 1),
    (49, 1),
    (50, 1),
    (51, 1),
    (52, 1),
    (53, 1),
    (54, 1),
    (55, 1),
    (56, 1),
    (57, 1),
    (58, 1),
    (59, 1),
    (60, 1),
    (61, 1),
    (62, 1),
    (63, 1),
    (64, 1),
    (65, 1),
    (66, 1),
    (67, 1),
    (68, 1),
    (69, 1),
    (70, 1),
    (71, 1),
    (72, 1),
    (73, 1),
    (74, 1),
    (75, 1),
    (76, 1),
    (77, 1),
    (78, 1),
    (79, 1),
    (80, 1),
    (81, 1),
    (82, 1),
    (83, 1),
    (84, 1),
    (85, 1),
    (86, 1),
    (87, 1),
    (88, 1),
    (89, 1),
    (90, 1),
    (91, 1),
    (92, 1),
    (93, 1),
    (94, 1),
    (95, 1),
    (96, 1),
    (97, 1),
    (98, 1),
    (99, 1),
    (100, 1),
    (101, 1),
    (102, 1),
    (103, 1),
    (104, 1),
    (105, 1),
    (106, 1),
    (107, 1),
    (108, 1),
    (109, 1),
    (110, 1),
    (111, 1),
    (112, 1),
    (113, 1),
    (114, 1),
    (115, 1),
    (116, 1),
    (117, 1),
    (118, 1),
    (119, 1),
    (120, 1),
    (121, 1),
    (122, 1),
    (123, 1),
    (124, 1),
    (125, 1),
    (126, 1),
    (127, 1),
    (128, 1);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
