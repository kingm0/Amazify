
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `card_name` varchar(255) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `exp_month` varchar(10) NOT NULL,
  `exp_year` varchar(10) NOT NULL,
  `cvv` varchar(10) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) 

INSERT INTO `orders` (`order_id`, `full_name`, `email`, `address`, `city`, `state`, `zip`, `card_name`, `card_number`, `exp_month`, `exp_year`, `cvv`, `order_date`) VALUES
(1, 'Mukul Singhal', 'singhalmukul920@gmail.com', 'nishank nagar  colony', 'Agra', 'Uttar Pradesh', '283121', 'Mukul singhal', '64984654984616', '1', '2028', '352', '2024-04-22 01:22:41'),
(6, 'Ria chugh', 'riachugh010903@gmail.com', 'dadjfoi', 'difoah', 'dfkjsgioash', 'dofha', 'dfjnaoih', 'sdfhao', 'dnfaoih', 'cdhfoaish', 'fadsoifh', '2024-04-23 11:39:33');

ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
