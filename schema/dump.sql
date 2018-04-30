CREATE TABLE users 
(
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(255) NOT NULL, 
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  remember_token VARCHAR(255),
  remember_identifier VARCHAR(255)
);

INSERT INTO 
  users (id, name, email, password, remember_token, remember_identifier)
VALUES 
  (1, "Israel Morales", "imoralescs@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null),
  (2, "Javier Perez", "perecito@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null),
  (3, "Michelle Louis", "michellin@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null),
  (4, "Stephany Mcnael", "stephkitty@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null),
  (5, "Pedro Diaz", "pedrito@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null),
  (6, "Adam Warlock", "adamhatethano@gmail.com", "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.", null, null);

CREATE TABLE friendships
(
  friend_id INT(11) NULL,
  user_id INT(11) NULL,
  FOREIGN KEY(user_id) 
  REFERENCES users(id)
);

INSERT INTO 
  friendships (user_id, friend_id)
VALUES 
  (1, 2), 
  (2, 1), 
  (3, 4), 
  (4, 3), 
  (1, 5),
  (5, 1),
  (1, 6),
  (6, 1),
  (2, 5),
  (5, 2),
  (2, 6),
  (6, 2),
  (5, 6),
  (6, 5);

/* Query Mysql: */
/* Friends */
/* SELECT * from friendships JOIN users ON users.id = friendships.friend_id WHERE friendships.user_id = 2; */