CREATE DATABASE IF NOT EXISTS reassured_app;

USE reassured_app;

CREATE TABLE users(
  id INT(10) AUTO_INCREMENT,
  username  VARCHAR(75)  NOT NULL,
  token     VARCHAR(300) NOT NULL,
  firstname VARCHAR(75)  NOT NULL,
  surname   VARCHAR(75)  NOT NULL,
  PRIMARY KEY(id)
);
