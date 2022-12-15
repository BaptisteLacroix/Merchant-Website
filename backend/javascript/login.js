const signinButton = document.getElementById('sign-in');
const signupButton = document.getElementById('sign-up');
const formBx = document.querySelector('.form-bx');
const body = document.querySelector('body');


signupButton.onclick = function(){
    formBx.classList.add('active');
    body.classList.add('active');
}

signinButton.onclick = function(){
    formBx.classList.remove('active');
    body.classList.remove('active');
}