const inputsCheck = document.querySelectorAll("body > main > div > div > div > div.card-body > form > ul input");
const LabelsCheck = document.querySelectorAll("body > main > div > div > div > div.card-body > form > ul label");
const inputSearch = document.querySelector("#search_livro");

Array.from(inputsCheck).forEach((elem, index) => {
    elem.addEventListener("change", (event) => {
        let label = LabelsCheck[index];
        inputSearch.setAttribute("placeholder", `Buscar aluno por ${label.textContent}`)
    })
})