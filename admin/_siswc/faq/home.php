<?php
$AdminLevel = LEVEL_ITV_FAQ;
if (!APP_FAQ || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE USER TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_FAQ, "WHERE faq_question = :question", "question=Nova Pergunta");
endif;
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-question">Perguntas Frequentes</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Perguntas Frequentes
        </p>
    </div>
    <div class="dashboard_header_search">
        <a class='btn btn_green icon-plus' href='dashboard.php?wc=faq/create' title='Nova Pergunta!'>Nova Pergunta</a>
    </div>
</header>

<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Pager = new Pager("dashboard.php?wc=faq/home&page=", "<<", ">>", 5);
    $Pager->ExePager($Page, 12);
    $Read->FullRead("SELECT * FROM ". DB_FAQ." LEFT JOIN " . DB_FAQ_CATEGORY ." ON faq_category_id = faq_category ORDER BY faq_category ASC, faq_question ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if (!$Read->getResult()):
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem perguntas cadastradas {$Admin['user_name']}. Comece agora mesmo cadastrando uma nova pergunta!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Faq):
            extract($Faq);
            $faq_question = ($faq_question ? $faq_question : 'Nova Pergunta');

            echo "<article class='single_user box box25 al_center'>
                    <div class='box_content wc_normalize_height'>
                        <h1>{$faq_question}</h1>
                        <br/>
                        <h5 class='nivel'>{$faq_category_name}</h5>
                        <p class='nivel'>" .($faq_status ? '<span class="font_green">Publicado</span>' : '<span class="font_red">Desativado</span>') . "</p>
                    </div>
                    <div class='single_user_actions'>
                        <a class='btn btn_green icon-question' href='dashboard.php?wc=faq/create&id={$faq_id}' title='Gerenciar Pergunta!'>Editar Pergunta</a>
                    </div>
                </article>";
        endforeach;
        $Pager->ExePaginator(DB_FAQ );
        echo $Pager->getPaginator();
    endif;
    ?>
</div>