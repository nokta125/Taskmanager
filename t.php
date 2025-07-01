<?php 
//Connnexion à la base de données
try {
    $db = new PDO('mysql:host=localhost;dbname=taskmanager;charset=utf8', 'root', '');
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

//Recuperation des données du formulaire
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['tache'];
    $time = htmlspecialchars($_POST['heure_tache']);
    $date = htmlspecialchars($_POST['date_tache']);
   
   //validation des données
    if(empty($titre) || empty($time) || empty($date)) {
        $error = 'Tous les champs sont obligatoires.';
    } else {
        //insertion des données dans la base de données
        $stmt = $db->prepare('INSERT INTO taches (tache, heure_tache, date_tache) VALUES (?, ?, ?)');
        $stmt->execute([$titre, $time, $date]);

        // Vérification de l'insertion
        if($stmt->rowCount() > 0) {
            // Redirection vers la page de gestion des tâches
            header('Location: Tache.html');
            exit();
        } else {
            $error = 'Erreur lors de l\'ajout de la tâche. Veuillez réessayer.';
        }
    }
}