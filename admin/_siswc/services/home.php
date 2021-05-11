<?php
$AdminLevel = LEVEL_ITV_SITE_SERVICES;
if (!APP_SITE_SERVICES || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE USER TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_SITE_SERVICES, "WHERE services_status = :status AND services_name = :name", "status=0&name=Novo Serviço");
endif;
// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

?>
    <link rel="stylesheet" href="<?=BASE. "/_cdn/fonts/flaticon/font/flaticon.css";?>" class="href">
    <header class="dashboard_header">
        <div class="dashboard_header_title">
            <h1 class="icon-sett">Serviços</h1>
            <p class="dashboard_header_breadcrumbs">
                &raquo; <?= ADMIN_NAME; ?>
                <span class="crumb">/</span>
                <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
                <span class="crumb">/</span>
                Serviços
            </p>
        </div>
        <div class="dashboard_header_search">
            <a class='btn btn_green icon-plus' href='dashboard.php?wc=services/create' title='Novo Serviço!'>Novo Serviço</a>
        </div>
    </header>

    <div class="dashboard_content">
        <?php
        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $Page = ($getPage ? $getPage : 1);
        $Pager = new Pager("dashboard.php?wc=services/home&page=", "<<", ">>", 5);
        $Pager->ExePager($Page, 12);
        $Read->FullRead("SELECT * FROM ". DB_SITE_SERVICES." ORDER BY services_order ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if (!$Read->getResult()):
            $Pager->ReturnPage();
            echo Erro("<span class='al_center icon-notification'>Ainda não existem serviços cadastrados {$Admin['user_name']}. Comece agora mesmo cadastrando um novo serviço!</span>", E_USER_NOTICE);
        else:
            foreach ($Read->getResult() as $Services):
                extract($Services);
                $services_name = ($services_name ? $services_name : 'Novo Serviço');

                echo "<article class='single_user box box25 al_center'>
                    <div class='box_content wc_normalize_height'>
                        <span style='font-size: 48px' class='{$services_icon}'></span>
                        <h1>{$services_name}</h1>
                        <br/>
                        <p>{$services_description}</p>
                        
                    </div>
                    <div class='single_user_actions'>
                        <a class='btn btn_green icon-pencil' href='dashboard.php?wc=services/create&id={$services_id}' title='Gerenciar Serviço!'>Editar Serviço</a>
                    </div>
                </article>";
            endforeach;
            $Pager->ExePaginator(DB_SITE_SERVICES );
            echo $Pager->getPaginator();
        endif;
        ?>
    </div>
<?php
