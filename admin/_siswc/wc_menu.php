<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'linhas/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-search" title="Linhas de Pesquisa" href="dashboard.php?wc=linhas/home">Linhas de Pesquisa</a>
</li>
<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'processo_seletivo/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-pencil" title="Processos Seletivos" href="dashboard.php?wc=processo_seletivo/home">Processos Seletivos</a>
</li>
<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'projetos/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-file-text" title="Projetos de Pesquisa" href="dashboard.php?wc=projetos/home">Projetos de Pesquisa</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'alunos/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-profile" title="Alunos" href="dashboard.php?wc=alunos/home">Alunos</a>
    <ul class="dashboard_nav_menu_sub">
        <li class="dashboard_nav_menu_sub_li"> <a title="Novo Aluno" href="dashboard.php?wc=alunos/create">Novo Aluno</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Pós-Doutorandos" href="dashboard.php?wc=alunos/home&d=4">Pós-Doutorandos</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Matriculados" href="dashboard.php?wc=alunos/home&opt=1&d=2">Matriculados</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Egressos" href="dashboard.php?wc=alunos/home&opt=2&d=2">Egressos</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Desligados" href="dashboard.php?wc=alunos/home&opt=3">Desligados</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Todos Alunos" href="dashboard.php?wc=alunos/home">Ver Todos Alunos</a></li>

    </ul>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'professores/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-user-tie" title="Professores" href="dashboard.php?wc=professores/home">Professores</a>
    <ul class="dashboard_nav_menu_sub">
        <li class="dashboard_nav_menu_sub_li"> <a title="Novo Professor" href="dashboard.php?wc=professores/create">Novo Professor</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Professores" href="dashboard.php?wc=professores/home">Ver Todos Professores</a></li>
    </ul>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'defesas/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-checkbox-checked" title="Defesas" href="dashboard.php?wc=defesas/home">Defesas</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'faq/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-question" title="Perguntas Frequentes" href="dashboard.php?wc=faq/home">Perguntas Frequentes</a>

    <ul class="dashboard_nav_menu_sub">
        <li class="dashboard_nav_menu_sub_li"> <a title="Perguntas Frequentes" href="dashboard.php?wc=faq/home">Ver Perguntas</a></li>
        <li class="dashboard_nav_menu_sub_li"> <a title="Categorias" href="dashboard.php?wc=faq/categories">Categorias</a></li>
    </ul>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'gallery/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-image" title="Fotos" href="dashboard.php?wc=gallery/home">Galerias de Imagens</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'services/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-checkbox-checked" title="Serviços" href="dashboard.php?wc=services/home">Serviços</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'hello/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-bullhorn" title="Avisos" href="dashboard.php?wc=hello/home">Avisos</a>
</li>


<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'depoimentos/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-bubble2" title="Depoimentos" href="dashboard.php?wc=depoimentos/home">Depoimentos</a>
</li>

<li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'complements/') ? 'dashboard_nav_menu_active' : ''; ?>">
    <a class="icon-plus" title="Complementos das Páginas" href="dashboard.php?wc=complements/home">Complementos das Páginas</a>
</li>