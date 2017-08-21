<?php $data = $this->_ci_cached_vars; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title><?php echo isset($section["title"]) ? $section["title"] . ' - ' . $this->config->item('site_nome') : $this->config->item('site_slogan') . ' - ' . $this->config->item('site_nome'); ?></title>
    <!--Meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo isset($section["description"]) ? $section["description"] : $this->config->item('site_description'); ?>">
    <meta name="author" content="Luciano Souza - 89dev">

    <meta name="google-site-verification" content="DUpvnuyLQXEMfeUSz9LVbKOLbXDi0NpybNaj9i_EIqA" />

    <meta property="og:title" content="<?php echo isset($section["title"]) ? $section["title"] . ' - ' . $this->config->item('site_nome') : $this->config->item('site_slogan') . ' - ' . $this->config->item('site_nome'); ?>"/>
    <?php
    if(isset($section["image"]) && !empty($section["image"])){
        ?>
        <meta property="og:image" content="<?php echo strpos($section["image"], '//') === false ? base_url($section["image"]) : $section["image"]; ?>" />
        <?php
    }
    ?>
    <meta property="og:site_name" content="<?php echo $this->config->item('site_nome'); ?>" />
    <meta property="og:description" content="<?php echo isset($section["description"]) ? $section["description"] : $this->config->item('site_description'); ?>" />

    <?php
    if(isset($section["canonical"]) && !empty($section["canonical"])){
        ?>
        <link rel="canonical" href="<?php echo $section["canonical"]; ?>" />
        <?php
    }
    ?>


    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_asset('img/favicon/apple-touch-icon-57x57.png'); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_asset('img/favicon/apple-touch-icon-114x114.png'); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_asset('img/favicon/apple-touch-icon-72x72.png'); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_asset('img/favicon/apple-touch-icon-144x144.png'); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_asset('img/favicon/apple-touch-icon-120x120.png'); ?>" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_asset('img/favicon/apple-touch-icon-152x152.png'); ?>" />
    <link rel="icon" type="image/png" href="<?php echo get_asset('img/favicon/favicon-32x32.png'); ?>" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo get_asset('img/favicon/favicon-16x16.png'); ?>" sizes="16x16" />
    <meta name="application-name" content="Mediz Imóveis"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="<?php echo get_asset('img/favicon/mstile-144x144.png'); ?>" />

    <link href="<?php echo get_asset('css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_asset('css/bootstrap-select.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_asset('css/font-awesome.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_asset('css/owl.carousel.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_asset('css/jquery-ui.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_asset('css/styles.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_asset('css/options.css'); ?>" rel="stylesheet" type="text/css" />
    <?php
    if(isset($assets["styles"]) && !empty($assets["styles"])){
      foreach($assets["styles"] as $index => $style){
        $style_src = strpos($style, '//') === false ? get_asset($style) . '?v=' . $this->config->item('site_versao') : $style;
        ?><link href="<?php echo $style_src; ?>" rel="stylesheet" type="text/css" media="screen" /><?php
      }
    }
    ?>
</head>
<?php
$body_class = array();

if(isset($section["body_class"])){
    $body_class = array_merge($body_class, (is_array($section["body_class"]) ? $section["body_class"] : explode(' ', $section["body_class"])));
}

?>
<body<?php echo isset($section["body_id"]) && !empty($section["body_id"]) ? ' id="' . $section["body_id"] . '"' : null; echo !empty($body_class) ? ' class="'. implode(' ', $body_class) .'"' : ''; ?>>
    <button class="btn scrolltop-btn back-top"><i class="fa fa-angle-up"></i></button>
    <?php $this->load->view('site/modal.php', $data); ?>
    <?php $this->load->view('site/modal.php', $data); ?>
    <?php $this->load->view('site/header.php', $data); ?>

    <?php echo $content; ?>

    <?php $this->load->view('site/footer.php', $data); ?>

    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '1830187297238353',
          cookie     : true,
          xfbml      : true,
          version    : 'v2.9'
        });
        FB.AppEvents.logPageView();
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-4536348-22']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>

    <script src="<?php echo get_asset('js/LAB.min.js'); ?>"></script>
    <script>
        paceOptions = {
           ajax: {
                 trackMethods: ['GET', 'POST', 'DELETE', 'PUT', 'PATCH']
           }
        }
    </script>
    <script>
        $LAB
        .script("<?php echo get_asset('js/jquery.js'); ?>").wait()
        .script("<?php echo base_url('configjs'); ?>").wait()
        .script("<?php echo get_asset('js/pace.min.js'); ?>").wait()
        .script("<?php echo get_asset('js/modernizr.custom.js'); ?>").wait()
        .script("<?php echo get_asset('js/bootstrap.min.js'); ?>").wait()
        .script("<?php echo get_asset('js/owl.carousel.min.js'); ?>").wait()
        .script("<?php echo get_asset('js/jquery.matchHeight-min.js'); ?>").wait()
        .script("<?php echo get_asset('js/bootstrap-select.js'); ?>").wait()
        .script("<?php echo get_asset('js/jquery-ui.min.js'); ?>").wait()
        .script("<?php echo get_asset('js/isotope.pkgd.min.js'); ?>").wait()
        .script("<?php echo get_asset('js/jquery.nicescroll.js'); ?>").wait()
        .script("<?php echo get_asset('js/jquery.parallax-1.1.3.js'); ?>").wait()
        .script("<?php echo get_asset('js/jquery.validate.min.js'); ?>").wait()
        .script("<?php echo get_asset('js/additional-methods.min.js'); ?>").wait()
        .script("<?php echo get_asset('js/jquery.form.js'); ?>").wait()
        .script("<?php echo get_asset('js/mustache.min.js'); ?>").wait()
        .script("<?php echo get_asset('js/pages/account.js'); ?>").wait()
        <?php
        if(isset($assets["scripts"]) && !empty($assets["scripts"])){
            foreach($assets["scripts"] as $index => $script){
                $src = strpos($script[0], '//') === false ? get_asset($script[0]) . '?v=' . $this->config->item('site_versao') : $script[0];
                ?>.script("<?php echo $src; ?>")<?php if(isset($script[1]) && $script[1] == true){ ?>.wait(function(){<?php if(isset($script[2])){ ?><?php echo $script[2]; ?><?php } ?>})<?php } ?><?php
            }
        }
        ?>
        .script("<?php echo get_asset('js/custom.js'); ?>").wait();
    </script>
</body>
</html>
