/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	11/05/2023	Criado Script de criação de tabelas e dados inicias.	  
******************************************************************************************************************
*/

/*Criação das tabelas da base*/

/*Criação da tabela TBIBLIOTECA*/
CREATE TABLE TBIBLIOTECA (
    IDOPERADOR INT NOT NULL AUTO_INCREMENT COMMENT 'ID DO OPERADOR',
    NOMEOPERADOR VARCHAR(50) COMMENT 'NOME DO OPERADOR',
	SENHA VARCHAR(20) COMMENT 'SENHA DO OPERADOR',
	CPF VARCHAR(14) COMMENT 'CPF DO OPERADOR',
	IS_STAFF INT COMMENT 'SE FAZ PARTE DA EQUIPE OU NÃO',
	IS_SUPERUSER INT COMMENT 'SE É SUPER USUARIO OU NÃO',
    PRIMARY KEY (IDOPERADOR),
    INDEX IDX_TBIBLIOTECA_IDOPERADOR (IDOPERADOR),
    INDEX IDX_TBIBLIOTECA_NOMEOPERADOR (NOMEOPERADOR)
);
	
/*Criação da tabela TALUNOS*/
CREATE TABLE TALUNOS (
	IDALUNO INT NOT NULL AUTO_INCREMENT COMMENT "ID DO ALUNO",
	NOMEALUNO VARCHAR(50) NOT NULL COMMENT "NOME DO ALUNO",
	CPFALUNO VARCHAR(14) NOT NULL COMMENT "CPF DO ALUNO",
	DATACADASTRO DATE COMMENT "DATA DE CADASTRO",
	EXALUNO BOOLEAN COMMENT "IDENTIFICADOR SE EX-ALUNO TRUE ou FALSE",
	CURSO VARCHAR(100) COMMENT "NOME DO CURSO",
	TURMA VARCHAR(06) COMMENT "CÓDIGO DA TURMA DO ALUNO",
	TELEFONE VARCHAR(19) COMMENT "TELEFONE DO ALUNO",
	CADASTROATIVO BOOLEAN COMMENT "SITUAÇÃO DO CADASTRO DO ALUNO ATIVO OU INATIVO",
	PRIMARY KEY (IDALUNO, CPFALUNO),
	INDEX IDX_TALUNOS_IDALUNO(IDALUNO),
	INDEX IDX_TALUNOS_NOMEALUNO(NOMEALUNO),
	INDEX IDX_TALUNOS_CPFALUNO(CPFALUNO));	
	
/*Criação da tabela TGENEROSLITERARIOS*/
CREATE TABLE TGENEROSLITERARIOS(
	IDGENERO INT NOT NULL AUTO_INCREMENT COMMENT "CODIGO DO GENERO",
	NOMEGENERO VARCHAR(100) NOT NULL COMMENT "NOME DO GENERO LITERARIO",
	PRIMARY KEY(IDGENERO, NOMEGENERO),
	INDEX IDX_TGENEROSLITERARIOS_IDGENERO(IDGENERO), 
    INDEX IDX_TGENEROSLITERARIOS_NOMEGENERO(NOMEGENERO));
	
/*Criação da tabela TLIVROS*/	
CREATE TABLE TLIVROS (
	IDLIVRO INT NOT NULL AUTO_INCREMENT COMMENT "ID DO LIVRO",
	NOMELIVRO VARCHAR(100) NOT NULL COMMENT "NOME DO LIVRO",
	NOMEAUTOR VARCHAR(50) COMMENT "NOME DO AUTOR",
	CORCAPA VARCHAR(50) COMMENT "COR DA CAPA",
	FONTE VARCHAR(50) COMMENT "FONTE DA CAPA",
	GENERO INT NOT NULL COMMENT "GENERO LITERARIO",
	SINOPSE VARCHAR(200) COMMENT "SINOPSE DO LIVRO",
	QTDE INT COMMENT "QTDE TOTAL",
	CADASTROATIVO BOOLEAN COMMENT "SITUAÇÃO DO CADASTRO DO LIVRO ATIVO OU INATIVO",
	PRIMARY KEY (IDLIVRO, NOMELIVRO, GENERO),
	INDEX IDX_TLIVROS_IDLIVRO(IDLIVRO),
	INDEX IDX_TLIVROS_NOMELIVRO(NOMELIVRO),
	INDEX IDX_TLIVROS_NOMEAUTOR(NOMEAUTOR),
	INDEX IDX_TLIVROS_GENERO(GENERO),
	CONSTRAINT FOREIGN KEY (GENERO) REFERENCES TGENEROSLITERARIOS(IDGENERO));
	
