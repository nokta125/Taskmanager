const tasks = [
    { title: "Faire un site pour mon père" , statuts:"terminé" , deadline:"19-06-2025"},
    { title: "soumttre mon projet sur github" , statuts:"En cours" , deadline:"29-06-2025"},
    { title: "Appeler le plombier" , statuts: "Dépassé" , deadline: "10-06-2025"},
];

const tacheList = document.getElementById("tache-list");
tasks.forEach (task => {
    const row = document.createElement("tr");
    row.innerHTML = `
    <td>${task.title}</td>
    <td>${task.status}</td>
    <td>${task.deadline}</td>
    `;
    tacheList.appendChild(row);
});

const tacheCompletée = tasks.filter(task => task.statut === "Terminé").length;
const tacheCours = tasks.filter(task => task.statut === "En cours").length;
const tachePassée = tasks.filter(task => task.staut === "Depassée").length;

document.getElementById("tache-completée").textContentntent = tacheCompletée;
document.getElementById("tache-cours").textContent = tacheCours;
document.getElementById("tache-passée").textContent = tachePassée;

const indicateurStat= document.getElementById("indicateur-stat");
if (tachePassée > 0) {
    indicateurStat.textContent= "Attention certaines taches sont déjà passées !";
    indicateurStat.style.color= "red";
} else if (tacheCompletée >= tacheCours) {
    indicateurStat.textContent= "Bonne gestion des taches.";
    indicateurStat.style.color ="green";
} else {
    indicateurStat.textContent= "Continuez à progresser.";
    indicateurStat.style.color= "#FF8C00";
}

