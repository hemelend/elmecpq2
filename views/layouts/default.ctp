<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Power Quality Domains Portal</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/aggregator.css?N" />

<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/book.css" />
<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/node.css" />
<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/poll.css" />
<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/defaults.css" />
<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/system.css" />
<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/system-menus.css" />
<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/user.css" />
<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/forum.css" />
<link type="text/css" rel="stylesheet" media="all" href="/elmecpq2/css/style.css" />
    
<!--[if IE]>
	<style type="text/css">
		.flash-for-ie { position:absolute;}
    	.ind-ie { padding-top:249px !important;}
    </style>
<![endif]-->
	<?php
		echo $html->meta('icon');
		echo $html->css('cake.generic');
		echo $scripts_for_layout;
	?>
	
    <script type="text/javascript" src="js/prototype.js"></script>
<!--    <script type="text/javascript" src="js/pMap.js"></script>-->
<!--    <script type="text/javascript" src="js/overlib.js"></script>-->

      
<!--  	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>-->
<!--	<script src="js/cufon-yui.js" type="text/javascript"></script>-->
<!---->
<!--    <script src="js/Myriad_Pro_400.font.js" type="text/javascript"></script>-->
<!--    <script src="js/cufon-replace.js" type="text/javascript"></script>-->

</head>
  
<body id="body">
<DIV ID="overDiv" STYLE="position:absolute; visibility:hidden; z-index:1000;"></DIV>
<!--<div id="loading" style="position:absolute; width:100%; text-align:center; top:350px;"><img src="img/loading10.gif" border=0></div>-->
<!--<script>-->
<!--var ld=(document.all);-->
<!--var ns4=document.layers;-->
<!--var ns6=document.getElementById&&!document.all;-->
<!--var ie4=document.all;-->
<!--if (ns4)-->
<!--ld=document.loading;-->
<!--else if (ns6)-->
<!--ld=document.getElementById("loading").style;-->
<!--else if (ie4)-->
<!--ld=document.all.loading.style;-->
<!--function init()-->
<!--{-->
<!--if(ns4){ld.visibility="hidden";}-->
<!--else if (ns6||ie4) ld.display="none";-->
<!--}-->
<!--</script>-->
	<div class="min-width">
        <div id="main">
        	<div class="border-left">
            	<div class="border-right">
                	<div class="border-top">
                    	<div class="border-bot">
                        	<div class="corner-top-left">
                            	<div class="corner-top-right">
                                	<div class="corner-bot-left">
                                    	<div class="corner-bot-right">                                        	
                                            <div id="header">
                                                <div class="head-row1">
                                                    <div class="search-box">

                                                        <!--<form action="#"  accept-charset="UTF-8" method="post" id="search-theme-form">
<div><input type="text" maxlength="128" name="search_theme_form" id="edit-search-theme-form-1" size="15" title="Enter the terms you wish to search for." class="form-text" /><input type="hidden" name="form_build_id" id="form-6a7119d92b7e6868707d4aa426fb8b84" value="form-6a7119d92b7e6868707d4aa426fb8b84"  />
<input type="hidden" name="form_id" id="edit-search-theme-form" value="search_theme_form"  />
<input type="submit" name="op" class="form-submit" value=" " />
</div></form>-->
                                                    </div>
                                                </div>
                                                <div class="head-row2">
                                                	<div class="col1">
                                                                                                                    <a href="index.php" title="Home"><img src="/elmecpq2/img/logo.jpg" alt="Home" class="logo" /></a>
                                                                                                                                                                                                                                                                                    </div>

                                                    <div class="col2">
                                                                                                                    <div class="pr-menu">
<ul class="links primary-links">
<li class="first menu-228"><a href="/elmecpq2/"><span  title="" class="menu-228"><span>Home Page</span></span></a></li>
<li class="menu-229"><a href="/elmecpq2/customers"><span  title="elmecpq2 " class="menu-209"><span>Customers</span></span></a></li>
<li class="menu-230"><a href="/elmecpq2/powerqs"><span  title="Power Quality at a Glance " class="menu-230"><span>PQuality</span></span></a></li>
<li class="menu-225"><a href="/elmecpq2/pages/about"><span  title="About us" class="menu-215"><span>About Us</span></span></a></li>
<li class="last menu-215"><a href="mailto:"><span  title="Email Solano Bernal" class="menu-215"><span>Contact Us</span></span></a></li>
</ul>                                                             </div>
                                                                                                            </div>

                                                </div>
                                            </div>                                                            
                                            <div id="cont">
                                            	<?php echo $session->flash(); ?>
												<?php echo $content_for_layout; ?>
                                            </div>
                                            <div class="clr"></div>
                                            <div id="footer">
                                              <div class="foot">
                                                     <span>Elmec S.A © <?php echo date('Y')?> San Jose, Costa Rica.  </span>
                                              </div>
                                            </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>                   
	        </div>
	    </div>
	</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7078796-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
