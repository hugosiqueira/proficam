<?php
$AdminLevel = LEVEL_ITV_RESEARCH;
if (!APP_RESEARCH || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;


// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-search-plus">Linhas de Pesquisa</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="Todos as Linhas de Pesquisa" href="dashboard.php?wc=linhas/home">Linhas de Pesquisa</a>
        </p>
    </div>
    <div class="dashboard_header_search">
        <a class='btn btn_green icon-plus' href='dashboard.php?wc=linhas/create' title='Nova Linha de Pesquisa!'>Nova Linha de Pesquisa</a>
    </div>

</header>

<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Paginator = new Pager("dashboard.php?wc=linhas/home&pg=", '<<', '>>', 5);
    $Paginator->ExePager($Page, 12);


    $Read->FullRead("SELECT * FROM " . DB_RESEARCH
            . " ORDER BY research_name ASC "
            . " LIMIT :limit OFFSET :offset", "limit={$Paginator->getLimit()}&offset={$Paginator->getOffset()}"
    );
            
    if (!$Read->getResult()):
        $Paginator->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem linhas de pesquisa cadastradas {$Admin['user_name']}. Comece agora mesmo criando sua primeira linha de pesquisa!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $RESEARCH):
            extract($RESEARCH);

            $ResearchCover = (file_exists("../uploads/linhas_pesquisa/{$research_img}") && !is_dir("../uploads/linhas_pesquisa/{$research_img}") ? "uploads/linhas_pesquisa/{$research_img}" : 'admin/_img/no_image.jpg');
            //$ResearchStatus = ($research_status == 1 && strtotime($post_date) >= strtotime(date('Y-m-d H:i:s')) ? '<span class="btn btn_blue icon-clock icon-notext wc_tooltip"><span class="wc_tooltip_baloon">Agendado</span></span>' : ($post_status == 1 ? '<span class="btn btn_green icon-checkmark icon-notext wc_tooltip"><span class="wc_tooltip_baloon">Publicado</span></span>' : '<span class="btn btn_yellow icon-warning icon-notext wc_tooltip"><span class="wc_tooltip_baloon">Pendente</span></span>'));
            $research_name = (!empty($research_name) ? $research_name : 'Edite esse rascunho para poder exibir como linha de pesquisa em seu site!');


            echo "<article class='box box25 post_single' id='{$research_id}'>           
                <div class='post_single_cover'>
                    <a title='Ver linha de pesquisa no site' target='_blank' href='" . BASE . "/linhas-de-pesquisa/{$research_link}'><img alt='{$research_name}' title='{$research_name}' src='../tim.php?src={$ResearchCover}&w=" . IMAGE_W / 2 . "&h=" . IMAGE_H / 2 . "'/></a>
                    
                </div>
                <div class='post_single_content wc_normalize_height'>
                    <h1 class='title'><a title='Ver linha de pesquisa no site' target='_blank' href='" . BASE . "/linhas-de-pesquisa/{$research_link}'>{$research_name}</a></h1>

                </div>
                <div class='post_single_actions'>
                    <a title='Editar linha de pesquisa' href='dashboard.php?wc=linhas/create&id={$research_id}' class='post_single_center icon-pencil btn btn_blue'>Editar</a>
                    <span rel='post_single' class='j_delete_action icon-cancel-circle btn btn_red' id='{$research_id}'>Deletar</span>
                    <span rel='post_single' callback='Research' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='{$research_id}'>Deletar Linha de Pesquisa?</span>
                </div>
            </article>";
        endforeach;

        $Paginator->ExePaginator(DB_RESEARCH);
        echo $Paginator->getPaginator();
    endif;
    ?>
</div>