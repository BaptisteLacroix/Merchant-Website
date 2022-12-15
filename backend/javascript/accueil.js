// Const
const sCont = document.querySelector(".images-containers");
const hScroll = document.querySelector(".horizontal-scroll");
// let
let currentScrollPosition = 0;
let scrollAmount = 320;
let maxScroll = -sCont.offsetWidth + hScroll.offsetWidth;

let buttonLeft = document.getElementById('btn-scroll-left');
let buttonRight = document.getElementById('btn-scroll-right');

function addListener() {
    // The base ID for the <span> elements
    let divContainer = document.getElementsByClassName('images-containers');
    // foreach divContainer add event listener
    for (let i = 0; i < divContainer.length; i++) {
        divContainer[i].addEventListener('wheel', function (event) {
            // If wheel up so go left
            event.preventDefault();
            if (event.deltaY < 0) {
                scrollHorizontally(1);
            } else {
                scrollHorizontally(-1);
            }
        });
    }
}


// Define a function that creates and adds the elements to the page
function createElements() {
    // Left button
    buttonLeft.onclick = () => {
        scrollHorizontally(1);
    };
    buttonLeft.style.opacity = "0";

    // Right button
    buttonRight.onclick = () => {
        scrollHorizontally(-1);
    };


    addListener();
}


function scrollHorizontally(val) {
    currentScrollPosition += val * scrollAmount;

    if (currentScrollPosition >= 0) {
        currentScrollPosition = 0;
        buttonLeft.style.opacity = 0;
    } else {
        buttonLeft.style.opacity = 1;
    }

    if (currentScrollPosition <= maxScroll) {
        currentScrollPosition = maxScroll
        buttonRight.style.opacity = 0;
    } else {
        buttonRight.style.opacity = 1;
    }

    sCont.style.left = currentScrollPosition + "px";
}

createElements();