CREATE DATABASE FLYBOARD;
USE FLYBOARD;


CREATE TABLE USERS (
    ID_USER INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    NAME VARCHAR(100) NOT NULL,
    CPF VARCHAR(100) NOT NULL,
    EMAIL VARCHAR(100) NOT NULL,
    DATA_DE_NASCIMENTO VARCHAR(100) NOT NULL,
    PASSWORD VARCHAR(100) NOT NULL,
    ROLE VARCHAR(100) NOT NULL,
    USERIMAGEPATH VARCHAR(200),
    UNIQUE (CPF, EMAIL)
);

CREATE TABLE BAGAGENS (
    ID_BAGAGEM INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    CODIGO_BAGAGEM VARCHAR(100) UNIQUE NOT NULL,
    PESO VARCHAR(100) NOT NULL,
    TIPO VARCHAR(100) NOT NULL,
    DESCRICAO VARCHAR(100) NOT NULL,
	STATUS_BAGAGEM VARCHAR(100) NOT NULL,
    FK_PASSAGENS_ID_PASSAGEM INT

);

CREATE TABLE PASSAGENS (
    ID_PASSAGEM INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    CODIGO_PASSAGEM VARCHAR(100) UNIQUE NOT NULL,
    NOME_PASSAGEIRO VARCHAR(100) NOT NULL,
    CPF_PASSAGEIRO VARCHAR(100) NOT NULL,
    ASSENTO VARCHAR(5) NOT NULL,
    CLASSE VARCHAR(100) NOT NULL,
    FK_USERS_ID_USER INT,
    FK_VOOS_ID_VOO INT
);

CREATE TABLE VOOS (
    ID_VOO INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    CODIGO_VOO VARCHAR(100) UNIQUE NOT NULL,
    LOCAL_DE_ORIGEM VARCHAR(100) NOT NULL,
    LOCAL_DE_DESTINO VARCHAR(100) NOT NULL,
    DATA_IDA VARCHAR(100) NOT NULL,
    DATA_CHEGADA VARCHAR(100) NOT NULL,
    PORTAO_EMBARQUE VARCHAR(100) NOT NULL,
    AERONAVE VARCHAR(100) NOT NULL,
    CODIGO_AERONAVE VARCHAR(100) NOT NULL,
    OPERADORA VARCHAR(100) NOT NULL,
    VOOIMAGEMPATH VARCHAR(200) NOT NULL
);
 
ALTER TABLE BAGAGENS ADD CONSTRAINT FK_BAGAGENS_2
    FOREIGN KEY (FK_PASSAGENS_ID_PASSAGEM)
    REFERENCES PASSAGENS (ID_PASSAGEM)
    ON DELETE RESTRICT;
 
ALTER TABLE PASSAGENS ADD CONSTRAINT FK_PASSAGENS_2
    FOREIGN KEY (FK_USERS_ID_USER)
    REFERENCES USERS (ID_USER)
    ON DELETE RESTRICT;
 
ALTER TABLE PASSAGENS ADD CONSTRAINT FK_PASSAGENS_3
    FOREIGN KEY (FK_VOOS_ID_VOO)
    REFERENCES VOOS (ID_VOO)
    ON DELETE RESTRICT;
    
    INSERT INTO USERS (NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, PASSWORD, ROLE, USERIMAGEPATH)
VALUES
    ("Matheus Kormann", "123.455.674-24", "matheus@gmail.com", "12/12/1999","$2y$10$NVD5KphAQLpuMZIuXWlew.ED7mdjyr2Et4Y15qFJoH4weWx72NWNS", "admin", "../imagens/padraoUser.png" ),-- doblo
    ("Lucas Baumer", "345.987.132-54", "luqui@gmail.com", "26/12/1999","$10$108wqJcVn6A3PAXujFaxRunzXqeXJeVC4/xesAiiQYgnsaqLY5lAa", "admin", "../imagens/padraoUser.png"),-- 123
    ("murilo mayer", "234.326.256-75", "murilo@bol.com.br", "16/11/1981","$10$108wqJcVn6A3PAXujFaxRunzXqeXJeVC4/xesAiiQYgnsaqLY5lAa", "admin", "../imagens/padraoUser.png");-- 123
    
    

    INSERT INTO VOOS (CODIGO_VOO, LOCAL_DE_ORIGEM, LOCAL_DE_DESTINO, DATA_IDA, DATA_CHEGADA, PORTAO_EMBARQUE, AERONAVE, CODIGO_AERONAVE, OPERADORA, VOOIMAGEMPATH)
