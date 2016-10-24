CREATE TABLE `depenses` (
	`id` int(10) UNSIGNED NOT NULL,
	`montant` decimal(10,2) UNSIGNED NOT NULL,
	`date` int(10) UNSIGNED NOT NULL,
	`name` varchar(255) NOT NULL,
	`group_id` smallint(5) UNSIGNED NOT NULL,
	`user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `depenses`
	ADD PRIMARY KEY (`id`);
ALTER TABLE `depenses`
	MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE `groups` (
	`id` smallint(5) UNSIGNED NOT NULL,
	`name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `groups`
	ADD PRIMARY KEY (`id`);
ALTER TABLE `groups`
	MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE `users` (
	`id` int(10) UNSIGNED NOT NULL,
	`name` varchar(255) NOT NULL,
	`color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `users`
	ADD PRIMARY KEY (`id`);
ALTER TABLE `users`
	MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE `mapping_groups` (
	`user_id` int(10) UNSIGNED NOT NULL,
	`group_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `mapping_groups`
	ADD UNIQUE KEY `key` (`user_id`,`group_id`);

CREATE TABLE `mapping_users` (
	`depense_id` int(10) UNSIGNED NOT NULL,
	`user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `mapping_users`
	ADD UNIQUE KEY `key` (`depense_id`,`user_id`);
