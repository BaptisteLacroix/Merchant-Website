// Constant
const numberOfIMages = 12;
const head = document.head;
const style = document.createElement('style');
const section = document.getElementById('explorer');


// Define a function that creates and adds the elements to the page
function createElements() {
    head.appendChild(style);

    const container = document.createElement('div');
    container.className = 'container';

    generateLists(container);

    // Add the outer <div> element to the parent element
    section.appendChild(container);
}

function generateLists(container) {

    for (let i = 1; i <= numberOfIMages; i++) {
        let div_card = document.createElement('div');
        div_card.className = 'card';

        let div = document.createElement('div');
        div.style = 'padding: 20px;text-align: center;font-size:12px;';

        let h1 = document.createElement('h1');
        h1.innerHTML = 'Apps';

        let p = document.createElement('p');
        p.innerHTML = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ultrices in iaculis nunc sed augue.';

        let button = document.createElement('button');
        button.className = 'btn-information cta';

        // On click a tag go to the page product.html
        // And call the function getJsonData
        // And insert the datat to the page
        button.onclick = () => {
            window.location.href = './frontend/product.html';
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
        span.appendChild(svg);
        button.appendChild(span);

        div.appendChild(h1);
        div.appendChild(p);
        div.appendChild(button);

        let div_cover = document.createElement('div');
        div_cover.className = 'cover';

        let div_coverFront = document.createElement('div');
        div_coverFront.className = 'cover-front';

        let div2 = document.createElement('div');

        let img = document.createElement('img');
        img.src = './img/image' + i + '.png';
        img.className = 'sh_img';
        img.alt = 'An Oil Painting with animals';

        div2.appendChild(img);

        div_coverFront.appendChild(div2);

        let div_coverBack = document.createElement('div');
        div_coverBack.className = 'cover-back';

        div_cover.appendChild(div_coverFront);
        div_cover.appendChild(div_coverBack);

        div_card.appendChild(div);
        div_card.appendChild(div_cover);

        container.appendChild(div_card);
    }
}

createElements();
