<?php
$AdminLevel = LEVEL_ITV_TESTIMONIALS;
if (!APP_TESTIMONIALS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;

?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-bubble2">Depoimentos</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Depoimentos
        </p>
    </div>
    <div class="dashboard_header_search">
        <a class='btn btn_green icon-bubble2' href='dashboard.php?wc=depoimentos/create' title='Novo Depoimento!'>Novo Depoimento</a>


    </div>
</header>

<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Pager = new Pager("dashboard.php?wc=depoimentos/home&page=", "<<", ">>", 5);
    $Pager->ExePager($Page, 12);
    $Read->FullRead("SELECT * FROM ". DB_TESTIMONIALS." LEFT JOIN " . DB_STUDENTS ." ON testimonial_student = students_id ORDER BY testimonial_id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
    if (!$Read->getResult()):
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem depoimentos cadastrados {$Admin['user_name']}. Comece agora mesmo cadastrando um novo depoimento!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $Testimonials):
            extract($Testimonials);
            $students_name = ($students_name ? $students_name : 'Novo Aluno');
            $StudentsThumb = "../uploads/{$students_thumb}";
            $students_thumb = (file_exists($StudentsThumb) && !is_dir($StudentsThumb) ? "uploads/{$students_thumb}" : 'admin/_img/no_avatar.jpg');

            echo "<article class='single_user box box25 al_center'>
                    <div class='box_content wc_normalize_height'>
                        <img alt='Este é {$students_name}' title='Este é {$students_name}' src='../tim.php?src={$students_thumb}&w=400&h=400'/>
                        <h1>{$students_name}</h1>
                        
                        <h5 class='nivel'>Turma de " .getStudentsClass($students_class) ."</h5>
                        <p class='nivel'>" .($testimonial_status ? '<span class="font_green">Publicado</span>' : '<span class="font_red">Desativado</span>') . "</p>
                    </div>
                    <div class='single_user_actions'>
                        <a class='btn btn_green icon-bubble2' href='dashboard.php?wc=depoimentos/create&id={$testimonial_id}' title='Gerenciar Depoimento!'>Editar Depoimento</a>
                    </div>
                </article>";
        endforeach;
        $Pager->ExePaginator(DB_TESTIMONIALS );
        echo $Pager->getPaginator();
    endif;
    ?>
</div>