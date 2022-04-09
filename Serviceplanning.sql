CREATE TABLE `worker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `birthDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `worker` (`id`, `firstName`, `lastName`, `birthDate`) VALUES
(1, 'Ali', 'Ben Taher', '1980-04-12'),
(2, 'Haroun', 'Lafi', '1981-05-12'),
(3, 'Salah', 'Sadaoui', '1982-06-12'),
(4, 'Mohamed', 'Lassoued', '1983-07-12'),
(5, 'Said', 'Tiss', '1984-08-12');

CREATE TABLE `shift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,  
  PRIMARY KEY (`id`)
);

INSERT INTO `shift` (`id`, `label`) VALUES
(1, '0-8'),
(2, '8-16'),
(3, '16-24');

CREATE TABLE `planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `day` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `planning` (`id`, `worker_id`, `shift_id`, `day`) VALUES
(1, 3, 1, '2022-04-14'),
(2, 1, 1, '2022-04-14'),
(3, 5, 1, '2022-04-14'),
(4, 2, 3, '2022-04-14'),
(5, 4, 2, '2022-04-14'),
(6, 1, 2, '2022-04-15'),
(7, 2, 1, '2022-04-15'),
(8, 3, 2, '2022-04-15'),
(9, 4, 2, '2022-04-15'),
(10, 5, 3, '2022-04-15');