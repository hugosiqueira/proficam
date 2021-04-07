<?php
session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_INTERVIEW;

if ((!APP_INTERVIEW) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

//usleep(5000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;;
$CallBack = 'Interview';
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
            $InterviewId = $PostData['interview_id'];
            $InterviewStudent = $PostData['interview_student'];
            //unset($PostData['interview_id'],$PostData['interview_student'] );
            $Read->ExeRead(DB_STUDENTS, "WHERE students_name = :name", "name={$InterviewStudent}");
            extract($Read->getResult()[0]);
            $PostData['interview_student'] = $students_id;
            $PostData['interview_date'] = (!empty($PostData['interview_date']) ? Check::Data($PostData['interview_date']) : date('Y-m-d H:i:s'));
            $PostData['interview_publish'] = (!empty($PostData['interview_publish']) ? Check::Data($PostData['interview_publish']) : date('Y-m-d H:i:s'));
            $PostData['interview_link'] = (!empty($PostData['interview_link']) ? Check::Name($PostData['interview_link']) : Check::Name($PostData['interview_title']));
            $Read->ExeRead(DB_INTERVIEW, "WHERE interview_id != :id AND interview_link = :link", "id={$InterviewId}&link={$PostData['interview_link']}");
            if ($Read->getResult()):
                $PostData['interview_link'] = "{$PostData['interview_link']}-{$InterviewId}";
            endif;
            $jSON['name'] = $PostData['interview_link'];


            $Read->ExeRead( DB_INTERVIEW ,  "WHERE interview_student = :student AND interview_id != :id", "student={$students_id}&id={$InterviewId}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. O aluno <b>{$InterviewStudent}</b> já tem uma defesa cadastrada!", E_USER_WARNING);
            else:

                //ATUALIZA USUÁRIO
                $Update->ExeUpdate(DB_INTERVIEW, $PostData, "WHERE interview_id = :id", "id={$InterviewId}");
                $jSON['trigger'] = AjaxErro("Tudo certo {$_SESSION['userLogin']['user_name']}, A defesa foi atualizado com sucesso!");
                // var_dump($PostData);
            endif;
            break;

        case 'delete':
            $InterviewId = $PostData['del_id'];
            $Read->ExeRead(DB_INTERVIEW, "WHERE interview_id = :id", "id=".$InterviewId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>DEFESA NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um aluno que não existe ou já foi removido!", E_USER_WARNING);
            else:
                //extract($Read->getResult()[0]);
                $Delete->ExeDelete(DB_INTERVIEW, "WHERE interview_id = :id", "id=".$InterviewId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>DEFESA REMOVIDA COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=defesas/home";
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
