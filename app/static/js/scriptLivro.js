let bookThemes = document.querySelectorAll("#corcapa option");
let fontesBook = document.querySelectorAll("#fonte option");
let inputcor = document.querySelector("body > main > div > div > div > div.card-body > div > div > div > div > form > div:nth-child(8) > input");
let book = document.querySelector(".book");
let cor = document.querySelector("#corcapa").value;
let fonte = document.querySelector("#fonte").value;

bookThemes.forEach((elem) => {
    elem.addEventListener("click", async (e) => {
        alterarCor(e.target);
    })
})

fontesBook.forEach((elem) => {
    elem.addEventListener("click", async (e) => {
        alterarFonte(e.target);
    })
})

function alterarFonte(elem) {
    book.classList.replace(fonte, elem.value);
    fonte = elem.value;
}

function alterarCor(elem) {
    book.classList.replace(cor, elem.value);
    cor = elem.value;
}