<?php
$AdminLevel = LEVEL_ITV_FAQ;
if (!APP_FAQ || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

//AUTO DELETE POST TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_FAQ_CATEGORY, "WHERE faq_category_name IS NULL AND faq_category_id >= :st", "st=1");
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-price-tags">Categorias</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=faq/home">Perguntas</a>
            <span class="crumb">/</span>
            Categorias
        </p>
    </div>

    <div class="dashboard_header_search">
        <a title="Nova Categoria" href="dashboard.php?wc=faq/category" class="btn btn_green icon-plus">Adicionar Categoria!</a>
    </div>

</header>
<div class="dashboard_content">

    <?php
    $Read->ExeRead(DB_FAQ_CATEGORY, " ORDER BY faq_category_name ASC");
    if (!$Read->getResult()):
        echo Erro("<span class='al_center icon-notification'>Ainda não existem categorias cadastradas {$Admin['user_name']}. Comece agora mesmo criando sua primera seção e então suas categorias!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Sess):
            echo "<article class='single_category box box100' id='{$Sess['faq_category_id']}'>
                    <header>
                        <h1 class='icon-price-tags'>{$Sess['faq_category_name']}:</h1>
                        <div class='single_category_actions'>
                            <a title='Editar Categoria!' href='dashboard.php?wc=faq/category&id={$Sess['faq_category_id']}' class='btn btn_blue icon-pencil icon-notext'></a>
                            <span rel='single_category' class='j_delete_action btn btn_red icon-cancel-circle icon-notext' id='{$Sess['faq_category_id']}'></span>
                            <span rel='single_category' callback='FAQ' callback_action='category_remove' class='j_delete_action_confirm btn btn_yellow icon-warning' style='display: none;' id='{$Sess['faq_category_id']}'>Deletar Categoria?</span>
                        </div>
                    </header>";


            echo "</article>";
        endforeach;
    endif;
    ?>
</div>