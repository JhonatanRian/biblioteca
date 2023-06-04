<header class="site-header sticky-top py-1 text-bg-dark navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
        <a class="py-2 float-left d-flex align-items-center mb-3 navbar-brand link-body-emphasis text-decoration-none" href="/painel/" aria-label="Product">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" viewBox="0 0 460 460" xml:space="preserve" width="44" height="44" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mx-auto" role="img" viewBox="0 0 24 24">
                <title>
                    Biblioteca
                </title>
                <circle cx="12" cy="12" r="10"></circle>
                <g id="XMLID_844_">
                    <path id="XMLID_1068_" style="fill:#695538;" d="M110,435H60l-10-30h70L110,435z M410,405h-70l10,30h50L410,405z" />
                    <path id="XMLID_843_" style="fill:#CBB57A;" d="M460,415H0v-40h460V415z" />
                    <path id="XMLID_842_" style="fill:#9E8E60;" d="M460,425H0v-20h460V425z" />
                    <path id="XMLID_1783_" style="fill:#D66A40;" d="M200,105v280c0,5.523-4.477,10-10,10h-50c-5.523,0-10-4.477-10-10   c0,5.523-4.477,10-10,10H70c-5.523,0-10-4.477-10-10V35c0-5.523,4.477-10,10-10h50c5.523,0,10,4.477,10,10v70   c0-5.523,4.477-10,10-10h50C195.523,95,200,99.477,200,105z M419.751,350.584L259.15,121.222   c-3.168-4.524-9.403-5.624-13.927-2.456l-40.958,28.679c-4.524,3.168-5.624,9.403-2.456,13.927l160.601,229.363   c3.168,4.524,9.403,5.624,13.927,2.456l40.958-28.679C421.82,361.344,422.919,355.109,419.751,350.584z" />
                    <path id="XMLID_1778_" style="fill:#B14724;" d="M200,235H60V135h140V235z M200,295H60v30h140V295z" />
                    <path id="XMLID_1782_" style="fill:#732D21;" d="M259.15,121.222l160.601,229.363c3.168,4.524,2.068,10.759-2.456,13.927   l-40.958,28.679c-4.524,3.168-10.759,2.068-13.927-2.456L201.809,161.372c-3.168-4.524-2.068-10.76,2.456-13.927l40.958-28.679   C249.747,115.598,255.982,116.698,259.15,121.222z" />
                    <path id="XMLID_1781_" style="fill:#C18F2B;" d="M287.829,162.18l-57.341,40.15l-17.207-24.575l57.341-40.15L287.829,162.18z    M310.772,194.946l-57.341,40.15l74.565,106.49l57.341-40.15L310.772,194.946z" />
                    <path id="XMLID_1780_" style="fill:#64757C;" d="M130,35v350c0,5.523-4.477,10-10,10H70c-5.523,0-10-4.477-10-10V35   c0-5.523,4.477-10,10-10h50C125.523,25,130,29.477,130,35z" />
                    <path id="XMLID_1779_" style="fill:#374145;" d="M130,295H60V145h70V295z M130,95H60v20h70V95z M130,325H60v20h70V325z" />
                </g>
            </svg>
        </a>
        <nav class="d-flex flex-column flex-md-row justify-content-center">

            <a class="py-2 d-none d-md-inline-block me-1" href="/painel/">
                <button class="btn btn-secondary">
                    Home
                </button>
            </a>
            <a class="py-2 d-none d-md-inline-block me-1" href="/painel/livros/">
                <button class="btn btn-secondary">
                    Livros
                </button>
            </a>
            <a class="py-2 d-none d-md-inline-block me-1" href="/painel/generos/">
                <button class="btn btn-secondary">
                    Generos
                </button>
            </a>
            <a class="py-2 d-none d-md-inline-block me-1" href="/painel/alunos/">
                <button class="btn btn-secondary">
                    Aluno
                </button>
            </a>
            <a class="py-2 d-none d-md-inline-block me-1" href="/painel/alugar/">
                <button class="btn btn-secondary">
                    Alugueis
                </button>
            </a>
            <a class="py-2 d-none d-md-inline-block me-1" href="./operarios/">
                <button class="btn btn-secondary">
                    Operarios
                </button>
            </a>
            <a class="py-2 d-none d-md-inline-block me-1" href="/logout/">
                <button class="btn btn-secondary">
                    Logout
                </button>
            </a>
        </nav>
        <script>
            let tags = document.querySelectorAll("body > header > div > nav a");
            let tagb = document.querySelectorAll("body > header > div > nav button");
            let list = Array.from(tags);
            list.forEach((elem, index)=>{
                if (elem.getAttribute("href") == window.location.pathname){
                    tagb[index].classList.add("active")
                }
            })

        </script>
        <span class="py-2 float-right navbar-brand">
            <?php
            $name = $_SESSION["nome"];
            echo "<span class='py-2 d-none d-md-inline-block' aria-current='page' href='#'>Bem vindo(a) $name<span class='text-primary'></span></span>";
            ?>
        </span>
    </div>
</header>