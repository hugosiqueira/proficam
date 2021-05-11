<div class="bg-top navbar-light header-mobile">
    <div class="container">
        <div class="row ">
            <div class="d-flex align-items-center pl-2">
                <div class="py-3 pr-2 d-flex topper justify-content-center  align-items-center">
                    <div class="d-flex justify-content-start align-items-center pr-2"><a title="Escola de Minas" target="_blank" href="https://em.ufop.br"><img alt='Escola de Minas' class="mx-auto" src="<?= BASE . '/tim.php?src=_cdn/images/logo_escola_minas.png&w=90&h=90';?>" width="90px" height="90px"/></a></div>
                    <div class="d-flex justify-content-end align-items-center"><a title="ITV" target="_blank" href="https://itv.org"><img alt='ITV'  class="mx-auto"  src="<?= BASE . '/tim.php?src=_cdn/images/itv.png&w=193&h=60';?>" width="193px" height="60px" /></a></div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center" >
                <a class="navbar-brand" href="<?= BASE;?>">
                    <img alt='Proficam'  class="logo_desktop"  src="<?= BASE . '/tim.php?src=_cdn/images/logo_proficam.jpg&w=683&h=99';?>"  />
                    <img alt='Proficam'  class="logo_mobile"  src="<?= BASE . '/tim.php?src=_cdn/images/logo_mobile_proficam.jpg&w=411&h=93';?>"  />
                </a>
            </div>
            <div class="d-flex align-items-center p-2">
                <div class="d-flex topper align-items-center justify-content-center align-items-stretch">
                    <div class="zerar_top d-flex justify-content-start align-items-center pr-2"><a href="javascript:trocarIdioma('en')" title="Translate to English" class="zerar_top"><img class="zerar_top" alt='English' src="<?= BASE . '/tim.php?src=_cdn/images/english.png&w=32&h=32';?>" width="32px" height="32px"/></a></div>
                    <div class="zerar_top d-flex justify-content-center align-items-center pr-2"><a href="javascript:trocarIdioma('es')" title="Traduzir para o Espanhol" class="zerar_top"><img class="zerar_top" alt='Espanhol' src="<?= BASE . '/tim.php?src=_cdn/images/espana.png&w=32&h=32';?>" width="32px" height="32px"/></a></div>
                    <div class="zerar_top d-flex justify-content-end align-items-center"><a id=":1.restore" href="javascript:trocarIdioma('pt');" title="Traduzir para portugu&ecirc;s" class="zerar_top"><img class="zerar_top" alt='Português' src="<?= BASE . '/tim.php?src=_cdn/images/brasil.png&w=32&h=32';?>" width="32px" height="32px"/></a></div>
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
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="<?= BASE;?>"
                       id="menu-apresentacao" role="button" >O Programa</a>
                    <div aria-labelledby="menu-apresentacao" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/historico">Histórico</a>
                        <a class="dropdown-item" href="<?= BASE;?>/area-de-concentracao">Área de Concentração</a>
                        <a class="dropdown-item" href="<?= BASE;?>/linhas-de-pesquisa">Linhas de Pesquisa</a>
                        <a class="dropdown-item" href="<?= BASE;?>/projetos-de-pesquisa">Projetos de Pesquisa</a>
                        <a class="dropdown-item" href="<?= BASE;?>/estrutura-curricular">Estrutura Curricular e Disciplinas</a>
                        <a class="dropdown-item" href="<?= BASE;?>/integracao-com-a-industria">Integração com a Indústria</a>
                        <a class="dropdown-item" href="<?= BASE;?>/rede-de-relacionamentos">Rede de Relacionamentos</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown"
                       id="menu-pessoas" href="#" >Pessoas</a>
                    <div aria-labelledby="menu-pessoas" class="dropdown-menu">
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
                    <div aria-labelledby="menu-infraestrutura" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/biblioteca">Biblioteca</a>
                        <a class="dropdown-item" href="<?= BASE;?>/laboratorios">Laboratórios</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       id="menu-documentos" role="button">Documentos</a>
                    <div aria-labelledby="menu-documentos" class="dropdown-menu">
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
                    <div aria-labelledby="menu-processo-seletivo" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/processo-seletivo">Em Andamento</a>
                        <a class="dropdown-item" href="<?= BASE;?>/processos-seletivos-anteriores">Encerrados</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       id="menu-defesas" role="button">Defesas</a>
                    <div aria-labelledby="menu-defesas" class="dropdown-menu">
                        <a class="dropdown-item" target="_blank" rel="noopener" href="https://www.repositorio.ufop.br/handle/123456789/10028">Repositório de Dissertações</a>
                        <a class="dropdown-item" href="<?= BASE;?>/defesas">Defesas</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE;?>/artigos">Notícias</a></li>
                <li class="nav-item dropdown">
                    <a aria-expanded="false" aria-haspopup="true"
                       class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       id="menu-contato" role="button">Contato</a>
                    <div aria-labelledby="menu-contato" class="dropdown-menu">
                        <a class="dropdown-item" href="<?= BASE;?>/perguntas-frequentes">Perguntas Frequentes</a>
                        <a class="dropdown-item" href="<?= BASE;?>/fale-conosco">Fale Conosco</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->