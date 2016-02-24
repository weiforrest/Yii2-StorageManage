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
	state ENUM('U','D') NOT NULL, DEFAULT 'U',
	PRIMARY KEY(trade_id),
	INDEX(customer_id),
	FOREIGN KEY(customer_id) REFERENCES customer (customer_id)
) ENGINE = InnoDB;

CREATE TABLE trade_detail(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	trade_id INT UNSIGNED NOT NULL,
	good_id INT UNSIGNED NOT NULL,
	count INT UNSIGNED NOT NULL,
	price DECIMAL(10,2) NOT NULL,
	PRIMARY KEY(id),
	INDEX(good_id),
	INDEX(trade_id),
	FOREIGN KEY(trade_id) REFERENCES trade (id),
	FOREIGN KEY(good_id) REFERENCES good (good_id)
) ENGINE = InnoDB;

CREATE TABLE card(
	card_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	card_number VARCHAR(64) NOT NULL,
	PRIMARY KEY(card_id)
) ENGINE  = InnoDB;

CREATE TABLE receive_money(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	trade_id int UNSIGNED NOT NULL,
	card_id INT UNSIGNED NOT NULL,
	time TIMESTAMP NOT NULL DEFAULT NOW(),
	money DECIMAL(10,2) NOT NULL,
	PRIMARY KEY(id),
	INDEX(card_id),
	INDEX (trade_id),
	FOREIGN KEY(card_id) REFERENCES card (card_id),
	FOREIGN KEY(trade_Id) REFERENCES trade (id)
) ENGINE = InnoDB;

CREATE TABLE input(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	time TIMESTAMP NOT NULL DEFAULT NOW(),
	PRIMARY KEY(input_id)
) ENGINE  = InnoDB;

CREATE TABLE input_detail(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	input_id INT UNSIGNED NOT NULL,
	good_id INT UNSIGNED NOT NULL,
	PRIMARY KEY(id),
  INDEX (input_id),
	INDEX(good_id),
	count INT UNSIGNED NOT NULL,
	FOREIGN KEY(input_id) REFERENCES input (id),
	FOREIGN KEY(good_id) REFERENCES good (good_id)
) ENGINE = InnoDB;
