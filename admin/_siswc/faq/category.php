<?php
$AdminLevel = LEVEL_ITV_FAQ;
if (!APP_FAQ || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT CREATE
if (empty($Create)):
    $Create = new Create;
endif;

$CatId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($CatId):
    $Read->ExeRead(DB_FAQ_CATEGORY, "WHERE faq_category_id = :id", "id={$CatId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = Erro("<b>OPPSS {$Admin['user_name']}</b>, você tentou editar uma categoria que não existe ou que foi removida recentemente!", E_USER_NOTICE);
        header('Location: dashboard.php?wc=faq/categories');
        exit;
    endif;
else:
    $Title = "Nova Categoria";
    $Name = Check::Name($Title);
    $FaqCreate = ['faq_category_name' => $Name, 'faq_category_status' => 1];
    $Create->ExeCreate(DB_FAQ_CATEGORY, $FaqCreate);
    header('Location: dashboard.php?wc=faq/category&id=' . $Create->getResult());
    exit;
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-price-tags"><?= $faq_category_name ? $faq_category_name : 'Nova Categoria'; ?></h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=faq/home">Perguntas</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=faq/categories">Categorias</a>
            <span class="crumb">/</span>
            Gerenciar Categoria
        </p>
    </div>

    <div class="dashboard_header_search">
        <a title="Ver Categorias!" href="dashboard.php?wc=faq/categories" class="btn btn_blue icon-eye">Ver Categorias!</a>
        <a title="Nova Categoria" href="dashboard.php?wc=faq/category" class="btn btn_green icon-plus">Adicionar Categoria!</a>
    </div>
</header>

<div class="dashboard_content">
    
    <div class="box box100">
        <div class="panel_header default">
            <h2 class="icon-price-tags">Dados da Categoria</h2>
        </div>
        <div class="panel">
            
            <form class="auto_save" name="category_add" action="" method="post" enctype="multipart/form-data">
                <div class="callback_return"></div>
                <input type="hidden" name="callback" value="FAQ"/>
                <input type="hidden" name="callback_action" value="category_add"/>
                <input type="hidden" name="faq_category_id" value="<?= $CatId; ?>"/>
                
                <label class="label">
                    <span class="legend">Nome:</span>
                    <input style="font-size: 1.5em;" type="text" name="faq_category_name" value="<?= $faq_category_name; ?>" placeholder="Título da Categoria:" required/>
                </label>


                <div class="m_top">&nbsp;</div>
                <img class="form_load fl_right none" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                <button class="btn btn_green icon-price-tags fl_right">Atualizar Categoria!</button>
                <div class="clear"></div>
            </form>
        </div>
    </div>
</div>