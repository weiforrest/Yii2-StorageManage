-- customer Table
CREATE TABLE customer(
    id INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    info VARCHAR(128) NOT NULL,
    time TIMESTAMP NOT NULL DEFAULT NOW(),
    unpay DECIMAL(10,2) NOT NULL DEFAULT 0,
    payed DECIMAL(10,2) NOT NULL DEFAULT 0,
    sum DECIMAL(10,2) NOT NULL DEFAULT 0,
    PRIMARY KEY(id)
) ENGINE = InnoDB;

CREATE TABLE product(
    id INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    name VARCHAR (128) NOT NULL,
    unit ENUM('P','B') NOT NULL DEFAULT 'B',
    specification INT UNSIGNED NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    cost DECIMAL(10,2) NOT NULL DEFAULT 0,
    PRIMARY KEY(id)
) ENGINE  = InnoDB;

CREATE TABLE delivery(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    customer_id INT UNSIGNED NOT NULL,
    time  TIMESTAMP NOT NULL DEFAULT NOW(),
    money DECIMAL(10,2) NOT NULL DEFAULT 0,
    profit DECIMAL(10,2) NOT NULL DEFAULT 0,
    state ENUM('D', 'A') NOT NULL DEFAULT 'A',
    PRIMARY KEY(id),
    INDEX(customer_id),
    FOREIGN KEY(customer_id) REFERENCES customer (id)
) ENGINE = InnoDB;

CREATE TABLE delivery_detail(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    delivery_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    count INT UNSIGNED NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY(id),
    INDEX(product_id),
    FOREIGN KEY(delivery_id) REFERENCES delivery (id),
    FOREIGN KEY(product_id) REFERENCES product (id)
) ENGINE = InnoDB;

CREATE TABLE account(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    card_number VARCHAR(64) NOT NULL,
    PRIMARY KEY(id)
) ENGINE  = InnoDB;

CREATE TABLE collection(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    account_id INT UNSIGNED NOT NULL,
    time TIMESTAMP NOT NULL DEFAULT NOW(),
    money DECIMAL(10,2) NOT NULL,
    customer_id INT UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    INDEX(account_id),
    INDEX(customer_id),
    FOREIGN KEY(customer_id) REFERENCES customer (id),
    FOREIGN KEY(account_id) REFERENCES account (id)
) ENGINE = InnoDB;

CREATE TABLE stockin(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    time TIMESTAMP NOT NULL DEFAULT NOW(),
    money DECIMAL(10,2) NOT NULL DEFAULT 0,
    PRIMARY KEY(id)
) ENGINE  = InnoDB;

CREATE TABLE stockin_detail(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    stockin_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    INDEX(product_id),
    INDEX(stockin_id),
    count INT UNSIGNED NOT NULL,
    FOREIGN KEY(stockin_id) REFERENCES stockin (id),
    FOREIGN KEY(product_id) REFERENCES product (id)
) ENGINE = InnoDB;
