<?php
$AdminLevel = LEVEL_ITV_FAQ;
if (!APP_FAQ || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
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

$FaqId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($FaqId):
    $queryFaq = "SELECT * FROM ".DB_FAQ. " s ";
    $queryFaq .= " LEFT JOIN " .DB_FAQ_CATEGORY. " d ON d.faq_category_id = s.faq_category";
    $queryFaq .= " WHERE  s.faq_id = :id";
    $Read->FullRead($queryFaq, "id={$FaqId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_FAQ):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=faq/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar uma pergunta que não existe ou que foi removida recentemente!";
        header('Location: dashboard.php?wc=faq/home');
        exit;
    endif;
else:
    $CreateFaqDefault = [
        "faq_category" => 2,
        "faq_question" => "Nova Pergunta",
        "faq_status" =>0,
        "faq_answer" => "Resposta"

    ];
    $Create->ExeCreate(DB_FAQ, $CreateFaqDefault);
    header("Location: dashboard.php?wc=faq/create&id={$Create->getResult()}");
    exit;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-question">Nova Pergunta</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=faq/home">Perguntas</a>
            <span class="crumb">/</span>
            Nova Pergunta
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $FaqId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $FaqId; ?>'>Deletar Pergunta!</span>
        <span rel='dashboard_header_search' callback='FAQ' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $FaqId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box100">
        <article class="wc_tab_target wc_active" id="profile">

            <div class="panel_header default">
                <h2 class="icon-question">Pergunta Frequente</h2>
            </div>

            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="faq_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="FAQ"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="faq_id" value="<?= $FaqId; ?>"/>

                    <label class="label">
                        <span class="legend">Categoria</span>
                        <select name="faq_category" required>
                            <?php
                            $Read->ExeRead(DB_FAQ_CATEGORY, "ORDER BY faq_category_name ASC");
                            foreach ($Read->getResult() as $FaqCategory):
                                extract($FaqCategory);
                            ?>
                                <option value="<?=$faq_category_id;?>" <?=($faq_category_id == $faq_category ? "selected" : "")?>><?=$faq_category_name;?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="label">
                            <span class="legend">Pergunta:</span>
                            <textarea name="faq_question" rows="3" placeholder="Pergunta" ><?=$faq_question;?></textarea>
                    </label>
                    <label class="label">
                        <span class="legend">Resposta:</span>
                        <textarea name="faq_answer" rows="3" placeholder="Resposta" ><?=$faq_answer;?></textarea>
                    </label>
                    <label class="label">
                        <span class="legend">Publicar:</span>
                        <select name="faq_status" required>
                            <option selected disabled value="">Selecione:</option>
                            <option value="1" <?= ($faq_status == 1 ? "selected" : "")?>>Sim</option>
                            <option value="0" <?= ($faq_status == 0 ? "selected" : "")?>>Não</option>
                        </select>
                    </label>

                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Pergunta!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>



    </div>


</div>