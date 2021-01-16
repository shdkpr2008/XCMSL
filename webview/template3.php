<?php 
libxml_use_internal_errors(true);
$dom = new DOMDocument(); 
$dom->preserveWhiteSpace = false;
$dom->load($file); 
$errors = libxml_get_errors();
$dom->formatOutput = true;
if(empty($errors))
{
$XML = new SimpleXMLElement(stripslashes($dom->saveXML($dom->documentElement)));
$news = array();
foreach($XML->news->new as $value)
	array_push($news, (array)$value);

	if(isset($_GET["id"]))
	{
		$title = $title." - ".$news[$_GET["id"]]["titlenews"];
	}
?>
<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	
		<title><?php echo $title; ?></title>	

		<!-- Favicon -->
		<link rel="shortcut icon" href="templates/img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="templates/img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="templates/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="templates/vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="templates/vendor/animate/animate.min.css">
		<link rel="stylesheet" href="templates/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="templates/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="templates/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="templates/vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="templates/css/theme.css">
		<link rel="stylesheet" href="templates/css/theme-elements.css">
		<link rel="stylesheet" href="templates/css/theme-blog.css">
		<link rel="stylesheet" href="templates/css/theme-shop.css">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="templates/vendor/rs-plugin/css/settings.css">
		<link rel="stylesheet" href="templates/vendor/rs-plugin/css/layers.css">
		<link rel="stylesheet" href="templates/vendor/rs-plugin/css/navigation.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="templates/css/skins/skin-law-firm.css"> 

		<!-- Demo CSS -->
		<link rel="stylesheet" href="templates/css/demos/demo-law-firm.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="templates/css/custom.css">

		<!-- Head Libs -->
		<script src="templates/vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body>

		<div class="body">
			<header id="header" class="header-no-border-bottom" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 115, 'stickySetTop': '-115px', 'stickyChangeLogo': false}">
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="#">
										<img alt="Logo" width="194" height="100" data-sticky-width="82" data-sticky-height="40" data-sticky-top="33" src="<?php echo $app_info["logo_left"]; ?>">
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="header-container header-nav header-nav-bar header-nav-bar-primary">
						<div class="container">
							<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
								Menu <i class="fa fa-bars"></i>
							</button>
							<div class="header-nav-main header-nav-main-light header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
								<nav>
                                    <ul class="nav nav-pills" id="mainNav">
                                        <li class="<?php if($title == "INICIO") echo "active"; ?>">
                                            <a href="./inicio.php?appid=<?php echo $appid; ?>">
                                                INICIO
                                            </a>
                                        </li>
                                        <li class="<?php if($title == "CONEXIÓN") echo "active"; ?>">
                                            <a href="./conexion.php?appid=<?php echo $appid; ?>">
                                                CONEXIÓN
                                            </a>
                                        </li>
                                        <li class="<?php if($title == "NOSTROS") echo "active"; ?>">
                                            <a href="./nosotros.php?appid=<?php echo $appid; ?>">
                                                NOSTROS
                                            </a>
                                        </li>
                                        <li class="<?php if($title == "EVENTOS") echo "active"; ?>">
                                            <a href="./eventos.php?appid=<?php echo $appid; ?>">
                                                EVENTOS
                                            </a>
                                        </li>
                                        <li class="<?php if($title == "CONTACTO") echo "active"; ?>">
                                            <a href="./contacto.php?appid=<?php echo $appid; ?>">
                                                CONTACTO
                                            </a>
                                        </li>
                                    </ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div role="main" class="main">
            <?php if(isset($_GET["id"])) { ?>
				<div class="container">
					<div class="row pt-xl">
                    	<div class="col-md-12">
                           <img src="<?php echo $news[$_GET["id"]]["imageurl"]; ?>" alt="" height="465px" width="1440px" class="img-responsive custom-border-1 custom-box-shadow">
							<div class="blog-posts single-post mt-xl">
								<article class="post post-large blog-single-post">
									<div class="post-content">
										<h1><?php echo $news[$_GET["id"]]["titlenews"]; ?></h1>
										<div class="divider divider-primary divider-small mb-xl">
											<hr>
										</div>
										<p class="lead"><?php echo $news[$_GET["id"]]["descnews"]; ?></p>
									</div>
								</article>
							</div>
						</div>
					</div>
				</div>
            <?php } else { ?>
            <div class="slider-container rev_slider_wrapper" style="height: 600px;">
					<div id="revolutionSlider" class="slider rev_slider manual">
						<ul>
					<?php $slides = array();
                        foreach($XML->news->slideshow as $slideshow)
                            array_push($slides, (string)$slideshow->link);
                    
                        foreach($slides as $key => $value) { ?>
							<li data-transition="fade">
								<img src="<?php echo $value; ?>"  
									alt=""
									data-bgposition="center center" 
									data-bgfit="cover" 
									data-bgrepeat="no-repeat"
									class="rev-slidebg">
							</li>
                    <?php } ?>
						</ul>
					</div>
				</div>
                
				<div class="container">
					<div class="row">
						<div class="col-md-12 center">
							<h2 class="mt-xl mb-none">Contents</h2>
							<div class="divider divider-primary divider-small divider-small-center mb-xl">
								<hr>
							</div>
						</div>
					</div>
					<div class="row mt-xl">
                    
                    <?php foreach($news as $key => $new) { ?>
                    
                    	<div class="col-md-6">
							<span class="thumb-info thumb-info-side-image thumb-info-no-zoom mb-xl">
								<span class="thumb-info-side-image-wrapper p-none hidden-xs">
									<a title="<?php echo $new["titlenews"]; ?>" href="<?php echo basename($_SERVER['REQUEST_URI']) ?>&id=<?php echo $key; ?>">
										<img src="<?php echo $new["imageurl"]; ?>" class="img-responsive" alt="" style="width: 195px;">
									</a>
								</span>
								<span class="thumb-info-caption">
									<span class="thumb-info-caption-text">
										<h2 class="mb-md mt-xs"><a title="<?php echo $new["titlenews"]; ?>" class="text-dark" href="<?php echo basename($_SERVER['REQUEST_URI']) ?>&id=<?php echo $key; ?>"><?php echo $new["titlenews"]; ?></a></h2>
										<p class="font-size-md"><?php echo substr($new["descnews"], 0, 200);  ?>...</p>
										<a class="mt-md" href="<?php echo basename($_SERVER['REQUEST_URI']) ?>&id=<?php echo $key; ?>">Read More <i class="fa fa-long-arrow-right"></i></a>
									</span>
								</span>
							</span>
						</div>
                    <?php }?>
                    

					</div>
				</div>

		<?php } ?>
