const footer = document.createElement('footer');

function createFooter() {
    let linkFooter = document.createElement('link');
    linkFooter.rel = 'stylesheet';
    linkFooter.type = 'text/css';
    linkFooter.href = './css/footer.css';
    document.head.appendChild(linkFooter);
    let listOfInnerHTML = ['Home', 'Explore', 'About Us', 'Cart', 'Login'];
    let listOfLinks = ['index.php', 'explore.php', 'about.php', 'cart.php', 'login.php'];
    footer.classList.add('sticky-footer');
    let ul = document.createElement('ul');
    for (let i = 0; i < listOfLinks.length; i++) {
        let li = document.createElement('li');
        let a = document.createElement('a');
        a.href = listOfLinks[i];
        a.innerHTML = listOfInnerHTML[i];
        li.appendChild(a);
        ul.appendChild(li);
    }
    footer.appendChild(ul);

    let p = document.createElement('p');
    let a = document.createElement('a');
    a.href = 'mailto:baptiste&period;lacroix&commat;etu&period;unice&period;fr';
    a.innerHTML = '© Copyright - Lacroix Baptiste - 2022/2023 - All rights reserved';
    p.appendChild(a);
    footer.appendChild(p);

    body.appendChild(footer);
}

createFooter();