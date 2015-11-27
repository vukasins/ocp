<!DOCTYPE html>
<html>
<head>
<title>Page title | Section name | Site name</title>

<!-- Meta -->
<meta name="Author" content="Some Author" />
<meta name="Keywords" content="some, key, words" />
<meta name="description" content="Description" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no;"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- CSS -->
<link rel="stylesheet" type="text/css" media="screen, projection" href="../css/default.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap-custom.css" />
<link rel="stylesheet" type="text/css" href="../css/slick.css" />
<link rel="stylesheet" type="text/css" href="../css/fancySelect.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 1200px)" href="../css/mobile.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-width: 1200px)" href="../css/component.css" />
<link rel="stylesheet" type="text/css" media="print" href="../css/print.css" />

<!-- Java Script -->
<script src="../jscript/jquery-1.11.2.min.js"></script>
<script src="../jscript/slick.min.js"></script>
<script src="../jscript/modernizr.custom.js"></script>
<script src="../jscript/jquery.dlmenu.js"></script>
<script src="../jscript/fancySelect.js"></script>
<script src="../jscript/custom.js"></script>
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

<!-- Icon -->
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/ico" />

<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../css/ie8.css" media="screen" /><![endif]-->
<!--[if IE 9]><link rel="stylesheet" type="text/css" href="../css/ie9.css" media="screen" /><![endif]-->
<!--[if lt IE 9]><script src="../jscript/html5.js"></script><![endif]-->

<?php if(isset($_GET['edit'])): ?>
        <script>
        	$(document).ready(function() {
        		$('.data-region').sortable({
    				iframeFix: true,
    		        forceHelperSize: true,
    		        connectWith: '.data-region',
    		        start: function(event, ui) {
        		        $('.data-region').each(function() {
            		        if(parseInt($(this).css('min-height')) <= 10)
        		        	{
            		        	$(this).data('old-min-height', $(this).css('min-height'));
            		        	$(this).data('old-background-color', $(this).css('background-color'));
            		        	
        		        		$(this).css('min-height', '250px');
        		        		$(this).css('background-color', 'red');
        		        	}
            		    });
            		},
    		        stop: function( event, ui ) {
    		        	$('.data-region').each(function() {
        		        	if($(this).css('background-color') == 'rgb(255, 0, 0)')
        		        	{
        		        		$(this).css('background-color', $(this).data('old-background-color'));
        		        		$(this).css('min-height', $(this).data('old-min-height'));

        		        		$(this).removeAttr('data-old-min-height');
        		        		$(this).removeAttr('data-old-background-color');
        		        	}
            		    });
            		            		        
        		        window.parent.updateWidgetOrder();
        		    }
    		    });

        		$('.data-region').disableSelection();
            });
        </script>
<?php endif; ?>

</head>

