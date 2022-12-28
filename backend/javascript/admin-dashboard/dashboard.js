let home = document.getElementById("home");
let people = document.getElementById("people");
let account = document.getElementById("account");
let stock = document.getElementById("stock");
let supplier = document.getElementById("supplier");
let iframe = document.getElementById("iframe");
let list = [home, people, account, stock, supplier];

home.addEventListener("click", () => {
    iframe.src = "./adminPanel.php";
    disableBorder();
    home.style.borderRight = '5px solid #456aff';
});

people.addEventListener("click", () => {
    iframe.src = "./iframes/people.php";
    disableBorder();
    people.style.borderRight = '5px solid #456aff';
});

account.addEventListener("click", () => {
    iframe.src = "./iframes/account.php";
    disableBorder();
    account.style.borderRight = '5px solid #456aff';
});

stock.addEventListener("click", () => {
    iframe.src = "./iframes/stock.php";
    disableBorder();
    stock.style.borderRight = '5px solid #456aff';
});

supplier.addEventListener("click", () => {
    iframe.src = "./iframes/fournisseur.php";
    disableBorder();
    supplier.style.borderRight = '5px solid #456aff';
});

function disableBorder() {
    list.forEach((element) => {
        element.style.border = 'none';
    });
}