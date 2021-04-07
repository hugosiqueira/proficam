<?php
$AdminLevel = LEVEL_ITV_TEACHERS;
if (!APP_TEACHERS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
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

$TeacherId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($TeacherId):
    $queryTeacher = "SELECT * FROM ".DB_TEACHERS. " s ";
    $queryTeacher .= " LEFT JOIN " .DB_COURSE_DEGREE. " d ON d.course_degree_id = s.teacher_title";
    $queryTeacher .= " WHERE  s.teacher_id = :id";
    $Read->FullRead($queryTeacher, "id={$TeacherId}");
    if ($Read->getResult()):
        $FormData = array_map('htmlspecialchars', $Read->getResult()[0]);
        extract($FormData);

        if ( $_SESSION['userLogin']['user_level'] < LEVEL_ITV_TEACHERS):
            $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!";
            header('Location: dashboard.php?wc=professores/home');
            exit;
        endif;
    else:
        $_SESSION['trigger_controll'] = "<b>OPPSS {$Admin['user_name']}</b>, você tentou editar um professor que não existe ou que foi removido recentemente!";
        header('Location: dashboard.php?wc=professores/home');
        exit;
    endif;
else:
    $CreateTeacherDefault = [
        "teacher_name" => "Novo Professor",
        "teacher_productivity" => 0,
        "teacher_status" => 1

    ];
    $Create->ExeCreate(DB_TEACHERS, $CreateTeacherDefault);
    header("Location: dashboard.php?wc=professores/create&id={$Create->getResult()}");
    exit;
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-user-plus">Novo Professor</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=professores/home">Professores</a>
            <span class="crumb">/</span>
            Novo Professor
        </p>
    </div>

    <div class="dashboard_header_search" style="font-size: 0.875em; margin-top: 16px;" id="<?= $TeacherId; ?>">
        <span rel='dashboard_header_search' class='j_delete_action icon-warning btn btn_red' id='<?= $TeacherId; ?>'>Deletar Usuário!</span>
        <span rel='dashboard_header_search' callback='Teachers' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='<?= $TeacherId; ?>'>EXCLUIR AGORA!</span>
    </div>
</header>

<div class="dashboard_content dashboard_users">
    <div class="box box70">
        <article class="wc_tab_target wc_active" id="profile">

            <div class="panel_header default">
                <h2 class="icon-user-plus">Dados de <?= $teacher_name; ?></h2>
            </div>

            <div class="panel">
                <form class="auto_save" class="j_tab_home tab_create" name="teacher_manager" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="Teachers"/>
                    <input type="hidden" name="callback_action" value="manager"/>
                    <input type="hidden" name="teacher_id" value="<?= $TeacherId; ?>"/>
                    <label class="label">
                        <span class="legend">Nome Completo:</span>
                        <input value="<?= $teacher_name; ?>" type="text" name="teacher_name" placeholder="Nome Completo:" required />
                    </label>
                    <label class="label">
                        <span class="legend">Nome a ser exibido:</span>
                        <input value="<?= $teacher_social_name; ?>" type="text" name="teacher_social_name" placeholder="Nome + Sobrenome Preferido:" />
                    </label>
                    <div class="label_50">
                        <label class="label">
                            <span class="legend">Vínculo:</span>
                            <select name="teacher_status" required>
                                <option selected disabled value="">Selecione o vínculo do professor:</option>
                                <option value="1"<?= ($teacher_status == 1 ? "selected" : "")?>>Permanente</option>
                                <option value="2"<?= ($teacher_status == 2 ? "selected" : "")?>>Colaborador</option>

                                <option value="3"<?= ($teacher_status == 3 ? "selected" : "")?>>Visitante</option>
                                <option value="0" <?= ($teacher_status == 0 ? "selected" : "")?>>Inativo</option>
                            </select>
                        </label>
                        <label class="label">
                            <span class="legend">Titulação:</span>
                            <select name="teacher_title" required>
                                <option selected disabled value="">Selecione a titulação:</option>
                                <?php
                                $Read->ExeRead(DB_COURSE_DEGREE);
                                foreach ($Read->getResult() as $Title):
                                    extract($Title);
                                    ?>
                                    <option value="<?=$course_degree_id;?>" <?= ($course_degree_id == $teacher_title) ? "selected" : ""; ?>><?=$course_degree_name;?></option>
                                <?php
                                endforeach;

                                ?>
                            </select>
                        </label>
                        <label class="label">
                            <span class="legend">País da Titulação:</span>
                            <select name="teacher_title_country" required>
                                <option selected disabled value="">Selecione o país:</option>
                                <?php
                                $Read->ExeRead("itv_country");
                                foreach ($Read->getResult() as $Country):
                                    extract($Country);
                                    ?>
                                    <option value="<?=$codigo;?>" <?= ($teacher_title_country == $codigo) ? "selected" : ""; ?>><?=$nome;?></option>
                                <?php
                                endforeach;

                                ?>
                            </select>
                        </label>
                        <label class="label">
                            <span class="legend">Ano da Titulação:</span>
                            <input value="<?= $teacher_title_year; ?>" type="text" name="teacher_title_year" placeholder="Ano que terminou o título:"  />
                        </label>

                        <label class="label">
                            <span class="legend">Nome da Titulação (IES):</span>
                            <input value="<?= $teacher_title_desc; ?>" type="text" name="teacher_title_desc" placeholder="Nome do programa:"  />
                        </label>

                        <label class="label">
                            <span class="legend">Foto (<?= AVATAR_W; ?>x<?= AVATAR_H; ?>px, JPG ou PNG):</span>
                            <input type="file" name="teacher_thumb" class="wc_loadimage" />
                        </label>
                    </div>
                    <label class="label">
                        <span class="legend">Área de Atuação:</span>
                        <input value="<?= $teacher_area; ?>" type="text" name="teacher_area" placeholder="Área de Atuação:"  />
                    </label>

                    <div class="label_50">
                        <label class="label">
                            <span class="legend">Curriculum Lattes: (LINK)</span>
                            <input value="<?= $teacher_lattes; ?>" type="text" name="teacher_lattes" placeholder="Link do Currículo Lattes" />
                        </label>
                        <label class="label">
                            <span class="legend">Instituição de Ensino:</span>
                            <input value="<?= $teacher_university; ?>" type="text" name="teacher_university" placeholder="Instituição de ensino superior" />
                        </label>
                        <label class="label">
                            <span class="legend">E-mail:</span>
                            <input value="<?= $teacher_email; ?>" type="email" name="teacher_email" placeholder="E-mail:" />
                        </label>
                        <label class="label">
                            <span class="legend">Possui Bolsa de Produtividade:</span>
                            <select name="teacher_productivity" required>
                                <option selected disabled value="">Selecione:</option>
                                <option value="1"<?= ($teacher_productivity == 1 ? "selected" : "")?>>Sim</option>
                                <option value="0" <?= ($teacher_productivity == 0 ? "selected" : "")?>>Não</option>
                            </select>
                        </label>
                    </div>
                        <label class="label">
                            <span class="legend">Descrição da Bolsa, caso possua:</span>
                            <input value="<?= $teacher_scholarship; ?>" type="text" name="teacher_scholarship" placeholder="Caso possua bolsa, qual o nome" />
                        </label>
                    <label class="label">
                        <span class="legend">Link do professor:</span>
                        <input value="<?= $teacher_link; ?>" type="text" name="teacher_link" placeholder="Campo com o link da página do professor" />
                    </label>
                    <label class="label">
                        <span class="legend">Resumo do Currículo:</span>
                        <textarea name="teacher_resume" rows="8" placeholder="Resumo do Currículo" ><?=$teacher_resume;?></textarea>
                    </label>





                    <div class="clear"></div>

                    <img class="form_load none fl_right" style="margin-left: 10px; margin-top: 2px;" alt="Enviando Requisição!" title="Enviando Requisição!" src="_img/load.gif"/>
                    <button name="public" value="1" class="btn btn_green fl_right icon-share" style="margin-left: 5px;">Atualizar Professor!</button>
                    <div class="clear"></div>
                </form>
            </div>
        </article>



    </div>

    <div class="box box30">
        <?php
        $Image = (file_exists("../uploads/{$teacher_thumb}") && !is_dir("../uploads/{$teacher_thumb}") ? "uploads/{$teacher_thumb}" : 'admin/_img/no_avatar.jpg');
        ?>
        <img class="teacher_thumb" style="width: 100%;" src="../tim.php?src=<?= $Image; ?>&w=400&h=400" alt="" title=""/>

        <div class="panel">
            <div class="box_conf_menu">
                <a class='conf_menu wc_tab wc_active' href='#profile'>Perfil</a>
            </div>
        </div>
    </div>
</div>