let signinButton = document.getElementById('sign-in');
let signupButton = document.getElementById('sign-up');
let formBx = document.querySelector('.form-bx');


signupButton.onclick = function(){
    formBx.classList.add('active');
    body.classList.add('active');
}

signinButton.onclick = function(){
    formBx.classList.remove('active');
    body.classList.remove('active');
}