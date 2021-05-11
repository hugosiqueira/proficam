<?php
$AdminLevel = LEVEL_ITV_COMPLEMENTS;
if (!APP_COMPLEMENTS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
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

$ComplementId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($ComplementId):
    $Read->ExeRead(DB_PAGE_COMPLEMENTS, "WHERE complement_id= :id", "id={$ComplementId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_COMPLEMENTS):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=complements/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um complemento que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=complements/home');
        exit;
    endif;
else:
    $CreateInterviewDefault = [
        "complement_text" => 'Novo Complemento'
    ];
    $Create->ExeCreate(DB_PAGE_COMPLEMENTS, $CreateInterviewDefault);
    header("Location: dashboard.php?wc=complements/create&id={$Create->getResult()}");
    exit;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-file-text">Novo Complemento de Página</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=complements/home">Complemento de Página</a>
            <span class="crumb">/</span>
            Novo Complemento de Página
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $ComplementId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $ComplementId; ?>'>Deletar Complemento!</span>
        <span rel='dashboard_header_search' callback='Complement' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $ComplementId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box100">
        <article class="wc_tab_target wc_active" id="profile">
            <div class="panel_header default">
                <h2 class="icon-file-text">Complemento de Página</h2>
            </div>
            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="complement_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Complement"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="complement_id" value="<?= $ComplementId; ?>"/>
                    <div class="label_50">
                        <label class="label">
                            <span class="legend">Página que terá o complemento:</span>
                            <select name="complement_name" required>
                                <option value="">Selecione a página</option>
                                <option value="corpo-discente">Corpo Discente</option>
                                <option value="egressos">Egressos</option>
                                <option value="pos-doutorandos">Pós-doutorandos</option>
                            </select>
                        </label>
                        <label class="label">
                            <span class="legend">Publicar:</span>
                            <select name="complement_status" required>
                                <option selected disabled value="">Selecione:</option>
                                <option value="1" <?= ($complement_status == 1 ? "selected" : "")?>>Sim</option>
                                <option value="0" <?= ($complement_status == 0 ? "selected" : "")?>>Não</option>
                            </select>
                        </label>
                    </div>

                    <label class="label">
                        <span class="legend">Conteúdo:</span>
                        <textarea name="complement_text" class="work_mce" ><?=$complement_text;?></textarea>
                    </label>



                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Complemento!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>
    </div>
</div>