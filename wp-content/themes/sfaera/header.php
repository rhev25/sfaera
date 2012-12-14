<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<script src="<?php echo bloginfo('template_directory');?>/assets/fonts/idlewild_300-idlewild_400.font.js" type="text/javascript"></script>
<script src="<?php echo bloginfo('template_directory');?>/assets/fonts/idlewild-book_325.font.js" type="text/javascript"></script>
<script type="text/javascript">// <![CDATA[
Cufon.replace('#main_menu ul li a', {fontFamily: 'idlewild-book'});
Cufon.replace('.pagehead-container .title', {fontFamily: 'idlewild-book'});
Cufon.replace('#main_menu .sub-menu a', { fontFamily: 'idlewild-book' });
Cufon.replace('.singlehead-container .single-title', {fontFamily: 'idlewild-book'});
Cufon.replace('.back-button-container', {fontFamily: 'idlewild-book'});
Cufon.replace('.idlewild-font', {fontFamily: 'idlewild-book'});// ]]>
</script>

<div class="header">
        <div class="logo-container">
            <a href="<?php bloginfo('url');?>"> <?php

        echo "<img src='".get_bloginfo("template_directory")."/images/logo.png'>";

    ?></a>
        </div>
      
        
        <div id="main_menu">
         <?php include_once (dirname(__FILE__)."/ext/mainmenus.php") ?>
        </div>
</div>