<?php
switch ($URL[0]){
    case 'area-de-concentracao':
    case 'historico':
    case 'estrutura-curricular':
    case 'integracao-com-a-industria':
    case 'disciplinas':
    case 'linhas-de-pesquisa':
        $menu_title = 'O Programa';
        $menu_content = '<li '.($URL[0] == "historico" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/historico">Histórico</a></li>
            <li '.($URL[0] == "area-de-concentracao" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/area-de-concentracao">Área de Concentração</a></li>
            <li '.($URL[0] == "linhas-de-pesquisa" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/linhas-de-pesquisa">Linhas de Pesquisa</a></li>
            <li '.($URL[0] == "estrutura-curricular" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/estrutura-curricular">Estrutura Curricular e Disciplinas</a></li>
            <li '.($URL[0] == "integracao-com-a-industria" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/integracao-com-a-industria">Integração com a Indústria</a></li>';
        break;
    case 'corpo-discente':
    case 'corpo-docente':
    case 'egressos':
    case 'secretaria':
    case 'comissoes':
    case 'pos-doutorandos':
        $menu_title = 'Pessoas';
        $menu_content = '<li '.($URL[0] == "corpo-docente" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/corpo-docente">Corpo Docente</a></li>
                <li '.($URL[0] == "corpo-discente" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/corpo-discente">Corpo Discente</a></li>
                <li '.($URL[0] == "egressos" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/egressos">Egressos</a></li>
                <li '.($URL[0] == "pos-doutorandos" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/pos-doutorandos">Pós-Doutorandos</a></li>
                <li '.($URL[0] == "comissoes" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/comissoes">Comissões</a></li>
                <li '.($URL[0] == "secretaria" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/secretaria">Secretaria</a></li>';
        break;
    case 'biblioteca':
    case 'laboratorios':
        $menu_title = 'Infraestrutura';
        $menu_content = '<li '.($URL[0] == "biblioteca" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/biblioteca">Biblioteca</a></li>
                <li '.($URL[0] == "laboratorios" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/laboratorios">Laboratórios</a></li>';
        break;
    case 'normas-e-procedimentos':
    case 'cronograma':
    case 'quadro-de-horarios':
    case 'formularios':
    case 'materiais':
        $menu_title = 'Documentos';
        $menu_content = '<li '.($URL[0] == "normas-e-procedimentos" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/normas-e-procedimentos">Normas e Procedimentos</a></li>
                    <li '.($URL[0] == "cronograma" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/cronograma">Cronograma</a></li>
                    <li '.($URL[0] == "quadro-de-horarios" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/quadro-de-horarios">Quadro de Horários</a></li>
                    <li '.($URL[0] == "formularios" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/formularios">Formulários</a></li>
                    <li '.($URL[0] == "materiais" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/materiais">Materiais</a></li>';
        break;
    case 'processo-seletivo':
    case 'processos-seletivos-anteriores':
        $menu_title = "Processos Seletivos";
        $menu_content = '<li '.($URL[0] == "processo-seletivo" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/processo-seletivo">Processo Seletivo Atual</a></li>
                        <li '.($URL[0] == "processos-seletivos-anteriores" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/processos-seletivos-anteriores">Processos Seletivos Anteriores</a></li>';
        break;
        case 'defesas':
            $menu_title = 'Defesas';
            $menu_content = '<li '.($URL[0] == "defesas" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/defesas">Defesas</a></li>
                    <li><a href="https://www.repositorio.ufop.br/handle/123456789/10028" target="_blank">Repositório de Dissertações</a></li>';
            break;

    case 'perguntas-frequentes':
    case 'fale-conosco':
        $menu_title = 'Contato';
        $menu_content = '<li '.($URL[0] == "perguntas-frequentes" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/perguntas-frequentes">Perguntas Frequentes</a></li>
                    <li '.($URL[0] == "fale-conosco" ? "class=font-weight-bolder" :"").'><a href="'.BASE.'/fale-conosco">Fale Conosco</a></li>';
        break;




}

?>
<div class="col-lg-4 sidebar ftco-animate">
    <div class="sidebar-box">
        <form class="search-form" name="search" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <span class="icon icon-search"></span>
                <input type="text" name="s" class="form-control" placeholder="Pesquisar..."/>
            </div>
        </form>
    </div>
    <div class="sidebar-box ftco-animate">
        <h3><?= $menu_title;?></h3>
        <ul class="categories">
            <?= $menu_content; ?>
        </ul>
    </div>

    <div class="sidebar-box ftco-animate">
        <h3>Últimas Notícias</h3>
        <?php
        $Read->ExeRead(DB_POSTS, "WHERE post_status = 1 AND post_date <= NOW() ORDER BY post_views DESC, post_date DESC LIMIT 5");
        if (!$Read->getResult()):
            echo Erro("Ainda não existe posts cadastrados. Por favor, volte mais tarde :)", E_USER_NOTICE);
        else:
        foreach ($Read->getResult() as $Post):
        ?>
        <div class="block-21 mb-4 d-flex">
            <a class="blog-img mr-4" style="background-image: url(<?= BASE; ?>/tim.php?src=uploads/<?= $Post['post_cover']; ?>&w=<?= IMAGE_W / 2; ?>&h=<?= IMAGE_H / 2; ?>);"></a>
            <div class="text">
                <h3 class="heading"><a title="Ler mais sobre <?= $Post['post_title']; ?>" href="<?= BASE; ?>/artigo/<?= $Post['post_name']; ?>"><?= $Post['post_title']; ?></a></h3>
            </div>
        </div>
       <?php endforeach; endif; ?>
    </div>


</div><!-- END COL -->