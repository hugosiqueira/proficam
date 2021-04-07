<?php

session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_RESEARCH;

if (!APP_RESEARCH || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPPSSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;


//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Research';
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
            $PostData['research_id'] = $PostData['del_id'];
            $Read->FullRead("SELECT research_img FROM " . DB_RESEARCH . " WHERE research_id = :ps", "ps={$PostData['research_id']}");
            if ($Read->getResult() && file_exists("../../uploads/linhas_pesquisa/{$Read->getResult()[0]['research_img']}") && !is_dir("../../uploads/linhas_pesquisa/{$Read->getResult()[0]['research_img']}")):
                unlink("../../uploads/linhas_pesquisa/{$Read->getResult()[0]['research_img']}");
            endif;

            $Delete->ExeDelete(DB_RESEARCH, "WHERE research_id = :id", "id={$PostData['research_id']}");
            $jSON['success'] = true;
            break;

        case 'manager':
            $ResearchId = $PostData['research_id'];
            unset($PostData['research_id']);

            $Read->ExeRead(DB_RESEARCH, "WHERE research_id = :id", "id={$ResearchId}");
            $ThisPost = $Read->getResult()[0];

            $PostData['research_link'] = (!empty($PostData['research_link']) ? Check::Name($PostData['research_link']) : Check::Name($PostData['research_name']));
            $Read->ExeRead(DB_RESEARCH, "WHERE research_id != :id AND research_link = :link", "id={$ResearchId}&link={$PostData['research_link']}");
            if ($Read->getResult()):
                $PostData['research_link'] = "{$PostData['research_link']}-{$ResearchId}";
            endif;
            $jSON['name'] = $PostData['research_name'];

            if (!empty($_FILES['research_img'])):
                $File = $_FILES['research_img'];

                if ($ThisPost['research_img'] && file_exists("../../uploads/linhas_pesquisa/{$ThisPost['research_img']}") && !is_dir("../../uploads/linhas_pesquisa/{$ThisPost['research_img']}")):
                    unlink("../../uploads/linhas_pesquisa/{$ThisPost['research_img']}");
                endif;

                $Upload = new Upload('../../uploads/linhas_pesquisa/');
                $Upload->Image($File, $PostData['research_name'] . '-' . time(), IMAGE_W);
                if ($Upload->getResult()):
                    $PostData['research_img'] = $Upload->getResult();
                else:
                    $jSON['trigger'] = AjaxErro("<b class='icon-image'>ERRO AO ENVIAR A FOTO:</b> Olá {$_SESSION['userLogin']['user_name']}, selecione uma imagem JPG ou PNG para enviar!", E_USER_WARNING);
                    echo json_encode($jSON);
                    return;
                endif;
            else:
                unset($PostData['research_img']);
            endif;

            $PostData['research_status'] = (!empty($PostData['research_status']) ? '1' : '0');

            $Update->ExeUpdate(DB_RESEARCH, $PostData, "WHERE research_id = :id", "id={$ResearchId}");
            $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>TUDO CERTO: </b> A linha de Pesquisa <b>{$PostData['research_name']}</b> foi atualizada com sucesso!");
            $jSON['view'] = BASE . "/linha-pesquisa/{$PostData['research_link']}";
            break;

        case 'sendimage':
            $NewImage = $_FILES['image'];
            $Read->FullRead("SELECT research_name, research_link FROM " . DB_RESEARCH . " WHERE research_id = :id", "id={$PostData['research_id']}");
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-image'>ERRO AO ENVIAR IMAGEM:</b> Desculpe {$_SESSION['userLogin']['user_name']}, mas não foi possível identificar a linha de pesquisa vinculada!", E_USER_WARNING);
            else:
                $Upload = new Upload('../../uploads/linhas_pesquisa/');
                $Upload->Image($NewImage, $PostData['research_id'] . '-' . time(), IMAGE_W);
                if ($Upload->getResult()):
                    $PostData['image'] = $Upload->getResult();
                    $Create->ExeCreate(DB_RESEARCH, $PostData);
                    $jSON['tinyMCE'] = "<img title='{$Read->getResult()[0]['research_name']}' alt='{$Read->getResult()[0]['research_name']}' src='../uploads/linhas_pesquisa/{$PostData['image']}'/>";
                else:
                    $jSON['trigger'] = AjaxErro("<b class='icon-image'>ERRO AO ENVIAR IMAGEM:</b> Olá {$_SESSION['userLogin']['user_name']}, selecione uma imagem JPG ou PNG para inserir no post!", E_USER_WARNING);
                endif;
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
