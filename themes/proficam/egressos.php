
<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
            $(this).prev(".card-header").find(".icon").addClass("icon-minus").removeClass("icon-plus");
            console.log("Entrou1");
        });

        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
            $(this).prev(".card-header").find(".icon").removeClass("icon-plus").addClass("icon-minus");
            console.log("Entrou2");
        }).on('hide.bs.collapse', function(){
            $(this).prev(".card-header").find(".icon").removeClass("icon-minus").addClass("icon-plus");
            console.log("Entrou23");
        });
    });
</script>
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE;?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Egressos</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE;?>">Pessoas <i class="ion-ios-arrow-forward"></i></a></span> <span>Corpo Discente <i class="ion-ios-arrow-forward"></i></span></p>
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
                    $Read->ExeRead(DB_STUDENTS, "WHERE students_status = :status GROUP BY students_class ORDER BY students_class DESC ", "status=2");
                    if (!$Read->getResult()):
                        echo Erro("Ainda Não existe alunos cadastrados. Favor volte mais tarde :)", E_USER_NOTICE);
                    else:
                    $i=0;

                        foreach ($Read->getResult() as $Alunos):
                            extract($Alunos);
                            ?>
                            <div class="accordion" style="width:99%;" id="corpo-discente<?=$students_class;?>">

                                <div class="card">
                                    <div class="card-header" id="heading<?=$students_class;?>">
                                        <h6>
                                            <a role="button" data-toggle="collapse" data-target="#collapse<?=$students_class;?>" aria-expanded="<?=($i === 0 ? 'true' : 'false');?>" aria-controls="collapse<?=$students_class;?>">
                                                <i class="icon icon-plus"></i>EGRESSOS DA TURMA DE <?=getStudentsClass($students_class);?>
                                            </a>
                                        </h6>
                                    </div>

                                    <div id="collapse<?=$students_class;?>" class="collapse<?=($i === 0 ? ' show' : '');?>" aria-labelledby="heading<?=$students_class;?>" data-parent="#corpo-discente<?=$students_class;?>">
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
                                                    $Read2->ExeRead(DB_STUDENTS, "WHERE students_status = :status  AND students_class = :class ORDER BY students_name ASC", "status=2&class=$students_class");
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
                                                        <?php
                                                        $i++;
                                                        endforeach;
                                                        endif; ?>

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
                <div class="row py-4">
                    <?php
                    $Read->ExeRead(DB_PAGE_COMPLEMENTS, "WHERE complement_name = :name AND complement_status= :status", "name=egressos&status=1");
                    if ($Read->getResult()):
                        foreach ($Read->getResult() as $complemento) {
                            extract($complemento);
                            echo $complement_text;
                        }


                    endif;
                    ?>
                </div>
            </div>
            <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
            <div class="clear"></div>
        </div>

    </div>
    </div>
</section>

