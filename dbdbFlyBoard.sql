CREATE DATABASE dbFlyBoard;
USE dbFlyBoard;

/* Lógico_1: */

CREATE TABLE USERS (
    ID_USER INT PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(50),
    CPF VARCHAR(15) UNIQUE,
    EMAIL VARCHAR(100) UNIQUE,
    DATA_DE_NASCIMENTO VARCHAR(100),
    PASSWORD VARCHAR(100),
    ROLE VARCHAR(100),
    USERIMAGEPATH VARCHAR(100),
    UNIQUE (CPF, EMAIL)
);

CREATE TABLE BAGAGENS (
    ID INT(50) PRIMARY KEY AUTO_INCREMENT,
    CODIGO_BAGAGEM INT(50) UNIQUE,
    PESO INT(50),
    TIPO VARCHAR(50),
    DESCRICAO VARCHAR(100),
    FK_PASSAGENS_ID_PASSAGEM INT(50)
);

CREATE TABLE PASSAGENS (
    CODIGO_PASSAGEM VARCHAR(100) UNIQUE,
    ID_PASSAGEM INT(50) PRIMARY KEY AUTO_INCREMENT,
    VALOR INT(200),
    CLASSE VARCHAR(50),
    FK_USERS_ID_USER INT,
    FK_VOOS_CODIGO_VOO VARCHAR(100)
);

CREATE TABLE VOOS (
    CODIGO_VOO VARCHAR(100) PRIMARY KEY UNIQUE,
    ID_VOO INT(50) AUTO_INCREMENT,
    DESTINO VARCHAR(100),
    DATA_IDA VARCHAR(50),
    DATA_CHEGADA VARCHAR(50),
    PORTAO_EMBARQUE VARCHAR(100),
    AERONAVE VARCHAR(50),
    OPERADORA VARCHAR(100),
    VOOIMAGEMPATH VARCHAR(100)
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
    FOREIGN KEY (FK_VOOS_CODIGO_VOO)
    REFERENCES VOOS (CODIGO_VOO)
    ON DELETE RESTRICT;
    
    INSERT INTO USERS (NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, PASSWORD, ROLE, USERIMAGEPATH)
VALUES
    ("Matheus Kormann", "123.455.674-24", "matheus@gmail.com", "12/12/1999","doblo", "admin", "../imagens/padraoUser.png" ),
    ("Lucas Baumer", "345.987.132-54", "luqui@gmail.com", "26/12/1999","luqui24", "admin", "../imagens/padraoUser.png"),
    ("murilo mayer", "234.326.256-75", "murilo@bol.com.br", "16/11/1981","murilui69", "admin", "../imagens/padraoUser.png");
    
    
    INSERT INTO USERS (NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, PASSWORD, ROLE, USERIMAGEPATH)
VALUES
    ("Ana Silva", "456.789.123-98", "ana.silva@example.com", "05/07/1990", "ana123", "cliente", "../imagens/padraoUser.png"),
    ("Carlos Santos", "987.654.321-01", "carlos.santos@example.com", "15/03/1985", "carlos85", "cliente", "../imagens/padraoUser.png"),
    ("Maria Oliveira", "654.321.987-74", "maria.oliveira@example.com", "10/10/1978", "maria1978", "cliente", "../imagens/padraoUser.png"),
    ("João Souza", "789.456.123-58", "joao.souza@example.com", "20/05/1995", "joao95", "cliente", "../imagens/padraoUser.png"),
    ("Fernanda Costa", "852.741.963-85", "fernanda.costa@example.com", "25/11/1983", "fernanda83", "cliente", "../imagens/padraoUser.png"),
    ("Pedro Mendes", "369.258.147-63", "pedro.mendes@example.com", "02/04/1992", "pedro92", "cliente", "../imagens/padraoUser.png"),
    ("Juliana Lima", "147.258.369-74", "juliana.lima@example.com", "14/09/1989", "juliana89", "cliente", "../imagens/padraoUser.png"),
    ("Rafaela Almeida", "963.852.741-52", "rafaela.almeida@example.com", "30/07/1997", "rafaela97", "cliente", "../imagens/padraoUser.png"),
    ("Gabriel Pereira", "258.369.147-85", "gabriel.pereira@example.com", "18/12/1993", "gabriel93", "cliente", "../imagens/padraoUser.png"),
    ("Luiza Fernandes", "741.852.963-96", "luiza.fernandes@example.com", "07/06/1987", "luiza87", "cliente", "../imagens/padraoUser.png"),
    ("Thiago Oliveira", "159.357.258-74", "thiago.oliveira@example.com", "22/03/1980", "thiago80", "cliente", "../imagens/padraoUser.png"),
    ("Camila Santos", "753.951.852-63", "camila.santos@example.com", "12/08/1998", "camila98", "cliente", "../imagens/padraoUser.png"),
    ("Marcelo Lima", "369.258.147-85", "marcelo.lima@example.com", "17/04/1984", "marcelo84", "cliente", "../imagens/padraoUser.png"),
    ("Eduarda Oliveira", "258.147.369-52", "eduarda.oliveira@example.com", "28/09/1996", "eduarda96", "cliente", "../imagens/padraoUser.png"),
    ("André Souza", "852.369.147-63", "andre.souza@example.com", "08/11/1991", "andre91", "cliente", "../imagens/padraoUser.png"),
    ("Pedro Silva", "123.456.789-01", "pedro.silva@example.com", "15/07/1980", "pedro80", "funcionario", "../imagens/padraoUser.png"),
    ("Carla Santos", "987.654.321-02", "carla.santos@example.com", "25/03/1985", "carla85", "funcionario", "../imagens/padraoUser.png"),
    ("Luciana Oliveira", "654.321.987-03", "luciana.oliveira@example.com", "20/10/1978", "luciana78", "funcionario", "../imagens/padraoUser.png"),
    ("Marcos Souza", "789.456.123-04", "marcos.souza@example.com", "05/05/1990", "marcos90", "funcionario", "../imagens/padraoUser.png"),
    ("Tatiane Fernandes", "852.741.963-05", "tatiane.fernandes@example.com", "10/11/1983", "tatiane83", "funcionario", "../imagens/padraoUser.png"),
    ("Renato Lima", "369.258.147-06", "renato.lima@example.com", "02/04/1988", "renato88", "funcionario", "../imagens/padraoUser.png"),
    ("Camila Oliveira", "147.258.369-07", "camila.oliveira@example.com", "15/07/1995", "camila95", "funcionario", "../imagens/padraoUser.png");