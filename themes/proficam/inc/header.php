<div class="bg-top navbar-light">
    <div class="container">
        <div class="row  d-flex align-items-center align-items-stretch">
            <div class="col-lg-4">
                <div class="py-3 pr-5 d-flex topper justify-content-start align-items-center align-items-stretch">
                    <div class="d-flex justify-content-end align-items-center pr-2"><a title="Escola de Minas" target="_blank" href="https://em.ufop.br"><img alt='Escola de Minas' src="<?= BASE . '/tim.php?src=_cdn/images/logo_escola_minas.png&w=90&h=90';?>" /></a></div>
                    <div class="d-flex justify-content-start align-items-center "><a title="ITV" target="_blank" href="https://itv.org"><img alt='ITV' src="<?= BASE . '/tim.php?src=_cdn/images/itv.png&w=193&h=60';?>" /></a></div>
                </div>
            </div>

            <div class="col-lg-6 d-flex justify-content-center align-items-center py-1">
                <a class="navbar-brand" href="<?= BASE;?>"><span class="title">Programa de Pós-Graduação em Instrumentação, Controle e Automação de Processos de Mineração</span>PROFICAM <span>ESCOLA DE MINAS - UFOP/ INSTITUTO TECNOLÓGICO VALE</span></a>
            </div>
            <div class="col-lg-2 d-flex align-items-center py-2">
                    <div class="d-flex topper align-items-center justify-content-end align-items-stretch">
                        <div class="d-flex justify-content-start align-items-center pr-2"><a href="#"><img alt='English' src="<?= BASE . '/tim.php?src=_cdn/images/english.png&w=32&h=32';?>" /></a></div>
                        <div class="d-flex justify-content-end align-items-center"><a href="#"><img alt='Português' src="<?= BASE . '/tim.php?src=_cdn/images/brasil.png&w=32&h=32';?>" /></a></div>
                    </div>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container d-flex align-items-center px-4">
        <button aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
                data-target="#ftco-nav" data-toggle="collapse" type="button">
            <span class="oi oi-menu"></span> Menu
        </button>
        <!--form action="#" class="searchform order-lg-last">
            <div class="form-group d-flex">
                <input class="form-control pl-3" placeholder="Pesquisar" type="text">
                <button class="form-control search" placeholder="" type="submit"><span class="ion-ios-search"></span>
                </button>
            </div>
        </form-->
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav mr-auto">
                <!--li class="nav-item"><a class="nav-link" href="<?= BASE;?>">Início</a></li-->

                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="<?= BASE;?>"
                       id="menu-apresentacao" role="button">Apresentação</a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/historico">Histórico</a>
                        <a class="dropdown-item" href="<?= BASE;?>/area-de-concentracao">Área de Concentração</a>
                        <a class="dropdown-item" href="<?= BASE;?>/estrutura-curricular">Estrutura Curricular</a>
                        <a class="dropdown-item" href="<?= BASE;?>/disciplinas">Disciplinas</a>
                        <a class="dropdown-item" href="<?= BASE;?>/integracao-com-a-industria">Integração com a Indústria</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown"
                       id="menu-pessoas" href="#">Pessoas</a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/corpo-docente">Corpo Docente</a>
                        <a class="dropdown-item" href="<?= BASE;?>/corpo-discente">Corpo Discente</a>
                        <a class="dropdown-item" href="<?= BASE;?>/egressos">Egressos</a>
                        <a class="dropdown-item" href="<?= BASE;?>/pos-doutorandos">Pós-Doutorandos</a>
                        <a class="dropdown-item" href="<?= BASE;?>/comissoes">Comissões</a>
                        <a class="dropdown-item" href="<?= BASE;?>/secretaria">Secretaria</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       id="menu-infraestrutura" role="button">Infraestrutura</a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/biblioteca">Biblioteca</a>
                        <a class="dropdown-item" href="<?= BASE;?>/laboratorios">Laboratórios</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       id="menu-documentos" role="button">Documentos</a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/normas-e-procedimentos">Normas e Procedimentos</a>
                        <a class="dropdown-item" href="<?= BASE;?>/cronograma">Cronograma</a>
                        <a class="dropdown-item" href="<?= BASE;?>/quadro-de-horarios">Quadro de Horários</a>
                        <a class="dropdown-item" href="<?= BASE;?>/formularios">Formulários</a>
                        <a class="dropdown-item" href="<?= BASE;?>/materiais">Materiais</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       id="menu-processo-seletivo" role="button">Processo Seletivo</a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/processo-seletivo">Atual</a>
                        <a class="dropdown-item" href="<?= BASE;?>/processo-seletivo-anteriores">Anteriores</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= BASE;?>/inscricao">Faça sua Inscrição</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       id="menu-defesas" role="button">Defesas</a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" target="_blank" href="https://www.repositorio.ufop.br/handle/123456789/10028">Repositório de Dissertações</a>
                        <a class="dropdown-item" href="<?= BASE;?>/defesas">Defesas</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE;?>/artigos">Notícias</a></li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       id="menu-contato" role="button">Contato</a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/perguntas-frequentes">Perguntas Frequentes</a>
                        <a class="dropdown-item" href="<?= BASE;?>/fale-conosco">Fale Conosco</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->