<!-- main container ends -->			</div>

			<footer class="short" id="footer">
				<div class="container">
					<div class="row">
						<div class="col-md-3 pull-left">
							<a href="#" class="logo mb-md">
								<img alt="Logo" class="img-responsive" width="97" height="32" src="<?php echo $app_info["logo_right"]; ?>">
							</a>
						</div>
						<div class="col-md-3 pull-right">
                            <ul class="social-icons custom-social-icons" style="margin-top:30px !important;">
                                <li class="social-icons"><a href="<?php echo $app_info["ios"]; ?>"><i class="fa fa-apple " ></i></a></li>
                                <li class="social-icons"><a href="<?php echo $app_info["android"]; ?>"><i class="fa fa-android " ></i></a></li>
                                <li class="social-icons-facebook"><a href="<?php echo $app_info["fb"]; ?>"><i class="fa fa-facebook-official " ></i></a></li>
                                <li class="social-icons-twitter"><a href="<?php echo $app_info["twitter"]; ?>"><i class="fa fa-twitter-square " ></i></a></li>
                                <li class="social-icons-instagram"><a href="<?php echo $app_info["insta"]; ?>"><i class="fa fa-instagram " ></i></a></li>
                                <li class="social-icons-youtube"><a href="<?php echo $app_info["youtube"]; ?>"><i class="fa fa-youtube-play " ></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<p>© Copyright 2017. All Rights Reserved.</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Vendor -->
		<script src="templates/vendor/jquery/jquery.min.js"></script>
		<script src="templates/vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="templates/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="templates/vendor/jquery-cookie/jquery-cookie.min.js"></script>
		<script src="templates/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="templates/vendor/common/common.min.js"></script>
		<script src="templates/vendor/jquery.validation/jquery.validation.min.js"></script>
		<script src="templates/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		<script src="templates/vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="templates/vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
		<script src="templates/vendor/isotope/jquery.isotope.min.js"></script>
		<script src="templates/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="templates/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="templates/vendor/vide/vide.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="templates/js/theme.js"></script>
		
		<!-- Current Page Vendor and Views -->
		<script src="templates/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="templates/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="templates/js/views/view.contact.js"></script>

		<!-- Demo -->
		<script src="templates/js/demos/demo-law-firm.js"></script>	
		
		<!-- Theme Custom -->
		<script src="templates/js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="templates/js/theme.init.js"></script>

	</body>
</html>
<?php } else { ?>
<p><strong>Missing or invalid linked xml file!</strong></p>
<?php } ?>