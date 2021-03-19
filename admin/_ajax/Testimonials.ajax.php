<?php
session_start();
require '../../_app/Config.inc.php';
$NivelAcess = LEVEL_ITV_TESTIMONIALS;

if ((!APP_TESTIMONIALS) || empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

//usleep(5000);

//DEFINE O CALLBACK E RECUPERA O POST
$jSON = null;;
$CallBack = 'Testimonials';
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
            $TestimonialId = $PostData['testimonial_id'];
            $TestimonialStudent = $PostData['testimonial_student'];
            //unset($PostData['testimonial_id'],$PostData['testimonial_student'] );
            $Read->ExeRead(DB_STUDENTS, "WHERE students_name = :name", "name={$TestimonialStudent}");
            extract($Read->getResult()[0]);
            $PostData['testimonial_student'] = $students_id;

            $Read->ExeRead( DB_TESTIMONIALS ,  "WHERE testimonial_student = :student AND testimonial_id != :id", "student={$students_id}&id={$TestimonialId}");
            if ($Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>OPSS:</b> Olá {$_SESSION['userLogin']['user_name']}. O aluno <b>{$TestimonialStudent}</b> já fez seu depoimento!", E_USER_WARNING);
            else:

                //ATUALIZA USUÁRIO
                $Update->ExeUpdate(DB_TESTIMONIALS, $PostData, "WHERE testimonial_id = :id", "id={$TestimonialId}");
                $jSON['trigger'] = AjaxErro("TUDO CERTO {$_SESSION['userLogin']['user_name']}, O Depoimento foi atualizado com sucesso!");
   // var_dump($PostData);
            endif;
            break;

        case 'delete':
            $TestimonialId = $PostData['del_id'];
            $Read->ExeRead(DB_TESTIMONIALS, "WHERE testimonial_id = :id", "id=".$TestimonialId);
            if (!$Read->getResult()):
                $jSON['trigger'] = AjaxErro("<b class='icon-warning'>DEPOIMENTO NÃO EXISTE:</b> Olá {$_SESSION['userLogin']['user_name']}, você tentou deletar um aluno que não existe ou já foi removido!", E_USER_WARNING);
            else:
                //extract($Read->getResult()[0]);
                $Delete->ExeDelete(DB_TESTIMONIALS, "WHERE testimonial_id = :id", "id=".$TestimonialId);
                $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>DEPOIMENTO REMOVIDO COM SUCESSO!</b>");
                $jSON['redirect'] = "dashboard.php?wc=depoimentos/home";
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