<body>
<header>
    <div class="headerBox">
        <div class="within">
        	<div class="subHolder">
            	<div class="langNav">
                    <select class="langSelect">
                    	<option value="1">Language (English)</option>
                        <option value="2">Language (Srpski)</option>
                        <option value="3">Language (Српски)</option> 
                        <!--<option value="4">Language (Русский)</option> 
                        <option value="5">Language (Français)</option>
                        <option value="6">Language (Italiano)</option> 
                        <option value="7">Language (Español)</option> 
                        <option value="8">Language (Deutsch)</option> 
                        <option value="9">Language (中文)</option>
                        <option value="10">Language (日本語)</option>-->           
                     </select>  
                </div>
                <div class="topNav">
                    <a href="#">News</a>
                    <a href="#">Newsletter</a>
                    <a href="#">About us</a>
                    <a href="#">Contact</a>
                </div>
                <div class="topSearch">
                	<form class="search" id="formQuery_inner" method="get" action="/насловна.13.html">
                        <button name="" type="submit"></button>
                        <input type="text" id="search" name="search_text" placeholder="Type in your keyword...">
                    </form>
                </div>
            </div>
            <div class="logoHolder">
                <a href="#"><img src="../images/basic/logo.png" alt="Site name"></a>
            </div>
            <div class="topSoc">
            	<p>Folow us on<br /> Social networks</p>
                <a href="#" class="fb"><span class="fa fa-facebook"></span></a>
                <a href="#" class="tw"><span class="fa fa-twitter"></span></a>
                <a href="#" class="in"><span class="fa fa-linkedin"></span></a>
            </div>
        </div>
        
        <div class="navBox">
        	<!--<div class="within">-->
            	<!--<div class="primNav">-->
                    <div id="mainMenu">
                        <ul>
                            <li><a href="#"><span>Home</span></a>
                                <div class="dropdown">
                                    <div class="dd-inner">
                                        <div class="column">
                                        	<a href="#"><img src="../images/basic/tmp/v1.jpg"></a>
                                            <h3><a href="#">Lorem Ipsum</a></h3>
                                            <a href="#">Dolor sit amet</a>
                                            <a href="#">Consectetur elit</a>
                                            <a href="#">Etiam massa</a>
                                            <a href="#">Suscipit sapien</a>
                                            <a href="#">Quis turpis</a>
                                            <a href="#">Web Menu Builder</a>
                                            <a href="#">Quos torpusior</a>
                                            <a href="#">Velit a dapibus</a>
                                        </div>
                                        <div class="column">
                                        	<a href="#"><img src="../images/basic/tmp/v1.jpg"></a>
                                            <h3><a href="#">Etiam Massa</a></h3>
                                            <a href="#">Sed interdum</a>
                                            <a href="#">Fringilla congue</a>
                                            <a href="#">Dolor nisl auctor</a>
                                            <a href="#">Quisque dictum</a>
                                            <a href="#">Porttitor</a>
                                            <a href="#">Tellus ullamcorper</a>
                                            <a href="#">Orci quis</a>
                                        </div>
                                        <div class="column">
                                        	<a href="#"><img src="../images/basic/tmp/v1.jpg"></a>
                                            <h3><a href="#">Lorem Ipsum</a></h3>
                                            <a href="#">Dolor sit amet</a>
                                            <a href="#">Consectetur elit</a>
                                            <a href="#">Etiam massa</a>
                                            <a href="#">Suscipit sapien</a>
                                            <a href="#">Quis turpis</a>
                                            <a href="#">Web Menu Builder</a>
                                            <a href="#">Quos torpusior</a>
                                            <a href="#">Velit a dapibus</a>
                                        </div>
                                        <div class="column">
                                        	<a href="#"><img src="../images/basic/tmp/v1.jpg"></a>
                                            <h3><a href="#">Lorem Ipsum</a></h3>
                                            <a href="#">Dolor sit amet</a>
                                            <a href="#">Consectetur elit</a>
                                            <a href="#">Etiam massa</a>
                                            <a href="#">Suscipit sapien</a>
                                            <a href="#">Quis turpis</a>
                                            <a href="#">Web Menu Builder</a>
                                            <a href="#">Quos torpusior</a>
                                            <a href="#">Velit a dapibus</a>
                                        </div>
                                        <div class="column">
                                        	<a href="#"><img src="../images/basic/tmp/v1.jpg"></a>
                                            <h3><a href="#">Lorem Ipsum</a></h3>
                                            <a href="#">Dolor sit amet</a>
                                            <a href="#">Consectetur elit</a>
                                            <a href="#">Etiam massa</a>
                                            <a href="#">Suscipit sapien</a>
                                            <a href="#">Quis turpis</a>
                                            <a href="#">Web Menu Builder</a>
                                            <a href="#">Quos torpusior</a>
                                            <a href="#">Velit a dapibus</a>
                                        </div>
                                        <div class="column">
                                        	<a href="#"><img src="../images/basic/tmp/v1.jpg"></a>
                                            <h3><a href="#">Lorem Ipsum</a></h3>
                                            <a href="#">Dolor sit amet</a>
                                            <a href="#">Consectetur elit</a>
                                            <a href="#">Etiam massa</a>
                                            <a href="#">Suscipit sapien</a>
                                            <a href="#">Quis turpis</a>
                                            <a href="#">Web Menu Builder</a>
                                        </div>
                                        <a href="#" class="all">View all</a>
                                    </div>
                                    
                                </div>
                            </li>
                            <li class="active"><a href="#"><span>Why Serbia</span></a></li>
                            <li><a href="#"><span>Destinations</span></a></li>
                            <li><a href="#"><span>Service providers</span></a></li>
                            <li><a href="#"><span>Ideas for incentive trips</span></a></li>
                            <li><a href="#"><span>Publications</span></a></li>
                            <li><a href="#"><span>Request for proposalas</span></a></li>
                        </ul>
                    </div>
                </div>
                <div id="dl-menu" class="dl-menuwrapper" style="z-index: 1000">
                    <button class="dl-trigger">Open Menu</button>
                    <ul class="dl-menu">
                        <li class="menuItem"><a href="#">Home</a>
                            <ul class="dl-submenu">
                                <li class=""><a href="#">aaaaa</a></li>
                                <li class=""><a href="#">Nagradna igra</a></li>
                                <li class=""><a href="#">Dešavanja</a></li>
                            </ul>
                        </li>
                        <li class="menuItem"><a href="#">Why Serbia</a>
                            <ul class="dl-submenu">
                                <li class=""><a href="#">Katalog i partneri</a></li>
                                <li class=""><a href="#">Podnesite zahtev</a></li>
                                <li class=""><a href="#">Opšti uslovi i pravila</a></li>
                            </ul>
                        </li>
                        <li class="menuItem"><a href="#">Destinations</a>
                           <ul class="dl-submenu">
                                <li class=""><a href="#">O nama</a></li>
                                <li class=""><a href="#">Lekovi na recept</a></li>
                                <li class=""><a href="#">Galenski proizvodi</a></li>
                            </ul>
                        </li>
                        <li class="menuItem"><a href="#">Service providers</a>
                            <ul class="dl-submenu">
                                <li class=""><a href="#">Lice</a></li>
                                <li class=""><a href="#">Tijelo</a></li>
                                <li class=""><a href="#">Kosa</a></li>
                                <li class=""><a href="#">Mirisi</a></li>
                                <li class=""><a href="#">Dekorativa</a></li>
                                <li class=""><a href="#">Muška kozmetika</a></li>
                            </ul>
                        </li>
                        <li class="menuItem"><a href="#">Ideas for incentive trips</a>
                            <ul class="dl-submenu">
                                <li class=""><a href="#">Kozmetika</a></li>
                                <li class=""><a href="#">Pelene</a></li>
                            </ul>
                        </li>
                        <li class="menuItem"><a href="#">Publications</a>
                            <ul class="dl-submenu">
                                <li class=""><a href="#">O zdravoj hrani</a></li>
                                <li class=""><a href="#">Proizvodi</a></li>
                                <li class=""><a href="#">Recepti</a></li>
                            </ul>
                        </li>
                        <li class="menuItem"><a href="#">Request for proposalas</a>
                            <ul class="dl-submenu">
                                <li class=""><a href="#">Kućni ljubimci</a></li>
                                <li class=""><a href="#">Publications</a></li>
                                <li class=""><a href="#">Bižuterija</a></li>
                            </ul>
                        </li>
                    </ul>
                <!--</div>-->
            <!--</div>-->
        </div>
    </div>
