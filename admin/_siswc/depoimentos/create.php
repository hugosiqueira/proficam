<?php
$AdminLevel = LEVEL_ITV_TESTIMONIALS;
if (!APP_TESTIMONIALS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
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

$TestimonialId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($TestimonialId):
    $querystudents = "SELECT *, students_thumb as students_img FROM ".DB_TESTIMONIALS. " s ";
    $querystudents .= " LEFT JOIN " .DB_STUDENTS. " d ON d.students_id = s.testimonial_student";
    $querystudents .= " WHERE  s.testimonial_id = :id";
    $Read->FullRead($querystudents, "id={$TestimonialId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_TESTIMONIALS):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=depoimentos/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um depoimento que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=depoimentos/home');
        exit;
    endif;
else:
    $CreateTestimonialDefault = [
        "testimonial_student" => 1,

    ];
    $Create->ExeCreate(DB_TESTIMONIALS, $CreateTestimonialDefault);
    header("Location: dashboard.php?wc=depoimentos/create&id={$Create->getResult()}");
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
        <h1 class="icon-bubble2">Novo Depoimento</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=depoimentos/home">Depoimentos</a>
            <span class="crumb">/</span>
            Novo Depoimento
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $TestimonialId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $TestimonialId; ?>'>Deletar Depoimento!</span>
        <span rel='dashboard_header_search' callback='Testimonials' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $TestimonialId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box70">
        <article class="wc_tab_target wc_active" id="profile">

            <div class="panel_header default">
                <h2 class="icon-bubble2">Depoimento de <?= $students_name; ?></h2>
            </div>

            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="students_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Testimonials"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="testimonial_id" value="<?= $TestimonialId; ?>"/>

                        <label class="label">
                            <span class="legend">Aluno:</span>
                            <select name="testimonial_student" id="editable-select" required>
                                <?php
                                $Read->ExeRead(DB_STUDENTS, "ORDER BY students_name ASC");
                                foreach ($Read->getResult() as $Students):
                                extract($Students);

                                ?>
                                <option value="<?=$students_id;?>" <?=($students_id == $testimonial_student ? "selected" : "")?>><?=$students_name;?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    <label class="label">
                        <span class="legend">Publicar:</span>
                        <select name="testimonial_status" required>
                            <option selected disabled value="">Selecione:</option>
                            <option value="1" <?= ($testimonial_status == 1 ? "selected" : "")?>>Sim</option>
                            <option value="0" <?= ($testimonial_status == 0 ? "selected" : "")?>>Não</option>
                        </select>
                    </label>

                    <label class="label">
                        <span class="legend">Depoimento:</span>
                        <textarea name="testimonial_text" rows="4" placeholder="Depoimento" ><?=$testimonial_text;?></textarea>
                    </label>





                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Depoimento!</button>
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