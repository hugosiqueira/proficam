<?php
session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_SELECTION_PROCESS;

if ((!APP_SELECTION_PROCESS) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

//usleep(5000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;;
$CallBack = 'Selection';
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//VALIDA AÇÃO
if ($PostData && $PostData['callback_action'] && $PostData['callback'] == $CallBack):
    //PREPARA OS DADOS
    $Case = $PostData['callback_action'];
    unset($PostData['callback'], $PostData['callback_action']);

    // AUTO INSTANCE OBJECT READ
    if (empty($Read)):
        $Read = new Read;
    endif;

    // AUTO INSTANCE OBJECT CREATE
    if (empty($Create)):
        $Create = new Create;
    endif;

    // AUTO INSTANCE OBJECT UPDATE
    if (empty($Update)):
        $Update = new Update;
    endif;

    // AUTO INSTANCE OBJECT DELETE
    if (empty($Delete)):
        $Delete = new Delete;
    endif;

    //SELECIONA AÇÃO
    switch ($Case):

        case 'modal_files':
            $SelectionId = $PostData['id'];
            $Content = ''
                . '<form name="files_manager" action="" autocomplete="off" method="post" enctype="multipart/form-data">'
                . '<input type="hidden" name="callback" value="Selection"/>'
                . '<input type="hidden" name="callback_action" value="files_manager"/>'
                . '<input type="hidden" name="sp_files_selection_process" value="'.$SelectionId.'"/>'

                . '<label>'
                . '<span class="legend">Nome do Arquivo</span>'
                . "<input name='sp_files_name' type='text' required/>"
                . '</label>'

                . '<label>'
                . '<span class="legend">Arquivo</span>'
                . '<input name="sp_files_link" accept="application/pdf" type="file" required/>'
                . '</label>'


                . '<label>'
                . '<span class="legend">Data da Publicação</span>'
                . '<input name="sp_files_publish" type="date" required>'
                . '</label>'
                . '<label>'
                . '<span class="legend">Situação</span>'
                . "<select name='sp_files_status' required><option value=1>Atual</option><option value=2>Retificado</option></select>"
                . '</label>'


                // ESSA IMAGEM É O LOAD QUE APARECERÁ NO FOOTER
                . "<img class='form_load none' load='true' style='margin-left:10px;' alt='Enviando Requisição!' title='Enviando Requisição!' src='./_img/load.gif'/>"
                . '</form>';
            $jSON['modal'] = [
                //'size' => 'medium',               // Tamanho da modal [medium / large] - o tamanho pequeno é nativo
                'icon' => 'file-pdf',                // Ícone que deseja usar
                'title' => 'Adicionar Documento', // Título que deseja exibir no topo
                'content' => $Content,           // $Content é a string com o conteúdo. Você deve criar!
                'footer' => "<a class='fl_left j_ajaxModalClose btn btn_red icon-cross'>Cancelar</a><div class='fl_right'><a class='btn btn_green btn-rounded j_sendFormModal  icon-floppy-disk'>Salvar</a></div>"
            ];
            break;

        case 'window_edit_files':
            $FileId = $PostData['id'];
            $Read->ExeRead(DB_SELECTION_PROCESS_FILES, "WHERE sp_files_id = :id", "id=".$FileId);
            extract($Read->getResult()[0]);
            $date_publish =  date("Y-m-d", strtotime($sp_files_publish));
            $Content = ''
                . '<form name="files_manager" action="" autocomplete="off" method="post" enctype="multipart/form-data">'
                . '<input type="hidden" name="callback" value="Selection"/>'
                . '<input type="hidden" name="callback_action" value="files_manager"/>'
                . '<input type="hidden" name="sp_files_id" value="'.$FileId.'"/>'
                . '<input type="hidden" name="sp_files_selection_process" value="'.$sp_files_selection_process.'"/>'

                . '<label>'
                . '<span class="legend">Nome do Arquivo</span>'
                . "<input name='sp_files_name' type='text' value='" . $sp_files_name . "' required/>"
                . '</label>'

                . '<label>'
                . '<span class="legend">Arquivo</span>'
                . '<input name="sp_files_link" accept="application/pdf" type="file" required/>'
                . '</label>'


                . '<label>'
                . '<span class="legend">Data da Publicação</span>'
                . '<input name="sp_files_publish"  type="date" value="'.$date_publish.'" required>'
                . '</label>'
                . '<label>'
                . '<span class="legend">Situação</span>'
                . '<select name="sp_files_status" required><option '.($sp_files_status == 1 ? "selected=selected" : "").' value=1>Atual</option><option '.($sp_files_status == 2 ? "selected=selected" : "").' value=2>Retificado</option></select>'
                . '</label>'


                // ESSA IMAGEM É O LOAD QUE APARECERÁ NO FOOTER
                . "<img class='form_load none' load='true' style='margin-left:10px;' alt='Enviando Requisição!' title='Enviando Requisição!' src='./_img/load.gif'/>"
                . '</form>';
            $jSON['modal'] = [
                //'size' => 'medium',               // Tamanho da modal [medium / large] - o tamanho pequeno é nativo
                'icon' => 'file-pdf',                // Ícone que deseja usar
                'title' => 'Atualizar Documento', // Título que deseja exibir no topo
                'content' => $Content,           // $Content é a string com o conteúdo. Você deve criar!
                'footer' => "<a class='fl_left j_ajaxModalClose btn btn_red icon-cross'>Cancelar</a><div class='fl_right'><a class='btn btn_green btn-rounded j_sendFormModal  icon-floppy-disk'>Atualizar</a></div>"
            ];
            break;

        case 'files_manager':
            $SelectionId = $PostData['sp_files_selection_process'];
            $SelectionPublish = $PostData['sp_files_publish'];
            $SelectionStatus = $PostData['sp_files_status'];
            $FileName = $PostData['sp_files_name'];

            if(empty($SelectionId) || empty($SelectionPublish) || empty ($SelectionStatus) || empty($FileName)):
                $jSON['trigger'] = AjaxErro("<span class='icon-warning'></span> Preencha todos os campos!", E_USER_ERROR);
                echo json_encode($jSON);
                return;
                endif;

            $Read->FullRead("SELECT * FROM " . DB_SELECTION_PROCESS_FILES . " LEFT JOIN " . DB_SELECTION_PROCESS . " ON sp_files_selection_process = selection_process_id WHERE sp_files_selection_process = :id AND sp_files_name = :name", "id={$SelectionId}&name={$FileName}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<span class='icon-warning'></span> Um arquivo com o mesmo nome nesse processo já está cadastrado! Remova-o, ou altere o nome para nova inserção!", E_USER_WARNING);
                echo json_encode($jSON);
                return;
            endif;

            $Read->FullRead("SELECT selection_process_year FROM "  . DB_SELECTION_PROCESS . "  WHERE selection_process_id = :id", "id={$SelectionId}");
            if ($Read->getResult()):
                extract($Read->getResult()[0]);
            endif;

            if (!empty($_FILES['sp_files_link'])):
                $File = $_FILES['sp_files_link'];
                $Upload = new Upload('../../uploads/');
                $Upload->File($File, Check::Name($FileName . '-' . $selection_process_year));
                if ($Upload->getResult()):
                    $PostData['sp_files_link'] = $Upload->getResult();
                else:
                    $jSON['trigger'] = AjaxErro("<b class='icon-file-pdf'>ERRO AO ENVIAR ARQUIVO:</b> Olá {$_SESSION['userLogin']['user_name']}, selecione um arquivo PDF!", E_USER_WARNING);
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['sp_files_link']);
            endif;
            if(empty($PostData['sp_files_id'])):
                if(empty($_FILES['sp_files_link'])):
                    $jSON['trigger'] = AjaxErro("<span class='icon-warning'></span> A inserção do arquivo PDF é obrigatória!", E_USER_ERROR);
                    echo json_encode($jSON);
                    return;
                    endif;

                $Create->ExeCreate(DB_SELECTION_PROCESS_FILES, $PostData);
            else:
                $FileId = $PostData['sp_files_id'];
                $Update->ExeUpdate(DB_SELECTION_PROCESS_FILES, $PostData,  "WHERE sp_files_id = :id", "id={$FileId}");
               endif;
            $jSON['redirect'] = "dashboard.php?wc=processo_seletivo/create&id={$SelectionId}";
            $jSON['trigger'] = AjaxErro("TUDO CERTO {$_SESSION['userLogin']['user_name']}, Documento adicionado com sucesso!");
            break;
            
        case 'window_delete_files':
            $FileId = $PostData['id'];
            $Read->ExeRead(DB_SELECTION_PROCESS_FILES, "WHERE sp_files_id = :id", "id=".$FileId);
            extract($Read->getResult()[0]);
            $Content = ''
                . '<form name="test" action="" autocomplete="off" method="post" enctype="multipart/form-data">'
                . '<input type="hidden" name="callback" value="Selection"/>'
                . '<input type="hidden" name="callback_action" value="delete_files"/>'
                . '<input type="hidden" name="sp_files_id" value='.$PostData["id"].'/>'
                . '<p class="font_normal al_center">'.$sp_files_name.'</p>'

                // ESSA IMAGEM É O LOAD QUE APARECERÁ NO FOOTER
                . "<img class='form_load none' load='true' style='margin-left:10px;' alt='Enviando Requisição!' title='Enviando Requisição!' src='./_img/load.gif'/>"
                . '</form>';
            $jSON['modal'] = [
               // 'size' => 'large',               // Tamanho da modal [medium / large] - o tamanho pequeno é nativo
                'icon' => 'file-pdf',                // Ícone que deseja usar
                'title' => 'Você tem certeze que deseja deletar o arquivo?', // Título que deseja exibir no topo
                'content' => $Content,           // $Content é a string com o conteúdo. Você deve criar!
                'footer' => "<a class='fl_left btn btn_red j_ajaxModalClose'>Cancelar</a><div class='fl_right'><a class='btn btn_green btn-rounded j_sendFormModal icon-cross'>Deletar Arquivo</a></div>"
            ];
            break;

        case 'delete_files':
            $FileId = $PostData['sp_files_id'];
            $Read->ExeRead(DB_SELECTION_PROCESS_FILES, "WHERE sp_files_id = :id", "id=".$FileId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>ARQUIVO NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um arquivo que não existe ou já foi removido!", E_USER_WARNING);
            else:
                extract($Read->getResult()[0]);
                if ($Read->getResult() && file_exists("../../uploads/{$sp_files_link}") && !is_dir("../../uploads/{$sp_files_link}")):
                    unlink("../../uploads/{$sp_files_link}");
                endif;
                $Delete->ExeDelete(DB_SELECTION_PROCESS_FILES, "WHERE sp_files_id = :id", "id=".$FileId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>ARQUIVO REMOVIDO COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=processo_seletivo/create&id={$sp_files_selection_process}";
            endif;
            break;

        case 'modal_schedule':
            $SelectionId = $PostData['id'];
            $Content = ''
                . '<form name="schedule_form" action="" class="j_tab_home tab_create" autocomplete="off" method="post" enctype="multipart/form-data">'
                . '<input type="hidden" name="callback_action" value="schedule_manager"/>'
                . '<input type="hidden" name="callback" value="Selection"/>'
                . '<input type="hidden" name="schedule_selection_process" value="'.$SelectionId.'"/>'
                . '<div class="label_50">'
                . '<label class="label">'
                . '<span class="legend">Programação</span>'
                . '<input type="text" name="schedule_name" />'
                . '</label>'
                . '<label class="label">'
                . '<span class="legend">Data Inicial da Programação</span>'
                . '<input type="date" name="schedule_initial_date" />'
                . '</label>'
                . '<label class="label">'
                . '<span class="legend">Data Final da Programação</span>'
                . '<input type="date"  name="schedule_final_date" />'
                . '</label>'
                . '<label class="label">'
                . '<span class="legend">Local</span>'
                . '<input type="text" name="schedule_local" />'
                . '</label>'
                . '</div>'
                . '<div class="clear"></div>'

                // ESSA IMAGEM É O LOAD QUE APARECERÁ NO FOOTER
                . "<img class='form_load none' load='true' style='margin-left:10px;' alt='Enviando Requisição!' title='Enviando Requisição!' src='./_img/load.gif'/>"
                . '</form>';
            $jSON['modal'] = [
                'size' => 'medium',               // Tamanho da modal [medium / large] - o tamanho pequeno é nativo
                'icon' => 'calendar',                // Ícone que deseja usar
                'title' => 'Adicionar Programação', // Título que deseja exibir no topo
                'content' => $Content,           // $Content é a string com o conteúdo. Você deve criar!
                'footer' => "<a class='fl_left j_ajaxModalClose btn btn_red icon-cross'>Cancelar</a><div class='fl_right'><a class='btn btn_green btn-rounded j_sendFormModal icon-floppy-disk'>Salvar</a></div>"
            ];
            break;

        case 'window_edit_schedule':
            $ScheduleId = $PostData['id'];
            $Read->ExeRead(DB_SELECTION_PROCESS_SCHEDULE, "WHERE schedule_id = :id", "id=".$ScheduleId);
            extract($Read->getResult()[0]);
            $schedule_initial_date = date("Y-m-d", strtotime($schedule_initial_date));
            ($schedule_final_date == '0000-00-00 00:00:00' || !$schedule_final_date ? $schedule_final_date = "" : $schedule_final_date = "value='".date("Y-m-d", strtotime($schedule_final_date))."'" );
            //$schedule_final_date = new DateTime($schedule_final_date);
            //$schedule_final_date = $schedule_final_date->format('Y-m-d');
            $Content = ''
                . '<form name="schedule_form" action="" class="j_tab_home tab_create" autocomplete="off" method="post" enctype="multipart/form-data">'
                . '<input type="hidden" name="callback_action" value="schedule_manager"/>'
                . '<input type="hidden" name="callback" value="Selection"/>'
                . '<input type="hidden" name="schedule_selection_process" value="'.$schedule_selection_process.'"/>'
                . '<input type="hidden" name="schedule_id" value="'.$ScheduleId.'"/>'
                . '<div class="label_50">'
                . '<label class="label">'
                . '<span class="legend">Programação</span>'
                . "<input type='text' name='schedule_name' value='{$schedule_name}' />"
                . '</label>'
                . '<label class="label">'
                . '<span class="legend">Data Inicial da Programação</span>'
                . "<input type='date' name='schedule_initial_date' value='{$schedule_initial_date}' />"

                . '</label>'
                . '<label class="label">'
                . '<span class="legend">Data Final da Programação</span>'
                . "<input type='date' name='schedule_final_date' $schedule_final_date />"
                . '</label>'
                . '<label class="label">'
                . '<span class="legend">Local</span>'
                . "<input type='text' name='schedule_local' value='{$schedule_local}' />"
                . '</label>'
                . '</div>'
                . '<div class="clear"></div>'


                // ESSA IMAGEM É O LOAD QUE APARECERÁ NO FOOTER
                . "<img class='form_load none' load='true' style='margin-left:10px;' alt='Enviando Requisição!' title='Enviando Requisição!' src='./_img/load.gif'/>"
                . '</form>';
            $jSON['modal'] = [
                'size' => 'medium',               // Tamanho da modal [medium / large] - o tamanho pequeno é nativo
                'icon' => 'calendar',                // Ícone que deseja usar
                'title' => 'Atualizar Programação', // Título que deseja exibir no topo
                'content' => $Content,           // $Content é a string com o conteúdo. Você deve criar!
                'footer' => "<a class='fl_left j_ajaxModalClose btn btn_red icon-cross'>Cancelar</a><div class='fl_right'><a class='btn btn_green btn-rounded j_sendFormModal icon-floppy-disk'>Atualizar</a></div>"
            ];
            break;

        case 'window_delete_schedule':
            $ScheduleId = $PostData['id'];
            $Read->ExeRead(DB_SELECTION_PROCESS_SCHEDULE, "WHERE schedule_id = :id", "id=".$ScheduleId);
            extract($Read->getResult()[0]);
            $Content = ''
                . '<form name="schedule_delete" action="" autocomplete="off" method="post" enctype="multipart/form-data">'
                . '<input type="hidden" name="callback" value="Selection"/>'
                . '<input type="hidden" name="callback_action" value="delete_schedule"/>'
                . '<input type="hidden" name="schedule_id" value='.$ScheduleId.'/>'
                . '<p class="font_normal al_center">'.$schedule_name.'</p>'

                // ESSA IMAGEM É O LOAD QUE APARECERÁ NO FOOTER
                . "<img class='form_load none' load='true' style='margin-left:10px;' alt='Enviando Requisição!' title='Enviando Requisição!' src='./_img/load.gif'/>"
                . '</form>';
            $jSON['modal'] = [
                // 'size' => 'large',               // Tamanho da modal [medium / large] - o tamanho pequeno é nativo
                'icon' => 'file-calendar',                // Ícone que deseja usar
                'title' => 'Você tem certeze que deseja deletar a programação?', // Título que deseja exibir no topo
                'content' => $Content,           // $Content é a string com o conteúdo. Você deve criar!
                'footer' => "<a class='fl_left btn btn_red j_ajaxModalClose'>Cancelar</a><div class='fl_right'><a class='btn btn_green btn-rounded j_sendFormModal icon-cross'>Deletar Programação</a></div>"
            ];
            break;

        case 'schedule_manager':
            $SelectionId = $PostData['schedule_selection_process'];
            $ScheduleName = $PostData['schedule_name'];
            $ScheduleInitialDate = $PostData['schedule_initial_date'];
            if(empty($ScheduleName) || empty($ScheduleInitialDate) ):
                $jSON['trigger'] = AjaxErro("<span class='icon-warning'></span> Os campos de programação e data inicial são obrigatórios!", E_USER_ERROR);
                echo json_encode($jSON);
                return;
            endif;

            if(empty($PostData['schedule_id'])):
               $Create->ExeCreate(DB_SELECTION_PROCESS_SCHEDULE, $PostData);
            else:
                $ScheduleId = $PostData['schedule_id'];
                $Update->ExeUpdate(DB_SELECTION_PROCESS_SCHEDULE, $PostData,  "WHERE schedule_id = :id", "id={$ScheduleId}");
            endif;
            $jSON['redirect'] = "dashboard.php?wc=processo_seletivo/create&id={$SelectionId}";
            $jSON['trigger'] = AjaxErro("TUDO CERTO {$_SESSION['userLogin']['user_name']}, Documento adicionado com sucesso!");
            break;

        case 'delete_schedule':
            $ScheduleId = $PostData['schedule_id'];
            $Read->ExeRead(DB_SELECTION_PROCESS_SCHEDULE, "WHERE schedule_id = :id", "id=".$ScheduleId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>A APROGRAMAÇÃO NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar uma programação que não existe ou já foi removida!", E_USER_WARNING);
            else:
                extract($Read->getResult()[0]);
                $Delete->ExeDelete(DB_SELECTION_PROCESS_SCHEDULE, "WHERE schedule_id = :id", "id=".$ScheduleId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>PROGRAMAÇÃO REMOVIDA COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=processo_seletivo/create&id={$schedule_selection_process}";
            endif;
            break;

        case 'manager':
            $SelectionId = $PostData['selection_process_id'];
            $SelectionType = $PostData['selection_process_type'];
            $SelectionYear = $PostData['selection_process_year'];
            
            $Read->ExeRead( DB_SELECTION_PROCESS ,  "WHERE selection_process_id != :id AND selection_process_type = :type AND selection_process_year = :year", "id={$SelectionId}&type={$SelectionType}&year={$SelectionYear}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. Esse processo seletivo já está cadastrado!", E_USER_WARNING);
            else:
                //ATUALIZA Processo
                $Update->ExeUpdate(DB_SELECTION_PROCESS, $PostData, "WHERE selection_process_id = :id", "id={$SelectionId}");
                $jSON['trigger'] = AjaxErro("TUDO CERTO {$_SESSION['userLogin']['user_name']}, Processo atualizado com sucesso!");
            endif;
            break;

        case 'delete':
            $SelectionId = $PostData['del_id'];
            $Read->ExeRead(DB_SELECTION_PROCESS, "WHERE selection_process = :id", "id=".$SelectionId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>PROCESSO SELETIVO NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um processo seletivo que não existe ou já foi removido!", E_USER_WARNING);
            else:
                $Delete->ExeDelete(DB_SELECTION_PROCESS, "WHERE selection_process = :id", "id=".$SelectionId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>PROCESSO SELETIVO REMOVIDO COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=processo_seletivo/home";
            endif;
            break;



    endswitch;

    //RETORNA O CALLBACK
    if ($jSON):
        echo json_encode($jSON);
    else:
        $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Desculpe. Mas uma ação do sistema não respondeu corretamente. Ao persistir, contate o desenvolvedor!', E_USER_ERROR);
        echo json_encode($jSON);
    endif;
else:
    //ACESSO DIRETO
    die('<br><br><br><center><h1>Acesso Restrito!</h1></center>');
endif;
