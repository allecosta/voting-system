CREATE DATABASE signo_sw;

USE signo_sw;

CREATE TABLE polls (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO polls (title, description) VALUES ('Qual o seu candidato favorito para governo?', '');

CREATE TABLE poll_answers (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  poll_id INT NOT NULL,
  answers text NOT NULL,
  votes INT NOT NULL DEFAULT '0',
  FOREIGN KEY (poll_id) REFERENCES polls (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO poll_answers (poll_id, answers, votes) VALUES 
(1, 'Lula', 0), 
( 1, 'Ciro Gomes', 0), 
( 1, 'Bolsonaro', 0)



