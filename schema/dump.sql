CREATE TABLE users 
(
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(255) NOT NULL, 
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  remember_token VARCHAR(255),
  remember_identifier VARCHAR(255)
);

INSERT INTO users (id, name, email, password, remember_token, remember_identifier)
VALUES (1, "Israel Morales", "imoralescs@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null);
INSERT INTO users (id, name, email, password, remember_token, remember_identifier)
VALUES (2, "Javier Perez", "perecito@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null);
INSERT INTO users (id, name, email, password, remember_token, remember_identifier)
VALUES (3, "Michelle Louis", "michellin@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null);
INSERT INTO users (id, name, email, password, remember_token, remember_identifier)
VALUES (4, "Stephany Mcnael", "stephkitty@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null);
INSERT INTO users (id, name, email, password, remember_token, remember_identifier)
VALUES (5, "Pedro Diaz", "pedrito@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null);
INSERT INTO users (id, name, email, password, remember_token, remember_identifier)
VALUES (6, "Adam Warlock", "adamhatethano@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null);

CREATE TABLE friendships
(
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(255) NOT NULL, 
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  remember_token VARCHAR(255),
  remember_identifier VARCHAR(255)
);