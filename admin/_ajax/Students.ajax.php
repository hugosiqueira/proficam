<?php

session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_STUDENTS;

if ((!APP_STUDENTS) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

usleep(50000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;
$CallBack = 'Students';
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
            $StudentId = $PostData['students_id'];
            unset($PostData['students_id'],$PostData['students_thumb'] );
            $PostData['students_datebirth'] = (!empty($PostData['students_datebirth']) ? Check::Data($PostData['students_datebirth']) : date('Y-m-d H:i:s'));

            $Read->FullRead("SELECT students_id FROM " . DB_STUDENTS . " WHERE students_email = :email AND students_id != :id", "email={$PostData['students_email']}&id={$StudentId}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. O e-mail <b>{$PostData['students_email']}</b> já está cadastrado na conta de outro usuário!", E_USER_WARNING);
            else:
                $Read->FullRead("SELECT students_id FROM " . DB_STUDENTS . " WHERE students_document = :dc AND students_id != :id", "dc={$PostData['students_document']}&id={$StudentId}");
                if ($Read->getResult()):
                    $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. O CPF <b>{$PostData['students_document']}</b> já está cadastrado na conta de outro usuário!", E_USER_WARNING);
                else:
                    if($PostData['students_document']):
                        if (Check::CPF($PostData['students_document']) != true):
                            $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. O CPF <b>{$PostData['students_document']}</b> informado não é válido!", E_USER_WARNING);
                            echo json_encode($jSON);
                            return;
                        endif;
                        endif;

                    if (!empty($_FILES['students_thumb'])):
                        $UserThumb = $_FILES['students_thumb'];
                        $Read->FullRead("SELECT students_thumb FROM " . DB_STUDENTS . " WHERE students_id = :id", "id={$StudentId}");
                        if ($Read->getResult()):
                            if (file_exists("../../uploads/{$Read->getResult()[0]['students_thumb']}") && !is_dir("../../uploads/{$Read->getResult()[0]['students_thumb']}")):
                                unlink("../../uploads/{$Read->getResult()[0]['students_thumb']}");
                            endif;
                        endif;

                        $Upload->Image($UserThumb, $StudentId . "-" . Check::Name($PostData['students_name']) . '-' . time(), 600);
                        if ($Upload->getResult()):
                            $PostData['students_thumb'] = $Upload->getResult();
                        else:
                            $jSON['trigger'] = AjaxErro("<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$_SESSION['userLogin']['user_name']}, selecione uma imagem JPG ou PNG para enviar como foto!", E_USER_WARNING);
                            echo json_encode($jSON);
                            return;
                        endif;
                        else: unset($PostData['students_thumb']);
                    endif;


                    //ATUALIZA USUÁRIO
                    $Update->ExeUpdate(DB_STUDENTS, $PostData, "WHERE students_id = :id", "id={$StudentId}");
                    $jSON['trigger'] = AjaxErro("TUDO CERTO {$_SESSION['userLogin']['user_name']}, O Aluno <b>{$PostData['students_name']}</b> Foi Atualizado Com Sucesso!");
                endif;
            endif;
            break;

        case 'delete':
            $StudentId = $PostData['del_id'];
            $Read->ExeRead(DB_STUDENTS, "WHERE students_id = :user", "user={$StudentId}");
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>ALUNO NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um aluno que não existe ou já foi removido!", E_USER_WARNING);
            else:
                extract($Read->getResult()[0]);
                    if (file_exists("../../uploads/{$students_thumb}") && !is_dir("../../uploads/{$students_thumb}")):
                        unlink("../../uploads/{$students_thumb}");
                    endif;

                    $Delete->ExeDelete(DB_STUDENTS, "WHERE students_id = :user", "user={$students_id}");
                    $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>ALUNO REMOVIDO COM SUCESSO!</b>");
                    $jSON['redirect'] = "dashboard.php?wc=alunos/home";
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
