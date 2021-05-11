<?php
$AdminLevel = LEVEL_ITV_PROJECTS;
if (!APP_PROJECTS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
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

$ProjectId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($ProjectId):
    $Read->ExeRead(DB_PROJECTS, "WHERE project_id= :id", "id={$ProjectId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_PROJECTS):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=projetos/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um projeto que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=projetos/home');
        exit;
    endif;
else:
    $CreateInterviewDefault = [
        "project_title" => 'Novo Projeto',

    ];
    $Create->ExeCreate(DB_PROJECTS, $CreateInterviewDefault);
    header("Location: dashboard.php?wc=projetos/create&id={$Create->getResult()}");
    exit;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-file-text">Novo Projeto</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=projetos/home">Projetos de Pesquisa</a>
            <span class="crumb">/</span>
            Novo Projeto
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $ProjectId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $ProjectId; ?>'>Deletar Projeto!</span>
        <span rel='dashboard_header_search' callback='Project' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $ProjectId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box100">
        <article class="wc_tab_target wc_active" id="profile">
            <div class="panel_header default">
                <h2 class="icon-file-text">Projeto de Pesquisa</h2>
            </div>
            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="project_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Project"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="project_id" value="<?= $ProjectId; ?>"/>

                    <label class="label">
                        <span class="legend">Título do Projeto:</span>
                        <input type="text"  name="project_title" value="<?= $project_title;?>" required/>
                    </label>

                    <!--label class="label">
                        <span class="legend">Linha de Pesquisa:</span>
                        <input type="text"  name="project_research_line" value="<?= $project_research_line;?>" required/>
                    </label-->

                    <label class="label">
                        <span class="legend">Linha de Pesquisa:</span>

                        <select multiple="multiple" name="project_research_line[]" required>
                            <?php
                            $Read->ExeRead(DB_RESEARCH, " WHERE research_status = :status", "status=1");
                            foreach ($Read->getResult() as $research):
                            echo '<option value="' . $research['research_name'] . '">'. $research['research_name'] . '</option>';
                                endforeach;
                                ?>
                        </select>
                        <textarea rows="2" disabled><?=$project_research_line;?></textarea>
                    </label>
                    <label class="label">
                        <span class="legend">Membros:</span>
                        <textarea name="project_members"  rows="2" ><?=$project_members;?></textarea>
                    </label>
                    <label class="label">
                        <span class="legend">Financiadores:</span>
                        <textarea name="project_financiers"  rows="2" ><?=$project_financiers;?></textarea>
                    </label>
                    <label class="label">
                        <span class="legend">Descrição:</span>
                        <textarea name="project_description" class="work_mce_basic" rows="3" ><?=$project_description;?></textarea>
                    </label>

                    <label class="label">
                        <span class="legend">Publicar:</span>
                        <select name="project_status" required>
                            <option selected disabled value="">Selecione:</option>
                            <option value="1" <?= ($project_status == 1 ? "selected" : "")?>>Sim</option>
                            <option value="0" <?= ($project_status == 0 ? "selected" : "")?>>Não</option>
                        </select>
                    </label>

                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Projeto!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>
    </div>
</div>