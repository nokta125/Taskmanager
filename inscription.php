<?php 
try {
    $db = new PDO('mysql:host=localhost;dbname=taskmanager;charset=utf8', 'root', '');
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
// Recuperation des données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ;
    $email = $_POST['email'] ;
    $password = $_POST['password'] ;
    $confirmPassword = $_POST['confirmPassword'] ; // Correction ici

    // Validation des données
    if (empty($nom) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse e-mail invalide.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Les mots de passe ne correspondent pas.';
    }

    if (empty($error)) { 
        //insertion des données dans la base de données
        $stmt = $db->prepare('INSERT INTO utilisateurs (nom, email, password, date_inscription) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$nom, $email, password_hash($password, PASSWORD_DEFAULT)]);

        // Vérification de l'insertion
        if ($stmt->rowCount() > 0) {
            // Redirection vers la page de connexion
            header('Location: connexion.html');
            exit();
        } else {
            $error = 'Erreur lors de l\'inscription. Veuillez réessayer.';
        } 
    }
}