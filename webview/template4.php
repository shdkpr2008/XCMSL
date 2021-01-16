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
		$loc = $title;
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
		<link rel="stylesheet" href="templates/css/skins/skin-real-estate.css"> 

		<!-- Demo CSS -->
		<link rel="stylesheet" href="templates/css/demos/demo-real-estate.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="templates/css/custom.css">

		<!-- Head Libs -->
		<script src="templates/vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body class="loading-overlay-showing" data-loading-overlay>
		<div class="loading-overlay">
			<div class="bounce-loader">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
		</div>

		<div class="body">
			<header id="header" class="header-narrow" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 37, 'stickySetTop': '-37px', 'stickyChangeLogo': false}">
				<div class="header-body background-color-primary pt-none pb-none">
					<div class="header-top header-top header-top-style-3 header-top-custom background-color-primary m-none">
						<div class="container">
						</div>
					</div>
					<div class="header-container container custom-position-initial">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="#">
										<img alt="Logo" width="143" height="70" src="<?php echo $app_info["logo_left"]; ?>">
									</a>
								</div>
							</div>
							<div class="header-column">
								<div class="header-row">
									<div class="header-nav">
										<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
											<i class="fa fa-bars"></i>
										</button>
										<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse m-none">
                                          <nav>
                                            <ul class="nav nav-pills" id="mainNav">
                                                <li class="<?php if($title == "INICIO") echo "active "; ?> dropdown-full-color dropdown-quaternary ">
                                                    <a href="./inicio.php?appid=<?php echo $appid; ?>">
                                                        INICIO
                                                    </a>
                                                </li>
                                                <li class="<?php if($title == "CONEXIÓN") echo "active"; ?> dropdown-full-color dropdown-quaternary ">
                                                    <a href="./conexion.php?appid=<?php echo $appid; ?>">
                                                        CONEXIÓN
                                                    </a>
                                                </li>
                                                <li class="<?php if($title == "NOSTROS") echo "active"; ?> dropdown-full-color dropdown-quaternary ">
                                                    <a href="./nosotros.php?appid=<?php echo $appid; ?>">
                                                        NOSTROS
                                                    </a>
                                                </li>
                                                <li class="<?php if($title == "EVENTOS") echo "active"; ?> dropdown-full-color dropdown-quaternary ">
                                                    <a href="./eventos.php?appid=<?php echo $appid; ?>">
                                                        EVENTOS
                                                    </a>
                                                </li>
                                                <li class="<?php if($title == "CONTACTO") echo "active"; ?> dropdown-full-color dropdown-quaternary ">
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
             <?php if(isset($_GET["id"])) { ?>
				<div class="container">
					<div class="row pb-xl pt-md">
						<div class="col-md-12">
                            <div class="page-header page-header-light" style="padding-bottom:0px !important;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1><?php echo $news[$_GET["id"]]["titlenews"]; ?><span><?php echo $loc; ?></a></span></h1>
									</div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-12">
									<div class="thumb-gallery">
										<div class="lightbox" data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}}">
											<div class="owl-carousel owl-theme manual thumb-gallery-detail show-nav-hover" id="thumbGalleryDetail">
												<div>
													<a href="<?php echo $news[$_GET["id"]]["imageurl"]; ?>">
														<span class="thumb-info thumb-info-centered-info thumb-info-no-borders font-size-xl">
															<span class="thumb-info-wrapper font-size-xl">
																<img alt="<?php echo $news[$_GET["id"]]["titlenews"]; ?>" src="<?php echo $news[$_GET["id"]]["imageurl"]; ?>" class="img-responsive">
																<span class="thumb-info-title font-size-xl">
																	<span class="thumb-info-inner font-size-xl"><i class="icon-magnifier icons font-size-xl"></i></span>
																</span>
															</span>
														</span>
													</a>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h4 class="mt-md mb-md">Description</h4>
									<p><?php echo $news[$_GET["id"]]["descnews"]; ?></p>
								</div>
							</div>

						</div>
					</div>
				</div>
             <?php } else { ?>
             <div class="slider-container light rev_slider_wrapper" style="height: 600px;">
					<div id="revolutionSlider" class="slider rev_slider" data-plugin-revolution-slider data-plugin-options="{'delay': 9000, 'gridwidth': 1170, 'gridheight': 650, 'disableProgressBar': 'on', 'navigation': {'arrows': {'enable': true, 'left':{'container':'slider','h_align':'right','v_align':'center','h_offset':20,'v_offset':-80},'right':{'container':'slider','h_align':'right','v_align':'center','h_offset':20,'v_offset':80}}}}">
                    	<div class="slides-number hidden-xs">
							<span class="atual">1</span>
							<span class="total">3</span>
						</div>
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
					<div class="row mb-lg">
						<ul class="properties-listing sort-destination p-none">
                        <?php foreach($news as $key => $new) { ?>
                    		<li class="col-md-4 col-sm-6 col-xs-12 p-md isotope-item">
								<div class="listing-item">
									<a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>&id=<?php echo $key; ?>" class="text-decoration-none">
										<span class="thumb-info thumb-info-lighten">
											<span class="thumb-info-wrapper m-none">
												<img src="<?php echo $new["imageurl"]; ?>" class="img-responsive" alt="">
											</span>
											<span class="thumb-info-price background-color-primary text-color-light text-lg p-sm pl-md pr-md">
												<?php echo $new["titlenews"]; ?>
												<i class="fa fa-caret-right text-color-secondary pull-right"></i>
											</span>
											<span class="custom-thumb-info-title b-normal p-lg">
												<span class="thumb-info-inner text-md"><?php echo substr($new["descnews"], 0, 200);  ?>...</span>
											</span>
										</span>
									</a>
								</div>
							</li>
                    <?php }?>
						</ul>
					</div>
					
				</div>		
		<?php }?>
				<footer id="footer" class="m-none custom-background-color-1">
					<div class="container">
						<div class="row">
						<div class="col-md-3 pull-left">
							<a href="#" class="logo mb-md">
								<img alt="Logo" class="img-responsive" width="160" height="32" src="<?php echo $app_info["logo_right"]; ?>">
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
					<div class="footer-copyright custom-background-color-1 pb-none" style="margin: 0px 0px 0px 0px !important;padding:0px 0 10px !important">
						<div class="container">
							<div class="row pt-md pb-md">
								<div class="col-md-12 left m-none">
									<p>© Copyright 2017. All Rights Reserved.</p>
								</div>
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
		
		<!-- Theme Base, Components and Settings -->
		<script src="templates/js/theme.js"></script>
		
		<!-- Current Page Vendor and Views -->
		<script src="templates/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="templates/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="templates/js/views/view.contact.js"></script>

		<!-- Demo -->
		<script src="templates/js/demos/demo-real-estate.js"></script>
		
		<!-- Theme Custom -->
		<script src="templates/js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="templates/js/theme.init.js"></script>

	</body>
</html>

<?php } else { ?>
<p><strong>Missing or invalid linked xml file!</strong></p>
<?php } ?>