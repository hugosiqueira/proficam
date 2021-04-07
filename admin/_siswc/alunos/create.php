<?php
$AdminLevel = LEVEL_ITV_STUDENTS;
if (!APP_STUDENTS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
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

$StudentId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($StudentId):
    $queryStudents = "SELECT * FROM ".DB_STUDENTS. " s ";
    $queryStudents .= " LEFT JOIN " . DB_STUDENTS_CLASS. " c ON s.students_class = c.students_class_id";
    $queryStudents .= " LEFT JOIN " .DB_COURSE_DEGREE. " d ON d.course_degree_id = s.students_degree";
    $queryStudents .= " LEFT JOIN " .DB_COURSE. " co ON co.course_id = s.students_course ";
    $queryStudents .= " WHERE  s.students_id = :id";
    $Read->FullRead($queryStudents, "id={$StudentId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_STUDENTS):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=alunos/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um usuário que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=alunos/home');
        exit;
    endif;
else:
    $CreateStudentDefault = [
        "students_name" => "Novo Aluno",
        "students_class" => 1,
        "students_status" => 1
    ];
    $Create->ExeCreate(DB_STUDENTS, $CreateStudentDefault);
    header("Location: dashboard.php?wc=alunos/create&id={$Create->getResult()}");
    exit;
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-user-plus">Novo Aluno</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=alunos/home">Alunos</a>
            <span class="crumb">/</span>
            Novo Aluno
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $StudentId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $StudentId; ?>'>Deletar Usuário!</span>
        <span rel='dashboard_header_search' callback='Students' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $StudentId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box70">
        <article class="wc_tab_target wc_active" id="profile">

            <div class="panel_header default">
                <h2 class="icon-user-plus">Dados de <?= $students_name; ?></h2>
            </div>

            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="students_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Students"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="students_id" value="<?= $StudentId; ?>"/>
                    <label class="label">
                        <span class="legend">Nome Completo:</span>
                        <input value="<?= $students_name; ?>" type="text" name="students_name" placeholder="Nome Completo:" required />
                    </label>
                    <div class="label_50">
                        <label class="label">
                            <span class="legend">Curso:</span>
                            <select name="students_course" required>
                                <option selected disabled value="">Selecione o curso do aluno:</option>
                                <?php
                                $Read->ExeRead(DB_COURSE);
                                foreach ($Read->getResult() as $Cursos):
                                    extract($Cursos);
                                    ?>
                                    <option value="<?=$course_id;?>" <?= ($course_id == $students_course) ? "selected" : ""; ?>><?=$course_name;?></option>
                                <?php
                                endforeach;

                                ?>
                            </select>
                        </label>

                        <label class="label">
                            <span class="legend">Nível:</span>
                            <select name="students_degree" required>
                                <option selected disabled value="">Selecione o grau:</option>
                                <?php
                                $Read->ExeRead(DB_COURSE_DEGREE);
                                foreach ($Read->getResult() as $Cursos):
                                    extract($Cursos);
                                    ?>
                                    <option value="<?=$course_degree_id;?>" <?= ($course_degree_id == $students_degree) ? "selected" : ""; ?>><?=$course_degree_name;?></option>
                                <?php
                                endforeach;

                                ?>
                            </select>
                        </label>

                        <label class="label">
                            <span class="legend">Turma:</span>
                            <select name="students_class" required>
                                <option selected disabled value="">Selecione a turma:</option>
                                <?php
                                $Read->ExeRead(DB_STUDENTS_CLASS);
                                foreach ($Read->getResult() as $Class):
                                    extract($Class);
                                    ?>
                                    <option value="<?=$students_class_id;?>" <?= ($students_class_id == $students_class) ? "selected" : ""; ?>><?=$students_class_name;?></option>
                                <?php
                                endforeach;

                                ?>
                            </select>
                        </label>

                        <label class="label">
                            <span class="legend">Situação:</span>
                            <select name="students_status" required>
                                <option selected disabled value="">Selecione o status do aluno:</option>
                                <?php
                                $Read->ExeRead(DB_STUDENTS_STATUS);
                                foreach ($Read->getResult() as $Alunos):
                                    extract($Alunos);
                                    ?>
                                    <option value="<?=$students_status_id;?>" <?= ($students_status_id == $students_status) ? "selected" : ""; ?>><?=$students_status_name;?></option>
                                <?php
                                endforeach;

                                ?>
                            </select>
                        </label>

                        <label class="label">
                            <span class="legend">Foto (<?= AVATAR_W; ?>x<?= AVATAR_H; ?>px, JPG ou PNG):</span>
                            <input type="file" name="students_thumb" class="wc_loadimage" />
                        </label>

                        <label class="label">
                            <span class="legend">E-mail:</span>
                            <input value="<?= $students_email; ?>" type="email" name="students_email" placeholder="E-mail:" />
                        </label>
                    </div>
                    <div class="label_50">

                        <label class="label">
                            <span class="legend">CPF:</span>
                            <input value="<?= $students_document; ?>" type="text" name="students_document" class="formCpf" placeholder="CPF:" />
                        </label>

                        <label class="label">
                            <span class="legend">Nascimento:</span>
                            <input type="text" class="jwc_datepicker" data-timepicker="false" name="students_datebirth" value="<?= $students_datebirth ? date('d/m/Y', strtotime($students_datebirth)) : ""; ?>" />
                        </label>


                    </div>
                    <label class="label">
                        <span class="legend">Currículo Lattes:</span>
                        <input type="text"  name="students_lattes" value="<?= $students_lattes; ?>" placeholder="Link do lattes"/>
                    </label>

                    <label class="label">
                        <span class="legend">Supervisor (Alunos de Pós-Doutorado):</span>
                        <select name="students_supervisor">
                            <option selected disabled value="0">Selecione o supervisor:</option>
                            <?php
                            $Read->ExeRead(DB_TEACHERS);
                            foreach ($Read->getResult() as $Teachers):
                                extract($Teachers);
                                ?>
                                <option value="<?=$teacher_id;?>" <?= ($teacher_id == $students_supervisor) ? "selected" : ""; ?>><?=$teacher_name;?></option>
                            <?php
                            endforeach;

                            ?>
                        </select>
                    </label>


                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Aluno!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>



    </div>

    <div class="box box30">
        <?php
        $Image = (file_exists("../uploads/{$students_thumb}") && !is_dir("../uploads/{$students_thumb}") ? "uploads/{$students_thumb}" : 'admin/_img/no_avatar.jpg');
        ?>
        <img class="students_thumb" style="width: 100%;" src="../tim.php?src=<?= $Image; ?>&w=400&h=400" alt="" title=""/>

        <div class="panel">
            <div class="box_conf_menu">
                <a class='conf_menu wc_tab wc_active' href='#profile'>Perfil</a>
            </div>
        </div>
    </div>
</div>