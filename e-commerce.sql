CREATE TABLE Client(
   IdClient INT,
   Nom VARCHAR(50) NOT NULL,
   Prenom VARCHAR(50) NOT NULL,
   AddresseMail VARCHAR(20) NOT NULL,
   MotDePasse VARCHAR(50) NOT NULL,
   DateDeNaissance DATE NOT NULL,
   NumeroDeTelephone SMALLINT NOT NULL,
   Anciennete DATE NOT NULL,
   PRIMARY KEY(IdClient)
);

CREATE TABLE Adresse(
   IdAdresse INT,
   TypeAdresse VARCHAR(20) NOT NULL,
   NomDuDestinataire VARCHAR(50) NOT NULL,
   Adresse VARCHAR(50) NOT NULL,
   Ville VARCHAR(20) NOT NULL,
   NumeroDeTelephone SMALLINT NOT NULL,
   CodePostal VARCHAR(5) NOT NULL,
   Pays VARCHAR(50) NOT NULL,
   IdClient INT NOT NULL,
   PRIMARY KEY(IdAdresse),
   FOREIGN KEY(IdClient) REFERENCES Client(IdClient)
);

CREATE TABLE Produit(
   IdProduit INT,
   NomProduit VARCHAR(50) NOT NULL,
   DescriptionDuProduit VARCHAR(200) NOT NULL,
   Prix DECIMAL(10,2) NOT NULL,
   Categorie VARCHAR(30) NOT NULL,
   Stock INT NOT NULL,
   PRIMARY KEY(IdProduit)
);

CREATE TABLE Panier(
   IdPanier INT,
   Quantite BIGINT NOT NULL,
   IdClient INT NOT NULL,
   PRIMARY KEY(IdPanier),
   FOREIGN KEY(IdClient) REFERENCES Client(IdClient)
);

CREATE TABLE Commande(
   IdCommandes INT,
   DatedeCommande DATETIME NOT NULL,
   StatusDeLaCommande VARCHAR(15) NOT NULL,
   IdAdresse INT NOT NULL,
   IdClient INT NOT NULL,
   PRIMARY KEY(IdCommandes),
   FOREIGN KEY(IdAdresse) REFERENCES Adresse(IdAdresse),
   FOREIGN KEY(IdClient) REFERENCES Client(IdClient)
);

CREATE TABLE Facture(
   IdFactures INT,
   DatedeFacturation DATETIME NOT NULL,
   MontantTotal DECIMAL(10,2) NOT NULL,
   IdClient INT NOT NULL,
   PRIMARY KEY(IdFactures),
   FOREIGN KEY(IdClient) REFERENCES Client(IdClient)
);

CREATE TABLE MethodeDePaiement(
   IdPaiement INT,
   TypePaiement VARCHAR(20) NOT NULL,
   InformationsDePaiement VARCHAR(100) NOT NULL,
   PRIMARY KEY(IdPaiement)
);

CREATE TABLE Utilise(
   IdPaiement INT,
   IdClient INT,
   PRIMARY KEY(IdPaiement, IdClient),
   FOREIGN KEY(IdPaiement) REFERENCES MethodeDePaiement(IdPaiement),
   FOREIGN KEY(IdClient) REFERENCES Client(IdClient)
);

CREATE TABLE Achete(
   IdClient INT,
   IdProduit INT,
   PRIMARY KEY(IdClient, IdProduit),
   FOREIGN KEY(IdClient) REFERENCES Client(IdClient),
   FOREIGN KEY(IdProduit) REFERENCES Produit(IdProduit)
);

CREATE TABLE Inclut(
   IdProduit INT,
   IdCommandes INT,
   PRIMARY KEY(IdProduit, IdCommandes),
   FOREIGN KEY(IdProduit) REFERENCES Produit(IdProduit),
   FOREIGN KEY(IdCommandes) REFERENCES Commande(IdCommandes)
);
