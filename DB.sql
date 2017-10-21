CREATE DATABASE "eu_prefeito"
TEMPLATE = 'template0'
ENCODING utf8
CONNECTION LIMIT -1

CREATE TABLE tb_user(
user_id		SERIAL,
name 		VARCHAR(500),
cpf			VARCHAR(500),
phone 		VARCHAR(500),
password	VARCHAR(500),
email		VARCHAR(500),
user_group	VARCHAR(500),
active		BOOLEAN,
entry_date 	VARCHAR(100),
update_at 	VARCHAR(100),
CONSTRAINT pk_tb_user_user_id PRIMARY KEY (user_id)
);

CREATE TABLE tb_solicitation(
solicitation_id		SERIAL,
user_id				INTEGER,
name				VARCHAR(500),
category			VARCHAR(500),
description			VARCHAR(500),	
picture				TEXT,
geolocalization 	VARCHAR(500),
status			VARCHAR(500),
entry_date		VARCHAR(500),
update_at		VARCHAR(500),
CONSTRAINT pk_tb_solicitation_solicitation_id PRIMARY KEY (solicitation_id),
CONSTRAINT fk_tb_solicitation_user_id FOREIGN KEY (user_id) REFERENCES tb_user (user_id)
);

CREATE TABLE tb_solicitation_votes(
solicitation_votes_id	SERIAL,
solicitation_id			INTEGER,
user_id					INTEGER,
vote					VARCHAR(500),
entry_date		VARCHAR(500),
CONSTRAINT pk_tb_solicitation_votes_solicitation_votes_id PRIMARY KEY (solicitation_votes_id),
CONSTRAINT fk_tb_solicitation_votes_solicitation_id FOREIGN KEY (solicitation_id) REFERENCES tb_solicitation (solicitation_id),
CONSTRAINT fk_tb_solicitation_votes_user_id FOREIGN KEY (user_id) REFERENCES tb_user (user_id)
);

CREATE TABLE tb_solicitation_history(
solicitation_history_id		SERIAL,
solicitation_id 			INTEGER,
user_id 					INTEGER,
description 				VARCHAR(500),
status 						VARCHAR(500),
entry_date 					VARCHAR(100),
update_at 					VARCHAR(100),
CONSTRAINT pk_tb_solicitation_history_solicitation_history_id PRIMARY KEY (solicitation_history_id),
CONSTRAINT fk_tb_solicitation_history_solicitation_id FOREIGN KEY (solicitation_id) REFERENCES tb_solicitation (solicitation_id),
CONSTRAINT fk_tb_solicitation_history_user_id FOREIGN KEY (user_id) REFERENCES tb_user (user_id)
);