<?php
$AdminLevel = LEVEL_ITV_GALLERY;
if (empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel):
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #fff; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você Não Está Logado<br>Ou Não Tem Permissão Para Acessar Essa Página!</div>');
endif;

// AUTO INSTANCE OBJECT READ
if (empty($Read)):
    $Read = new Read;
endif;
/*
//AUTO DELETE POST TRASH
if (DB_AUTO_TRASH):
    $Delete = new Delete;
    $Delete->ExeDelete(DB_GALLERY, "WHERE gallery_name = '' AND gallery_cover = '' AND gallery_status = :st", "st=0");

    //AUTO TRASH IMAGES
    $Read->FullRead("SELECT gallery_image_file FROM " . DB_GALLERY_IMAGES . " WHERE gallery_id NOT IN(SELECT gallery_id FROM " . DB_GALLERY . ")");
    if ($Read->getResult()):
        $Delete->ExeDelete(DB_GALLERY_IMAGES, "WHERE gallery_image_id >= :id AND galley_id NOT IN(SELECT gallery_id FROM " . DB_GALLERY . ")", "id=1");
        foreach ($Read->getResult() as $ImageRemove):
            if (file_exists("../uploads/{$ImageRemove['gallery_file']}") && !is_dir("../uploads/{$ImageRemove['gallery_image_file']}")):
                unlink("../uploads/{$ImageRemove['gallery_file']}");
            endif;
        endforeach;
    endif;
endif;*/
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-images">Galerias de Fotos</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            Galeria de Fotos
        </p>
    </div>

    <div class="dashboard_header_search">
        <a class='btn btn_green icon-images' href='dashboard.php?wc=gallery/create' title='Nova Galeria!'>Nova Galeria</a>
    </div>

</header>
<div class="dashboard_content">
    <?php
    $getGallery = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT);
    $Gallery = ($getGallery ? $getGallery : 1);
    $Paginator = new Pager('dashboard.php?wc=gallery/home&pg=', '<<', '>>', 5);
    $Paginator->ExePager($Gallery, 12);

    $Read->ExeRead(DB_GALLERY, "ORDER BY gallery_name ASC LIMIT :limit OFFSET :offset", "limit={$Paginator->getLimit()}&offset={$Paginator->getOffset()}");
    if (!$Read->getResult()):
        $Paginator->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Olá {$Admin['user_name']}, Ainda Não Existe Nenhuma Galeria. Comece Agora Mesmo Criando Sua Primeira Galeria de Fotos!</span>", E_USER_NOTICE);
    else:
        foreach ($Read->getResult() as $GALLERY):
            extract($GALLERY);
            $gallery_status = ($gallery_status == 1 ? '<span class="icon-checkmark font_blue">Publicada</span>' : '<span class="icon-warning font_yellow">Rascunho</span>');
            $gallery_cover = (!empty($gallery_cover) ? BASE . "/tim.php?src=uploads/{$gallery_cover}&w=" . IMAGE_W / 4 . "&h=" . IMAGE_H / 4 . "" : "");

            echo "<article class='box box25 post_single' id='{$gallery_id}'>
<div class='post_single_cover'>
    <img alt='{$gallery_name}' title='{$gallery_name}' src='{$gallery_cover}'/>
</div>
        <div class='post_single_content wc_normalize_height'>
            <h1 class='title'>{$gallery_name}</h1>
            <p>{$gallery_status}</p>
        </div>
        <div class='post_single_actions'>
            <a title='Editar Galeria' href='dashboard.php?wc=gallery/create&id={$gallery_id}' class='post_single_center icon-pencil btn btn_blue'>Editar Galeria</a>
            <span title='Excluir Galeria' rel='post_single' class='j_delete_action icon-cancel-circle btn btn_red' id='{$gallery_id}'>Deletar</span>
            <span rel='post_single' callback='Gallery' callback_action='delete' class='j_delete_action_confirm icon-warning btn btn_yellow' style='display: none' id='{$gallery_id}'>Deletar Galeria?</span>
        </div>
    </article>";
        endforeach;

        $Paginator->ExePaginator(DB_GALLERY);
        echo $Paginator->getPaginator();
    endif;
    ?>
</div>