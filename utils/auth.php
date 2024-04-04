<?php



function connection()
{
    $nomDuServeur = "localhost";
    $nomUtilisateur = "root";
    $motDePasse = "";
    $nomBDD = "bdd_ifosup";

    // Tenter d'établir une connexion à la base de données :
    try {
        // Instancier une nouvelle connexion.
        $pdo = new PDO("mysql:host=$nomDuServeur;dbname=$nomBDD;charset=utf8;port=3308", $nomUtilisateur, $motDePasse);

        // Définir le mode d'erreur sur "exception".
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    // Capturer les exceptions en cas d'erreur de connexion :
    catch (PDOException $e) {
        // Afficher les potentielles erreurs 
        echo "Erreur d'exécution de requête : " . $e->getMessage() . PHP_EOL;
    }
}


try {
    $conn = connection();

    $requete = "select * from utilisateurs";

    $data = $conn->query($requete);

    print_r($data->fetch(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo $e;
}

// connection();
// try {
//     $nomDuServeur = "localhost";
//     $nomUtilisateur = "root";
//     $motDePasse = "";
//     $nomBDD = "bdd_ifosup";

//     $pdo = new PDO("mysql:host=$nomDuServeur;port=3308", $nomUtilisateur, $motDePasse);
//     $pdo->exec("CREATE DATABASE bdd_ifosup DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;");

//     $pdo = new PDO("mysql:host=$nomDuServeur;port=3308;dbname=$nomBDD;", $nomUtilisateur, $motDePasse);
//     // Définir le mode d'erreur sur "exception".
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $requete = "CREATE TABLE utilisateurs (
//         uti_id INT AUTO_INCREMENT PRIMARY KEY,
//         uti_pseudo VARCHAR(32) NOT NULL,
//         uti_email VARCHAR(255) UNIQUE
//     ) ENGINE=InnoDB";

//     // Exécuter la requête SQL pour créer la table "t_utilisateur_uti".
//     $pdo->exec($requete);
// } catch (PDOException $e) {
//     echo $e;
// }