</header>
<!-- /header -->
<section class="slider">
	<div class="slickSlider">
    	<div class="photo">
       		<img src="../images/basic/empty.gif" style="background:url(../images/basic/tmp/slide-1.jpg)">
            <div class="within">
            	<div class="capiton">
                	<h2 class="title red-txt">Why choose Serbia for your convention?</h2>
                    <ul>
                    	<li><i class="fa fa-check-circle-o"></i> Serbia is in the centre of Europe</li>
                        <li><i class="fa fa-check-circle-o"></i> It has great road and airplane connectivity</li>
                        <li><i class="fa fa-check-circle-o"></i> It has lots of  activities planned outside the convention</li>
                    </ul>
                    <p class="lead">Find your perfect convention centre in the search form below.</p>
                </div>
            </div>
        </div>
        <div class="photo">
       		<img src="../images/basic/empty.gif" style="background:url(../images/basic/tmp/slide-2.jpg)">
            <div class="within">
            	<div class="capiton">
                	<h2 class="title red-txt">Why choose Serbia for your convention?</h2>
                    <ul>
                    	<li><i class="fa fa-check-circle-o"></i> Serbia is in the centre of Europe</li>
                        <li><i class="fa fa-check-circle-o"></i> It has great road and airplane connectivity</li>
                        <li><i class="fa fa-check-circle-o"></i> It has lots of  activities planned outside the convention</li>
                    </ul>
                    <p class="lead">Find your perfect convention centre in the search form below.</p>
                </div>
            </div>
        </div>
        <div class="photo">
       		<img src="../images/basic/empty.gif" style="background:url(../images/basic/tmp/slide-3.jpg)">
            <div class="within">
            	<div class="capiton">
                	<h2 class="title red-txt">Why choose Serbia for your convention?</h2>
                    <ul>
                    	<li><i class="fa fa-check-circle-o"></i> Serbia is in the centre of Europe</li>
                        <li><i class="fa fa-check-circle-o"></i> It has great road and airplane connectivity</li>
                        <li><i class="fa fa-check-circle-o"></i> It has lots of  activities planned outside the convention</li>
                    </ul>
                    <p class="lead">Find your perfect convention centre in the search form below.</p>
                </div>
            </div>
        </div>
        <div class="photo">
       		<img src="../images/basic/empty.gif" style="background:url(../images/basic/tmp/slide-4.jpg)">
            <div class="within">
            	<div class="capiton">
                	<h2 class="title red-txt">Why choose Serbia for your convention?</h2>
                    <ul>
                    	<li><i class="fa fa-check-circle-o"></i> Serbia is in the centre of Europe</li>
                        <li><i class="fa fa-check-circle-o"></i> It has great road and airplane connectivity</li>
                        <li><i class="fa fa-check-circle-o"></i> It has lots of  activities planned outside the convention</li>
                    </ul>
                    <p class="lead">Find your perfect convention centre in the search form below.</p>
                </div>
            </div>
        </div>
        <div class="photo">
       		<img src="../images/basic/empty.gif" style="background:url(../images/basic/tmp/slide-5.jpg)">
            <div class="within">
            	<div class="capiton">
                	<h2 class="title red-txt">Why choose Serbia for your convention?</h2>
                    <ul>
                    	<li><i class="fa fa-check-circle-o"></i> Serbia is in the centre of Europe</li>
                        <li><i class="fa fa-check-circle-o"></i> It has great road and airplane connectivity</li>
                        <li><i class="fa fa-check-circle-o"></i> It has lots of  activities planned outside the convention</li>
                    </ul>
                    <p class="lead">Find your perfect convention centre in the search form below.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="findBox">
	<div class="within">
    	<div class="findHolder">
        	<div class="headerFind">
            	<h1>Find a convention hall <span class="mag"><i class="fa  fa-angle-double-up"></i> <span>Advanced search</span></span> <span class="mag adv"><i class="fa  fa-angle-double-down"></i> <span>Simplify search</span></span></h1>
            </div>
            <div class="contentFind">
            	<form class="find-form">
                	<div class="formBox col-lg-3 col-md-6 col-sm-6 col-xs-12">
                		<p class="lab"><label>Location</label></p>
                        <div class="styled-select">
                            <select name="title" class="custom-form ">
                                <option value="">Belgrade</option>
                                <option>Novi Sad</option>
                                <option>Nis</option>
                                <option>Subotica</option>
                                <option>Zlatibor</option>
                            </select>
                        </div>
                    </div>
                    <div class="formBox col-lg-3 col-md-6 col-sm-6 col-xs-12">
                		<p class="lab"><label>Hall capacity</label></p>
                        <div class="styled-select">
                            <select name="title" class="custom-form ">
                                <option value="">Belgrade</option>
                                <option>Novi Sad</option>
                                <option>Nis</option>
                                <option>Subotica</option>
                                <option>Zlatibor</option>
                            </select>
                        </div>
                    </div>
                    <div class="formBox adv col-lg-3 col-md-6 col-sm-6 col-xs-12">
                		<p class="lab"><label>Room capacity</label></p>
                        <div class="styled-select">
                            <select name="title" class="custom-form ">
                                <option value="">Belgrade</option>
                                <option>Novi Sad</option>
                                <option>Nis</option>
                                <option>Subotica</option>
                                <option>Zlatibor</option>
                            </select>
                        </div>
                    </div>
                    <div class="formBox adv col-lg-3 col-md-6 col-sm-6 col-xs-12">
                		<p class="lab"><label>Sitting type</label></p>
                        <div class="styled-select">
                            <select name="title" class="custom-form ">
                                <option value="">Belgrade</option>
                                <option>Novi Sad</option>
                                <option>Nis</option>
                                <option>Subotica</option>
                                <option>Zlatibor</option>
                            </select>
                        </div>
                    </div>
                    <div class="formBox-full adv col-md-6 col-xs-12">
                    	<span class="type">Type</span>
                        <span><input type="checkbox" /> <label>Convention centres</label> </span>
                        <span><input type="checkbox" /><label>Special venues</label> </span>
                        <span><input type="checkbox" /><label>4 <i class="fa fa-star-o"></i> Hotels</label> </span>
                        <span><input type="checkbox" /><label>5 <i class="fa fa-star-o"></i> Hotels</label> </span>
                    </div>
                    <div class="formBox btn">
                    	<button class="find"><span>Find a hall</span> <i class="fa fa-search "></i></button>
                    </div>
                </form>
            </div>
		</div>
    </div>
