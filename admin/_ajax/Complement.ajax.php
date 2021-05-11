<?php
session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_COMPLEMENTS;

if (!APP_RESEARCH || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPPSSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;


//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Complement';
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
        //DELETE
        case 'delete':

            $Delete->ExeDelete(DB_PAGE_COMPLEMENTS, "WHERE complement_id = :id", "id={$PostData['del_id']}");
            $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>COMPLEMENTO DE PÁGINA REMOVIDO COM SUCESSO!</b>");
            $jSON['redirect'] = "dashboard.php?wc=complements/home";
            break;

        case 'manager':
            $ComplementId = $PostData['complement_id'];
            unset($PostData['complement_id']);

            $Read->ExeRead( DB_PAGE_COMPLEMENTS ,  "WHERE complement_name = :complement_name AND complement_id != :id ", "complement_name={$PostData['complement_name']}&id={$ComplementId}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. Essa página já possui um complemento cadastrado!", E_USER_WARNING);
            else:
                //ATUALIZA USUÁRIO
                $Update->ExeUpdate(DB_PAGE_COMPLEMENTS, $PostData, "WHERE complement_id = :id", "id={$ComplementId}");
                $jSON['trigger'] = AjaxErro("Tudo certo {$_SESSION['userLogin']['user_name']}, O complemento foi atualizado com sucesso!");
                // var_dump($PostData);
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
