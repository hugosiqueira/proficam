
<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'alunos/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-profile" title="Alunos" href="dashboard.php?wc=alunos/home">Alunos</a>
    <ul class="dashboard_nav_menu_sub">
        <li class="dashboard_nav_menu_sub_li"> <a title="Novo Aluno" href="dashboard.php?wc=alunos/create">Novo Aluno</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Alunos" href="dashboard.php?wc=alunos/home&opt=1">Matriculados</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Alunos" href="dashboard.php?wc=alunos/home&opt=2">Egressos</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Alunos" href="dashboard.php?wc=alunos/home&opt=3">Desligados</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Alunos" href="dashboard.php?wc=alunos/home">Ver Todos Alunos</a></li>

    </ul>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'professores/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-user-tie" title="Professores" href="dashboard.php?wc=professores/home">Professores</a>
    <ul class="dashboard_nav_menu_sub">
        <li class="dashboard_nav_menu_sub_li"> <a title="Novo Professor" href="dashboard.php?wc=professores/create">Novo Professor</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Professores" href="dashboard.php?wc=professores/home">Ver Todos Professores</a></li>
    </ul>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'depoimentos/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-bubble2" title="Depoimentos" href="dashboard.php?wc=depoimentos/home">Depoimentos</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'defesas/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-checkbox-checked" title="Defesas" href="dashboard.php?wc=defesas/home">Defesas</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'faq/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-question" title="Perguntas Frequentes" href="dashboard.php?wc=faq/home">Perguntas Frequentes</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'gallery/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-image" title="Fotos" href="dashboard.php?wc=gallery/home">Fotos</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'hello/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-bullhorn" title="Avisos" href="dashboard.php?wc=hello/home">Avisos</a>
</li>