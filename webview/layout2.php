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
		<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700%7CSintony:400,700" rel="stylesheet" type="text/css">

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
		<link rel="stylesheet" href="templates/css/skins/skin-church.css"> 

		<!-- Demo CSS -->
		<link rel="stylesheet" href="templates/css/demos/demo-church.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="templates/css/custom.css">

		<!-- Head Libs -->
		<script src="templates/vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body>
    		<div class="body">
			<header id="header" class="header-narrow" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 88, 'stickySetTop': '0px', 'stickyChangeLogo': false}">
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="#">
										<img alt="Porto" width="90" height="41" src="<?php echo $app_info["logo_left"]; ?>">
									</a>
								</div>
							</div>
							<div class="header-column">
								<div class="header-row">
									<div class="header-nav pt-xs">
										<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
											<i class="fa fa-bars"></i>
										</button>
										<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse m-none">
											<nav>
												<ul class="nav nav-pills" id="mainNav">
													<li class="<?php if($title == "INICIO") echo "active"; ?> dropdown-full-color dropdown-primary">
														<a href="./inicio.php?appid=<?php echo $appid; ?>">
															INICIO
														</a>
													</li>
													<li class="<?php if($title == "CONEXIÓN") echo "active"; ?> dropdown-full-color dropdown-primary">
														<a href="./conexion.php?appid=<?php echo $appid; ?>">
															CONEXIÓN
														</a>
													</li>
													<li class="<?php if($title == "NOSTROS") echo "active"; ?> dropdown-full-color dropdown-primary">
														<a href="./nosotros.php?appid=<?php echo $appid; ?>">
															NOSTROS
														</a>
													</li>
													<li class="<?php if($title == "EVENTOS") echo "active"; ?> dropdown-full-color dropdown-primary">
														<a href="./eventos.php?appid=<?php echo $appid; ?>">
															EVENTOS
														</a>
													</li>
													<li class="<?php if($title == "CONTACTO") echo "active"; ?> dropdown-full-color dropdown-primary">
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
						</div>
					</div>
				</div>
			</header>
			<div role="main" class="main">

				<div class="slider-container rev_slider_wrapper" style="height: 600px;">
					<div id="revolutionSlider" class="slider rev_slider manual">
						<ul>
					<?php $slides = array();
                        foreach($XML->news->slideshow as $slideshow)
                            array_push($slides, (string)$slideshow->link);
                    
                        foreach($slides as $key => $value) { ?>
							<li data-transition="fade">
								<img src="<?php echo $value; ?>"  
									alt="Proceed to the Next Steps"
									data-bgposition="center center" 
									data-bgfit="cover" 
									data-bgrepeat="no-repeat"
									class="rev-slidebg">
							</li>
                    <?php } ?>
						</ul>
					</div>
				</div>

				<section class="section section-no-border background-color-light m-none">
					<div class="container">
						<div class="row">
							<div class="col-md-12 col-sm-8 col-md-offset-0 col-sm-offset-2">
								<h2 class="font-weight-bold"></h2>
							</div>
						</div>
						<div class="row">
					<?php foreach($news as $key => $new) { ?>
							<div class="col-md-4 col-sm-8 col-md-offset-0 col-sm-offset-2 custom-sm-margin-bottom-1">
								<article class="custom-post-blog">
									<span class="thumb-info custom-thumb-info-2">
										<span class="thumb-info-wrapper">
											<a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>&id=<?php echo $key; ?>">
												<img src="<?php echo $new["imageurl"]; ?>" alt class="img-responsive" />
											</a>
										</span>
										<span class="thumb-info-caption custom-box-shadow">
											<span class="thumb-info-caption-text">
												<h4 class="font-weight-bold mb-lg">
													<a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>&id=<?php echo $key; ?>" class="text-decoration-none custom-secondary-font text-color-dark">
														<?php echo $new["titlenews"]; ?>
													</a>
												</h4>
												<p><?php echo substr($new["descnews"], 0, 200);  ?></p>
											</span>
										</span>
									</span>
								</article>
							</div>
                    <?php }?>
						</div>
					</div>
				</section>

			<footer id="footer" class="background-color-secondary custom-footer m-none" style="background: url('templates/img/demos/church/footer-bg.jpg'); background-size: cover;">
				<div class="container">
					<div class="row center">
						<div class="col-md-12">
							<a href="#" class="text-decoration-none">
								<img src="<?php echo $app_info["logo_right"]; ?>" width="90" height="41" alt class="img-responsive custom-img-responsive-center" />
							</a>
						</div>
					</div>
					<hr class="solid tall custom-hr-color-1">
					<div class="row center pb-xlg mb-xlg">
						<div class="col-md-12">
							<ul class="social-icons custom-social-icons">
                                <li><a href="<?php echo $app_info["ios"]; ?>"><i class="fa fa-apple " aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo $app_info["android"]; ?>"><i class="fa fa-android " aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo $app_info["fb"]; ?>"><i class="fa fa-facebook-official " aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo $app_info["twitter"]; ?>"><i class="fa fa-twitter-square " aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo $app_info["insta"]; ?>"><i class="fa fa-instagram " aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo $app_info["youtube"]; ?>"><i class="fa fa-youtube-play " aria-hidden="true"></i></a></li>
							</ul>
							<p>Copyright Notice</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
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
		<script src="templates/vendor/jquery.countdown/jquery.countdown.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="templates/js/theme.js"></script>
		
		<!-- Current Page Vendor and Views -->
		<script src="templates/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="templates/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="templates/js/views/view.contact.js"></script>

		<!-- Demo -->
		<script src="templates/js/demos/demo-church.js"></script>
		
		<!-- Theme Custom -->
		<script src="templates/js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="templates/js/theme.init.js"></script>
	</body>
</html>
<?php } else { ?>
<p><strong>Missing or invalid linked xml file!</strong></p>
<?php } ?>