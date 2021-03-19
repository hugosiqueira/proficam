<?php
$AdminLevel = LEVEL_ITV_TEACHERS;
if (!APP_TEACHERS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE USER TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_TEACHERS, "WHERE teacher_name = :name", "name=Novo Professor");
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

$S = filter_input(INPUT_GET, "s", FILTER_DEFAULT);
$O = filter_input(INPUT_GET, "opt", FILTER_DEFAULT);
$T = filter_input(INPUT_GET, "c", FILTER_DEFAULT);

$WhereString = (!empty($S) ? " AND (teacher_name LIKE '%{$S}%')" : "");
$WhereOpt = (!empty($O) ? " AND teacher_status = {$O}" : "");

$Search = filter_input_array(INPUT_POST);
if ($Search && (isset($Search['s']) || isset($Search['opt']) )):
    $S = urlencode($Search['s']);
    $O = urlencode($Search['opt']);

    header("Location: dashboard.php?wc=professores/home&opt={$O}&s={$S}");
    exit;
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-users">Professores</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Professores
        </p>
    </div>
    <div class="dashboard_header_search">

        <form name="searchTeachers" action="" method="post" enctype="multipart/form-data" class="ajax_off">

            <input type="search" value="<?= $S; ?>" name="s" placeholder="Pesquisar:" style="width: 40%; margin-right: 3px;" />

            <select name="opt" style="width: 35%; margin-right: 3px; padding: 5px 10px">
                <option value="">Todos</option>
                <option value="1">Permanente</option>
                <option value="2">Colaborador</option>
                <option value="0">Inativo</option>

           </select>

            <button class="btn btn_green icon icon-search icon-notext"></button>
        </form>
    </div>
</header>

<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Pager = new Pager("dashboard.php?wc=professores/home&opt={$O}&s={$S}&page=", "<<", ">>", 5);
    $Pager->ExePager($Page, 12);
    $Read->ExeRead(DB_TEACHERS, "WHERE 1 = 1 $WhereString $WhereOpt  ORDER BY teacher_name ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if (!$Read->getResult()):
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem professores cadastrados {$Admin['user_name']}. Comece agora mesmo cadastrando um novo professor!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Teachers):
            extract($Teachers);
            $teacher_name = ($teacher_name ? $teacher_name : 'Novo Professor');
            $TeacherThumb = "../uploads/{$teacher_thumb}";
            $teacher_thumb = (file_exists($TeacherThumb) && !is_dir($TeacherThumb) ? "uploads/{$teacher_thumb}" : 'admin/_img/no_avatar.jpg');

            echo "<article class='single_user box box25 al_center'>
                    <div class='box_content wc_normalize_height'>
                        <img alt='Este é {$teacher_name}' title='Este é {$teacher_name}' src='../tim.php?src={$teacher_thumb}&w=400&h=400'/>
                        <h1>{$teacher_name}</h1>
                        
                        <h5 class='nivel'>{$teacher_university}</h5>
                        <p class='info icon-envelop'>{$teacher_email}</p>
                    </div>
                    <div class='single_user_actions'>
                        <a class='btn btn_green icon-user' href='dashboard.php?wc=professores/create&id={$teacher_id}' title='Gerenciar Professor!'>Editar Professor</a>
                    </div>
                </article>";
        endforeach;
        $Pager->ExePaginator(DB_TEACHERS, "WHERE 1 = 1" . $WhereString . $WhereOpt );
        echo $Pager->getPaginator();
    endif;
    ?>
</div>