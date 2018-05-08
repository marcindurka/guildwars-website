<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Ordo Lupi Albi</title>
    <!--<link rel="stylesheet" href="assets/css/bootstrap.css">-->
    <link rel="stylesheet" href="<?php echo ROOT_URL?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL?>assets/css/globals.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL?>assets/css/fontello.css" type="text/css"/>
    <link rel="shortcut icon" href="<?php echo ROOT_URL?>assets/images/favicon.ico" type="image/vnd.microsoft.icon"/>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Lato&amp;subset=latin-ext" rel="stylesheet"/>
    <script type="text/javascript" src="assets/js/jquery-3.2.1.js"></script> 
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <meta name="description" content="Guild Wars"/>
    <meta name="keywords" content="Guild Wars" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
</head>
<body>
    <?php
        unset($previous_page);
        $uri = explode('/',$_SERVER['REQUEST_URI']);
        $page=count($uri)-1;
        //echo $page;
        $current_page=$uri[$page];
        $previous_page=$uri[$page-1];
        //echo $current_page;
        //echo $previous_page;
    ?>
    <header class="banner site">
        <!--<img src="<?php //echo ROOT_URL?>assets/images/banner-a.jpg" class="site"/>-->
        <?php if(isset($_SESSION['is_logged_in'])):?>
        <div class="logged-info">
            <div class="logged-info-inside">
                <div class="logged-info-inside-links"></div>
                <a href="<?php echo ROOT_URL; ?>users/profile">
                    <div class="logged-info-inside-links <?php if(($current_page=="profile")||($previous_page=="profile")): echo 'current-page'; endif;?>">
                    <?php echo $_SESSION['user_data']['name']." (".$_SESSION['user_data']['rank'].")";?>
                    </div>
                </a>
                <a href="<?php echo ROOT_URL; ?>users/settings" class="icon-cog logged-info-inside-links <?php if(($current_page)=="settings"): echo 'current-page'; endif;?>"></a>
                <?php if($_SESSION['user_data']['admin']==1):?>
                <a href="<?php echo ROOT_URL; ?>admin" class="icon-wrench logged-info-inside-links <?php if(($current_page)=="admin"): echo 'current-page'; endif;?>"></a>   
                <?php endif;?>
                <a href="<?php echo ROOT_URL; ?>users/logout" class="icon-logout logged-info-inside-links"></a>
                
            </div>
        </div>
        <?php else: 
          ?>
                <div class="logged-info">
                    <div class="logged-info-inside">
                       <a href="<?php echo ROOT_PATH; ?>users/login">Zaloguj się</a>
                    </div>
                </div>        
        <?php endif; ?>
    </header>
    <nav class="nav-main site">

        <ul class="nav-main-up">
            
            <li><a href="<?php echo ROOT_URL; ?>" class="icon-home <?php if($current_page!=("news"||"recruitment"||"history"||"recomended"||"contact")): echo "current-page"; endif;?>"></a></li>
            <li><a href="<?php echo ROOT_URL; ?>content/news" <?php if($current_page=="news"): echo 'class="current-page"'; endif;?>>Newsy</a></li>
            <li><a href="http://ordolupialbi.pl/forum/">Forum</a></li>
            <li><a href="<?php echo ROOT_URL; ?>content/recruitment"<?php if($current_page=="recruitment"): echo ' class="current-page"'; endif;?>>Rekrutacja</a></li>
            <li><a href="<?php echo ROOT_URL; ?>content/history"<?php if($current_page=="history"): echo ' class="current-page"'; endif;?>>Historia gildii</a></li>
            <li><a href="<?php echo ROOT_URL; ?>content/recomended"<?php if($current_page=="recomended"): echo ' class="current-page"'; endif;?>>Przydatne linki</a></li>
            <li><a href="<?php echo ROOT_URL; ?>content/contact"<?php if($current_page=="contact"): echo ' class="current-page"'; endif;?>>Kontakt</a></li>
        </ul>

    </nav>

    <div class="site">
            
            <?php require($view); ?>

    </div><!-- /.container -->
    <footer class="site">
        FOOTER
    </footer>

    
</body>
</html>