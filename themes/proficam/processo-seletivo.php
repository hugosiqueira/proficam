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
$Read->ExeRead(DB_SELECTION_PROCESS, "WHERE selection_process_status = :status", "status=1");
extract($Read->getResult()[0]);
?>

<section class="ftco-section  py-5">

    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <h2 class="mb-4"><span>Processo Seletivo</span> <?=$selection_process_year?></h2>
                <p class="text-dark">Confira todos os detalhes do nosso processo seletivo</p>
            </div>
        </div>
        <div class="row">
            <h3 class="mb-1"><span>Últimas Notícias</span></h3>
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
            <h3 class="mb-1"><span>Cronograma</span></h3>
                <article class="wc_tab_target wc_active" id="profile">
                    <div class="panel">
                        <div style="overflow-x:auto;">
                            <table class="styled-table">
                                <thead>
                                <tr>
                                    <th>Programação</th>
                                    <th>Data</th>
                                    <th>Local</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $querySelectionSchedule = "SELECT * FROM ". DB_SELECTION_PROCESS_SCHEDULE. " p";
                                $querySelectionSchedule .= " LEFT JOIN " . DB_SELECTION_PROCESS . " s ON p.schedule_selection_process = s.selection_process_id";
                                $querySelectionSchedule .= " WHERE s.selection_process_id = :id  ORDER BY schedule_initial_date";
                                $Read->FullRead($querySelectionSchedule, "id={$selection_process_id}");
                                if ($Read->getResult()):
                                    foreach ($Read->getResult() as $Schedule):
                                        extract($Schedule);
                                        ?>

                                        <tr>
                                            <td><?=$schedule_name;?></td>
                                            <td><?=($schedule_initial_date ? date('d/m/Y', strtotime($schedule_initial_date)) : "") . ($schedule_final_date&& $schedule_final_date !='0000-00-00 00:00:00' ? " a " . date('d/m/Y', strtotime($schedule_final_date)) : "");?></td>
                                            <td><?=$schedule_local;?></td>
                                        </tr>
                                    <?php endforeach;
                                endif;
                                ?>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </article><
        </div>

    </div>

</section>
