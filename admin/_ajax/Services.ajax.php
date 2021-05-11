<?php
session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_SITE_SERVICES;

if ((!APP_SITE_SERVICES) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

//usleep(5000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;;
$CallBack = 'Services';
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
        case 'manager':
            $ServiceId = $PostData['services_id'];
            $ServiceName= $PostData['services_name'];

            $Read->ExeRead( DB_SITE_SERVICES ,  "WHERE services_name = :name AND services_id != :id AND services_status = :status", "name={$ServiceName}&id={$ServiceId}&status=1");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. O Serviço <b>{$ServiceName}</b> já está cadastrado!", E_USER_WARNING);
            else:
                //ATUALIZA USUÁRIO
                $Update->ExeUpdate(DB_SITE_SERVICES, $PostData, "WHERE services_id = :id", "id={$ServiceId}");
                $jSON['trigger'] = AjaxErro("Tudo certo {$_SESSION['userLogin']['user_name']}, O serviço foi atualizado com sucesso!");
                // var_dump($PostData);
            endif;
            break;

        case 'delete':
            $ServiceId = $PostData['del_id'];
            $Read->ExeRead(DB_SITE_SERVICES, "WHERE services_id = :id", "id=".$ServiceId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>O SERVIÇO NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um projeto de pesquisa que não existe ou já foi removido!", E_USER_WARNING);
            else:
                $Delete->ExeDelete(DB_SITE_SERVICES, "WHERE services_id = :id", "id=".$ServiceId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>SERVIÇO REMOVIDO COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=services/home";
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
