<?php
session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_FAQ;

if ((!APP_FAQ) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

//usleep(5000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;;
$CallBack = 'FAQ';
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
            $FaqId = $PostData['faq_id'];
            $FaqCategory = $PostData['faq_category'];
            $FaqQuestion = $PostData['faq_question'];

            $Read->ExeRead( DB_FAQ ,  "WHERE faq_id != :id AND faq_question = :question AND faq_category = :category", "id={$FaqId}&question={$FaqQuestion}&category={$FaqCategory}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. Essa pergunta já está cadastrada!", E_USER_WARNING);
            else:

                //ATUALIZA USUÁRIO
                $Update->ExeUpdate(DB_FAQ, $PostData, "WHERE faq_id = :id", "id={$FaqId}");
                $jSON['trigger'] = AjaxErro("TUDO CERTO {$_SESSION['userLogin']['user_name']}, A pergunta foi atualizada com sucesso!");

            endif;
            break;

        case 'delete':
            $FaqId = $PostData['del_id'];
            $Read->ExeRead(DB_FAQ, "WHERE faq_id = :id", "id=".$FaqId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>PERGUNTA NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar uma pergunta que não existe ou já foi removida!", E_USER_WARNING);
            else:
                //extract($Read->getResult()[0]);
                $Delete->ExeDelete(DB_FAQ, "WHERE faq_id = :id", "id=".$FaqId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>PERGUNTA REMOVIDA COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=faq/home";
            endif;
            break;


        case 'category_add':
            $PostData = array_map('strip_tags', $PostData);
            $CatId = $PostData['faq_category_id'];
            $FaqCategory = $PostData['faq_category_name'];
            unset($PostData['faq_category_id']);


            $Read->ExeRead( DB_FAQ_CATEGORY,  "WHERE faq_category_id != :id  AND faq_category_name = :category", "id={$CatId}&category={$FaqCategory}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. Essa categoria já está cadastrada!", E_USER_WARNING);
            else:

                //ATUALIZA Categoria
                $Update->ExeUpdate(DB_FAQ_CATEGORY, $PostData, "WHERE faq_category_id = :id", "id={$CatId}");
                $jSON['trigger'] = AjaxErro("TUDO CERTO {$_SESSION['userLogin']['user_name']}, A categoria foi atualizada com sucesso!");

            endif;
            break;
            break;

        case 'category_remove':
            $FaqId = $PostData['del_id'];
            $Read->ExeRead(DB_FAQ_CATEGORY, "WHERE faq_category_id = :id", "id=".$FaqId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>CATEGORIA NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar uma categoria que não existe ou já foi removida!", E_USER_WARNING);
            else:
                //extract($Read->getResult()[0]);
                $Delete->ExeDelete(DB_FAQ_CATEGORY, "WHERE faq_category_id = :id", "id=".$FaqId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>CATEGORIA REMOVIDA COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=faq/categories";
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