</section>

<section class="combinedBox">
	<div class="within no-padd">
    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 data-region" data-region-name="home_combined_box1">
    		<?php Page_Libraries_Widget::render('home_combined_box1'); ?>
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 data-region" data-region-name="home_combined_box2">
        	<?php Page_Libraries_Widget::render('home_combined_box2'); ?>
        </div>
    </div>
</section>

<section class="recommendBox top-hr">
	<div class="within no-padd">
        <div class="col-md-6 col-sm-6 data-region" data-region-name="recommendBox1_proposal">
        	<?php Page_Libraries_Widget::render('recommendBox1_proposal'); ?>
        </div>
        <div class="no-padd col-md-6 col-sm-6 data-region" data-region-name="recommendBox1_ideas">
        	<?php Page_Libraries_Widget::render('recommendBox1_ideas'); ?>
        </div>
    </div>
    <div class="within no-padd data-region">
		<div class="col-md-12 no-padd data-region" data-region-name="recommendBox2_publications">
			<?php Page_Libraries_Widget::render('recommendBox2_publications'); ?>
        </div>
    </div>
</section>
<section class="referenceBox">
	<div class="col-md-12">
        <h2 class="sectionTitle">Members</h2>
    </div>
	<div class="within">
    	<div class="slickCarousel">
          <div class="product red-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r15_c9.png">
                </div>
            </a>
          </div>
          <div class="product orange-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r15_c11.png">
                </div>
            </a>
          </div>
          <div class="product blue-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r15_c16.png">
                </div>
            </a>
          </div>
          <div class="product green-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r15_c24.png">
                </div>
            </a>
          </div>
          <div class="product red-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r15_c31.png">
                </div>
            </a>
          </div>
          <div class="product orange-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r18_c9.png">
                </div>
            </a>
          </div>
          <div class="product orange-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r18_c12.png">
                </div>
            </a>
          </div>
          <div class="product orange-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r18_c17.png">
                </div>
            </a>
          </div>
          <div class="product orange-bord">
          	<a href="#">
                <div class="imgHolder">
                    <img src="../images/basic/tmp/logos/_r19_c26.png">
                </div>
            </a>
          </div>
        </div>
    </div>
