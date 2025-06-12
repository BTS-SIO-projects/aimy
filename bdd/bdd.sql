DROP DATABASE IF EXISTS aimy; 
CREATE DATABASE aimy;
USE aimy;

CREATE TABLE message (
    idmessage INT(3) NOT NULL AUTO_INCREMENT,
    titre VARCHAR(50),
    description TEXT,
    idmedecin INT NOT NULL,
    idpatient INT NOT NULL,
    PRIMARY KEY (idmessage),
    FOREIGN KEY (idmedecin) REFERENCES medecin(idmedecin),
    FOREIGN KEY (idpatient) REFERENCES patient(idpatient)
);


CREATE TABLE specialite (
    idspecialite INT(3) NOT NULL AUTO_INCREMENT,
    categorie VARCHAR(50),
    PRIMARY KEY (idspecialite)
);

CREATE TABLE patient (
    idpatient INT(3) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    age INT(3),
    email VARCHAR(50),
    password VARCHAR(50),
    telephone VARCHAR(50),
    adresse VARCHAR(50),
    numeroSecu VARCHAR(50),
    PRIMARY KEY (idpatient)
);

CREATE TABLE lieu (
    idlieu INT(3) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50),
    adresse VARCHAR(200),
    typeLieu VARCHAR(100),
    PRIMARY KEY (idlieu)
);

CREATE TABLE medecin (
    idmedecin INT(3) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(50),
    telephone VARCHAR(10),
    photo LONGBLOB,
    statut ENUM("en attente", "valider", "refuser"),
    idspecialite INT(3),
    idlieu INT(3),
    PRIMARY KEY (idmedecin),
    FOREIGN KEY (idspecialite) REFERENCES specialite(idspecialite),
    FOREIGN KEY (idlieu) REFERENCES lieu(idlieu)
);

CREATE TABLE rdv (
    idrdv INT(3) NOT NULL AUTO_INCREMENT,
    daterdv DATE,
    heureRdv TIME,
    motif VARCHAR(50),
    idmedecin INT(3),
    idpatient INT(3),
    idlieu INT(3),
    PRIMARY KEY (idrdv),
    FOREIGN KEY (idmedecin) REFERENCES medecin(idmedecin),
    FOREIGN KEY (idpatient) REFERENCES patient(idpatient),
    FOREIGN KEY (idlieu) REFERENCES lieu(idlieu)
);

CREATE TABLE document (
    iddocument INT(3) NOT NULL AUTO_INCREMENT,
    typeDoc VARCHAR(50),
    url VARCHAR(50),
    datedepot DATE,
    description VARCHAR(50),
    idmedecin INT(3),
    idpatient INT(3),
    idrdv INT(3),
    PRIMARY KEY (iddocument), 
    FOREIGN KEY (idmedecin) REFERENCES medecin(idmedecin),
    FOREIGN KEY (idpatient) REFERENCES patient(idpatient),
    FOREIGN KEY (idrdv) REFERENCES rdv(idrdv)   
);

CREATE TABLE diplome (
    iddiplome INT(3) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50),
    sigle VARCHAR(50),
    faculte VARCHAR(50),
    PRIMARY KEY (iddiplome)
);

CREATE TABLE avoir (
    iddiplome INT(3),
    idmedecin INT(3),
    annee DATE,
    PRIMARY KEY (iddiplome, idmedecin),
    FOREIGN KEY (idmedecin) REFERENCES medecin(idmedecin),
    FOREIGN KEY (iddiplome) REFERENCES diplome(iddiplome) 
);
CREATE TABLE administrateur (
    idAdministrateur INT(3) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(15),
    PRIMARY KEY (idAdministrateur)
);
/*
commande pour valider le statut du medecin 
select *from medecin; 

UPDATE medecin
SET statut = 'valider'
WHERE idmedecin = 'TON_ID';

INSERT INTO specialite (categorie) VALUES 
('Cardiologie'),
('Neurologie'),
('Dermatologie'),
('Pediatrie'),
('Orthopédie');
INSERT INTO lieu (nom, adresse, typeLieu) VALUES 
('Delafontaine', '12 Avenue de Paris', 'Hopital'),
('Lilas', '45 carrefour Sebastopol', 'Clinique'),
('Soleil', '12  clichy', 'Centre'),
('paris', '78 Rue Louis', 'Hopital'),
('Dr. Lemoine', '9 Place de Clichy', 'Cabinet');
*/