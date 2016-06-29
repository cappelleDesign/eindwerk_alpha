<?php
$viewRoot = Globals::getRoot('view', 'app');
$base = Globals::getBasePath();
$design = $viewRoot . '/images/design';
$title = 'Neoludus | Home';
$desc = 'Neoludus is THE website about gaming. We have been gamers for decennia and thought it was time to pass our knowledge!'
        . ' Neoludus, where press play\'s';
$tags = 'Neoludus, gaming, reviews, review, game, games, podcast, podcasts, streaming, twitch, live stream, press, press plays';
$img = Globals::getRoot('img', 'app', true) . 'design/official.png';
$url = $base;
?>
<base href="<?php echo $base ?>"/>
<meta charset="UTF-8">
<meta name="fragment" content="!">
<meta name="description" content="<?php echo $desc ?>">
<meta name="keywords" content="<?php echo $tags ?>">
<meta name="author" content="Neoludus">

<!--FACEBOOK OPENGRAPH-->
<meta property="og:title" content="<?php echo $title ?>">
<meta property="og:type" content="article">
<meta property="og:image" content="http://test.neoludus.com/application/view/images/design/official.png">
<meta property="og:url" content="<?php echo $url ?>">
<meta property="og:description" content="<?php echo $desc ?>">

<!--TWITTER CARD-->
<!--<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="url">
<meta name="twitter:title" content="title">
<meta name="twitter:description" content="max 200 char">
<meta name="twitter:image" content="image url from base">-->

<!--FAVICON-->
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $design ?>/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $design ?>/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $design ?>/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $design ?>/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $design ?>/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $design ?>/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $design ?>/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $design ?>/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $design ?>/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $design ?>/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $design ?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $design ?>/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $design ?>/favicon-16x16.png">
<link rel="manifest" href="<?php echo $design ?>/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo $design ?>/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<meta name="viewport" content="width=device-width, initial-scale=1">

<!--HTML5 RESET-->
<link href="<?php echo $viewRoot ?>/css/html5reset-1.6.1.css" rel="stylesheet">

<!--JQUERY UI-->
<!--<link href="<?php //echo $viewRoot  ?>/js/plugins/jqueryUI/jquery-ui.min.css" rel="stylesheet" type="text/css"/>-->

<!--BOOTSTRAP-->
<!--<link href="<?php //echo $viewRoot  ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!--SLICK SLIDER-->
<!--<link href="<?php // echo $viewRoot  ?>/js/plugins/slick-1.5.9/slick/slick.css" rel="stylesheet">-->
<!--<link href="<?php // echo $viewRoot  ?>/js/plugins/slick-1.5.9/slick/slick-theme.css" rel="stylesheet">-->

<!--CUSTOM SCROLLBAR-->
<!--<link href="<?php // echo $viewRoot  ?>/js/plugins/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.min.css" rel="stylesheet">-->

<!--SLICK NAV-->
<!--<link href="<?php // echo $viewRoot  ?>/js/plugins/slicknav/slicknav.min.css" rel="stylesheet" type="text/css"/>-->

<!--FONT AWESOME-->
<!--<link href="<?php // echo $viewRoot  ?>/fonts/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet">  use CDN when life -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
<link href="<?php echo $viewRoot ?>/fonts/font-awesome-4.5.0/css/font-awesome-animations.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo $viewRoot ?>/css/major.min.css">

<!--sUNITE-GALLERY-->
<!--<link href="<?php // echo $viewRoot  ?>/js/plugins/unite-gallery/css/unite-gallery.css" rel="stylesheet" type="text/css"/>-->

<!--SWAL-->
<!--<link href="<?php // echo $viewRoot  ?>/js/plugins/swal/sweetalert.css" rel="stylesheet" type="text/css"/>-->
<!--MAIN MARKUP-->
<!--<link href="<?php // echo $viewRoot  ?>/css/loader-styles.css" rel="stylesheet">-->
<!--<link href="<?php // echo $viewRoot  ?>/css/mainstyles.css" rel="stylesheet">-->
<script>document.write('<link href="<?php echo $viewRoot ?>/css/noscript-style-remover.css" rel="stylesheet">');</script>
<!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


<script>
    $scriptRoot = '<?php echo Globals::getRoot('view', 'sys') ?>';
    $viewRoot = '<?php echo Globals::getRoot('view', 'app') ?>';
    $viewRootServer = '<?php echo Globals::getRoot('view', 'app', true) ?>';
    $base = '<?php echo Globals::getBasePath(); ?>';
    $imgRoot = '<?php echo Globals::getRoot('img', 'app'); ?>';
</script>