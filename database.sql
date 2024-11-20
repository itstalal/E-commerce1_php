drop DATABASE if exists projet;
CREATE DATABASE projet;
use projet;

CREATE table Utilisateur
(
id_utilisateur int auto_increment primary Key not null,
nom varchar (50) not null,
prenom varchar (150) not null, 
courriel varchar (250) not null unique,
mot_de_passe text not null,
date_naissance date,
telephone varchar (50)
);
CREATE table Adresse
(
id_adresse int auto_increment primary Key not null,
rue varchar (100)  not null,
code_postale varchar (10) not null,
province varchar (30) not null,
ville varchar (50) not null,
numero varchar (15) not null
);
CREATE table Adresse_utilisateur
(
id_utilisateur int,
id_adresse int
);
CREATE table Role
(
id_role int auto_increment primary Key not null,
description varchar (50)  not null
);

CREATE table Role_utilisateur
(
id_role int,
id_utilisateur int
);
CREATE TABLE image_utilisateur
(
 id_image  INT auto_increment PRIMARY KEY NOT NULL,
 chemin TEXT,
 id_utilisateur INT
);

CREATE table Produit
(
id_produit int auto_increment primary Key not null,
nom varchar (250) not null,
descriptions text,
prix_unitaire varchar (10)  not null,
quantite int DEFAULT 0
);
CREATE TABLE Commande
(
    id_commande INT auto_increment PRIMARY KEY NOT NULL,
    id_utilisateur INT,
    quantite INT,
    prix VARCHAR (10),
    date_commane DATETIME,
    etat VARCHAR (50)
);
CREATE TABLE Produit_commande
(
    id_commande INT,
    id_produit INT,
    quantite INT NOT NULL
);

CREATE TABLE image_produit
(
 id_image  INT auto_increment PRIMARY KEY NOT NULL,
 chemin TEXT,
 id_produit INT
);

CREATE TABLE console
(
    id_console  INT auto_increment PRIMARY KEY NOT NULL,
    nom TEXT
);

CREATE Table console_produit
(
 id_produit INT,
  id_console INT   
);

CREATE TABLE style
(
    id_style INT auto_increment PRIMARY KEY NOT NULL,
    nom TEXT,
    id_produit INT
)

ALTER TABLE Adresse_utilisateur
    ADD CONSTRAINT fk_adresse_utilisateur
        FOREIGN KEY (id_adresse) REFERENCES Adresse(id_adresse)
            ON DELETE CASCADE ON UPDATE CASCADE,

    ADD CONSTRAINT fk_utilisateur_adresse
        FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur (id_utilisateur)
            ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE Role_utilisateur
    ADD CONSTRAINT fk_role_utilisateur
        FOREIGN KEY (id_role) REFERENCES Role(id_role)
            ON DELETE CASCADE ON UPDATE CASCADE ,

    ADD CONSTRAINT fk_utilisateur_role
        FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur (id_utilisateur)
            ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE image_utilisateur
    ADD CONSTRAINT fk_image_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
                on DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE Commande
    ADD CONSTRAINT fk_commande_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
                on DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE Produit_commande
    ADD CONSTRAINT fk_produit_commande
        FOREIGN KEY (id_produit) REFERENCES Produit(id_produit)
                ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT fk_commande_produit
        FOREIGN KEY (id_commande) REFERENCES Commande(id_commande)
                ON DELETE CASCADE on  UPDATE CASCADE;

ALTER TABLE console_produit
    ADD CONSTRAINT fk_idconsole_produit
        FOREIGN KEY (id_produit) REFERENCES Produit(id_produit)
                ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT fk_console_produit
        FOREIGN KEY (id_console ) REFERENCES console(id_console)
                ON DELETE CASCADE on  UPDATE CASCADE;

ALTER TABLE style
    ADD CONSTRAINT fk_produit_id
        FOREIGN KEY (id_produit) REFERENCES Produit(id_produit)
                on DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE image_produit
    ADD CONSTRAINT fk_image_produit
        FOREIGN KEY (id_produit) REFERENCES Produit(id_produit)
                on DELETE CASCADE ON UPDATE CASCADE;  


 CREATE TABLE question(id_question INT auto_increment PRIMARY KEY, question text);





ALTER TABLE console
    ADD CONSTRAINT fk_consolee_id
        FOREIGN KEY (id_console) REFERENCES console(id_console)
                on DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE produit
    ADD CONSTRAINT fk_idc_produit
        FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
                on DELETE CASCADE ON UPDATE CASCADE; 