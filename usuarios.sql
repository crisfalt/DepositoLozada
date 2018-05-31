-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-05-2018 a las 23:46:04
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `depositolozada`
--

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `tipo_documento_id`, `number_id`, `address`, `phone`, `celular`, `email`, `password`, `perfil_id`, `bodega_id`, `estado`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Cristian Álvarez Trujillo', 2, '1075255095', 'Calle 2 A # 2-57', '8712268', '3003637018', 'crisfalt@gmail.com', '$2y$10$yvFw3tZSsskGeihGKLDoIu9bSfByhwLxly.LJ0xnVQqWsxzvJbDPy', 1, 1, 'A', 'M6PcKJZwmEoNvIoF5mj1xTTowaSRHYlvZVGoLuchhUxwcXhWXCfI8Y3HcudP', '2018-04-21 03:00:42', '2018-04-21 03:00:42'),
(2, 'alvaro morata', 4, '4789879', 'Calle 22a sur # 34c-64', '8745889', '3215548798', 'morata@gmail.com', '$2y$10$KOorS/N61BN4f6DhXnnL1uTEBdwKgIf0E6OUQMm3P6.8Wq6hcKfpi', 1, 1, 'A', 'krNwCQFROgw7YdcWaPapoXxL2vFtK89m2IH9K8pxbI0ZlD4QYekCv2L2VLjM', '2018-04-26 03:11:36', '2018-04-26 03:11:36'),
(3, 'kevin alexis perico torres', 2, '1089797878', 'Calle 22a sur # 34c-64', '3053121363', '3215548798', 'nearriver1995@gmail.com', '$2y$10$hh.BmaSHzqLz2M66Q69DI.cnQJrJMxOCxMdJ2ngL3yLoYjnl6v/cO', 2, 1, 'A', 'gpfFNYqCQ3QWApSEpOHu2LPWFm1bsb5rPQKoNpgzscMb3h1sRkQltdhFIUqw', '2018-04-30 18:09:45', '2018-04-30 18:09:45'),
(4, 'fabian la perra', 5, '87897897987', 'Calle 2 A # 2-57', '8986', '3215548798', 'fabian@gmail.com', '$2y$10$5d2U8f6xpHNi/NajmK4nhOCYLXJPKUf4zTBnZbOqAT7Z3p3UNETCG', 4, 1, 'A', 'mH2H3fhcFpFhfyPiVt4qveg0FTzbtEhMFF0M0ZbyUIQAwv41UQUgwB8mNIk9', '2018-04-30 18:16:01', '2018-04-30 18:16:01'),
(5, 'paracohp', 4, '13131113', 'Calle 22a sur # 34c-64', '3053121363', '3239019201', 'paraco@gmail.com', '$2y$10$aCYwMoHzAuf0OmAcTRMzkuFyuxsw14bFXThQNhugv94mxWbS/XIza', 2, 1, 'A', 'Ul1J0Mbt3SkGrymKlRbm0wsOWxhFLIwePGHnPvbIsWumPBpkYddtI94jYwn0', '2018-04-30 19:09:50', '2018-04-30 19:09:50'),
(6, 'leonel messi', 7, '98767', 'carrera 12 # 45-09', '87615245', '3121999', 'messi@gmail.com', '$2y$10$kZIZKc7iyGm0Zpy6A.ARSudk.Q3EbUk9kFP9JmCAugQkHSo5PNj7m', 1, 1, 'A', NULL, '2018-04-30 19:18:00', '2018-04-30 19:18:00'),
(7, 'gerard pique', 5, '10587797', 'carrera 56 # 34-07', '8978797', '3255798789', 'amdajd@gmail.com', '$2y$10$jnyWrufZR9OJnSfCMynWHe.hEVSE7Ru1uw6WwP.n7Ue9ENesRoBeG', 4, 1, 'A', 'JqpnBFex1NSRdAHfq4evZFxo223hDJvBj4XhKcKSIQFmkmg6Sq19EnoOYPxg', '2018-04-30 19:22:42', '2018-04-30 19:22:42'),
(8, 'pablo dybala', 6, '9876567', 'carrera 19 bis # 45-08 torre 3 apto 8', '8712122', '873192837', 'dybala@gmail.com', '$2y$10$EuNYq/Krhsd96QZnkM/R1OMxNbY.zNcTAgzuIhg1OzqLX5UNwdWNO', 2, 1, 'A', 'oGSN6quyGAVgMQ6xdCkGFwQALMK1DZvyn5eSYwspt6KNxicjfUdaAGaunoNn', '2018-04-30 19:29:56', '2018-04-30 19:29:56'),
(9, 'juan david', 4, '4789879', 'Calle 2 A # 2-57', '8712268', '3239019201', 'juancho@hotmail.com', '$2y$10$7dJbVTBqEiICFkn.67LNrORUNyzwUTH6E6M/QOqOQupgYWPthnrEi', 2, 1, 'A', NULL, '2018-04-30 19:53:59', '2018-04-30 19:53:59'),
(10, 'sunny', 4, '1088855', 'carrera 12 # 45-09', '887445', '3259987', 'sunny@gmail.com', '$2y$10$CgsxLcSoCHLZG2JFvD9HgunVr1EbRoWA0BxB2YqQCqfl2zPaxMatS', 4, 1, 'A', 'AeqFHqgDNmSHYiN406bYORHvHJUc4QQTHa2tcRvGUiFJcLz13pAxGGJNuqmc', '2018-04-30 19:54:51', '2018-04-30 19:54:51');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
