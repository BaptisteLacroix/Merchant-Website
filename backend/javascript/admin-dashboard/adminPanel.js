let container = document.querySelector('.container')

function createPanel() {
    let linkFooter = document.createElement('link');
    linkFooter.rel = 'stylesheet';
    linkFooter.type = 'text/css';
    linkFooter.href = '../css/dashboard/adminPanel.css';
    document.head.appendChild(linkFooter);
    let listOfInnerTitle = ['Forum', 'People', 'Account', 'Stock'];
    let listOfInnerHTML = ['Manage customer feedback.', 'Manage customer accounts.', 'Access the chart of accounts.', 'Managing stocks'];
    let listOfimages = ['forum.svg', 'people.svg', 'account.svg', 'stock.svg'];
    let listOfLinks = ['./dashboard.php?forum', './dashboard.php?people', './dashboard.php?acount', './dashboard.php?stock'];

    for (let i = 0; i < listOfInnerHTML.length; i++) {
        let card = document.createElement('div');
        card.className = 'card';

        let imgBox = document.createElement('div');
        imgBox.className = 'imgBox';
        let img = document.createElement('img');
        img.src = '../img/' + listOfimages[i];
        imgBox.appendChild(img);

        let content = document.createElement('div');
        content.className = 'content';
        let div = document.createElement('div');
        let h2 = document.createElement('h2');
        h2.innerHTML = listOfInnerTitle[i];
        let p = document.createElement('p');
        p.innerHTML = listOfInnerHTML[i];
        let a = document.createElement('a');
        a.href = listOfLinks[i];
        a.innerHTML = 'Access';

        div.appendChild(h2);
        div.appendChild(p);
        div.appendChild(a);
        content.appendChild(div);
        card.appendChild(imgBox);
        card.appendChild(content);
        container.appendChild(card);
    }
}

createPanel();