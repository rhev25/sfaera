<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />


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
       