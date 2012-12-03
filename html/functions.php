<script src="assets/cufonjs/cufon-yui.js" type="text/javascript"></script>
<script src="assets/fonts/idlewild-light_300.font.js" type="text/javascript"></script>
<script type="text/javascript">
Cufon.replace('.menu2 ul li a', {fontFamily: 'idlewild-light'});
Cufon.replace('.pagehead-container .title', {fontFamily: 'idlewild-light'});
Cufon.replace('.menu ul li a', { fontFamily: 'idlewild-light' });
Cufon.replace('.menu2 ul li a', {fontFamily: 'idlewild-light'});
Cufon.replace('.singlehead-container .single-title', {fontFamily: 'idlewild-light'});
Cufon.replace('.singlehead-container .back-button-container', {fontFamily: 'idlewild-light'});
</script>

<?php 
	function _header(){
		include("header.php");	
	}
	
	function header_products(){ ?>
					<div class="header">
                	<div class="logo-container">
                    	<a href="index.php"><img src="images/logo.png"></a>
                    </div>
                  
                    
                    <div class="menu2">
                     	<ul>
                    	<li><a href="#">About</a></li>
                        <li class="active">
                        <a href="products.php">Products</a>
                            <ul>
								<li><a href="collections.php">Collection</a></li>
                                <li><a href="#">Furniture</a></li>
                                <li><a href="#">Luxury Home</a></li>
                                <li><a href="#">Private Commissions</a></li>                          
                            </ul>
                        </li>
                        <li><a href="#">News + Press</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    </div>
            </div>
       
	<?php }
	
	function _footer(){
		include("footer.php");	
	}
	
	function _slider(){
		include("slider.htm");	
	}
?>