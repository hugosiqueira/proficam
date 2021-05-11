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
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Lattes</th>
                                <th scope="col">Supervisor</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $Read2 = new Read();
                            $Read2->ExeRead(DB_STUDENTS, "WHERE students_status = :status AND students_degree = :degree ORDER BY students_name ASC", "status=1&degree=4&");
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

                                        <td><a target="_blank" href="<?=$students_lattes;?>"><img src="<?= BASE;?>/_cdn/images/lattes.png" alt="Lattes do <?= $students_name;?>" title="Lattes do <?= $students_name;?>"></a></td>
                                        <td><?=($students_supervisor ? getTeacherName($students_supervisor) : "" );?></td>
                                    </tr>
                                <?php endforeach; endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div><div class="row py-4">
                    <?php
                    $Read->ExeRead(DB_PAGE_COMPLEMENTS, "WHERE complement_name = :name AND complement_status= :status", "name=pos-doutorandos&status=1");
                    if ($Read->getResult()):
                        foreach ($Read->getResult() as $complemento) {
                            extract($complemento);
                            echo $complement_text;
                        }

                    endif;
                    ?>
                </div>

            </div>
            <div class="clear"></div>

            <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
        </div>
    </div>

    <div class="clear"></div>
    </div>

</section>



