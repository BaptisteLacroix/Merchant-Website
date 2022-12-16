// Constant
const numberOfIMages = 6;
const head = document.head;
const style = document.createElement('style');
const section = document.getElementById('commentary');
const buttonLeft = document.createElement('button');
const buttonRight = document.createElement('button');
buttonLeft.id = 'btn-scroll-left';
buttonRight.id = 'btn-scroll-right';


// Define a function that creates and adds the elements to the page
function createElements() {
    head.appendChild(style);

    const container = document.createElement('div');
    container.className = 'container';

    let div_slider = document.createElement('div');
    div_slider.className = 'slide';
    

    generateLists(div_slider);

    container.appendChild(buttonLeft)
    container.appendChild(div_slider);
    container.appendChild(buttonRight);


    // Add the outer <div> element to the parent element
    section.appendChild(container);
}

function generateLists(divSlider) {
    for (let i = 1; i <= numberOfIMages; i++) {
        let div = document.createElement('div');
        div.className = 'card';
        let img = document.createElement('img');
        img.src = '#';
        img.alt = 'Nothing for the moment';
        let h2_username = document.createElement('h2');
        h2_username.className = 'username';
        h2_username.innerHTML = 'Username';
        let rating_div = document.createElement('div');
        rating_div.className = 'rating';
        rating_div.innerHTML = 'Rating';
        let p_comment = document.createElement('p');
        p_comment.className = 'comment';
        p_comment.innerHTML = 'Comment';
        div.appendChild(img);
        div.appendChild(h2_username);
        div.appendChild(rating_div);
        div.appendChild(p_comment);
        divSlider.appendChild(div);
    }
}

createElements();


let tab = document.querySelectorAll('.card');
let slide = document.querySelector('.slide');
let middleCard = 1;

function scrollUp(balise) {
    balise.style="z-index:2; transform: scale(1.2); width:calc(2*100%);"
}

function scrollDown(balise) {
    balise.style = "transform: scale(1); z-index:1;"
}

window.onload = function() {
    scrollUp(tab[middleCard]);
}

buttonLeft.onclick = function() {
    if (middleCard !== 0) {
        scrollDown(tab[middleCard]);
        middleCard--;
        scrollUp(tab[middleCard]);
        slide.scrollBy(-350, 0);
    }
}

buttonRight.onclick = function() {
    if (middleCard !== numberOfIMages - 1) {
        scrollDown(tab[middleCard]);
        middleCard++;
        scrollUp(tab[middleCard]);
        slide.scrollBy(350, 0);
    }
}