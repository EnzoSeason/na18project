CREATE TABLE Administrateur (
login VARCHAR PRIMARY KEY,
nom VARCHAR(20),
prenom VARCHAR(20),
motDePasse VARCHAR NOT NULL,
adresseMail VARCHAR(50) UNIQUE);

CREATE TABLE Vendeur (
login VARCHAR PRIMARY KEY,
nom VARCHAR(20),
prenom VARCHAR(20),
motDePasse VARCHAR NOT NULL,
adresseMail VARCHAR(50) UNIQUE,
adresse VARCHAR,
cooBanqueNum NUMERIC(16),
dateExpiration CHAR(5),
cryptoCarte NUMERIC(3),
CHECK (dateExpiration LIKE '%%/%%'));

CREATE TABLE Annonce (
loginVendeur VARCHAR(20),
FOREIGN KEY (loginVendeur) REFERENCES Vendeur(login),
titre VARCHAR(100),
PRIMARY KEY(loginVendeur, titre),
description VARCHAR UNIQUE,
photographie VARCHAR,
prix FLOAT NOT NULL,
tag VARCHAR,
CHECK (photographie LIKE 'http%'));

CREATE TABLE Acheteur (
login VARCHAR PRIMARY KEY,
nom VARCHAR(20),
prenom VARCHAR(20),
motDePasse VARCHAR NOT NULL,
adresseMail VARCHAR(50) UNIQUE,
adresse VARCHAR,
cooBanqueNum NUMERIC(16),
dateExpiration CHAR(5),
cryptoCarte NUMERIC(3),
CHECK (dateExpiration LIKE '%%/%%'));

CREATE TABLE Panier (
loginAcheteur VARCHAR(20) PRIMARY KEY,
FOREIGN KEY (loginAcheteur) REFERENCES Acheteur(login),
quantité INTEGER NOT NULL);

CREATE TYPE expeditionTypeContrat AS ENUM ('Colissimo','TNT','Retrait');
CREATE TABLE Contrat (
loginVendeur VARCHAR(20),
annonceTitre VARCHAR(100),
FOREIGN KEY (loginVendeur, annonceTitre) REFERENCES Annonce(loginVendeur, titre),
loginAcheteur VARCHAR(20),
FOREIGN KEY (loginAcheteur) REFERENCES Panier(loginAcheteur),
dateAjout DATE NOT NULL,
quantité INTEGER NOT NULL,
expeditionType expeditionTypeContrat,
expeditionCout FLOAT,
paiement BOOLEAN NOT NULL);

CREATE TABLE Notation (
loginVendeur VARCHAR(20) NOT NULL,
FOREIGN KEY (loginVendeur) REFERENCES Vendeur(login),
loginAcheteur VARCHAR(20) NOT NULL,
FOREIGN KEY (loginAcheteur) REFERENCES Acheteur(login),
score INTEGER,
avis VARCHAR,
dateAvis DATE,
CHECK (score BETWEEN 0 AND 20));

CREATE TYPE typeRub AS ENUM ('Selection','Blog','Catégorie');
CREATE TABLE Rubrique (
nom VARCHAR(50) PRIMARY KEY,
type typeRub,
description VARCHAR,
loginAdmin VARCHAR(20) NOT NULL,
FOREIGN KEY (loginAdmin) REFERENCES Administrateur(login));

CREATE TABLE AnnonceDansRubrique (
rubriqueNom VARCHAR(50) NOT NULL,
FOREIGN KEY (rubriqueNom) REFERENCES Rubrique(nom),
annonceVendeur VARCHAR(20),
annonceTitre VARCHAR(100),
FOREIGN KEY (annonceVendeur, annonceTitre) REFERENCES Annonce(loginVendeur, titre)
);

--Création d'une vue permettant de voir les commandes ayant abouti
CREATE VIEW CommandeRéussie (Vnom, Vprenom, Anom, Aprenom, Antitre) AS
SELECT V.nom, V.prenom, A.nom, A.prenom, An.titre
FROM Vendeur V
INNER JOIN Contrat C ON V.loginVendeur = C.loginVendeurContrat
INNER JOIN Acheteur A ON A.loginAcheteur = C.loginAcheteurContrat
INNER JOIN Annonce An ON C.IDAnnonceContrat = An.IDAnnonce
WHERE C.paiement = TRUE;

