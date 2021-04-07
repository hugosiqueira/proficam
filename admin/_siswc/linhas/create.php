<?php
$AdminLevel = LEVEL_ITV_RESEARCH;
if (!APP_RESEARCH || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
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

$ResearchId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($ResearchId):
    $Read->ExeRead(DB_RESEARCH, "WHERE research_id = :id", "id={$ResearchId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar uma linha de pesquisa que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=linhas/home');
    endif;
else:
    $ResearchCreate = ['research_course' => 1, 'research_status' => 0, 'research_name' => 'Nova Linha de Pesquisa'];
    $Create->ExeCreate(DB_RESEARCH, $ResearchCreate);
    header('Location: dashboard.php?wc=linhas/create&id=' . $Create->getResult());
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-new-tab"><?= $research_name ? $research_name : "Nova Linha de Pesquisa"; ?></h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=linhas/home">Linha de Pesquisa</a>
            <span class="crumb">/</span>
            Gerenciar Linha de Pesquisa
        </p>
    </div>

    <div class="dashboard_header_search">
        <a target="_blank" title="Ver no site" href="<?= BASE; ?>/linhas-de-pesquisa/<?= $research_link; ?>" class="wc_view btn btn_green icon-eye">Ver linha de pesquisa no site!</a>
    </div>
</header>

<div class="workcontrol_imageupload none" id="post_control">
    <div class="workcontrol_imageupload_content">
        <form name="workcontrol_post_upload" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="callback" value="Research"/>
            <input type="hidden" name="callback_action" value="sendimage"/>
            <input type="hidden" name="research_id" value="<?= $ResearchId; ?>"/>
            <div class="upload_progress none" style="padding: 5px; background: #00B594; color: #fff; width: 0%; text-align: center; max-width: 100%;">0%</div>
            <div style="overflow: auto; max-height: 300px;">
                <img class="image image_default" alt="Nova Imagem" title="Nova Imagem" src="../tim.php?src=admin/_img/no_image.jpg&w=<?= IMAGE_W; ?>&h=<?= IMAGE_H; ?>" default="../tim.php?src=admin/_img/no_image.jpg&w=<?= IMAGE_W; ?>&h=<?= IMAGE_H; ?>"/>
            </div>
            <div class="workcontrol_imageupload_actions">
                <input class="wc_loadimage" type="file" name="image" required/>
                <span class="workcontrol_imageupload_close icon-cancel-circle btn btn_red" id="post_control" style="margin-right: 8px;">Fechar</span>
                <button class="btn btn_green icon-image">Enviar e Inserir!</button>
                <img class="form_load none" style="margin-left: 10px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<div class="dashboard_content">

    <form class="auto_save" name="research_create" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="Research"/>
        <input type="hidden" name="callback_action" value="manager"/>
        <input type="hidden" name="research_id" value="<?= $ResearchId; ?>"/>

        <div class="box box70">
            <div class="panel_header default">
                <h2 class="icon-blog">Dados sobre a Linha de Pesquisa</h2>
            </div>
            <div class="panel">
                <label class="label">
                    <span class="legend">Título:</span>
                    <input style="font-size: 1.4em;" type="text" name="research_name" value="<?= $research_name; ?>" required/>
                </label>



                    <label class="label">
                        <span class="legend">Link Alternativo (Opcional):</span>
                        <input type="text" name="research_link" value="<?= $research_link; ?>" placeholder="Link da linha de pesquisa:"/>
                    </label>


                <label class="label">
                    <span class="legend">Imagem: (JPG 250 x 250px)</span>
                    <input type="file" class="wc_loadimage" name="research_img"/>
                </label>


                <label class="label">
                    <span class="legend">Descrição:</span>
                    <textarea class="work_mce" rows="50" name="research_description"><?= $research_description; ?></textarea>
                </label>
            </div>
        </div>

        <div class="box box30">

            <div class="post_create_cover">
                <div class="upload_progress none">0%</div>
                <?php
                $ResearchCover = (!empty($research_img) && file_exists("../uploads/linhas_pesquisa/{$research_img}") && !is_dir("../uploads/linhas_pesquisa/{$research_img}") ? "uploads/linhas_pesquisa/{$research_img}" : 'admin/_img/no_image.jpg');
                ?>
                <img class="post_thumb post_cover" alt="Capa" title="Capa" src="../tim.php?src=<?= $ResearchCover; ?>&w=<?= IMAGE_W; ?>&h=<?= IMAGE_H; ?>" default="../tim.php?src=<?= $ResearchCover; ?>&w=<?= IMAGE_W; ?>&h=<?= IMAGE_H; ?>"/>
            </div>


            <div class="panel_header default">
                <h2>Publicar:</h2>
            </div>

            <div class="panel">

                <div class="m_top">&nbsp;</div>
                <div class="wc_actions" style="text-align: center">
                    <label class="label_check label_publish <?= ($research_status == 1 ? 'active' : ''); ?>"><input style="margin-top: -1px;" type="checkbox" value="1" name="research_status" <?= ($research_status == 1 ? 'checked' : ''); ?>> Publicar Agora!</label>
                    <button name="public" value="1" class="btn btn_green icon-share">ATUALIZAR</button>
                    <img class="form_load none" style="margin-left: 10px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                </div>
                <div class="clear"></div>

            </div>
        </div>
    </form>
</div>