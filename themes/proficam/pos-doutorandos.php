<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE;?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Pós-Doutorandos</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE;?>">Pessoas <i class="ion-ios-arrow-forward"></i></a></span> <span>Pós-Doutorandos <i class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 ftco-animate">
                <div class ="row">
                    <?php
                    $Read->ExeRead(DB_STUDENTS, "WHERE students_status = :status AND students_degree = :degree GROUP BY students_class ORDER BY students_class DESC ", "status=1&degree=4");
                    if (!$Read->getResult()):
                        echo Erro("Ainda Não existe alunos cadastrados. Favor volte mais tarde :)", E_USER_NOTICE);
                    else:

                    foreach ($Read->getResult() as $Alunos):
                    extract($Alunos);
                    ?>
                    <div class="accordion " style="width:90%;" id="corpo-discente<?=$students_class;?>">
                        <a role="button"  data-toggle="collapse" data-target="#collapse<?=$students_class;?>" aria-expanded="false" aria-controls="collapse<?=$students_class;?>">

                            <div class="card">
                                <div class="card-header " id="heading<?=$students_class;?>">
                                    <h6>
                                        <span class="icon-plus"></span>
                                        Pós-doutorandos da turma de <?=getStudentsClass($students_class);?>

                                    </h6>
                                </div>
                        </a>

                        <div id="collapse<?=$students_class;?>" class="collapse" aria-labelledby="heading<?=$students_class;?>" data-parent="#corpo-discente<?=$students_class;?>">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Turma</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $Read2 = new Read();
                                        $Read2->ExeRead(DB_STUDENTS, "WHERE students_status = :status AND students_degree = :degree AND students_class = :class ORDER BY students_name ASC", "status=1&degree=4&class=$students_class");
                                        if (!$Read2->getResult()):
                                            echo Erro("Ainda Não existe alunos cadastrados. Favor volte mais tarde :)", E_USER_NOTICE);
                                        else:
                                            $i = 1;
                                            foreach ($Read2->getResult() as $Alunos2):
                                                extract($Alunos2);
                                                ?>
                                                <tr>
                                                    <th scope="row"><?= $i++;?></th>
                                                    <td><?=$students_name;?></td>
                                                    <td><?=getStudentsClass($students_class);?></td>
                                                </tr>
                                            <?php endforeach; endif; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <?php endforeach; endif; ?>
            </div>
        </div>
        <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
        <div class="clear"></div>
    </div>

    </div>
    </div>
</section>



