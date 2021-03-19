<?php
$AdminLevel = LEVEL_ITV_INTERVIEW;
if (!APP_INTERVIEW || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Create)):
    $Create = new Create;
endif;

$InterviewId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($InterviewId):
    $querystudents = "SELECT *, students_thumb as students_img FROM ".DB_INTERVIEW. " s ";
    $querystudents .= " LEFT JOIN " .DB_STUDENTS. " d ON d.students_id = s.interview_student";
    $querystudents .= " WHERE  s.interview_id = :id";
    $Read->FullRead($querystudents, "id={$InterviewId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_INTERVIEW):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=defesas/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar uma defesa que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=defesas/home');
        exit;
    endif;
else:
    $CreateInterviewDefault = [
        "interview_student" => 1,
        "interview_date" => '2021-01-01',
        "interview_publish" => 1,
        "interview_status" => 0

    ];
    $Create->ExeCreate(DB_INTERVIEW, $CreateInterviewDefault);
    header("Location: dashboard.php?wc=defesas/create&id={$Create->getResult()}");
    exit;
endif;

?>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
<script>
    $(function(){
        $('#editable-select').editableSelect();
    });
</script>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-bubble2">Nova Defesa</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=defesas/home">Defesas</a>
            <span class="crumb">/</span>
            Nova Defesa
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $InterviewId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $InterviewId; ?>'>Deletar Defesa!</span>
        <span rel='dashboard_header_search' callback='Interview' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $InterviewId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box70">
        <article class="wc_tab_target wc_active" id="profile">

            <div class="panel_header default">
                <h2 class="icon-checkbox-checked">Defesa de <?= $students_name; ?></h2>
            </div>

            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="interview_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Interview"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="interview_id" value="<?= $InterviewId; ?>"/>

                        <label class="label">
                            <span class="legend">Aluno:</span>
                            <select name="interview_student" id="editable-select" required>
                                <?php
                                $Read->ExeRead(DB_STUDENTS, "ORDER BY students_name ASC");
                                foreach ($Read->getResult() as $Students):
                                extract($Students);

                                ?>
                                <option value="<?=$students_id;?>" <?=($students_id == $interview_student ? "selected" : "")?>><?=$students_name;?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    <label class="label">
                        <span class="legend">Publicar:</span>
                        <select name="interview_status" required>
                            <option selected disabled value="">Selecione:</option>
                            <option value="1" <?= ($interview_status == 1 ? "selected" : "")?>>Sim</option>
                            <option value="0" <?= ($interview_status == 0 ? "selected" : "")?>>Não</option>
                        </select>
                    </label>

                    <label class="label">
                        <span class="legend">Detalhes da Defesa:</span>
                        <textarea name="inteview_details" rows="4" placeholder="Orientador: \n Banca \n " ><?=$interview_details;?></textarea>
                    </label>





                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Defesa!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>



    </div>

    <div class="box box30">
        <?php
        $Image = (file_exists("../uploads/{$students_img}") && !is_dir("../uploads/{$students_img}") ? "uploads/{$students_img}" : 'admin/_img/no_avatar.jpg');
        ?>
        <img class="students_thumb" style="width: 100%;" src="../tim.php?src=<?= $Image; ?>&w=400&h=400" alt="" title=""/>

    </div>

</div>