--Création d'une vue pemettant de voir les usagers proposant des annonces dont le tag contient Loisirs dedans
CREATE VIEW  VendeursLoisirs (nomVendeur, prenomVendeur) AS
SELECT V.nom, V.prenom
FROM Vendeur V
INNER JOIN Annonce An ON V.loginVendeur = An.loginVendeurAnnonce
WHERE An.tag LIKE 'Loisirs';

--Création d'une vue permettant de voir les usagers proposant plus d'une annonce sur le site
CREATE VIEW VendeurMultiAnnonce (nomVendeur, prenomVendeur, nombreAnnonce) AS
SELECT V.nom, V.prenom, COUNT(Annonce.titre)
FROM Vendeur V
INNER JOIN Annonce ON V.loginVendeur = Annonce.loginVendeurAnnonce
GROUP BY V.nom, V.prenom
HAVING Count(Annonce.titre)>1;

INSERT INTO Administrateur (login, nom, prenom, motDePasse, adresseMail)
VALUES ('DupontLu', 'Dupont', 'Lucas', 'os2qs5a1', 'dupont.lucas@gmail.com');
INSERT INTO Administrateur (login, nom, prenom, motDePasse, adresseMail)
VALUES ('DurandPa', 'Durand', 'Paul', 'fqseer812s', 'durand.paul@laposte.net');
INSERT INTO Administrateur (login, nom, prenom, motDePasse, adresseMail)
VALUES ('DeschampsAd', 'Deschamps', 'Adrien', '65dzafd124', 'deschamps.adrien@wanadoo.fr');

INSERT INTO Vendeur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte)
VALUES ('LaurentMo', 'Laurent', 'Morgan', 'kqsj542sd', 'laurent.morgan@free.fr', '22 rue de la gare, 54210 Tataouine les Bains', 8548632541563241, '05/22', 512);
INSERT INTO Vendeur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte)
VALUES ('BelleNi', 'Belle', 'Nicolas', 'qsffg41cs2', 'belle.nicolas@free.fr', '125 avenue de paris, 94500 Malte en Boisis', 6548651235485632, '10/19', 128);
INSERT INTO Vendeur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte)
VALUES ('PoulpeCa', 'Poulpe', 'Camille', 'pujh51hj47y', 'poulpe.camille@sfr.fr', '64 ruelle du chemin, 12540 Brest sur Aulnay', 7854125478569841, '02/26', 962);

INSERT INTO Annonce (loginVendeur, titre, description, photographie, prix, tag)
VALUES ('LaurentMo', 'Appareil photo', 'Appareil photo Canon presque neuf', 'https://cdn.discordapp.com/attachments/45458sd7f454546.jpg', 150.20, 'Matériel Photo');
INSERT INTO Annonce (loginVendeur, titre, description, photographie, prix, tag)
VALUES ('LaurentMo', 'Frigo', 'Frigo américain avec trois compartiments (frigo, congelateur et bac à légumes séparés)', 'https://cdn.discordapp.com/attachments/455sd74a5s46.jpg', 325.00, 'Electroménager');
INSERT INTO Annonce (loginVendeur, titre, description, photographie, prix, tag)
VALUES ('PoulpeCa', 'CD', 'CD de différents groupes de rock et hard rock, prix unitaire', 'http' , 3, 'Loisirs');

INSERT INTO Acheteur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte)
VALUES ('MarinLu', 'Marin', 'Lucie', '54ds1sd4ds', 'marin.lucie@orange.fr', '51 rue du général Pétain, 71600 Champignac', 1254212365465158, '02/23', 631);
INSERT INTO Acheteur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte)
VALUES ('DupuisJe', 'Dupuis', 'Jean', '1sd749z61d', 'dupuis.jean@outlook.com', '324 avenue de la libération, 62150 Cateroy', 3211478512657512, '09/22', 842);
INSERT INTO Acheteur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte)
VALUES ('AlmorSt', 'Almor', 'Stan', 'a7d1s394d5', 'almor.stan@outlook.com', '159 impasse Foch, 32170 Clertel', 6512132545841245, '01/28', 961);

INSERT INTO Panier (loginAcheteur, quantité)
VALUES ('MarinLu', 2);
INSERT INTO Panier (loginAcheteur, quantité)
VALUES ('DupuisJe', 1);
INSERT INTO Panier (loginAcheteur, quantité)
VALUES ('AlmorSt', 2);