VALUES
    ("VOO123", "São Paulo", "Rio de Janeiro", "2024-04-20 08:00:00", "2024-04-20 10:00:00", "Gate 5", "Airbus A320", "A320-123", "LATAM", "../imagens/padraoVoos.jpeg"),
    ("VOO124", "Rio de Janeiro", "São Paulo", "2024-04-21 09:30:00", "2024-04-21 11:00:00", "Gate 3", "Boeing 737", "B737-456", "GOL", "../imagens/padraoVoos.jpeg"),
    ("VOO125", "São Paulo", "Belo Horizonte", "2024-04-22 06:45:00", "2024-04-22 08:00:00", "Gate 8", "Embraer E190", "E190-789", "Azul", "../imagens/padraoVoos.jpeg"),
    ("VOO126", "São Paulo", "Curitiba", "2024-04-23 07:00:00", "2024-04-23 08:15:00", "Gate 2", "Airbus A320", "A320-124", "LATAM", "../imagens/padraoVoos.jpeg"),
    ("VOO127", "Curitiba", "Porto Alegre", "2024-04-23 08:30:00", "2024-04-23 10:00:00", "Gate 7", "Boeing 737", "B737-457", "GOL", "../imagens/padraoVoos.jpeg"),
    ("VOO128", "Porto Alegre", "Brasília", "2024-04-24 10:00:00", "2024-04-24 11:30:00", "Gate 6", "Embraer E190", "E190-790", "Azul", "../imagens/padraoVoos.jpeg"),
    ("VOO129", "Brasília", "Salvador", "2024-04-25 12:00:00", "2024-04-25 14:00:00", "Gate 4", "Airbus A320", "A320-125", "LATAM", "../imagens/padraoVoos.jpeg"),
    ("VOO130", "Salvador", "Fortaleza", "2024-04-25 14:30:00", "2024-04-25 17:00:00", "Gate 9", "Boeing 737", "B737-458", "GOL", "../imagens/padraoVoos.jpeg"),
    ("VOO131", "Fortaleza", "Manaus", "2024-04-26 07:00:00", "2024-04-26 10:30:00", "Gate 1", "Embraer E190", "E190-791", "Azul", "../imagens/padraoVoos.jpeg"),
    ("VOO132", "Manaus", "Recife", "2024-04-26 11:00:00", "2024-04-26 13:30:00", "Gate 5", "Airbus A320", "A320-126", "LATAM", "../imagens/padraoVoos.jpeg"),
    ("VOO133", "Recife", "Belém", "2024-04-27 14:00:00", "2024-04-27 17:00:00", "Gate 3", "Boeing 737", "B737-459", "GOL", "../imagens/padraoVoos.jpeg"),
    ("VOO134", "Belém", "São Luís", "2024-04-28 08:00:00", "2024-04-28 11:00:00", "Gate 6", "Embraer E190", "E190-792", "Azul", "../imagens/padraoVoos.jpeg"),
    ("VOO135", "São Luís", "Florianópolis", "2024-04-28 15:00:00", "2024-04-28 16:30:00", "Gate 4", "Airbus A320", "A320-127", "LATAM", "../imagens/padraoVoos.jpeg"),
    ("VOO136", "Florianópolis", "Campo Grande", "2024-04-29 10:00:00", "2024-04-29 12:00:00", "Gate 8", "Boeing 737", "B737-460", "GOL", "../imagens/padraoVoos.jpeg"),
    ("VOO137", "Campo Grande", "Foz do Iguaçu", "2024-04-29 14:00:00", "2024-04-29 16:00:00", "Gate 2", "Embraer E190", "E190-793", "Azul", "../imagens/padraoVoos.jpeg"),
    ("VOO138", "Foz do Iguaçu", "Natal", "2024-04-30 09:00:00", "2024-04-30 11:30:00", "Gate 7", "Airbus A320", "A320-128", "LATAM", "../imagens/padraoVoos.jpeg"),
    ("VOO139", "Natal", "Maceió", "2024-05-01 10:30:00", "2024-05-01 12:30:00", "Gate 3", "Boeing 737", "B737-461", "GOL", "../imagens/padraoVoos.jpeg"),
    ("VOO140", "Maceió", "Aracaju", "2024-05-02 07:00:00", "2024-05-02 09:30:00", "Gate 1", "Embraer E190", "E190-794", "Azul", "../imagens/padraoVoos.jpeg"),
    ("VOO141", "Aracaju", "Teresina", "2024-05-02 12:00:00", "2024-05-02 14:30:00", "Gate 6", "Airbus A320", "A320-129", "LATAM", "../imagens/padraoVoos.jpeg"),
    ("VOO142", "Teresina", "João Pessoa", "2024-05-03 09:00:00", "2024-05-03 11:30:00", "Gate 5", "Boeing 737", "B737-462", "GOL", "../imagens/padraoVoos.jpeg");


     