</section>

<footer>
	<div class="footerTop">
    	<div class="within">
        	<div class="logoHolder">
                <a href="#"><img alt="Site name" src="../images/basic/logo.png"></a>
            </div>
        	<div class="footerMenu">
                <div class="navHolder">
                    <ul id="navSec">
                        <h3 class="label">Why serbia</h3>
                        <li class=""><a href="#">Facts</a></li>
                        <li class=""><a href="#">Societ</a></li>
                        <li class=""><a href="#">History</a></li>
                        <li class=""><a href="#">People</a></li>
                        <li class=""><a href="#">Typically Serbian!</a></li>
                    </ul>
                </div>
                <div class="navHolder">
                    <ul id="navSec">
                        <h3 class="label">Destinations</h3>
                        <li class=""><a href="#">Belgrade</a></li>
                        <li class=""><a href="#">Novi Sad</a></li>
                        <li class=""><a href="#">Subitica / Palic Lake</a></li>
                        <li class=""><a href="#">Mountain Kopaonik</a></li>
                        <li class=""><a href="#">Mountain Zlatibor</a></li>
                        <li class=""><a href="#">Other locations</a></li>
                    </ul>
                </div>
                <div class="navHolder">
                    <ul id="navSec">
                        <h3 class="label">Service providers</h3>
                        <li class=""><a href="#">Hotels</a></li>
                        <li class=""><a href="#">Venues</a></li>
                        <li class=""><a href="#">Agencies</a></li>
                        <li class=""><a href="#">Other</a></li>
                    </ul>
                </div>
                <div class="navHolder">
                    <ul id="navSec">
                        <h3 class="label">Ideas for incentive trips</h3>
                        <li class=""><a href="#">Boost your adrenaline</a></li>
                        <li class=""><a href="#">Peace and Serenity of Nature</a></li>
                        <li class=""><a href="#">Urban Beats</a></li>
                        <li class=""><a href="#">We Learn from History</a></li>
                        <li class=""><a href="#">Your Dinner is served</a></li>
                    </ul>
                </div>
                 <div class="navHolder">
                    <ul id="navSec">
                        <h3 class="label">Publications</h3>
                        <li class=""><a href="#">Brochures</a></li>
                        <li class=""><a href="#">Development files</a></li>
                        <li class=""><a href="#">Logos</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footerBottom">
        <div class="within">
            <div class="copyrightHolder">
                <p class="copyright">© 2015 NTOS. All rights reserved.</p>
            </div>
                <div class="subMenu">
                	<ul>
                    	<li><a href="#">Contact</a></li>
                        <li><a href="#">About NTOS</a></li>
                        <li><a href="#">Terms of use</a></li>
                        <li><a href="#">Impressum</a></li>
                        <li><a href="#">Sitemap</a></li>
                    </ul>
                </div>
        </div>
    </div>
</footer>
</body>
<script>
	// slick Slider
	$(document).ready(function(){
	  $('.slickSlider').slick({
		autoplay:false,
		dots:true
	  });
	});
	// slick Carousel
	$(document).ready(function(){
		$('.slickCarousel').slick({
		  dots: false,
		  infinite: false,
		  speed: 300,
		  slidesToShow: 5,
		  slidesToScroll: 1,
		  responsive: [
			{
			  breakpoint: 1024,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
				infinite: true,
				dots: false
			  }
			},
			{
			  breakpoint: 600,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
		  ]
		});
	});
	// Mobile Menu
	$( document ).ready(function() {
		$( '#dl-menu' ).dlmenu();
	});
	// fancy Select
	$( document ).ready(function() {
		$('.langSelect').fancySelect();
	});
	// Search on
	$(document).ready(function(){
		$( '.mag' ).on( 'click', function() {
			$( '.findHolder' ).toggleClass( 'advanced' );
		});
	});
	// Over
	$(document).ready(function(){
		$( "#mainMenu ul li" ).hover(function() {
		  $( this ).addClass( 'over' );
		},function(){
       		$( this ).removeClass( 'over' );
		});
	});
	
</script>

</html>