INSERT INTO Contrat (loginVendeur, annonceTitre, loginAcheteur, dateAjout, quantité, expeditionType, expeditionCout, paiement)
VALUES ('LaurentMo', 'Appareil photo', 'MarinLu', '2018-10-02', 1, 'Colissimo', 10.00, TRUE);
INSERT INTO Contrat (loginVendeur, annonceTitre, loginAcheteur, dateAjout, quantité, expeditionType, expeditionCout, paiement)
VALUES ('PoulpeCa', 'CD', 'MarinLu', '2018-06-24', 3, 'Colissimo', 3.00, TRUE);
INSERT INTO Contrat (loginVendeur, annonceTitre, loginAcheteur, dateAjout, quantité, expeditionType, expeditionCout, paiement)
VALUES ('PoulpeCa', 'CD', 'DupuisJe', '2017-05-26', 5, 'Retrait', 0, FALSE);
INSERT INTO Contrat (loginVendeur, annonceTitre, loginAcheteur, dateAjout, quantité, expeditionType, expeditionCout, paiement)
VALUES ('LaurentMo', 'Frigo', 'AlmorSt', '2018-12-05', 1, 'TNT', 20.00, TRUE);
INSERT INTO Contrat (loginVendeur, annonceTitre, loginAcheteur, dateAjout, quantité, expeditionType, expeditionCout, paiement)
VALUES ('PoulpeCa', 'CD', 'AlmorSt', '2018-03-16', 2, 'Colissimo', 1.50, TRUE);

INSERT INTO Notation (loginVendeur, loginAcheteur, score, avis, dateAvis)
VALUES ('LaurentMo', 'MarinLu', 18, 'Vendeur très gentil, rapide à répondre', '2018-10-04');
INSERT INTO Notation (loginVendeur, loginAcheteur, score, avis, dateAvis)
VALUES ('PoulpeCa', 'DupuisJe', 4, 'Très déçu, les CD étaient rayés ou leurs boites étaient endommagées, je ne conseille pas', '2017-06-10');

INSERT INTO Rubrique (nom, type, description, loginAdmin)
VALUES ('Déco maison', 'Blog', 'Blog dédié aux amoureux de la décoration pour poster vos conseils et idées', 'DurandPa');
INSERT INTO Rubrique (nom, type, description, loginAdmin)
VALUES ('Electroménager dernier cri', 'Selection', 'Meilleurs plans pour avoir un électroménager dernier cri et performant', 'DupontLu');

INSERT INTO AnnonceDansRubrique (rubriqueNom, annonceVendeur, annonceTitre)
VALUES ('Electroménager dernier cri', 'LaurentMo', 'Frigo');

--Question : Donner les noms/prénoms des vendeurs et acheteurs ayant été mis en relation pour une annonce mais dont le paiement n'a pas abouti
SELECT V.nom Vnom, V.prenom Vprenom, A.nom Anom, A.prenom Aprenom, An.titre
FROM Vendeur V
INNER JOIN Contrat C ON V.loginVendeur = C.loginVendeurContrat
INNER JOIN Acheteur A ON A.loginAcheteur = C.loginAcheteurContrat
INNER JOIN Annonce An ON C.IDAnnonceContrat = An.IDAnnonce
WHERE C.paiement = FALSE;

--Question : Donner le login des usagers ayant ajouté une annonce à leur panier dont le titre contient CD et dont la quantité associée est supérieure à 2
SELECT C.loginAcheteurContrat, C.quantité
FROM Contrat C
INNER JOIN Annonce An ON C.IDAnnonceContrat = An.IDAnnonce
WHERE An.description LIKE '%CD%' AND C.quantité >2;

--Question : Donner les noms/prénoms des vendeurs ayant expédié un objet à travers une annonce par Colissimo et dont l'acheteur habite Champignac
SELECT V.nom, V.prenom
FROM Vendeur V
INNER JOIN Contrat C ON V.loginVendeur = C.loginVendeurContrat
INNER JOIN Acheteur A ON A.loginAcheteur = C.loginAcheteurContrat
WHERE C.expeditionType = 'Colissimo' AND A.adresse LIKE '%Champignac';