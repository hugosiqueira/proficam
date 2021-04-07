<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE; ?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Defesas</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE; ?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="defesas">Defesas <i class="ion-ios-arrow-forward"></i></a></span> </p>
            </div>
        </div>
    </div>
</section>
<?php
if (!$Read):
    $Read = new Read;
endif;
if($URL[1]):
    $Read->FullRead("SELECT * FROM ".DB_INTERVIEW." LEFT JOIN ".DB_INTERVIEW_TYPE." ON interview_type_id = interview_type" .
    " LEFT JOIN " . DB_STUDENTS . " ON interview_student = students_id "
    ." WHERE interview_link = :nm  AND interview_status = :status ", "nm={$URL[1]}&status=1");
    if (!$Read->getResult()):
        require REQUIRE_PATH . '/404.php';
        return;
    else:
        extract($Read->getResult()[0]);
    endif;
    $interview_date = new DateTime($interview_date);
?>



<section class="ftco-section">
	<div class="container">
		<div class="row">
            <div class="col-lg-8 ftco-animate">


                <div class="htmlchars">
                    <p><strong>Aluno: </strong><?=$students_name;?>
                    <br /><strong>Título: </strong><?=$interview_title;?>
                    <br /><strong>Data: </strong><?=$interview_date->format('d/m/Y');?>
                    <strong>Horário: </strong><?=$interview_date->format('H:i:s');?>
                    <br /><strong>Local: </strong><?=$interview_local;?>
                    <?php
                    $link = "<br /><strong>Link:</strong> <a target='_blank' href='" . $interview_url . "' title='Link da defesa'>Clique e veja a defesa </a>";
                    ?>
                    <?= ($interview_url ? $link :"")?>
                    </p>
                    <?= $interview_details; ?>
                    <?= $interview_resume;?>
                </div>

                <div class="clear"></div>
            </div>


            <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
        <div class="clear"></div>
    </div>
</div>
    <?php
    else:
    ?>

   <section class="ftco-section  py-5">

    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <h2 class="mb-4"><span>Próximas</span> Defesas</h2>
                <p class="text-dark">Confira as próximas defesas de nosso programa</p>
            </div>
        </div>
        <div class="row">
            <?php
            $Read->FullRead("SELECT * FROM ".DB_INTERVIEW.
                " LEFT JOIN ".DB_STUDENTS." ON interview_student = students_id"
                ." LEFT JOIN " . DB_INTERVIEW_TYPE. " ON interview_type_id = interview_type"
             . " WHERE interview_status = :status ORDER BY interview_date ASC LIMIT :limit", "status=1&limit=3");
            if (!$Read->getResult()):
                $Pager->ReturnPage();
                echo Erro("Ainda Não existe defesas cadastrados. Favor volte mais tarde :)", E_USER_NOTICE);
            else:

                foreach ($Read->getResult() as $Interview):
                    extract($Interview);

                        ?>
                        <div class="col-md-6 col-lg-4 ftco-animate">
                            <div class="blog-entry align-content-stretch"">
                                <!--a class="block-20 d-flex align-items-end img" href="#"
                                   style="background-image: url('<?= BASE; ?>/uploads/<?= $students_thumb; ?>');"-->

                                <?php
                                setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                date_default_timezone_set('America/Sao_Paulo');
                                $interview_date = new DateTime($interview_date);
                                ?>


                                <div class="text p-4" style="border: 1px solid #ccc!important; border-radius: 16px;">
                                    <h5 class="heading" style="font-size: 16px;">
                                        <a title="Detalhes da defesa <?= $students_name; ?>" href="<?= BASE; ?>/defesa/<?= $interview_link; ?>"> <?= $students_name; ?><br></a>
                                    </h5>
                                    <p><?=$interview_type_name;?></p>
                                    <p><strong>Data:</strong> <?= $interview_date->format('d/m/Y');?> <span class="ml-4"><strong>Horário:</strong> <?=$interview_date->format('H:i');?></span></p>
                                    <p><strong>Local: </strong><?= ($interview_local ? $interview_local : "---");?></p>

                                    <div class="d-flex align-items-center mt-4">

                                        <p class="mb-0">
                                            <a title="Detalhes da defesa <?= $students_name; ?>" class="btn btn-primary" href="<?= BASE; ?>/defesas/<?= $interview_link; ?>">
                                                 Detalhes &nbsp;
                                                <span class="ion-ios-arrow-round-forward"></span>
                                            </a>
                                        </p>
                                        <p class="ml-auto mb-0">
                                            <!--a class="mr-2" href="#">Proficam</a>
                                            <a class="meta-chat" href="#"><span class="icon-chat"></span> 3</a-->
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php

                endforeach;
            endif;

            ?>

        </div>

    </div>

</section>
    <?php endif; ?>