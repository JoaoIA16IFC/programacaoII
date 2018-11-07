CREATE DATABASE meu_blog;
USE meu_blog;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `icone` varchar(30)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `titulo` varchar(200) NOT NULL,
  `texto` varchar(255) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `dt_criacao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `post`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);

INSERT INTO categoria (nome,descricao,icone) VALUES
('Política','Comentários sobre as eleições 2018','fas fa-landmark'),
('Esportes','Tudo sobre futebol e outros esportes','fas fa-football-ball'),
('Entretenimento','Notícias sobre o mundo do cinema','fas fa-headset'),
('Comédia','KKKJKJKJ trallei','fas fa-theater-masks'),
('Infantil','Conteúdo para crianças','fas fa-child'),
('Comida','Hmmm que fome','fas fa-utensils'),
('Moda','Maria linda','fas fa-tshirt');

INSERT INTO post (titulo,texto,id_categoria,autor) VALUES
('Post1','Vou votar em branco',1,'Jorge'),
('Post2','Basquete é toooop',2,'Eu'),
('Post3','SW IX vai flopar',3,'Eu 2019'),
('Post4','KJKJKJKJ GRAZADO',4,'Didi'),
('Post5','Peppa Pig é top',5,'Maria'),
('Post6','Fazer esse bolo hmmm',6,'Ana'),
('Post7','te amo',7,'Eu'),
('Post8','Cade meu pão',6,'Andressa'),
('Post9','Vou te comer',6,'Thairinck'),
('Post10','Comer uma pizza',6,'Nicolas');