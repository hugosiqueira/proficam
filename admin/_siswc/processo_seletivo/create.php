<?php
$AdminLevel = LEVEL_ITV_SELECTION_PROCESS;
if (!APP_SELECTION_PROCESS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
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

$SelectionId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($SelectionId):
    $querySelection = "SELECT * FROM ".DB_SELECTION_PROCESS;
    $querySelection .= " WHERE  selection_process_id = :id";
    $Read->FullRead($querySelection, "id={$SelectionId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_SELECTION_PROCESS):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=processo_seletivo/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar uma pergunta que não existe ou que foi removida recentemente!";
        header('Location: dashboard.php?wc=processo_seletivo/home');
        exit;
    endif;
else:
    $CreateSelectionDefault = [
        "selection_process_type" => "Novo Processo Seletivo",
        "selection_process_year" => date('Y'),
        "selection_process_status" =>0

    ];
    $Create->ExeCreate(DB_SELECTION_PROCESS, $CreateSelectionDefault);
    header("Location: dashboard.php?wc=processo_seletivo/create&id={$Create->getResult()}");
    exit;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-pencil">Novo Processo Seletivo</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=processo_seletivo/home">Processo Seletivo</a>
            <span class="crumb">/</span>

        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $SelectionId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $SelectionId; ?>'>Deletar Processo!</span>
        <span rel='dashboard_header_search' callback='SELECTION_PROCESS' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $SelectionId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box30">
        <article class="wc_tab_target wc_active" id="profile">

            <div class="panel_header default">
                <h2 class="icon-question">Processo Seletivo</h2>
            </div>

            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="selection_process_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Selection"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="selection_process_id" value="<?= $SelectionId; ?>"/>
                    <label class="label">
                        <span class="legend">Nome</span>
                        <input type="text" name="selection_process_type" value="<?=$selection_process_type;?>" placeholder="Escolha o nome de divulgação" required>
                    </label>

                    <label class="label">
                        <span class="legend">Nº do Processo (Nº/Ano)</span>
                        <input type="text" name="selection_process_year" value="<?=$selection_process_year;?>" placeholder="Qual o ano que ocorrerá o processo seletivo" required />
                    </label>

                    <label class="label">
                        <span class="legend">Número de Vagas</span>
                        <input type="number" name="selection_process_vacancies" value="<?=$selection_process_vacancies;?>" placeholder="Nº de vagas oferecidas" required />
                    </label>

                    <label class="label">
                        <span class="legend">Situação:</span>
                        <select name="selection_process_status" required>
                            <option selected disabled value="">Selecione a situação do processo:</option>
                            <option value="0" <?= ($selection_process_status == 0 ? "selected" : "")?>>Em Planejamento</option>
                            <option value="1" <?= ($selection_process_status == 1 ? "selected" : "")?>>Em Andamento</option>
                            <option value="2" <?= ($selection_process_status == 2 ? "selected" : "")?>>Encerrado</option>
                        </select>
                    </label>

                    <label class="label">
                        <span class="legend">Observação</span>
                        <textarea name="selection_process_obs" rows="3" ><?=$selection_process_obs?></textarea>
                    </label>

                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Processo!</button>

                    <div class="clear"></div>
                </form>
            </div>
        </article>



    </div>
    <div class="box box70">
        <article class="wc_tab_target wc_active" id="profile">
            <div class="panel_header default">
                <h2 class="icon-file-pdf">Documentos</h2>
            </div>
            <div class="panel">
                <table class="styled-table">
                    <thead>
                    <th width="87%">Descrição</th>
                    <th width="10%">Publicação</th>
                    <th width="1%"></th>
                    <th width="1%"></th>
                    <th width="1%"></th>
                    </thead>
                    <tbody>
                    <?php
                    $queryFiles = "SELECT * FROM ". DB_SELECTION_PROCESS_FILES. " p";
                    $queryFiles .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.sp_files_selection_process = s.selection_process_id";
                    $queryFiles .= " WHERE s.selection_process_id = :id  ORDER BY sp_files_publish DESC";
                    $Read->FullRead($queryFiles, "id={$SelectionId}");
                    if ($Read->getResult()):
                        foreach ($Read->getResult() as $Files):
                            extract($Files);
                            ?>

                            <tr>
                                <td><?=$sp_files_name;?></td>
                                <td><?=($sp_files_publish ? date('d/m/Y', strtotime($sp_files_publish)) : "") ;?></td>
                                <td><a target="_blank" href="<?= BASE.'/uploads/'.$sp_files_link;?>"><span class="icon-file-pdf"></span></a></td>
                                <td><span callback='Selection' callback_action='window_edit_files' data-id='<?=$sp_files_id;?>' class="j_ajaxModal btn btn_blue"> Editar</span></td>
                                <td><span callback='Selection' callback_action='window_delete_files' data-id='<?=$sp_files_id;?>'  class="j_ajaxModal btn btn_red"> Excluir</span></td>
                            </tr>
                        <?php endforeach;
                    endif;
                    ?>
                    </tbody>
                </table>
                <div class="panel_footer">
                    <span callback='Selection' callback_action='modal_files' data-id='<?=$SelectionId;?>' class='j_ajaxModal btn btn_green icon-file-pdf'>Adicionar Documento</span>
                </div>
            </div>
        </article>
    </div>
    <div class="box box100">
        <article class="wc_tab_target wc_active" id="profile">
            <div class="panel_header default">
                <h2 class="icon-calendar">Cronograma</h2>
            </div>
            <div class="panel">
                <div style="overflow-x:auto;">
                    <table class="styled-table">
                        <thead>
                        <tr>
                            <th>Programação</th>
                            <th>Data</th>
                            <th>Local</th>
                            <th width="1%"></th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $querySelectionSchedule = "SELECT * FROM ". DB_SELECTION_PROCESS_SCHEDULE. " p";
                        $querySelectionSchedule .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.schedule_selection_process = s.selection_process_id";
                        $querySelectionSchedule .= " WHERE s.selection_process_id = :id  ORDER BY schedule_initial_date";
                        $Read->FullRead($querySelectionSchedule, "id={$SelectionId}");
                        if ($Read->getResult()):
                            foreach ($Read->getResult() as $Schedule):
                                extract($Schedule);
                                ?>

                                <tr>
                                    <td><?=$schedule_name;?></td>
                                    <td><?=($schedule_initial_date ? date('d/m/Y', strtotime($schedule_initial_date)) : "") . ($schedule_final_date&& $schedule_final_date !='0000-00-00 00:00:00' ? " a " . date('d/m/Y', strtotime($schedule_final_date)) : "");?></td>
                                    <td><?=$schedule_local;?></td>
                                    <td><span callback='Selection' callback_action='window_edit_schedule' data-id='<?=$schedule_id;?>' class="j_ajaxModal btn btn_blue"> Editar</span></td>
                                    <td><span callback='Selection' callback_action='window_delete_schedule' data-id='<?=$schedule_id;?>'  class="j_ajaxModal btn btn_red"> Excluir</span></td>
                                </tr>
                            <?php endforeach;
                        endif;
                        ?>
                        </tbody>
                    </table>
                    <div class="panel_footer">
                    <span callback='Selection' callback_action='modal_schedule' data-id='<?=$SelectionId;?>' class='j_ajaxModal btn btn_green icon-calendar'>Adicionar Programação</a>
                    </div>
                </div>

            </div>
        </article>
    </div>




</div>