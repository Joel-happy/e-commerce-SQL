# e-commerce-SQL

## Description

Ce projet consiste à créer la base de données d'un site de commerce électronique en suivant un modèle conceptuel de données (MCD), puis à remplir cette base de données avec des données factices à l'aide d'un script en PHP.

## Étapes Réalisées

### Étape 1: Modèle Conceptuel de Données (MCD)

1. Utilisation de l'outil Looping pour créer un MCD détaillé.
2. Inclusion de toutes les relations et attributs nécessaires dans le MCD.
3. Affichage clair de toutes les relations sur le MCD.

### Étape 2: Base de Données

1. Création de la base de données en utilisant l'outil PhpMyAdmin.
2. Respect scrupuleux du MCD lors de la création des tables suivantes :
   - `client`: Informations sur les clients.
   - `adresse`: Adresses des clients.
   - `produit`: Produits disponibles à la vente.
   - `panier`: Contenu du panier des clients.
   - `commande`: Commandes passées par les clients.
   - `facture`: Historique des factures.
   - Tables de jonction nécessaires pour les relations.

3. Cryptage de toutes les informations privées dans la base de données.

### Étape 3: Script de Remplissage (Fixtures)

1. Écriture d'un script en PHP pour remplir la base de données avec des données factices.
2. Utilisation de la bibliothèque Faker en PHP pour générer des données réalistes.

### Avertissement

Le script de remplissage de données est conçu à des fins de test et de développement. Des mesures de sécurité supplémentaires seront nécessaires pour une utilisation en environnement de production.

