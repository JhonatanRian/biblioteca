<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js"></script>
    <link rel="stylesheet" href="./static/css/book.css">
</head>

<body>
    <header class="site-header sticky-top py-1 text-bg-dark">
        <nav class="container d-flex flex-column flex-md-row justify-content-between">
            <a class="py-2" href="#" aria-label="Product">
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
            <a class="py-2 d-none d-md-inline-block" href="./login/">
                <button class="btn btn-secondary">
                    Entrar
                </button>
            </a>
            <!-- <a class="py-2 d-none d-md-inline-block" href="./livros/">
                <button class="btn btn-secondary active">
                    Livros
                </button>
            </a> -->
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 m-auto text-center">
                    <div class="title rounded m-2">
                        <h5 class="text-bg-secundary">
                            Livros novos
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                            </svg>
                        </h5>
                    </div>
                    <article class="c-carousel c-carousel--simple w-100">
                        <div class="c-carousel__slides js-carousel--simple">
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <br>
                        <button id="prev" class="js-carousel--simple-prev btn btn-success">«</button>
                        <button id="next" class="js-carousel--simple-next btn btn-success">»</button>
                        <div class="js-carousel--simple-dots"></div>
                    </article>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 m-auto text-center">
                    <div class="title rounded m-2">
                        <h5 class="text-bg-secundary">
                            Mais alugados
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-bookmark-star" viewBox="0 0 16 16">
                                <path d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.178.178 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.178.178 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.178.178 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.178.178 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.178.178 0 0 0 .134-.098L7.84 4.1z" />
                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z" />
                            </svg>
                        </h5>
                    </div>
                    <article class="c-carousel c-carousel--simple w-100">
                        <div class="c-carousel__slides js-carousel--simple2">
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Indiponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="c-carousel__slide">
                                <div class="col">
                                    <div class="card shadow-sm p-2 bg-light">
                                        <div class="book book-brown book-text-rajd m-auto">
                                            <span>titulo book</span>
                                        </div>

                                        <div class="card-body">
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">acessar</button>
                                                </div>
                                                <small class="text-muted">Disponivel</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                        <br>
                        <button id="prev" class="js-carousel--simple-prev btn btn-success">«</button>
                        <button id="next" class="js-carousel--simple-next btn btn-success">»</button>
                        <div class="js-carousel--simple-dots"></div>
                    </article>
                </div>
            </div>
        </div>
    </main>
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>
                <span class="mb-3 mb-md-0 text-muted">© 2022 Company, Inc</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                            <use xlink:href="#twitter"></use>
                        </svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                            <use xlink:href="#instagram"></use>
                        </svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                            <use xlink:href="#facebook"></use>
                        </svg></a></li>
            </ul>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        var $simpleCarousel = document.querySelector(".js-carousel--simple");
        var $simpleCarousel2 = document.querySelector(".js-carousel--simple2");

        new Glider($simpleCarousel, {
            slidesToShow: 3,
            slidesToScroll: 3,
            draggable: true,
            dots: ".js-carousel--responsive-dots",
            arrows: {
                prev: "#prev",
                next: "#next",
            },

            responsive: [{
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    },
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    },
                },
            ],
        });

        new Glider($simpleCarousel2, {
            slidesToShow: 3,
            slidesToScroll: 3,
            draggable: true,
            dots: ".js-carousel--responsive-dots",
            arrows: {
                prev: "#prev",
                next: "#next",
            },

            responsive: [{
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    },
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    },
                },
            ],
        });
    </script>
</body>

</html>