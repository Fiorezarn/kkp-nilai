-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2024 at 06:49 PM
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
-- Database: `kkp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `nip`, `no_telp`) VALUES
(1, 'Adian Ali', '802131231123', '0923213123123'),
(2, 'Sugiono', '13123313', '1231231');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'TKP I'),
(2, 'TKP II'),
(3, 'TKJT I'),
(4, 'TKJT II'),
(5, 'TKJT III'),
(6, 'PM I'),
(7, 'PM II'),
(8, 'MPLB I'),
(9, 'MPLB II'),
(10, 'MPLB III'),
(11, 'LPS I'),
(12, 'LPS II'),
(13, 'AK I'),
(14, 'AK II'),
(15, 'BKP I'),
(16, 'BKP II'),
(17, 'TKJ I'),
(18, 'TKJ II'),
(19, 'TKJ III'),
(20, 'BDP I'),
(21, 'BDP II'),
(22, 'OTKP I'),
(23, 'OTKP II'),
(24, 'OTKP III'),
(25, 'PSY I'),
(26, 'PSY II'),
(27, 'AKL I'),
(28, 'AKL II');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`) VALUES
(1, 'Kelas X'),
(2, 'Kelas XI'),
(3, 'Kelas XII');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_jurusan_mapel`
--

CREATE TABLE `kelas_jurusan_mapel` (
  `id_kelas_jurusan_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas_jurusan_mapel`
--

INSERT INTO `kelas_jurusan_mapel` (`id_kelas_jurusan_mapel`, `id_kelas`, `id_jurusan`, `id_mapel`) VALUES
(3, 2, 1, 2),
(4, 2, 1, 3),
(5, 2, 1, 4),
(6, 2, 1, 5),
(7, 2, 1, 6),
(8, 2, 1, 7),
(9, 2, 1, 8),
(11, 2, 1, 10),
(13, 3, 1, 2),
(14, 3, 1, 3),
(15, 3, 1, 4),
(16, 3, 1, 5),
(17, 3, 1, 6),
(18, 3, 1, 7),
(19, 3, 1, 8),
(21, 3, 1, 10),
(23, 1, 1, 2),
(24, 1, 1, 3),
(25, 1, 1, 4),
(26, 1, 1, 5),
(27, 1, 1, 6),
(28, 1, 1, 7),
(29, 1, 1, 8),
(31, 1, 1, 10),
(32, 1, 1, 11),
(33, 1, 1, 12),
(34, 1, 1, 13),
(35, 1, 1, 14),
(36, 1, 1, 33),
(37, 1, 2, 33),
(38, 1, 1, 46),
(39, 1, 2, 46),
(40, 1, 1, 24),
(41, 1, 2, 24),
(42, 1, 1, 29),
(43, 1, 2, 29),
(45, 2, 1, 18),
(46, 3, 1, 18),
(47, 2, 2, 19),
(48, 3, 2, 19),
(49, 2, 1, 57),
(50, 3, 1, 57),
(51, 2, 2, 45),
(52, 3, 2, 45),
(53, 2, 1, 52),
(54, 3, 1, 52),
(78, 1, 3, 28),
(79, 2, 3, 49),
(80, 3, 3, 49),
(81, 2, 3, 30),
(82, 3, 3, 30),
(83, 2, 3, 25),
(84, 3, 3, 25),
(85, 1, 4, 28),
(86, 2, 4, 26),
(87, 3, 4, 26),
(88, 2, 4, 38),
(89, 3, 4, 38),
(90, 2, 4, 25),
(91, 3, 4, 25),
(92, 1, 5, 28),
(93, 2, 5, 22),
(94, 3, 5, 22),
(95, 2, 5, 52),
(96, 3, 5, 52),
(97, 2, 5, 25),
(98, 3, 5, 25),
(99, 1, 6, 20),
(100, 1, 6, 37),
(101, 1, 7, 20),
(102, 1, 7, 37),
(103, 2, 6, 27),
(104, 3, 6, 27),
(105, 2, 7, 27),
(106, 3, 7, 27),
(107, 2, 6, 47),
(108, 3, 6, 47),
(109, 2, 7, 47),
(110, 3, 7, 47),
(111, 2, 6, 16),
(112, 3, 6, 16),
(113, 2, 7, 16),
(114, 3, 7, 16),
(115, 2, 6, 32),
(116, 3, 6, 32),
(117, 2, 7, 32),
(118, 3, 7, 32),
(119, 2, 6, 42),
(120, 3, 6, 42),
(121, 2, 7, 42),
(122, 3, 7, 42),
(123, 2, 6, 39),
(124, 3, 6, 39),
(125, 2, 7, 39),
(126, 3, 7, 39),
(127, 2, 6, 31),
(128, 3, 6, 31),
(129, 2, 7, 31),
(130, 3, 7, 31),
(131, 2, 6, 56),
(132, 3, 6, 56),
(133, 2, 7, 56),
(134, 3, 7, 56),
(135, 2, 6, 52),
(136, 3, 6, 52),
(137, 2, 7, 52),
(138, 3, 7, 52),
(139, 2, 6, 25),
(140, 3, 6, 25),
(141, 2, 7, 25),
(142, 3, 7, 25),
(143, 2, 6, 48),
(144, 3, 6, 48),
(145, 2, 7, 48),
(146, 3, 7, 48),
(147, 1, 8, 58),
(148, 1, 8, 61),
(149, 1, 9, 58),
(150, 1, 9, 61),
(151, 1, 10, 58),
(152, 1, 10, 61),
(153, 2, 8, 62),
(154, 3, 8, 62),
(155, 2, 9, 62),
(156, 3, 9, 62),
(157, 2, 10, 62),
(158, 3, 10, 62),
(159, 2, 8, 63),
(160, 3, 8, 63),
(161, 2, 9, 63),
(162, 3, 9, 63),
(163, 2, 10, 63),
(164, 3, 10, 63),
(165, 2, 8, 64),
(166, 3, 8, 64),
(167, 2, 9, 64),
(168, 3, 9, 64),
(169, 2, 10, 64),
(170, 3, 10, 64),
(171, 2, 8, 65),
(172, 3, 8, 65),
(173, 2, 9, 65),
(174, 3, 9, 65),
(175, 2, 10, 65),
(176, 3, 10, 65),
(177, 2, 8, 66),
(178, 3, 8, 66),
(179, 2, 9, 66),
(180, 3, 9, 66),
(181, 2, 10, 66),
(182, 3, 10, 66),
(183, 2, 8, 67),
(184, 3, 8, 67),
(185, 2, 9, 67),
(186, 3, 9, 67),
(187, 2, 10, 67),
(188, 3, 10, 67),
(189, 2, 8, 68),
(190, 3, 8, 68),
(191, 2, 9, 68),
(192, 3, 9, 68),
(193, 2, 10, 68),
(194, 3, 10, 68),
(195, 2, 8, 69),
(196, 3, 8, 69),
(197, 2, 9, 69),
(198, 3, 9, 69),
(199, 2, 10, 69),
(200, 3, 10, 69),
(201, 2, 8, 70),
(202, 3, 8, 70),
(203, 2, 9, 70),
(204, 3, 9, 70),
(205, 2, 10, 70),
(206, 3, 10, 70),
(207, 2, 8, 71),
(208, 3, 8, 71),
(209, 2, 9, 71),
(210, 3, 9, 71),
(211, 2, 10, 71),
(212, 3, 10, 71),
(213, 2, 8, 52),
(214, 3, 8, 52),
(215, 2, 9, 52),
(216, 3, 9, 52),
(217, 2, 10, 52),
(218, 3, 10, 52),
(219, 2, 8, 62),
(220, 3, 8, 62),
(221, 2, 9, 62),
(222, 3, 9, 62),
(223, 2, 10, 62),
(224, 3, 10, 62),
(225, 2, 8, 63),
(226, 3, 8, 63),
(227, 2, 9, 63),
(228, 3, 9, 63),
(229, 2, 10, 63),
(230, 3, 10, 63),
(231, 2, 8, 64),
(232, 3, 8, 64),
(233, 2, 9, 64),
(234, 3, 9, 64),
(235, 2, 10, 64),
(236, 3, 10, 64),
(237, 2, 8, 65),
(238, 3, 8, 65),
(239, 2, 9, 65),
(240, 3, 9, 65),
(241, 2, 10, 65),
(242, 3, 10, 65),
(243, 2, 8, 66),
(244, 3, 8, 66),
(245, 2, 9, 66),
(246, 3, 9, 66),
(247, 2, 10, 66),
(248, 3, 10, 66),
(249, 2, 8, 67),
(250, 3, 8, 67),
(251, 2, 9, 67),
(252, 3, 9, 67),
(253, 2, 10, 67),
(254, 3, 10, 67),
(255, 2, 8, 68),
(256, 3, 8, 68),
(257, 2, 9, 68),
(258, 3, 9, 68),
(259, 2, 10, 68),
(260, 3, 10, 68),
(261, 2, 8, 69),
(262, 3, 8, 69),
(263, 2, 9, 69),
(264, 3, 9, 69),
(265, 2, 10, 69),
(266, 3, 10, 69),
(267, 2, 8, 70),
(268, 3, 8, 70),
(269, 2, 9, 70),
(270, 3, 9, 70),
(271, 2, 10, 70),
(272, 3, 10, 70),
(273, 2, 8, 71),
(274, 3, 8, 71),
(275, 2, 9, 71),
(276, 3, 9, 71),
(277, 2, 10, 71),
(278, 3, 10, 71),
(279, 2, 8, 52),
(280, 3, 8, 52),
(281, 2, 9, 52),
(282, 3, 9, 52),
(283, 2, 10, 52),
(284, 3, 10, 52),
(285, 2, 8, 62),
(286, 3, 8, 62),
(287, 2, 9, 62),
(288, 3, 9, 62),
(289, 2, 10, 62),
(290, 3, 10, 62),
(291, 2, 8, 63),
(292, 3, 8, 63),
(293, 2, 9, 63),
(294, 3, 9, 63),
(295, 2, 10, 63),
(296, 3, 10, 63),
(297, 2, 8, 64),
(298, 3, 8, 64),
(299, 2, 9, 64),
(300, 3, 9, 64),
(301, 2, 10, 64),
(302, 3, 10, 64),
(303, 2, 8, 65),
(304, 3, 8, 65),
(305, 2, 9, 65),
(306, 3, 9, 65),
(307, 2, 10, 65),
(308, 3, 10, 65),
(309, 2, 8, 66),
(310, 3, 8, 66),
(311, 2, 9, 66),
(312, 3, 9, 66),
(313, 2, 10, 66),
(314, 3, 10, 66),
(315, 2, 8, 67),
(316, 3, 8, 67),
(317, 2, 9, 67),
(318, 3, 9, 67),
(319, 2, 10, 67),
(320, 3, 10, 67),
(321, 2, 8, 68),
(322, 3, 8, 68),
(323, 2, 9, 68),
(324, 3, 9, 68),
(325, 2, 10, 68),
(326, 3, 10, 68),
(327, 2, 8, 69),
(328, 3, 8, 69),
(329, 2, 9, 69),
(330, 3, 9, 69),
(331, 2, 10, 69),
(332, 3, 10, 69),
(333, 2, 8, 70),
(334, 3, 8, 70),
(335, 2, 9, 70),
(336, 3, 9, 70),
(337, 2, 10, 70),
(338, 3, 10, 70),
(339, 2, 8, 71),
(340, 3, 8, 71),
(341, 2, 9, 71),
(342, 3, 9, 71),
(343, 2, 10, 71),
(344, 3, 10, 71),
(345, 2, 8, 52),
(346, 3, 8, 52),
(347, 2, 9, 52),
(348, 3, 9, 52),
(349, 2, 10, 52),
(350, 3, 10, 52),
(351, 2, 8, 62),
(352, 3, 8, 62),
(353, 2, 9, 62),
(354, 3, 9, 62),
(355, 2, 10, 62),
(356, 3, 10, 62),
(357, 2, 8, 63),
(358, 3, 8, 63),
(359, 2, 9, 63),
(360, 3, 9, 63),
(361, 2, 10, 63),
(362, 3, 10, 63),
(363, 2, 8, 64),
(364, 3, 8, 64),
(365, 2, 9, 64),
(366, 3, 9, 64),
(367, 2, 10, 64),
(368, 3, 10, 64),
(369, 2, 8, 65),
(370, 3, 8, 65),
(371, 2, 9, 65),
(372, 3, 9, 65),
(373, 2, 10, 65),
(374, 3, 10, 65),
(375, 2, 8, 66),
(376, 3, 8, 66),
(377, 2, 9, 66),
(378, 3, 9, 66),
(379, 2, 10, 66),
(380, 3, 10, 66),
(381, 2, 8, 67),
(382, 3, 8, 67),
(383, 2, 9, 67),
(384, 3, 9, 67),
(385, 2, 10, 67),
(386, 3, 10, 67),
(387, 2, 8, 68),
(388, 3, 8, 68),
(389, 2, 9, 68),
(390, 3, 9, 68),
(391, 2, 10, 68),
(392, 3, 10, 68),
(393, 2, 8, 69),
(394, 3, 8, 69),
(395, 2, 9, 69),
(396, 3, 9, 69),
(397, 2, 10, 69),
(398, 3, 10, 69),
(399, 2, 8, 70),
(400, 3, 8, 70),
(401, 2, 9, 70),
(402, 3, 9, 70),
(403, 2, 10, 70),
(404, 3, 10, 70),
(405, 2, 8, 71),
(406, 3, 8, 71),
(407, 2, 9, 71),
(408, 3, 9, 71),
(409, 2, 10, 71),
(410, 3, 10, 71),
(411, 2, 8, 52),
(412, 3, 8, 52),
(413, 2, 9, 52),
(414, 3, 9, 52),
(415, 2, 10, 52),
(416, 3, 10, 52),
(417, 2, 8, 62),
(418, 3, 8, 62),
(419, 2, 9, 62),
(420, 3, 9, 62),
(421, 2, 10, 62),
(422, 3, 10, 62),
(423, 2, 8, 63),
(424, 3, 8, 63),
(425, 2, 9, 63),
(426, 3, 9, 63),
(427, 2, 10, 63),
(428, 3, 10, 63),
(429, 2, 8, 64),
(430, 3, 8, 64),
(431, 2, 9, 64),
(432, 3, 9, 64),
(433, 2, 10, 64),
(434, 3, 10, 64),
(435, 2, 8, 65),
(436, 3, 8, 65),
(437, 2, 9, 65),
(438, 3, 9, 65),
(439, 2, 10, 65),
(440, 3, 10, 65),
(441, 2, 8, 66),
(442, 3, 8, 66),
(443, 2, 9, 66),
(444, 3, 9, 66),
(445, 2, 10, 66),
(446, 3, 10, 66),
(447, 2, 8, 67),
(448, 3, 8, 67),
(449, 2, 9, 67),
(450, 3, 9, 67),
(451, 2, 10, 67),
(452, 3, 10, 67),
(453, 2, 8, 68),
(454, 3, 8, 68),
(455, 2, 9, 68),
(456, 3, 9, 68),
(457, 2, 10, 68),
(458, 3, 10, 68),
(459, 2, 8, 69),
(460, 3, 8, 69),
(461, 2, 9, 69),
(462, 3, 9, 69),
(463, 2, 10, 69),
(464, 3, 10, 69),
(465, 2, 8, 70),
(466, 3, 8, 70),
(467, 2, 9, 70),
(468, 3, 9, 70),
(469, 2, 10, 70),
(470, 3, 10, 70),
(471, 2, 8, 71),
(472, 3, 8, 71),
(473, 2, 9, 71),
(474, 3, 9, 71),
(475, 2, 10, 71),
(476, 3, 10, 71),
(477, 2, 8, 52),
(478, 3, 8, 52),
(479, 2, 9, 52),
(480, 3, 9, 52),
(481, 2, 10, 52),
(482, 3, 10, 52),
(483, 2, 8, 62),
(484, 3, 8, 62),
(485, 2, 9, 62),
(486, 3, 9, 62),
(487, 2, 10, 62),
(488, 3, 10, 62),
(489, 2, 8, 63),
(490, 3, 8, 63),
(491, 2, 9, 63),
(492, 3, 9, 63),
(493, 2, 10, 63),
(494, 3, 10, 63),
(495, 2, 8, 64),
(496, 3, 8, 64),
(497, 2, 9, 64),
(498, 3, 9, 64),
(499, 2, 10, 64),
(500, 3, 10, 64),
(501, 2, 8, 65),
(502, 3, 8, 65),
(503, 2, 9, 65),
(504, 3, 9, 65),
(505, 2, 10, 65),
(506, 3, 10, 65),
(507, 2, 8, 66),
(508, 3, 8, 66),
(509, 2, 9, 66),
(510, 3, 9, 66),
(511, 2, 10, 66),
(512, 3, 10, 66),
(513, 2, 8, 67),
(514, 3, 8, 67),
(515, 2, 9, 67),
(516, 3, 9, 67),
(517, 2, 10, 67),
(518, 3, 10, 67),
(519, 2, 8, 68),
(520, 3, 8, 68),
(521, 2, 9, 68),
(522, 3, 9, 68),
(523, 2, 10, 68),
(524, 3, 10, 68),
(525, 2, 8, 69),
(526, 3, 8, 69),
(527, 2, 9, 69),
(528, 3, 9, 69),
(529, 2, 10, 69),
(530, 3, 10, 69),
(531, 2, 8, 70),
(532, 3, 8, 70),
(533, 2, 9, 70),
(534, 3, 9, 70),
(535, 2, 10, 70),
(536, 3, 10, 70),
(537, 2, 8, 71),
(538, 3, 8, 71),
(539, 2, 9, 71),
(540, 3, 9, 71),
(541, 2, 10, 71),
(542, 3, 10, 71),
(543, 2, 8, 52),
(544, 3, 8, 52),
(545, 2, 9, 52),
(546, 3, 9, 52),
(547, 2, 10, 52),
(548, 3, 10, 52),
(549, 2, 8, 25),
(550, 3, 8, 25),
(551, 2, 9, 25),
(552, 3, 9, 25),
(553, 2, 10, 25),
(554, 3, 10, 25),
(555, 2, 8, 48),
(556, 3, 8, 48),
(557, 2, 9, 48),
(558, 3, 9, 48),
(559, 2, 8, 62),
(560, 3, 8, 62),
(561, 2, 9, 62),
(562, 3, 9, 62),
(563, 2, 10, 62),
(564, 3, 10, 62),
(565, 2, 8, 63),
(566, 3, 8, 63),
(567, 2, 9, 63),
(568, 3, 9, 63),
(569, 2, 10, 63),
(570, 3, 10, 63),
(571, 2, 8, 64),
(572, 3, 8, 64),
(573, 2, 9, 64),
(574, 3, 9, 64),
(575, 2, 10, 64),
(576, 3, 10, 64),
(577, 2, 8, 65),
(578, 3, 8, 65),
(579, 2, 9, 65),
(580, 3, 9, 65),
(581, 2, 10, 65),
(582, 3, 10, 65),
(583, 2, 8, 66),
(584, 3, 8, 66),
(585, 2, 9, 66),
(586, 3, 9, 66),
(587, 2, 10, 66),
(588, 3, 10, 66),
(589, 2, 8, 67),
(590, 3, 8, 67),
(591, 2, 9, 67),
(592, 3, 9, 67),
(593, 2, 10, 67),
(594, 3, 10, 67),
(595, 2, 8, 68),
(596, 3, 8, 68),
(597, 2, 9, 68),
(598, 3, 9, 68),
(599, 2, 10, 68),
(600, 3, 10, 68),
(601, 2, 8, 69),
(602, 3, 8, 69),
(603, 2, 9, 69),
(604, 3, 9, 69),
(605, 2, 10, 69),
(606, 3, 10, 69),
(607, 2, 8, 70),
(608, 3, 8, 70),
(609, 2, 9, 70),
(610, 3, 9, 70),
(611, 2, 10, 70),
(612, 3, 10, 70),
(613, 2, 8, 71),
(614, 3, 8, 71),
(615, 2, 9, 71),
(616, 3, 9, 71),
(617, 2, 10, 71),
(618, 3, 10, 71),
(619, 2, 8, 52),
(620, 3, 8, 52),
(621, 2, 9, 52),
(622, 3, 9, 52),
(623, 2, 10, 52),
(624, 3, 10, 52),
(625, 2, 8, 25),
(626, 3, 8, 25),
(627, 2, 9, 25),
(628, 3, 9, 25),
(629, 2, 10, 25),
(630, 3, 10, 25),
(631, 2, 8, 48),
(632, 3, 8, 48),
(633, 2, 9, 48),
(634, 3, 9, 48),
(635, 2, 10, 48),
(636, 3, 10, 48),
(637, 1, 11, 17),
(638, 1, 12, 17),
(639, 2, 11, 27),
(640, 2, 12, 27),
(641, 3, 11, 27),
(642, 3, 12, 27),
(643, 2, 11, 40),
(644, 2, 12, 40),
(645, 3, 11, 40),
(646, 3, 12, 40),
(647, 2, 11, 55),
(648, 2, 12, 55),
(649, 3, 11, 55),
(650, 3, 12, 55),
(651, 2, 11, 53),
(652, 2, 12, 53),
(653, 3, 11, 53),
(654, 3, 12, 53),
(655, 2, 11, 15),
(656, 2, 12, 15),
(657, 3, 11, 15),
(658, 3, 12, 15),
(659, 2, 11, 50),
(660, 2, 12, 50),
(661, 3, 11, 50),
(662, 3, 12, 50),
(663, 2, 11, 21),
(664, 2, 12, 21),
(665, 3, 11, 21),
(666, 3, 12, 21),
(667, 2, 11, 25),
(668, 2, 12, 25),
(669, 3, 11, 25),
(670, 3, 12, 25),
(671, 2, 11, 48),
(672, 2, 12, 48),
(673, 3, 11, 48),
(674, 3, 12, 48),
(675, 1, 27, 36),
(676, 1, 27, 41),
(677, 1, 27, 23),
(678, 1, 28, 36),
(679, 1, 28, 41),
(680, 1, 28, 23),
(681, 2, 27, 27),
(682, 2, 27, 43),
(683, 2, 27, 34),
(684, 2, 27, 35),
(685, 2, 27, 50),
(686, 2, 27, 54),
(687, 2, 27, 21),
(688, 2, 27, 25),
(689, 2, 27, 48),
(690, 3, 27, 27),
(691, 3, 27, 43),
(692, 3, 27, 34),
(693, 3, 27, 35),
(694, 3, 27, 50),
(695, 3, 27, 54),
(696, 3, 27, 21),
(697, 3, 27, 25),
(698, 3, 27, 48),
(699, 2, 28, 27),
(700, 2, 28, 43),
(701, 2, 28, 34),
(702, 2, 28, 35),
(703, 2, 28, 50),
(704, 2, 28, 54),
(705, 2, 28, 21),
(706, 2, 28, 25),
(707, 2, 28, 48),
(708, 3, 28, 27),
(709, 3, 28, 43),
(710, 3, 28, 34),
(711, 3, 28, 35),
(712, 3, 28, 50),
(713, 3, 28, 54),
(714, 3, 28, 21),
(715, 3, 28, 25),
(716, 3, 28, 48);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Pendidikan Agama dan Budi Pekerti'),
(2, 'Pendidikan Pancasila'),
(3, 'Bahasa Indonesia'),
(4, 'Penjaskes'),
(5, 'Sejarah'),
(6, 'Matematika'),
(7, 'Bahasa Inggris'),
(8, 'Bahasa Jepang'),
(10, 'Fasil'),
(11, 'Seni Budaya'),
(12, 'Bahasa Jerman'),
(13, 'Informatika'),
(14, 'IPAS'),
(15, 'Akuntansi perbankan syariah'),
(16, 'Customer service'),
(17, 'Dasar program keahlian LPS'),
(18, 'Perencanaan pekerjaan konstruksi dan perumahan'),
(19, 'Pelaksanaan pekerjaan konstruksi perumahan'),
(20, 'Perkembangan teknologi dan isu-isu terkini'),
(21, 'PKK'),
(22, 'Keamanan jaringan'),
(23, 'Profil pekerjaan/profesi dan peluang usaha di bidang akuntansi dan keuangan lembaga'),
(24, 'Profesi dan Kewirausahaan, serta peluang usaha pad'),
(25, 'Mata pelajaran pilihan'),
(26, 'Teknologi jaringan kabel dan nirkabel'),
(27, 'Ekonomi bisnis dan administrasi umum'),
(28, 'Dasar program keahlian TKJT'),
(29, 'K3LH dan budaya kerja industri'),
(30, 'Pemasangan dan konfigurasi perangkat jaringan (S4)'),
(31, 'Pengemasan dan pendistribusian produk'),
(32, 'Komunikasi bisnis'),
(33, 'Proses Bisnis pada pekerjaan konstruksi dan peruma'),
(34, 'Akuntansi lembaga / instansi pemerintah'),
(35, 'Akuntansi keuangan'),
(36, 'Proses Bisnis dibidang akuntansi dan keuangan lemb'),
(37, 'Proses bisnis bidang pemasaran di berbagai industr'),
(38, 'Administrasi sistem jaringan'),
(39, 'Strategi marketing visual merchandising'),
(40, 'Pengelolaan kas'),
(41, 'Perkembangan teknologi di industri dan dunia kerja serta Isu-isu terkini di bidang akuntansi dan keuangan lembaga'),
(42, 'Pengelolaan bisnis retail'),
(43, 'Akuntansi perusahaan jasa, dagang, dan manufaktur'),
(45, 'Estimasi biaya konstruksi dan perumahan'),
(46, 'Perkembangan teknologi dan dunia kerja konstruksi '),
(47, 'Marketing'),
(48, 'Basaha Inggris Jurusan'),
(49, 'Perencanaan dan pengamatan jaringan'),
(50, 'Komputer akuntansi'),
(52, 'Projek kreatif dan kewirausahaan'),
(53, 'Layanan lembaga keuangan syariah'),
(54, 'Perpajakan'),
(55, 'Ekonomi Islam'),
(56, 'Administrasi transaksi'),
(57, 'Pengawasan pekerjaan konstruksi perumahan'),
(58, 'Proses bisnis manajemen perkantoran dan layanan bisnis di dunia kerja'),
(59, 'Pengelolaan rapat / pertemuan'),
(60, 'Proses bisnis manajemen perkantoran dan layanan bisnis di dunia kerja'),
(61, 'Perkembangan teknologi dan isu-isu terkini terkait manajemen perkantoran dan layanan bisnis'),
(62, 'Ekonomi dan Bisnis'),
(63, 'Pengelolaan administrasi umum'),
(64, 'Komunikasi di tempat kerja'),
(65, 'Pengelolaan kearsipan'),
(66, 'Teknologi perkantoran'),
(67, 'Pengelolaan rapat / pertemuan'),
(68, 'Pengelolaan keuangan sederhana'),
(69, 'Pengelolaan SDM'),
(70, 'Pengelolaan sarana dan prasarana'),
(71, 'Pengelolaan humas dan keprotokolan');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `kd` varchar(10) DEFAULT NULL,
  `type_kd` varchar(50) DEFAULT NULL,
  `tugas_1` int(11) DEFAULT NULL,
  `tugas_2` int(11) DEFAULT NULL,
  `tugas_3` int(11) DEFAULT NULL,
  `tugas_4` int(11) DEFAULT NULL,
  `tugas_5` int(11) DEFAULT NULL,
  `tugas_6` int(11) DEFAULT NULL,
  `uh_1` int(11) DEFAULT NULL,
  `uh_2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_siswa`, `kd`, `type_kd`, `tugas_1`, `tugas_2`, `tugas_3`, `tugas_4`, `tugas_5`, `tugas_6`, `uh_1`, `uh_2`) VALUES
(2, 1, '1', 'Pengetahuan', 80, 81, 82, NULL, 89, 78, 76, 45);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_siswa`
--

CREATE TABLE `nilai_siswa` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `id_jurusan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `id_kelas`, `id_jurusan`) VALUES
(1, 'Sony Wakwaw', 1, 1),
(5, 'sadasdasd', 1, 1),
(6, 'ajaw ngentot', 3, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `kelas_jurusan_mapel`
--
ALTER TABLE `kelas_jurusan_mapel`
  ADD PRIMARY KEY (`id_kelas_jurusan_mapel`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kelas_jurusan_mapel`
--
ALTER TABLE `kelas_jurusan_mapel`
  MODIFY `id_kelas_jurusan_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=717;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kelas_jurusan_mapel`
--
ALTER TABLE `kelas_jurusan_mapel`
  ADD CONSTRAINT `kelas_jurusan_mapel_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `kelas_jurusan_mapel_ibfk_2` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`),
  ADD CONSTRAINT `kelas_jurusan_mapel_ibfk_3` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`);

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
