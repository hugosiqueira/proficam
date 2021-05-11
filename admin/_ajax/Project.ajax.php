<?php
session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_PROJECTS;

if ((!APP_PROJECTS) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

//usleep(5000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;;
$CallBack = 'Project';
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
    $Upload = new Upload('../../uploads/');

    //SELECIONA AÇÃO
    switch ($Case):
        case 'manager':
            $ProjectId = $PostData['project_id'];
            $ProjectTitle= $PostData['project_title'];
            $PostData['project_link'] = Check::Name($ProjectTitle);
            $linhas_pesquisa = $PostData['project_research_line'];
            $PostData['project_research_line'] = "";
            for ($i=0;$i<count($linhas_pesquisa);$i++)
            {
                $PostData['project_research_line'] .= $linhas_pesquisa[$i]. "; ";
            }

            $Read->ExeRead( DB_PROJECTS ,  "WHERE project_title = :title AND project_id != :id AND project_status = :status", "title={$ProjectTitle}&id={$ProjectId}&status=1");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. O projeto <b>{$ProjectTitle}</b> já está cadastrado!", E_USER_WARNING);
            else:
                //ATUALIZA USUÁRIO
                $Update->ExeUpdate(DB_PROJECTS, $PostData, "WHERE project_id = :id", "id={$ProjectId}");
                $jSON['trigger'] = AjaxErro("Tudo certo {$_SESSION['userLogin']['user_name']}, O projeto de pesquisa foi atualizado com sucesso!");
                // var_dump($PostData);
            endif;
            break;

        case 'delete':
            $ProjectId = $PostData['del_id'];
            $Read->ExeRead(DB_PROJECTS, "WHERE project_id = :id", "id=".$ProjectId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>O PROJETO DE PESQUISA NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um projeto de pesquisa que não existe ou já foi removido!", E_USER_WARNING);
            else:
                $Delete->ExeDelete(DB_PROJECTS, "WHERE project_id = :id", "id=".$ProjectId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>PROJETO DE PESQUISA REMOVIDA COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=projetos/home";
            endif;
            break;
        case 'window_delete_project':

            $Content = ''
                . '<form name="schedule_delete" action="" autocomplete="off" method="post" enctype="multipart/form-data">'
                . '<input type="hidden" name="callback" value="Project"/>'
                . '<input type="hidden" name="callback_action" value="delete"/>'
                . '<input type="hidden" name="del_id" value="'.$PostData['id'].'"/>'

                // ESSA IMAGEM É O LOAD QUE APARECERÁ NO FOOTER
                . "<img class='form_load none' load='true' style='margin-left:10px;' alt='Enviando Requisição!' title='Enviando Requisição!' src='./_img/load.gif'/>"
                . '</form>';
            $jSON['modal'] = [
                // 'size' => 'large',               // Tamanho da modal [medium / large] - o tamanho pequeno é nativo
                'icon' => 'pencil',                // Ícone que deseja usar
                'title' => 'Você tem certeze que deseja deletar o projeto?', // Título que deseja exibir no topo
                'content' => $Content,           // $Content é a string com o conteúdo. Você deve criar!
                'footer' => "<a class='fl_left btn btn_red j_ajaxModalClose'>Cancelar</a><div class='fl_right'><a class='btn btn_green btn-rounded j_sendFormModal icon-cross'>Deletar Programação</a></div>"
            ];
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
