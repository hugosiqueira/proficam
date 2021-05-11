<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE; ?>/_cdn/images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Processos Seletivos em Andamento</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?= BASE; ?>">Início <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="processo-seletivo">Processos Seletivos <i class="ion-ios-arrow-forward"></i></a></span> </p>
            </div>
        </div>
    </div>
</section>
<?php
if (!$Read):
    $Read = new Read;
endif;

?>

<section class="ftco-section  py-5">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class=" text-center heading-section ftco-animate">
                <h2 class="mb-4"><span>Processo Seletivo</span> Encerrados</h2>
                <p class="text-dark">Confira os processos seletivos passados</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="py-4">
                    <div class=" heading-section ftco-animate">
                        <h3 class="mb-4"><span>Escolha o processo seletivo</span> </h3>
                    </div>
                    <div class="py-2">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <?php
                                $Read->ExeRead(DB_SELECTION_PROCESS, "WHERE selection_process_status=:status ORDER BY selection_process_year DESC", "status=2");

                                if ($Read->getResult()):
                                    $i=0;
                                    foreach ($Read->getResult() as $processo):
                                        extract($processo);
                                        ?>
                                        <a class="nav-item nav-link <?=($i==0 ? 'active' : '');?>" id="nav-<?=$selection_process_id?>-tab" data-toggle="tab" href="#nav-<?=$selection_process_id?>" role="tab" aria-controls="nav-<?=$selection_process_id?>" aria-selected="true"><?=$selection_process_year?></a>
                                        <?php
                                        $i++;
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <?php
                            $Read->ExeRead(DB_SELECTION_PROCESS, "WHERE selection_process_status=:status ORDER BY selection_process_year DESC", "status=2");
                            if ($Read->getResult()):
                                $j=0;
                                foreach ($Read->getResult() as $processos):
                                    extract($processos);
                                    ?>
                                    <div class="tab-pane fade show <?=($j==0 ? 'active' : '');?>" id="nav-<?=$selection_process_id?>" role="tabpanel" aria-labelledby="nav-<?=$selection_process_id?>-tab" >
                                        <div class="py-4">
                                            <h3 class="mb-1"><span>Informações, Edital e Resultados</span></h3>
                                            <table class="styled-table">
                                                <thead>
                                                <th width="70%">Descrição</th>
                                                <th width="120%">Publicação</th>
                                                <th width="10%" class="text-center">Arquivo</th>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $queryFiles = "SELECT * FROM ". DB_SELECTION_PROCESS_FILES. " p";
                                                $queryFiles .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.sp_files_selection_process = s.selection_process_id";
                                                $queryFiles .= " WHERE s.selection_process_id = :id  ORDER BY sp_files_publish DESC";
                                                $Read->FullRead($queryFiles, "id={$selection_process_id}");
                                                if ($Read->getResult()):
                                                    foreach ($Read->getResult() as $Files):
                                                        extract($Files);
                                                        ?>

                                                        <tr>
                                                            <td><?=$sp_files_name;?></td>
                                                            <td><?=($sp_files_publish ? date('d/m/Y', strtotime($sp_files_publish)) : "") ;?></td>
                                                            <td class="text-center"><a target="_blank" href="<?= BASE.'/uploads/'.$sp_files_link;?>"><span class="icon-file-pdf"></span></a></td>
                                                        </tr>
                                                    <?php endforeach;
                                                endif;
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                    $j++;
                                endforeach;

                            endif;
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <?php require REQUIRE_PATH . '/inc/sidebar_pag.php'; ?>
            <div class="clear"></div>
        </div>
    </div>
</section>
