<?php
session_start();
// Connexion à la base de données
try {
    $db = new PDO('mysql:host=localhost;dbname=taskmanager;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: connexion.php');
    exit();
}

$error = '';
$success = '';

// Traitement du formulaire d'ajout de tâche
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tache = $_POST['tache'] ?? '';
    $date_tache = $_POST['date_tache'] ?? '';
    $heure_tache = $_POST['heure_tache'] ?? '';
    $priorite = $_POST['priorite'] ?? '';

    if (empty($tache) || empty($date_tache) || empty($heure_tache) || empty($priorite)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $db->prepare('INSERT INTO taches (user_id, tache, date_tache, heure_tache, priorite) VALUES (?, ?, ?, ?, ?)');
        if ($stmt->execute([$_SESSION['user_id'], $tache, $date_tache, $heure_tache, $priorite])) {
            $success = "Tâche ajoutée avec succès.";
        } else {
            $error = "Erreur lors de l'ajout de la tâche.";
        }
    }
}

// Récupération des tâches de l'utilisateur
$stmt = $db->prepare('SELECT * FROM taches WHERE user_id = ? ORDER BY date_tache, heure_tache');
$stmt->execute([$_SESSION['user_id']]);
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Gérer vos taches facilement</title>
    <link rel="stylesheet" href="m.css">
</head>

<body>
    <div class="planning">
        <div class="sidebar-laterale">
            <!--Barre laterale-->
            <aside class="sidebare">
                <h2>Menu</h2>
                <ul>
                    <li><a href="Accueil.html">Accueil</a></li>
                    <li><a href="stat.html"> Evolution</a> </li>
                    <li><a href="setting.html"> Paramètre</li>
                </ul>

            </aside>
        </div>
        <div class="planning-container">
            <!-- Affichage des messages -->
            <?php if ($error): ?>
                <div style="color: #c0392b; margin-bottom: 10px;"><?= htmlspecialchars($error) ?></div>
            <?php elseif ($success): ?>
                <div style="color: #27ae60; margin-bottom: 10px;"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <!--To-do_list dynamique-->

            <h1 class="org">Organisez-vous de la meilleure des façons</h1>

            <!--formulaire d'ajout de tache-->
            <section class="task-form">
                <h2>Ajoutez une nouvelle tâche</h2>
                <div class="task-for">
                    <form id="taskForm" method="post" action="tache.php">
                        <div>
                            <input type="text" name="tache" id="taskInput" placeholder="Entrer votre tâche" required>
                        </div>
                        <div>
                            <input type="date" name="date_tache" id="taskDate" required>
                        </div>
                        <div>
                            <input type="time" name="heure_tache" id="taskTime" required>
                        </div>
                        <div>
                            <select name="priorite" id="taskPriority" required>
                                <option value=" disabled selected">Choisir la priorité</option>
                                <option value="haute">Très important</option>
                                <option value="moyenne">Important</option>
                                <option value="basse">Moins important</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit">Ajouter</button>
                        </div>
                    </form>
                </div>
            </section>

        </div>
        <div class="pl">
            <div>
                <h2>Mon Planing</h2>
                <p>Bienvenue, <?= htmlspecialchars($_SESSION['user_nom']) ?> !</p>
                <p>Voici vos tâches pour aujourd'hui :</p>
            </div>
            <section class="todo-list">
                <?php if (count($taches) > 0): ?>
                    <?php foreach ($taches as $t): ?>
                        <div class="task">
                            <span class="task-title"><?= htmlspecialchars($t['tache']) ?></span>
                            <span><?= htmlspecialchars($t['date_tache']) ?> à <?= htmlspecialchars($t['heure_tache']) ?></span>
                            <span>Priorité : <?= htmlspecialchars($t['priorite']) ?></span>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="task">
                        <span class="task-title">Aucune tâche pour le moment.</span>
                    </div>
                <?php endif; ?>
            </section>

        </div>
    </div>
</body>

</html>