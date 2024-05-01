CREATE DATABASE FLYBOARD;
USE FLYBOARD;


CREATE TABLE USERS (
    ID_USER INT PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(100),
    CPF VARCHAR(100),
    EMAIL VARCHAR(100),
    DATA_DE_NASCIMENTO VARCHAR(100),
    PASSWORD VARCHAR(100),
    ROLE VARCHAR(100),
    USERIMAGEPATH VARCHAR(200),
    UNIQUE (CPF, EMAIL)
);

CREATE TABLE BAGAGENS (
    ID_BAGAGEM INT PRIMARY KEY AUTO_INCREMENT,
    CODIGO_BAGAGEM VARCHAR(100) UNIQUE,
    PESO VARCHAR(100),
    TIPO VARCHAR(100),
    DESCRICAO VARCHAR(100),
	STATUS_BAGAGEM VARCHAR(100),
    FK_PASSAGENS_ID_PASSAGEM INT
);

CREATE TABLE PASSAGENS (
    ID_PASSAGEM INT PRIMARY KEY AUTO_INCREMENT,
    CODIGO_PASSAGEM VARCHAR(100) UNIQUE,
    NOME_PASSAGEIRO VARCHAR(100),
    CPF_PASSAGEIRO VARCHAR(100),
    CLASSE VARCHAR(100),
    FK_USERS_ID_USER INT,
    FK_VOOS_ID_VOO INT
);

CREATE TABLE VOOS (
    ID_VOO INT PRIMARY KEY AUTO_INCREMENT,
    CODIGO_VOO VARCHAR(100) UNIQUE,
    LOCAL_DE_ORIGEM VARCHAR(100),
    LOCAL_DE_DESTINO VARCHAR(100),
    DATA_IDA VARCHAR(100),
    DATA_CHEGADA VARCHAR(100),
    PORTAO_EMBARQUE VARCHAR(100),
    AERONAVE VARCHAR(100),
    CODIGO_AERONAVE VARCHAR(100),
    OPERADORA VARCHAR(100),
    VOOIMAGEMPATH VARCHAR(200),
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

-- Inserção de uma nova viagem para o usuário com ID 1
INSERT INTO PASSAGENS (CODIGO_PASSAGEM, NOME_PASSAGEIRO, CPF_PASSAGEIRO, VALOR, CLASSE, FK_USERS_ID_USER, FK_VOOS_ID_VOO)
VALUES ('1', 'Fulano de Tal', '123.456.789-10', '500.00', 'Econômica', '1', '1');

INSERT INTO BAGAGENS (CODIGO_BAGAGEM, PESO, TIPO, DESCRICAO, STATUS_BAGAGEM, FK_PASSAGENS_ID_PASSAGEM)
VALUES ('BAG124', '15kg', 'Mala de Mão', 'Livros e eletrônicos', 'Em Trânsito', 
        (SELECT ID_PASSAGEM FROM PASSAGENS WHERE FK_USERS_ID_USER = 1 LIMIT 1)),
       ('BAG125', '30kg', 'Mala de Grande Porte', 'Roupas e objetos pessoais', 'Em Trânsito', 
        (SELECT ID_PASSAGEM FROM PASSAGENS WHERE FK_USERS_ID_USER = 1 LIMIT 1)),
       ('BAG126', '10kg', 'Mala de Mão', 'Documentos e laptop', 'Em Trânsito', 
        (SELECT ID_PASSAGEM FROM PASSAGENS WHERE FK_USERS_ID_USER = 1 LIMIT 1)),
       ('BAG127', '25kg', 'Mala de Grande Porte', 'Artigos de viagem', 'Em Trânsito', 
        (SELECT ID_PASSAGEM FROM PASSAGENS WHERE FK_USERS_ID_USER = 1 LIMIT 1)),
       ('BAG128', '18kg', 'Mala de Mão', 'Medicamentos e produtos de higiene', 'Em Trânsito', 
        (SELECT ID_PASSAGEM FROM PASSAGENS WHERE FK_USERS_ID_USER = 1 LIMIT 1)),
       ('BAG129', '22kg', 'Mala de Grande Porte', 'Presentes e lembranças', 'Em Trânsito', 
        (SELECT ID_PASSAGEM FROM PASSAGENS WHERE FK_USERS_ID_USER = 1 LIMIT 1));
     
     