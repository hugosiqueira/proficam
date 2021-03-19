<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE;?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Corpo Docente</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Pessoas <i class="ion-ios-arrow-forward"></i></a></span> <span>Corpo Docente <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
            <?php
                $Read->ExeRead(DB_TEACHERS, "WHERE (teacher_status = :status OR teacher_status = :status2) ORDER BY teacher_name ASC", "status=1&status2=2");
                if (!$Read->getResult()):
                    echo Erro("Ainda Não existe professores. Favor volte mais tarde :)", E_USER_NOTICE);
                else:
                foreach ($Read->getResult() as $Professores):
                    extract($Professores);
                    $partes = explode(' ', $teacher_name);
                    $primeiroNome = array_shift($partes);
                    $ultimoNome = array_pop($partes);
                    $teacher_name = $primeiroNome . " ". $ultimoNome;
                ?>
                <div class="col col-md-4 col-lg-4 ftco-animate curriculo">
                    <div class="staff">
                        <div class="img-wrap d-flex align-items-stretch">
                            <div class="img align-self-stretch" style="background-image: url(<?= BASE; ?>/tim.php?src=<?= (!$teacher_thumb ? 'admin/_img/no_avatar.jpg' : 'uploads/'.$teacher_thumb); ?>&w=300&h=300););"></div>
                        </div>
                        <div class="text pt-3 text-center">
                            <h3><?= $teacher_name;?></h3>

                            <span class="position mb-2"><?= getTitle($teacher_title);?></span>
                            <div class="faded">
                                <?php if($teacher_productivity): ?>
                                    <p><strong><?=$teacher_scholarship;?></strong></p>
                                <?php endif; ?>

                                <!--p><?= $teacher_resume;?></p-->

                                <ul class="ftco-social text-center">
                                    <li class="ftco-animate">
                                        <a class="btn btn-sm btn-primary"  href="<?= BASE . "/professor/".$teacher_link;?>">Detalhes</a>
                                    </li>
                                    <!--li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                                    <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                    endif;
                ?>
                </div>
                <div class="clear"></div>
            </div>
            <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
            <div class="clear"></div>

        </div>
    </div>

</section>
