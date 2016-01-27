-- customer Table
CREATE TABLE customer(
	customer_id INT UNSIGNED  NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	telphone VARCHAR(64) NOT NULL,
	time TIMESTAMP NOT NULL DEFAULT NOW(),
	PRIMARY KEY(customer_id)
) ENGINE = InnoDB;

CREATE TABLE good(
	good_id INT UNSIGNED  NOT NULL AUTO_INCREMENT,
	name VARCHAR (128) NOT NULL,
	unit ENUM('H','X') NOT NULL,
	price DECIMAL(10,2) NOT NULL,
	cost DECIMAL(10,2) NOT NULL,
	enable ENUM('D','E') NOT NULL DEFAULT 'E',
	PRIMARY KEY(good_id)
) ENGINE  = InnoDB;

CREATE TABLE trade(
	trade_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	customer_id INT UNSIGNED NOT NULL,
	time  TIMESTAMP NOT NULL DEFAULT NOW(),
	money DECIMAL(10,2) NOT NULL,
	PRIMARY KEY(trade_id),
	INDEX(customer_id),
	FOREIGN KEY(customer_id) REFERENCES customer (customer_id)
) ENGINE = InnoDB;

CREATE TABLE trade_detail(
	trade_id INT UNSIGNED NOT NULL,
	good_id INT UNSIGNED NOT NULL,
	count INT UNSIGNED NOT NULL,
	PRIMARY KEY(trade_id, good_id),
	INDEX(good_id),
	FOREIGN KEY(trade_id) REFERENCES trade (trade_id),
	FOREIGN KEY(good_id) REFERENCES good (good_id)
) ENGINE = InnoDB;

CREATE TABLE card(
	card_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	card_number VARCHAR(64) NOT NULL,
	PRIMARY KEY(card_id)
) ENGINE  = InnoDB;

CREATE TABLE receive_money(
	receive_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	customer_id INT UNSIGNED NOT NULL,
	card_id INT UNSIGNED NOT NULL,
	time TIMESTAMP NOT NULL DEFAULT NOW(),
	money DECIMAL(10,2) NOT NULL,
	PRIMARY KEY(receive_id),
	INDEX(customer_id),
	INDEX(card_id),
	FOREIGN KEY(customer_id) REFERENCES customer (customer_id),
	FOREIGN KEY(card_id) REFERENCES card (card_id)
) ENGINE = InnoDB;

CREATE TABLE input(
	input_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	time TIMESTAMP NOT NULL DEFAULT NOW(),
	PRIMARY KEY(input_id)
) ENGINE  = InnoDB;

CREATE TABLE input_detail(
	input_id INT UNSIGNED NOT NULL,
	good_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(input_id, good_id),
	INDEX(good_id),
	count INT UNSIGNED NOT NULL,
	FOREIGN KEY(input_id) REFERENCES input (input_id),
	FOREIGN KEY(good_id) REFERENCES good (good_id)
) ENGINE = InnoDB;
