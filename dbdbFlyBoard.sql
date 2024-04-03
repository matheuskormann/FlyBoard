CREATE DATABASE dbFlyBoard;
USE dbFlyBoard;

DROP TABLE users;

CREATE TABLE users (
    id_user INT PRIMARY KEY UNIQUE AUTO_INCREMENT,
    name VARCHAR(100),
    cpf VARCHAR(100),
    login VARCHAR(100),
    data_de_nacimento VARCHAR(100),
    password VARCHAR(100),
    role VARCHAR(100),
    userImagePath VARCHAR(100)
);
INSERT INTO users (name, cpf, login, data_de_nacimento, password, role, userImagePath )
	VALUES
	("Matheus Kormann", "123.455.674-24", "matheus@gmail.com", "12/12/1999","doblo", "admin", "../imagens/padraoUser.png" );
    ("Lucas Baumer", "345.987.132-54", "luqui@gmail.com", "26/12/1999","luqui24", "cliente", "../imagens/padraoUser.png");
    ("murilo mayer", "234.326.256-75", "murilo@bol.com.br", "16/11/1981","murilui69", "funcionario", "../imagens/padraoUser.png")