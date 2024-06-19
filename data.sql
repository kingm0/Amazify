CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `age` int(11) NOT NULL
) 


INSERT INTO `users` (`id`, `name`, `username`, `password`, `address`, `gender`, `age`) VALUES
(1, 'kingm01', 'singhalmukul920@gmail.com', '$2y$10$P3T3Ygywa.RgQJ5ercEoS.dfdGJkxmGTzpjZkkESgMWPYb8Mqg7qq', 'agra', 'male', 20),
(2, 'kingm01', '1654', '$2y$10$DYnJJPVdpytkfVkjYwYptOl3TgDXaGPNHUAcsvkW01JNvbW2lEZSS', '2516', 'male', 20),
(3, 'Ria', 'riachugh010903@gmail.com', '$2y$10$89iq01JGqN1zRMGEZVFqaePhDXl5YKi3S5mTCK65aYm1YyQAYW/IK', 'chandigarh', 'female', 20),
(4, 'Muk', 'mukul6237@gmail.com', '$2y$10$bZ4GPbIjWLiIgGrQ3sJ0BerHMwFbEx3.bc4EamXKI53t19Y2F5abC', 'Agra', 'male', 20);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
