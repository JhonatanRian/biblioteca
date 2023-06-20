(
    function (param) {
        let btnDe = document.querySelector("#btn-delete");
        btnDe.addEventListener("click", clickDel);
    }
)()

let pageret = "/painel/generos/"

async function clickDel(e) {
    e.preventDefault();
    let form = document.querySelector("#form-delete");
    let id = form.querySelector("input[name=id_delete]").value;
    let obj = {
        "id": id
    }
    console.log(obj);
    let response = await fetch("delete.php", {
        method: "DELETE",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(obj)
    })
    let json = await response.json();
    if (response.ok) {
        location.href = pageret;
    } else {
        exibirErro(json.msg);
    }
}

function exibirErro(msg) {
    let err = document.querySelector("#err-danger");
    err.classList.contains("d-none") ? err.classList.remove("d-none") : null ;
    err.textContent = "";
    err.textContent = msg;
}
