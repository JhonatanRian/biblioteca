(
    function () {
        let lis = document.querySelectorAll("#alugeis-aluno li");
        if (lis.length > 0) {
            let idAlg = lis[0].value
            renderUpdate(idAlg);
            renderDelete(idAlg);
            Array.from(lis).forEach((elem, index, arr) => {
                elem.addEventListener("click", clickLi)
            })
        }

        let btnUp = document.querySelector("#btn-update");
        let btnDe = document.querySelector("#btn-delete");
        btnUp.addEventListener("click", clickUpd);
        btnDe.addEventListener("click", clickDel);
    }
)();

function renderUpdate(idAlg) {
    let paneUpdate = document.querySelector("#update-tab-pane");
    
    let elemText = `
        <form action="." id="form-update" class="text-center " method="patch">
            <input type="hidden" name="id_alg" value="${idAlg}">
            <div class="row g-3">
                <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="form-label" for="data">Data prevista para entrega:</label>
                <input type="date" class="form-control" id="data" name="data-prevista">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="form-label" for="data">Data em que o livro foi entregue:</label>
                <input type="date" class="form-control" id="data" name="data-entrega">
                </div>
            </div>
            <button id="btn-update" class="btn btn-success m-1">ATUALIZAR</button>
        </form>
    `
    paneUpdate.innerHTML = "";
    paneUpdate.innerHTML = elemText;
}

function renderDelete(idAlg) {
    let paneDelete = document.querySelector("#delete-tab-pane");
    let elemText = `
    <form action="." id="form-delete" class="text-center" method="delete">
        <input type="hidden" name="id_alg" value="${idAlg}">
        <p class="alert alert-warning m-1">Deseja deletar esse aluguel?</p>
        <button class="btn btn-danger" id="btn-delete" >DELETAR</button>
    </form>
    `

    paneDelete.innerHTML = "";
    paneDelete.innerHTML = elemText;
}

function clickLi(event) {
    let liSelected = event.currentTarget
    let lis = document.querySelectorAll("#alugeis-aluno li");
    let arrLis = Array.from(lis);
    let liActive = arrLis.filter((elem, index, arr) => elem.classList.contains("active"))[0];
    liActive.classList.remove("active");
    liSelected.classList.add("active");

    AlterarIdUpdateDelete(liSelected.value)
}

function AlterarIdUpdateDelete(idAlg) {
    let inputs = document.querySelectorAll("input[name=id_alg]"); 
    Array.from(inputs).forEach((elem)=> {
        elem.setAttribute("value", idAlg);
    })
}

async function clickUpd(e) {
    e.preventDefault();
    let form = document.querySelector("#form-update");
    let idAlg = form.querySelector("input[name=id_alg]").value;
    let datapv = form.querySelector("input[name='data-prevista']").value;
    let dataet = form.querySelector("input[name='data-entrega']").value;
    let obj = {
        "dpv": datapv,
        "det": dataet,
        "idalg": idAlg
    }
    if (dataet || datapv) {
        let response = await fetch("update.php", {
            method: "PATCH",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(obj)
        })
        let json = await response.json();
        if (response.ok) {
            exibirSucesso(json.msg);
            atualizarPagina();
        } else {
            exibirErro(json.msg);
        }
    }else {
        exibirErro("Preencha pelo menos um campo!")
        return;
    }
}

async function clickDel(e) {
    e.preventDefault();
    let form = document.querySelector("#form-delete");
    let idAlg = form.querySelector("input[name=id_alg]").value;
    let obj = {
        "idalg": idAlg
    }
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
        exibirSucesso(json.msg);
        atualizarPagina();
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

function exibirSucesso(msg) {
    let err = document.querySelector("#err-success");
    err.classList.contains("d-none") ? err.classList.remove("d-none") : null ;
    err.textContent = "";
    err.textContent = msg;
}

function atualizarPagina() {
    setTimeout(function() {
      // Atualizar a página
      location.reload();
    }, 3500); // 3500 milissegundos = 3 segundos
  }