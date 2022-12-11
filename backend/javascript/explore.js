// Constant
const numberOfIMages = 8;
const head = document.head;
const style = document.createElement('style');
const section = document.body;


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
    
        let div_imgBox = document.createElement('div');
        div_imgBox.className = 'imgBox';
    
        let img = document.createElement('img');
        img.src = './img/image' + i + '.png';

        let ul_action = document.createElement('ul');
        ul_action.className = 'action';

        let li_shopping_cart = document.createElement('li');
        let i_shopping_cart = document.createElement('i');
        i_shopping_cart.className = 'fa fa-shopping-cart';

        let span_cart = document.createElement('span');
        span_cart.innerHTML = 'Add to cart';
    
        let li_heart = document.createElement('li');
        let i_heart = document.createElement('i');
        i_heart.className = 'fa fa-heart';

        let span_heart = document.createElement('span');
        span_heart.innerHTML = 'Add to wishlist';

        let li_eye = document.createElement('li');
        let i_eye = document.createElement('i');
        i_eye.className = 'fa fa-eye';

        let span_eye = document.createElement('span');
        span_eye.innerHTML = 'View Details';

        let div_content = document.createElement('div');
        div_content.className = 'content';
    
        let div_productName = document.createElement('div');
        div_productName.className = 'productName';
    
        let h3 = document.createElement('h3');
        h3.innerHTML = 'Product Name';
    
        let div_price_rating = document.createElement('div');
        div_price_rating.className = 'price_rating';
    
        let h2_price_rating = document.createElement('h2');
        h2_price_rating.innerHTML = 'Price';
    
        let div_rating = document.createElement('div');
        div_rating.className = 'rating';
    
        for (let i = 0; i < 5; i++) {
            // TODO -> Notation voir avec la BDD (rajouter classe grey si vide)
            let span = document.createElement('span');
            i.className = 'fa fa-star';
            i.arialHidden = 'true';
            span.innerHTML = '★';
            div_rating.appendChild(span);
        }

        div_price_rating.appendChild(h2_price_rating);
        div_price_rating.appendChild(div_rating);

        div_productName.appendChild(h3);

        div_content.appendChild(div_productName);
        div_content.appendChild(div_price_rating);

        div_imgBox.appendChild(img);
        div_imgBox.appendChild(ul_action);

        ul_action.appendChild(li_shopping_cart);
        ul_action.appendChild(li_heart);
        ul_action.appendChild(li_eye);

        li_shopping_cart.appendChild(i_shopping_cart);
        li_heart.appendChild(i_heart);
        li_eye.appendChild(i_eye);

        li_shopping_cart.appendChild(span_cart);
        li_heart.appendChild(span_heart);
        li_eye.appendChild(span_eye);

        div_card.appendChild(div_imgBox);
        div_card.appendChild(div_content);

        container.appendChild(div_card);
    }
}

createElements();
