CREATE DATABASE IF NOT EXISTS reassured_app;

USE reassured_app;

CREATE TABLE users(
  id INT(10) AUTO_INCREMENT,
  username  VARCHAR(75)  NOT NULL,
  token     VARCHAR(300) NOT NULL,
  firstname VARCHAR(75)  NOT NULL,
  surname   VARCHAR(75)  NOT NULL,
  created   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE TABLE service_tokens(
  id INT(10) AUTO_INCREMENT,
  service_name VARCHAR(250) NOT NULL,
  type         VARCHAR(75)  NOT NULL,
  token        VARCHAR(250) NOT NULL,
  created      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  updated      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

INSERT INTO service_tokens(
  `service_name`,
  `type`,
  `token`,
  `updated`
) VALUES (
  'onelogin',
  'Bearer',
  'Not yet obtained',
  NOW()
);

ALTER TABLE users ADD COLUMN onelogin_id INT(10) NOT NULL;
