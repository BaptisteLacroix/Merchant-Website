// Constant
const numberOfIMages = 12;
const head = document.head;
const style = document.createElement('style');
const body = document.body;
const buttonLeft = document.createElement('button');
const buttonRight = document.createElement('button');


function generateImages(outerDiv) {
    // The base ID for the <span> elements
    let divContainer = document.createElement('div');
    divContainer.className = 'images-containers';
    divContainer.addEventListener('wheel', function (event) {
        // If wheel up so go left
        event.preventDefault();
        if (event.deltaY < 0) {
            scrollHorizontally(1);
        } else {
            scrollHorizontally(-1);
        }
    });

    let baseClassName = 'image-size';
    for (let i = 1; i <= numberOfIMages; i++) {
        // Create a new <span> element
        let div = document.createElement('div');
        div.className = baseClassName;
        let image = document.createElement('img');
        image.src = './frontend/img/image' + i + '.png';
        image.alt = 'Oil Painting'

        let a = document.createElement('a');
        a.className = 'btn-information cta';

        // On click a tag go to the page product.html
        // And call the function getJsonData
        // And insert the datat to the page
        a.onclick = () => {
            window.location.href = './frontend/product.html';
            getJsonData();
            console.log("SENTs")
        }


        let span = document.createElement('span');
        span.className = 'hover-underline-animation';
        span.innerHTML = 'Shop now';

        let svg = document.createElement('svg');
        svg.viewBox = '0 0 46 16';
        svg.head = '10';
        svg.head = '30';
        svg.xmlns = 'http://www.w3.org/2000/svg';
        svg.id = 'arrow-horizontal';

        let path = document.createElement('path');
        path.transform = 'translate(30)';
        path.d = 'M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z';
        path.data = 'Path 10';
        path.id = 'Path_10';

        svg.appendChild(path);
        a.appendChild(span);
        a.appendChild(svg);

        div.appendChild(image);
        div.appendChild(a);

        // Add the <div> element to the page
        divContainer.appendChild(div);
    }

    outerDiv.appendChild(divContainer);
}


// Define a function that creates and adds the elements to the page
function createElements() {
    head.appendChild(style);

    const container = document.createElement('div');
    container.className = 'container';

    // Create the outer <div> element
    const outerDiv = document.createElement('div');
    outerDiv.className = 'horizontal-scroll';

    // Left button
    buttonLeft.className = 'btn-scroll';
    buttonLeft.id = 'btn-scroll-left';
    buttonLeft.onclick = () => {
        scrollHorizontally(1);
    };
    buttonLeft.style.opacity = "0";

    // Right button
    buttonRight.className = 'btn-scroll';
    buttonRight.id = 'btn-scroll-right';
    buttonRight.onclick = () => {
        scrollHorizontally(-1);
    };

    outerDiv.appendChild(buttonLeft);
    outerDiv.appendChild(buttonRight);

    generateImages(outerDiv);


    container.appendChild(outerDiv);
    // Add the outer <div> element to the parent element
    body.appendChild(container);
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


// Const
const sCont = document.querySelector(".images-containers");
const hScroll = document.querySelector(".horizontal-scroll");
// let
let currentScrollPosition = 0;
let scrollAmount = 320;
let maxScroll = -sCont.offsetWidth + hScroll.offsetWidth;