/*Criação da tabela TEMPRESTIMOS_LIVROS*/
CREATE TABLE TEMPRESTIMOS_LIVROS(
	ORDEMEMPRESTIMOS INT NOT NULL AUTO_INCREMENT COMMENT "ORDEM DE EMPRESTIMOS",
	IDALUNO INT NOT NULL COMMENT "ID DO ALUNO",
	IDLIVRO INT NOT NULL COMMENT "ID DO LIVRO",
	IDOPERADOR INT NOT NULL COMMENT "ID DO OPERADOR RESPONSAVEL",
	DATAEMPRESTIMO DATE NOT NULL COMMENT "DATA DO EMPRESTIMO",
	DATAPREVISTADEVOLUCAO DATE NOT NULL COMMENT "DATA PREVISTA DE DEVOLUÇÃO",
	DATADADEVOLUCAO DATE COMMENT "DATA DE DEVOLUÇÃO",
	PRIMARY KEY (ORDEMEMPRESTIMOS, IDALUNO, IDLIVRO),
	CONSTRAINT FOREIGN KEY (IDALUNO) REFERENCES TALUNOS(IDALUNO),
	CONSTRAINT FOREIGN KEY (IDLIVRO) REFERENCES TLIVROS(IDLIVRO),
	CONSTRAINT FOREIGN KEY (IDOPERADOR) REFERENCES TBIBLIOTECA(IDOPERADOR),
	INDEX IDX_TEMPRESTIMOS_LIVROS_ORDEM(ORDEMEMPRESTIMOS),
	INDEX IDX_TEMPRESTIMOS_LIVROS_IDALUNO(IDALUNO),
	INDEX IDX_TEMPRESTIMOS_LIVROS_IDLIVRO(IDLIVRO));

/*Insert do usuario admim*/
INSERT INTO TBIBLIOTECA(NOMEOPERADOR, SENHA, CPF, IS_STAFF, IS_SUPERUSER) VALUES ('MASTER', 'root', '954.523.524-04', 1, 1);

/*Insert do aluno para teste*/
INSERT INTO TALUNOS(NOMEALUNO, CPFALUNO, DATACADASTRO, EXALUNO, CURSO, TURMA, TELEFONE, CADASTROATIVO) VALUES ('ALUNO TESTE', '99999999999', NOW(), FALSE, 'ADS - ANALISE E DESENVOLVIMENTO DE SISTEMAS', 'A-215', '984000000', TRUE);

/*Insert de generos literarios na tabela*/
INSERT INTO TGENEROSLITERARIOS (NOMEGENERO) VALUES
('Romance'),
('Ficção científica'),
('Fantasia'),
('Suspense/Thriller'),
('Mistério'),
('Drama'),
('Comédia'),
('Poesia'),
('Teatro'),
('Biografia'),
('Autobiografia'),
('Ensaio'),
('Crônica'),
('História'),
('HQs'),
('Literatura infantil'),
('Literatura juvenil'),
('Literatura erótica'),
('Literatura de horror'),
('Literatura de guerra'),
('Literatura de viagem'),
('Literatura de ficção histórica'),
('Literatura de humor'),
('Literatura policial'),
('Literatura de romance histórico'),
('Literatura de ficção científica e fantasia juvenil'),
('Literatura de ficção científica e fantasia para adultos'),
('Literatura de autoajuda'),
('Literatura religiosa/espiritual'),
('Literatura de ficção científica apocalíptica/post-apocalíptica'),
('Literatura utópica/distorcida'),
('Literatura de esporte'),
('Literatura de gastronomia/cozinha'),
('Literatura de moda/beleza'),
('Literatura de negócios/economia'),
('Literatura de política/social'),
('Literatura de filosofia/religião'),
('Literatura de arte/arquitetura'),
('Literatura de música'),
('Literatura de ciência/natureza'),
('Literatura de viagem no tempo'),
('Literatura de ficção científica/fantasia urbana'),
('Literatura de ficção científica/fantasia de mundo alternativo'),
('Literatura de ficção científica/fantasia de espaço sideral'),
('Literatura de ficção científica/fantasia distópica');

/*Insert de dois livros para os testes*/
INSERT INTO TLIVROS(NOMELIVRO, NOMEAUTOR, GENERO, SINOPSE, QTDE, CADASTROATIVO) VALUES ('Harry Potter e a Ordem da Fênix', 'J. K. Rowling', 2, 'Em meio ao esplendor decadente do lar ancestral de Sirius Black, a Ordem da Fênix se reúne à sombra da guerra que se aproxima.', 2, true);
INSERT INTO TLIVROS(NOMELIVRO, NOMEAUTOR, GENERO, SINOPSE, QTDE, CADASTROATIVO) VALUES ('1984', 'George Orwell', 38, 'O romance distópico 1984, de George Orwell, é uma crítica sombria à tirania totalitária e à degradação da linguagem.', 1, true);

/*Cadastro de emprestimo de livro*/
INSERT INTO TEMPRESTIMOS_LIVROS(IDALUNO, IDLIVRO, IDOPERADOR, DATAEMPRESTIMO, DATAPREVISTADEVOLUCAO) VALUES (1, 1, 1, NOW(), '2023-06-15');
INSERT INTO TEMPRESTIMOS_LIVROS(IDALUNO, IDLIVRO, IDOPERADOR, DATAEMPRESTIMO, DATAPREVISTADEVOLUCAO) VALUES (1, 1, 1, '2023-04-27', '2023-05-06');