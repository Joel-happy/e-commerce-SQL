<?php

require_once 'vendor/autoload.php'; // Charger l'autoloader de Composer

// Utilisation de la classe Faker pour générer des données factices
$faker = Faker\Factory::create();

// Configuration de la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-commerce-sql";

// Nombre de données à générer
$nombreDeDonnees = 12;

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurer le mode d'erreur PDO à exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Génération des données pour la table Client
    for ($i = 0; $i < $nombreDeDonnees; $i++) {
        $nom = $faker->lastName;
        $prenom = $faker->firstName;
        $adresseMail = $faker->email;
        $motDePasse = password_hash($faker->password, PASSWORD_DEFAULT);
        $dateDeNaissance = $faker->date;
        $numeroDeTelephone = $faker->numerify('###########');
        $anciennete = $faker->date;

        $sql = "INSERT INTO client (Nom, Prenom, AddresseMail, MotDePasse, DateDeNaissance, NumeroDeTelephone, Anciennete) 
                VALUES ('$nom', '$prenom', '$adresseMail', '$motDePasse', '$dateDeNaissance', '$numeroDeTelephone', '$anciennete')";
        $conn->exec($sql);
        echo "Enregistrement Client inséré avec succès.\n";
    }

    // Génération des données pour la table Adresse
for ($i = 0; $i < $nombreDeDonnees; $i++) {
    $typeAdresse = $faker->randomElement(['Domicile', 'Travail', 'Autre']);
    $nomDuDestinataire = $faker->name;
    $adresse = $faker->address;
    $ville = $faker->city;
    $numeroDeTelephoneAdresse = $faker->numerify('###########');
    $codePostal = $faker->postcode;
    $pays = $faker->country;

    $sql = "INSERT INTO adresse (TypeAdresse, NomDuDestinataire, Adresse, Ville, NumeroDeTelephone, CodePostal, Pays, IdClient) 
            VALUES ('$typeAdresse', '$nomDuDestinataire', '$adresse', '$ville', '$numeroDeTelephoneAdresse', '$codePostal', '$pays', (SELECT IdClient FROM client ORDER BY RAND() LIMIT 1))";
    $conn->exec($sql);
    echo "Enregistrement Adresse inséré avec succès.\n";
}

   // Génération des données pour la table Produit
for ($i = 0; $i < $nombreDeDonnees; $i++) {
    $nomProduit = $faker->sentence;
    $descriptionProduit = $faker->paragraph(3, true);
    $prix = $faker->randomFloat(2, 10, 500);
    $categorie = $faker->randomElement(['Électronique', 'Vêtements', 'Meubles', 'Alimentation']);
    $stock = $faker->numberBetween(10, 100);

    $sql = "INSERT INTO produit (NomProduit, DescriptionDuProduit, Prix, Categorie, Stock) 
        VALUES ('$nomProduit', '$descriptionProduit', '$prix', '$categorie', '$stock')";

try {
    $conn->exec($sql);
    echo "Enregistrement Produit inséré avec succès.\n";
} catch (PDOException $e) {
    echo "Erreur lors de l'insertion dans la table produit : " . $e->getMessage() . "\n";
    echo "Requête SQL : $sql\n";
}
}

// Génération des données pour la table Panier
for ($i = 0; $i < $nombreDeDonnees; $i++) {
    $quantite = $faker->numberBetween(1, 5);

    // Sélectionner un client existant
    $idClient = $faker->numberBetween(1, $nombreDeDonnees);

    // Sélectionner un produit existant
    do {
        $idProduit = $faker->numberBetween(1, $nombreDeDonnees);
        // Vérifier si l'IdProduit existe déjà dans la table Panier
        $existingProduct = $conn->query("SELECT IdProduit FROM Panier WHERE IdProduit = $idProduit")->fetch();
    } while ($existingProduct);

    $sql = "INSERT INTO panier (Quantite, IdClient, IdProduit) 
            VALUES ('$quantite', '$idClient', '$idProduit')";
    
    $conn->exec($sql);
    echo "Enregistrement Panier inséré avec succès.\n";
}


    // Génération des données pour la table Commande
    for ($i = 0; $i < $nombreDeDonnees; $i++) {
        $dateDeCommande = $faker->dateTimeThisYear->format('Y-m-d H:i:s');
        $statusDeLaCommande = $faker->randomElement(['En attente', 'Expédiée', 'Livraison en cours', 'Livrée']);

        $idAdresse = $conn->query("SELECT IdAdresse FROM adresse ORDER BY RAND() LIMIT 1")->fetchColumn();
        $idClient = $conn->query("SELECT IdClient FROM client ORDER BY RAND() LIMIT 1")->fetchColumn();

        $sql = "INSERT INTO commande (DatedeCommande, StatusDeLaCommande, IdAdresse, IdClient) 
                VALUES ('$dateDeCommande', '$statusDeLaCommande', '$idAdresse', '$idClient')";
        
        $conn->exec($sql);
        echo "Enregistrement Commande inséré avec succès.\n";
    }

    //Génération des données pour la table Facture
