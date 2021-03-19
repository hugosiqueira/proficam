<?php

session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_TEACHERS;

if ((!APP_TEACHERS) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

usleep(50000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Teachers';
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
            $TeacherId = $PostData['teacher_id'];
            unset($PostData['teacher_id'],$PostData['teacher_thumb'] );
            //$PostData['teacher_datebirth'] = (!empty($PostData['teacher_datebirth']) ? Check::Data($PostData['teacher_datebirth']) : date('Y-m-d H:i:s'));

            $Read->FullRead("SELECT teacher_id FROM " . DB_TEACHERS . " WHERE teacher_email = :email AND teacher_id != :id", "email={$PostData['teacher_email']}&id={$TeacherId}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. O e-mail <b>{$PostData['teacher_email']}</b> já está cadastrado na conta de outro usuário!", E_USER_WARNING);
            else:

                    if (!empty($_FILES['teacher_thumb'])):
                        $UserThumb = $_FILES['teacher_thumb'];
                        $Read->FullRead("SELECT teacher_thumb FROM " . DB_TEACHERS . " WHERE teacher_id = :id", "id={$TeacherId}");
                        if ($Read->getResult()):
                            if (file_exists("../../uploads/{$Read->getResult()[0]['teacher_thumb']}") && !is_dir("../../uploads/{$Read->getResult()[0]['teacher_thumb']}")):
                                unlink("../../uploads/{$Read->getResult()[0]['teacher_thumb']}");
                            endif;
                        endif;

                        $Upload->Image($UserThumb, $TeacherId . "-" . Check::Name($PostData['teacher_name']) . '-' . time(), 600);
                        if ($Upload->getResult()):
                            $PostData['teacher_thumb'] = $Upload->getResult();
                        else:
                            $jSON['trigger'] = AjaxErro("<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$_SESSION['userLogin']['user_name']}, selecione uma imagem JPG ou PNG para enviar como foto!", E_USER_WARNING);
                            echo json_encode($jSON);
                            return;
                        endif;
                    else: unset($PostData['teacher_thumb']);
                    endif;


                    //ATUALIZA USUÁRIO
                    $Update->ExeUpdate(DB_TEACHERS, $PostData, "WHERE teacher_id = :id", "id={$TeacherId}");
                    $jSON['trigger'] = AjaxErro("TUDO CERTO {$_SESSION['userLogin']['user_name']}, O(a) professor(a) <b>{$PostData['teacher_name']}</b> foi Atualizado Com Sucesso!");

            endif;
            break;

        case 'delete':
            $TeacherId = $PostData['del_id'];
            $Read->ExeRead(DB_TEACHERS, "WHERE teacher_id = :user", "user={$TeacherId}");
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>PROFESSOR NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um professor que não existe ou já foi removido!", E_USER_WARNING);
            else:
                extract($Read->getResult()[0]);
                if (file_exists("../../uploads/{$teacher_thumb}") && !is_dir("../../uploads/{$teacher_thumb}")):
                    unlink("../../uploads/{$teacher_thumb}");
                endif;

                $Delete->ExeDelete(DB_TEACHERS, "WHERE teacher_id = :user", "user={$teacher_id}");
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>PROFESSOR REMOVIDO COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=professores/home";
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
