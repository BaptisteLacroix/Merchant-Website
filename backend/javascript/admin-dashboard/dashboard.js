let home = document.getElementById("home");
let people = document.getElementById("people");
let account = document.getElementById("account");
let stock = document.getElementById("stock");
let forum = document.getElementById("forum");
let supplier = document.getElementById("supplier");
let iframe = document.getElementById("iframe");

home.addEventListener("click", () => {
    iframe.src = "./adminPanel.php";
});

people.addEventListener("click", () => {
    iframe.src = "./iframes/people.php";
});

account.addEventListener("click", () => {
    iframe.src = "./iframes/account.php";
});

stock.addEventListener("click", () => {
    iframe.src = "./iframes/stock.php";
});

forum.addEventListener("click", () => {
    iframe.src = "./iframes/forum.php";
});

supplier.addEventListener("click", () => {
    iframe.src = "./iframes/fournisseur.php";
});