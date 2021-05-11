<?php
$AdminLevel = LEVEL_ITV_SITE_SERVICES;
if (!APP_SITE_SERVICES || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;

$ServiceId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($ServiceId):
    $Read->ExeRead(DB_SITE_SERVICES, "WHERE services_id= :id", "id={$ServiceId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_SITE_SERVICES):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=services/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um serviço que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=services/home');
        exit;
    endif;
else:
    $CreateServiceDefault = [
        "services_name" => 'Novo Serviço',

    ];
    $Create->ExeCreate(DB_SITE_SERVICES, $CreateServiceDefault);
    header("Location: dashboard.php?wc=services/create&id={$Create->getResult()}");
    exit;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-clock">Novo Serviço</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=services/home">Serviços</a>
            <span class="crumb">/</span>
            Novo Serviço
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $ServiceId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $ServiceId; ?>'>Deletar Serviço!</span>
        <span rel='dashboard_header_search' callback='Services' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $ServiceId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box100">
        <article class="wc_tab_target wc_active" id="profile">
            <div class="panel_header default">
                <h2 class="icon-clock">Serviços</h2>
            </div>
            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="service_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Services"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="services_id" value="<?= $ServiceId; ?>"/>

                    <label class="label">
                        <span class="legend">Nome:</span>
                        <input type="text"  name="services_name" value="<?= $services_name;?>" required/>
                    </label>

                    <label class="label">
                        <span class="legend">Link:</span>
                        <input type="text"  name="services_link" value="<?= $services_link;?>" required/>
                    </label>
                    <label class="label">
                        <span class="legend">Descrição:</span>
                        <textarea name="services_description"  rows="2" ><?=$services_description;?></textarea>
                    </label>
                    <label class="label">
                        <span class="legend">Código do Ícone <a target='_blank' href="<?= BASE . '/_cdn/demo.html';?>">(VEJA TODOS OS ÍCONES AQUI)</a>:</span>
                        <input type="text"  name="services_icon" value="<?= $services_icon;?>" required/>
                    </label>
                    
                    <label class="label">
                        <span class="legend">Publicar:</span>
                        <select name="services_status" required>
                            <option selected disabled value="">Selecione:</option>
                            <option value="1" <?= ($services_status == 1 ? "selected" : "")?>>Sim</option>
                            <option value="0" <?= ($services_status == 0 ? "selected" : "")?>>Não</option>
                        </select>
                    </label>

                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Serviço!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>
    </div>
</div>