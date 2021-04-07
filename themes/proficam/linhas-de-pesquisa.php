<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE; ?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Linhas de Pesquisa</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE; ?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="#">Linha de Pesquisa <i class="ion-ios-arrow-forward"></i></a></span> </p>
            </div>
        </div>
    </div>
</section>
<?php
if (!$Read):
    $Read = new Read;
endif;
if($URL[1]):
    $Read->ExeRead(DB_RESEARCH, "WHERE research_link = :nm  AND research_status = :status ", "nm={$URL[1]}&status=1");
    if (!$Read->getResult()):
        require REQUIRE_PATH . '/404.php';
        return;
    else:
        extract($Read->getResult()[0]);
    endif;
?>



<section class="ftco-section">
	<div class="container">
		<div class="row">
            <div class="col-lg-8 ftco-animate">
                <h2 class="mb-3"><?= $research_name; ?></h2>
                <?php
                if ($research_img):

                    echo "<img class='cover' title='{$research_name}' alt='{$research_name}' src='" . BASE . "/uploads/linhas_pesquisa/{$research_img}'/>";
                endif;
                ?>


                <div class="htmlchars text-justify">
                    <?= $research_description; ?>
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

    <section class="ftco-section py-5">
        <div class="container px-4">
            <div class="row justify-content-center mb-4 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">

                    <p>Nosso programa tem como área de concentração Instrumentação, Controle e Automação de Processos de Mineração e possui as seguintes linhas de pesquisa</p>
                </div>
            </div>
            <div class="row">
                <?php
                $Read->ExeRead(DB_RESEARCH, "WHERE research_status = :status ORDER BY research_name ASC", "status=1");
                if (!$Read->getResult()):
                    echo Erro("Ainda Não existe linhas de pesquisa cadastradas. Favor volte mais tarde :)", E_USER_NOTICE);
                else:
                    foreach ($Read->getResult() as $Pesquisa):
                        extract($Pesquisa);
                        ?>
                        <div class="col-md-3 col-lg-3 course ftco-animate">
                            <div class="img" style="background-image: url(<?= BASE; ?>/uploads/linhas_pesquisa/<?= $research_img ;?>);"></div>
                            <div class="text pt-4">
                                <h3><a href="#"><?= $research_name ;?></a></h3>
                                <p class="text-justify"><?= limita_caracteres( $research_description, 140, false );?></p>

                            </div>
                            <div class="embaixo">
                                <a class="btn btn-primary" href="<?= BASE . "/linhas-de-pesquisa/" .$research_link;?>">Saiba Mais &nbsp;<span
                                            class="ion-ios-arrow-round-forward"></span></a>
                            </div>


                        </div>

                    <?php endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>