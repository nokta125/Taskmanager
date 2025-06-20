

// Ajout dynamique des taches
const taskForm = document.getElementById("taskForm");
const taskInput= document.getElementById("taskInput");

taskForm.addEventListener("submit", (e) => {
    e.preventDefault();
const taskText = taskInput.value.trim();
if (taskText) {;
const taskItem=document.createElement("li");
taskItem.textContent= taskText ;
taskInput.value="";
}

taskForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const taskText = taskInput.value.trim();
    if (taskText){
        const taskItem = document.createElement("li");
        taskItem.textContent = taskText;
        taskInput.value="";
    }


})});

const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");
const showRegister = document.getElementById("show-register");
const showLogin = document.getElementById("show-login");

showRegister.addEventListener( 'click',() => {
    loginForm.classList.add('hidden');
    registerForm.classList.remove('hidden');

});
 showLogin.addEventListener('click', () => {
    registerForm.classList.add('hidden');
    loginForm.classList.remove('hidden');

 });