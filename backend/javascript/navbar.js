const header = document.createElement('header');
const body = document.querySelector('body');


// Define a function that creates and adds the elements to the page
function createElements() {
    // Add the link href to the stylesheet
    let linkNav = document.createElement('link');
    linkNav.rel = 'stylesheet';
    linkNav.type = 'text/css';
    linkNav.href = './css/navbar.css';
    document.head.appendChild(linkNav);

    const logo = document.createElement('div');
    logo.className = 'logo';
    logo.innerHTML = 'Oil Painting';

    header.appendChild(logo);
    header.appendChild(hamburgerMenu());

    const nav = document.createElement('nav');
    nav.className = 'nav-bar';

    header.appendChild(nav);
    navbar(nav);
    body.appendChild(header);
}

function navbar(nav) {
    let listOfInnerHTML = ['Home', 'Explore', 'About Us', 'Cart', 'Login'];
    let listOfLinks = ['index.php', 'explore.php', 'about.php', 'cart.php', 'login.php'];
    let ul = document.createElement('ul');
    for (let i = 0; i < listOfLinks.length; i++) {
        let li = document.createElement('li');
        let a = document.createElement('a');
        a.href = listOfLinks[i];

        if (listOfLinks[i] === 'index.php') {
            a.className = 'active';
            a.innerHTML = listOfInnerHTML[i];
        } else if (listOfLinks[i] === 'explore.php') {
            let link = generateSVG('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="white"><path fill-rule="evenodd" d="M4.475 4.475a5.5 5.5 0 1 0 7.778 7.778a5.5 5.5 0 0 0-7.778-7.778Zm6.364 6.364a3.5 3.5 0 1 1-4.95-4.95a3.5 3.5 0 0 1 4.95 4.95Z" clip-rule="evenodd"/><path d="M11.192 13.314a1.5 1.5 0 1 1 2.122-2.122l3.535 3.536a1.5 1.5 0 1 1-2.121 2.121l-3.536-3.535Z"/></g></svg>');
            a.appendChild(link);
        } else if (listOfLinks[i] === 'about.php') {
            a.innerHTML = listOfInnerHTML[i];
        } else if (listOfLinks[i] === 'cart.php') {
            let link = generateSVG('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="white" d="M7 22q-.825 0-1.412-.587Q5 20.825 5 20q0-.825.588-1.413Q6.175 18 7 18t1.412.587Q9 19.175 9 20q0 .825-.588 1.413Q7.825 22 7 22Zm10 0q-.825 0-1.412-.587Q15 20.825 15 20q0-.825.588-1.413Q16.175 18 17 18t1.413.587Q19 19.175 19 20q0 .825-.587 1.413Q17.825 22 17 22ZM5.2 4h14.75q.575 0 .875.512q.3.513.025 1.038l-3.55 6.4q-.275.5-.738.775Q16.1 13 15.55 13H8.1L7 15h12v2H7q-1.125 0-1.7-.988q-.575-.987-.05-1.962L6.6 11.6L3 4H1V2h3.25Z"/></svg>');
            let span = document.createElement('span');
            span.id = 'cart-quantity';
            // Print the number of items in the cart
            // the number of items is taken from the php variable $order->size();
            span.innerHTML = '0';
            a.appendChild(link);
            a.appendChild(span);
        } else {
            let link = generateSVG('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="white"><path d="M11 6a3 3 0 1 1-6 0a3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></g></svg>');
            a.appendChild(link);
        }
        li.appendChild(a);
        ul.appendChild(li);
    }
    nav.appendChild(ul);
}

function generateSVG(link) {
    let svg = document.createElement('svg');
    svg.classList.add('icon-svg');
    svg.innerHTML = link;
    return svg;
}


function hamburgerMenu() {
    const hamburger = document.createElement('div');
    hamburger.className = 'hamburger';
    let span = document.createElement('span');

    hamburger.appendChild(span);
    return hamburger;
}


createElements();

let hamburger = document.querySelector('.hamburger');
let nav = document.querySelector('.nav-bar');
hamburger.onclick = function () {
    nav = document.querySelector('.nav-bar');
    nav.classList.toggle('active');
    hamburger.classList.toggle('active');
}