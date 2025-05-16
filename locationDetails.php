<!DOCTYPE HTML>
<!--
	Road Trip by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
	<html>
		<head>
			<title>Turistički portal Sokobanje</title>
				<meta charset="utf-8">
				<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" href="assets/css/main.css">
				
				<!-- Stylesheets -->
	            <link rel="stylesheet" href="css/bootstrap.min.css"/>
	            <link rel="stylesheet" href="css/fresco.css"/>

	            <!-- Main Stylesheets -->
	            <link rel="stylesheet" href="css/style.css"/>
		</head>
		
		<body onload = "defaultTranslate('SRB')">
		<!-- Header -->
			<header id="header">
				<div class="logo">
					<a href="http://gisit.rs"><span id="txt_creator"></span><img src="images/Gisit_transparent.png" alt="GisIt" style="height: 1.5em; vertical-align: middle;"></a>
				</div>
				<a onclick="defaultTranslate('SRB')"><img class="language" src="images/icons/SRB.svg" alt="Small Button"/></a>
				<a onclick="defaultTranslate('ENG')"><img class="language" src="images/icons/GBR.svg" alt="Small Button"/></a>
				<a href="#menu" class="menu-button"><span>Menu</span></a>
			</header>
			
			<?php
				include "database.php";
				$id = $_GET['locationId'];
				$sqlLocation = "SELECT * FROM vw_locations_get WHERE id = ".$id;
				$resultLocation = $conn->query($sqlLocation);
				$redLocation = $resultLocation->fetch_assoc();
			?>
			
			<!-- Nav -->
			<nav id="menu">
			<ul class="links">
			    <li><a id="txt_li_home" href="#"></a></li>
				<li><a id="txt_li_map" href="#"></a></li>
				<li><a id="txt_li_location_map" href"=#" onclick="goToPageDynamicPath('./Map.php?locationId=<?php echo htmlspecialchars($redLocation['id']); ?>')"></a></li>
				<li><a id="txt_li_location_navigation"  onclick="googleMapNavigation('<?php echo htmlspecialchars($redLocation['latitude']); ?>','<?php echo htmlspecialchars($redLocation['longitude']); ?>')"></a></li>
				<li><a id="txt_li_info" href="#"></a></li>
				<li><a id="txt_li_events" href=""></a></li>
			</ul>
			</nav>
			
			<!-- Banner -->
			<!-- Note: To show a background image, set the "data-bg" attribute below
			to the full filename of your image. This is used in each section to set
			the background image.-->
			
			<!--<php
				include "database.php";
				$sql = "SELECT * FROM vw_citiesphoto_get WHERE city_id = 1";
				$result = $conn->query($sql);
				$redCity = $result->fetch_assoc();
			?>
			<section id="banner" class="bg-img" data-bg=<php echo htmlspecialchars($redCity['path']); ?>>-->
			<h1 id="txt_title" style="display:none;"></h1>
			
			<div class="gallery__page" style="margin-top: 20px;">
		        <div class="gallery__warp">
		            <div>
			            <h2 id="nameId" style="text-align: center;"><?php echo htmlspecialchars($redLocation['name']); ?></h2>
			            <h2 id="nameEngId" style="text-align:center;display:none;"><?php echo htmlspecialchars($redLocation['name_eng']); ?></h2>
			        </div>
			        <div class="row" style="display:flex; justify-content:center;">
			            
			            <?php
				            include "database.php";
				            $id = $_GET['locationId'];
				            $sql = "SELECT * FROM vw_locationimages_getallimages WHERE location_id =".$id;
				            $result = $conn->query($sql);
			            ?>
			            
			             <?php while($red = $result->fetch_assoc()): ?>
			                <div class="col-lg-3 col-md-4 col-sm-6">
                                <a class="gallery__item fresco" href="<?php echo htmlspecialchars($red['path']); ?>" data-fresco-group="gallery">
						            <img src="<?php echo htmlspecialchars($red['path']); ?>" alt="" style="z-index: 2;">
					            </a>
					        </div>
                         <?php endwhile; ?>
                         
                         <p id="descriptionId"><?php echo htmlspecialchars($redLocation['description']); ?></p>
						 <p id="descriptionEngId" style="display:none;"><?php echo htmlspecialchars($redLocation['description_eng']); ?></p>
			        </div>
			    </div>
			</div>
			<!--</section>-->
			
			<script src="https://unpkg.com/proj4@2.7.3/dist/proj4.js"></script>
			
			<script>
			    function googleMapNavigation(latitude, longitude){
			        var proj3857 = 'EPSG:3857';
                    var proj4326 = 'EPSG:4326';
                    
                    var point4326 = proj4(proj3857, proj4326, [Number(longitude), Number(latitude)]);
                    var lat = point4326[1];
                    var lon = point4326[0];
                    
			        window.location.href = `https://www.google.com/maps?q=${lat},${lon}`;
			    }
			    
			    function goToPageDynamicPath(path){
			        window.location.href = `${path}&language=${currentSelectedLanguage}`;
			    }
			</script>
			
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/fresco.min.js"></script>
			<script src="assets/js/main.js"></script>

			<script src="assets/js/englishText.js"></script>
			<script src="assets/js/serbianText.js"></script>
			<script src="assets/js/translate.js"></script>
			
			<script>
			    window.onload = catchCurrentLanguage();
			</script>
		</body>
	</html>

