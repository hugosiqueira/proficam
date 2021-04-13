<?php
$AdminLevel = LEVEL_ITV_SELECTION_PROCESS;
if (!APP_SELECTION_PROCESS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE USER TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_SELECTION_PROCESS, "WHERE selection_process_status = :status AND selection_process_type = :type", "status=0&type=Novo Processo Seletivo");
endif;
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-pencil">Processos Seletivos</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Processos Seletivos
        </p>
    </div>
    <div class="dashboard_header_search">
        <a class='btn btn_green icon-plus' href='dashboard.php?wc=processo_seletivo/create' title='Novo Processo Seletivo!'>Novo Processo Seletivo</a>
    </div>
</header>

<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Pager = new Pager("dashboard.php?wc=processo_seletivo/home&page=", "<<", ">>", 5);
    $Pager->ExePager($Page, 12);
    $Read->FullRead("SELECT * FROM ". DB_SELECTION_PROCESS." ORDER BY selection_process_year DESC, selection_process_type ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if (!$Read->getResult()):
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem processos seletivos cadastradas {$Admin['user_name']}. Comece agora mesmo cadastrando uma nova pergunta!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Selection):
            extract($Selection);
            $selection_process_type = ($selection_process_type ? $selection_process_type : 'Novo Processo Seletivo');

            echo "<article class='single_user box box25 al_center'>
                    <div class='box_content wc_normalize_height'>
                        <h1>{$selection_process_type}</h1>
                        <br/>
                        <h2>{$selection_process_year}</h2>
                        <p class='nivel'>" .($selection_process_status == 0 ? '<span class="font_red">Planejamento</span>' : $selection_process_status == 1 ? '<span class="font_blue">Em Andamento</span>' : '<span class="font_green">Concluido</span>') . "</p>
                    </div>
                    <div class='single_user_actions'>
                        <a class='btn btn_green icon-pencil' href='dashboard.php?wc=processo_seletivo/create&id={$selection_process_id}' title='Gerenciar Pergunta!'>Editar Processo</a>
                    </div>
                </article>";
        endforeach;
        $Pager->ExePaginator(DB_SELECTION_PROCESS );
        echo $Pager->getPaginator();
    endif;
    ?>
</div>
