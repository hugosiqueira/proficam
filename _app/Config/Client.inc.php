<?php

if (!$WorkControlDefineConf):

    /*
     * SITE CONFIG
     */
    define('SITE_NAME', 'PROFICAM'); //Nome do site do cliente
    define('SITE_SUBNAME', 'Instrumentação, Controle e Automação de Processos de Mineração'); //Nome do site do cliente
    define('SITE_DESC', 'O Programa de Pós-Graduação Profissional em Instrumentação, Controle e Automação de Processos de Mineração (PROFICAM), coordenado em associação no âmbito do convênio firmado entre a Universidade Federal de Ouro Preto e o Instituto Tecnológico Vale - UFOP/ITV, visa atender à demanda da empresa do setor mineral e fomentar a sinergia entre o estudo investigativo, o desenvolvimento tecnológico, a inovação, a produção e a indústria.'); //Descrição do site do cliente

    define('SITE_FONT_NAME', 'Montserrat'); //Tipografia do site (https://www.google.com/fonts)
    define('SITE_FONT_WHIGHT', '300,400,600,700,800'); //Tipografia do site (https://www.google.com/fonts)

    /*
     * CONFIGURAÇÕES DA PÁGINA INICIAL
     * */

    define('SITE_SERVICES_1', 'Corpo Docente'); //SERVIÇO 1 OFERECIDO
    define('SITE_SERVICES_1_DESC', 'Nosso programa conta com professores qualificados para te orientar com um conteúdo atualizado.');
    define('SITE_SERVICES_2', 'Integração com a Indústria'); //SERVIÇO 2 OFERECIDO
    define('SITE_SERVICES_2_DESC', 'Nossos alunos saem preparados para atuar diretamente na indústria, veja alguns cases.'); //SERVIÇO 2 OFERECIDO
    define('SITE_SERVICES_3', 'Dissertações'); //SERVIÇO 3 OFERECIDO
    define('SITE_SERVICES_3_DESC', 'Veja todas dissertações que já foram apresentadas em nosso programa.'); //SERVIÇO 2 OFERECIDO
    define('SITE_SERVICES_4', 'Infraestrutura'); //SERVIÇO 4 OFERECIDO
    define('SITE_SERVICES_4_DESC', 'Nossos laboratórios contam com as mais novas tecnologias existentes e nossa biblioteca com todo material necessário para sua pesquisa'); //SERVIÇO 2 OFERECIDO



    /*
     * SHIP CONFIG
     * DADOS DO SEU CLIENTE/DONO DO SITE
     */
    define('SITE_ADDR_NAME', 'PROFICAM'); //Nome de remetente
    define('SITE_ADDR_RS', 'Instituto Tecnológico Vale'); //Razão Social
    define('SITE_ADDR_EMAIL', 'ensino.itvmi@itv.org'); //E-mail de contato
    define('SITE_ADDR_SITE', 'proficam.ufop.br'); //URL descrita
    define('SITE_ADDR_CNPJ', '00.000.000/0000-00'); //CNPJ da empresa
    define('SITE_ADDR_IE', '000/0000000'); //Inscrição estadual da empresa
    define('SITE_ADDR_PHONE_A', '(31) 3552- 7352'); //Telefone 1
    define('SITE_ADDR_PHONE_B', '(31) 3552-7376'); //Telefone 2
    define('SITE_ADDR_ADDR', 'Rua Professor Paulo Magalhães, S/N - Conj. Laboratórios da Escola de Minas, UFOP'); //ENDEREÇO: rua, número (complemento)
    define('SITE_ADDR_CITY', 'Ouro Preto'); //ENDEREÇO: cidade
    define('SITE_ADDR_DISTRICT', 'Morro do Cruzeiro'); //ENDEREÇO: bairro
    define('SITE_ADDR_UF', 'MG'); //ENDEREÇO: UF do estado
    define('SITE_ADDR_ZIP', '35400-000'); //ENDEREÇO: CEP
    define('SITE_ADDR_COUNTRY', 'Brasil'); //ENDEREÇO: País


    /**
     * Social Config
     */
    define('SITE_SOCIAL_NAME', 'PROFICAM');
    /*
     * Google
     */
    define('SITE_SOCIAL_GOOGLE', 0);
    define('SITE_SOCIAL_GOOGLE_AUTHOR', '0'); //https://plus.google.com/????? (**ID DO USUÁRIO)
    define('SITE_SOCIAL_GOOGLE_PAGE', '0'); //https://plus.google.com/???? (**ID DA PÁGINA)
    /*
     * Facebook
     */
    define('SITE_SOCIAL_FB', 0);
    define('SITE_SOCIAL_FB_APP', 0); //Opcional APP do facebook
    define('SITE_SOCIAL_FB_AUTHOR', '0'); //https://www.facebook.com/?????
    define('SITE_SOCIAL_FB_PAGE', '0'); //https://www.facebook.com/?????
    /*
     * Twitter
     */
    define('SITE_SOCIAL_TWITTER', ''); //https://www.twitter.com/?????
    /*
     * YouTube
     */
    define('SITE_SOCIAL_YOUTUBE', ''); //https://www.youtube.com/user/?????
    /*
     * Instagram
     */
    define('SITE_SOCIAL_INSTAGRAM', ''); //https://www.instagram.com/?????
    /*
     * Snapchat
     */
    define('SITE_SOCIAL_SNAPCHAT', ''); //https://www.snapchat.com/add/?????
endif;