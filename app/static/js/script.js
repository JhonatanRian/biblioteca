const inputLivro = document.querySelector("input[name=nome_livro]")
const btnlivro = document.querySelector("#btn-buscar")

btnlivro.addEventListener("click", renderOptions)

inputLivro.addEventListener("keydown", async (e) => {
    if (e.keyCode === 13) {
        e.preventDefault();
        await renderOptions(e)
    }
})

async function renderOptions(e) {
    e.preventDefault();

    let myHeader = new Headers();
    myHeader.append("Content-Type", "application/json");

    let value = inputLivro.value;
    let response = await fetch(`../functions/livros.php?nome_livro=${value}`, {
        method: "GET",
        headers: myHeader,
        mode: "cors",
        cache: 'default',
    })
    json = await response.json();

    let arr_livros = Array.from(json);
    let select = document.querySelector("#floatingSelect")
    select.textContent = ""
    arr_livros.forEach((livro, index, arr) => {
        let option = document.createElement("option");
        option.value = livro.id
        let text = document.createTextNode(`${livro.nome} | quantidade=${livro.qtde}`);
        option.appendChild(text);
        if (index == 0) {
            option.setAttribute("selected", true);
        }
        select.appendChild(option);
    })
}