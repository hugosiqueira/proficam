<?php
$AdminLevel = LEVEL_ITV_PROJECTS;
if (!APP_PROJECTS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;
//AUTO DELETE USER TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_PROJECTS, "WHERE project_title = :title", "title=Novo Projeto");
endif;
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-file-text">Projetos de Pesquisa</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Projeto
        </p>
    </div>
    <div class="dashboard_header_search">
        <a class='btn btn_green icon-file-text' href='dashboard.php?wc=projetos/create' title='Novo Projeto!'>Novo Projeto</a>


    </div>
</header>

<div class="dashboard_content">
    <article class='project_dashboard box box100'>
        <table class='styled-table'>
            <thead>
                <th width='87%'>Título</th>
                <th width='10%'>Status</th>
                <th width='1%'></th>
                <th width='1%'></th>
            </thead>
            <tbody>
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Pager = new Pager("dashboard.php?wc=projetos/home&page=", "<<", ">>", 5);
    $Pager->ExePager($Page, 25);
    $Read->FullRead("SELECT * FROM ". DB_PROJECTS."  ORDER BY project_title ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if (!$Read->getResult()):
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem projetos de pesquisa cadastrados {$Admin['user_name']}. Comece agora mesmo cadastrando um novo projeto de pesquisa!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Projects):
            extract($Projects);
            $project_title = ($project_title ? $project_title : 'Novo Projeto');
            $project_status = ($project_status ? "Publicado" : 'Despublicado' );

            echo "
                    
                    <tr>
                    <td>{$project_title}</td>
                    <td>{$project_status}</td>
                    <td><a href='dashboard.php?wc=projetos/create&id={$project_id}' class=' btn btn_blue'> Editar</a></td>
                    <td><span callback='Project' callback_action='window_delete_project' data-id='{$project_id}'  class='j_ajaxModal btn btn_red'> Excluir</span></td>                  
                    </tr>
                    
                ";
        endforeach;
        $Pager->ExePaginator(DB_PROJECTS);
        echo $Pager->getPaginator();
    endif;
    ?>
            </tbody>
        </table>
    </article>
</div>