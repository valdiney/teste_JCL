/*BANCO DE DADOS TESTE*/
CREATE DATABASE teste
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Portuguese_Brazil.1252'
    LC_CTYPE = 'Portuguese_Brazil.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

/*TABELA CURSOS*/
CREATE TABLE IF NOT EXISTS public.cursos
(
    id integer NOT NULL DEFAULT nextval('cursos_id_seq'::regclass),
    nome character varying(200) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT cursos_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE public.cursos
    OWNER to postgres;


/*INSERT DE CURSOS*/
INSERT INTO cursos(nome) VALUES ('Analise e Desenvolvimento de Sistemas');
INSERT INTO cursos(nome) VALUES ('Design Grafico');
INSERT INTO cursos(nome) VALUES ('Analista de Teste de Software');
INSERT INTO cursos(nome) VALUES ('DBA');
INSERT INTO cursos(nome) VALUES ('SCRUM');


/*TABELA ALUNOS*/
CREATE TABLE IF NOT EXISTS public.alunos
(
    id integer NOT NULL DEFAULT nextval('alunos_id_seq'::regclass),
    nome character varying(50) COLLATE pg_catalog."default" NOT NULL,
    email character varying(50) COLLATE pg_catalog."default" NOT NULL,
    id_curso integer,
    CONSTRAINT alunos_pkey PRIMARY KEY (id),
    CONSTRAINT alunos_id_curso_fkey FOREIGN KEY (id_curso)
        REFERENCES public.cursos (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE public.alunos
    OWNER to postgres;