for ($i = 0; $i < $nombreDeDonnees; $i++) {
    $dateDeFacturation = $faker->dateTimeThisYear->format('Y-m-d H:i:s');
    $montantTotal = $faker->randomFloat(2, 10, 1000); // Montant total aléatoire entre 10 et 1000

    $idClient = $conn->query("SELECT IdClient FROM client ORDER BY RAND() LIMIT 1")->fetchColumn();

    $sql = "INSERT INTO facture (DatedeFacturation, MontantTotal, IdClient) 
            VALUES ('$dateDeFacturation', '$montantTotal', '$idClient')";
    
    $conn->exec($sql);
    echo "Enregistrement Facture inséré avec succès.\n";
}


// Génération des données pour la table Achete
for ($i = 0; $i < $nombreDeDonnees; $i++) {
    // Sélectionner un client existant
    $idClient = $conn->query("SELECT IdClient FROM client ORDER BY RAND() LIMIT 1")->fetchColumn();

    // Sélectionner un produit existant
    $idProduit = $conn->query("SELECT IdProduit FROM produit ORDER BY RAND() LIMIT 1")->fetchColumn();

    $sql = "INSERT INTO achete (IdClient, IdProduit) 
            VALUES ('$idClient', '$idProduit')";
    
    $conn->exec($sql);
    echo "Enregistrement Achete inséré avec succès.\n";
}

// Génération des données pour la table Utilise
for ($i = 0; $i < $nombreDeDonnees; $i++) {
    // Insérer une nouvelle méthode de paiement
    $typePaiement = $faker->randomElement(['Carte de crédit', 'PayPal', 'Virement bancaire']);
    $informationsPaiement = $faker->text(50);

    $sql = "INSERT INTO methodedepaiement (TypePaiement, InformationsDePaiement) 
            VALUES ('$typePaiement', '$informationsPaiement')";

    $conn->exec($sql);

    // Récupérer l'ID de la méthode de paiement nouvellement créée
    $idPaiement = $conn->lastInsertId();

    // Sélectionner un client existant
    $idClient = $faker->numberBetween(1, $nombreDeDonnees);

    // Insérer dans la table de jointure Utilise
    $sql = "INSERT INTO utilise (IdPaiement, IdClient) VALUES ('$idPaiement', '$idClient')";
    
    $conn->exec($sql);
    echo "Enregistrement Utilise inséré avec succès.\n";
}


// Génération des données pour la table Inclut
for ($i = 0; $i < $nombreDeDonnees; $i++) {
    // Sélectionner un produit existant
    $idProduit = $faker->numberBetween(1, $nombreDeDonnees);

    // Sélectionner une commande existante
    $idCommandes = $faker->numberBetween(1, $nombreDeDonnees);

    // Vérifier si la paire IdProduit-IdCommandes existe déjà dans la table Inclut
    $existingPair = $conn->query("SELECT IdProduit, IdCommandes FROM Inclut WHERE IdProduit = $idProduit AND IdCommandes = $idCommandes")->fetch();

    // Si la paire existe, générez une nouvelle paire
    while ($existingPair) {
        $idProduit = $faker->numberBetween(1, $nombreDeDonnees);
        $idCommandes = $faker->numberBetween(1, $nombreDeDonnees);
        $existingPair = $conn->query("SELECT IdProduit, IdCommandes FROM Inclut WHERE IdProduit = $idProduit AND IdCommandes = $idCommandes")->fetch();
    }

    $sql = "INSERT INTO inclut (IdProduit, IdCommandes) 
            VALUES ('$idProduit', '$idCommandes')";
    
    $conn->exec($sql);
    echo "Enregistrement Inclut inséré avec succès.\n";
}

// Génération des données pour la table MethodeDePaiement
for ($i = 0; $i < $nombreDeDonnees; $i++) {
    $typePaiement = $faker->randomElement(['Carte de crédit', 'PayPal', 'Virement bancaire']);
    $informationsPaiement = $faker->text(50);

    $sql = "INSERT INTO methodedepaiement (TypePaiement, InformationsDePaiement) 
            VALUES ('$typePaiement', '$informationsPaiement')";

    $conn->exec($sql);
    echo "Enregistrement MethodeDePaiement inséré avec succès.\n";
}

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermer la connexion à la base de données
$conn = null;
?>
