<?php
$AdminLevel = LEVEL_ITV_STUDENTS;
if (!APP_STUDENTS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

//AUTO DELETE USER TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_STUDENTS, "WHERE students_name = :name", "name=Novo Aluno");
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

$S = filter_input(INPUT_GET, "s", FILTER_DEFAULT);
$O = filter_input(INPUT_GET, "opt", FILTER_DEFAULT);
$C = filter_input(INPUT_GET, "c", FILTER_DEFAULT);

$WhereString = (!empty($S) ? " AND (students_name LIKE '%{$S}%')" : "");
$WhereOpt = (!empty($O) ? " AND students_status = {$O}" : "");
$WhereClass = (!empty($C) ? " AND students_class = {$C}" : "");

$Search = filter_input_array(INPUT_POST);
if ($Search && (isset($Search['s']) || isset($Search['opt']) || isset($Search['c']) )):
    $S = urlencode($Search['s']);
    $O = urlencode($Search['opt']);
    $C = urlencode($Search['c']);

    header("Location: dashboard.php?wc=alunos/home&opt={$O}&s={$S}&c={$C}");
    exit;
endif;
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-users">Alunos</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Alunos
        </p>
    </div>
    <div class="dashboard_header_search">

        <form name="searchStudents" action="" method="post" enctype="multipart/form-data" class="ajax_off">

            <input type="search" value="<?= $S; ?>" name="s" placeholder="Pesquisar:" style="width: 30%; margin-right: 3px;" />

            <select name="opt" style="width: 25%; margin-right: 3px; padding: 5px 10px">
                <option value="">Todos</option>
                <option value="1">Matriculado</option>
                <option value="2">Egresso</option>
                <option value="0">Desligado</option>

            </select>

            <select name="c" style="width: 25%; margin-right: 3px; padding: 5px 10px">
                <option value="">Turma</option>
                <?php
                $Read->ExeRead(DB_STUDENTS_CLASS);
                foreach ($Read->getResult() as $Class):
                extract($Class);
                ?>

                <option value="<?=$students_class_id;?>" <?= ($students_class_id == $C) ? "selected" : ""; ?>><?=$students_class_name;?></option>
                <?php endforeach; ?>

            </select>

            <button class="btn btn_green icon icon-search icon-notext"></button>
        </form>
    </div>
</header>

<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Pager = new Pager("dashboard.php?wc=alunos/home&opt={$O}&s={$S}&c={$C}&page=", "<<", ">>", 5);
    $Pager->ExePager($Page, 12);
    $Read->ExeRead(DB_STUDENTS, "WHERE 1 = 1 $WhereString $WhereOpt $WhereClass ORDER BY students_name ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if (!$Read->getResult()):
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem alunos cadastrados {$Admin['user_name']}. Comece agora mesmo cadastrando um novo aluno!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Students):
            extract($Students);
            $students_name = ($students_name ? $students_name : 'Novo Aluno');
            $StudentThumb = "../uploads/{$students_thumb}";
            $students_thumb = (file_exists($StudentThumb) && !is_dir($StudentThumb) ? "uploads/{$students_thumb}" : 'admin/_img/no_avatar.jpg');

            echo "<article class='single_user box box25 al_center'>
                    <div class='box_content wc_normalize_height'>
                        <img alt='Este é {$students_name}' title='Este é {$students_name}' src='../tim.php?src={$students_thumb}&w=400&h=400'/>
                        <h1>{$students_name}</h1>
                        
                        <h5 class='nivel'> Turma de ". getStudentsClass($students_class). "</h5>
                        <p class='info'>" . getStudentsCategory($students_status). "</p>
                    </div>
                    <div class='single_user_actions'>
                        <a class='btn btn_green icon-user' href='dashboard.php?wc=alunos/create&id={$students_id}' title='Gerenciar Aluno!'>Editar Aluno</a>
                    </div>
                </article>";
        endforeach;
        $Pager->ExePaginator(DB_STUDENTS, "WHERE 1 = 1" . $WhereString . $WhereOpt . $WhereClass );
        echo $Pager->getPaginator();
    endif;
    ?>
</div>