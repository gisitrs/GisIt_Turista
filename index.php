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
			
			<!-- Nav -->
			<nav id="menu">
			<ul class="links">
				<li><a id="txt_li_map" href="#"></a></li>
				<li><a id="txt_li_info" href="#"></a></li>
				<li><a id="txt_li_events" href=""></a></li>
			</ul>
			</nav>
			
			<!-- Banner -->
			<!-- Note: To show a background image, set the "data-bg" attribute below
			to the full filename of your image. This is used in each section to set
			the background image.
			Test small changes -->
			<?php
				include "database.php";
				$sql = "SELECT * FROM vw_citiesphoto_get WHERE city_id = 1";
				$result = $conn->query($sql);
				$red = $result->fetch_assoc();
			?>
			<section id="banner" class="bg-img" data-bg=<?php echo htmlspecialchars($red['path']); ?>>
				<div class="inner">
					<header>
						<h1 id="txt_title"></h1>
						<!-- <p id="txt_description">Sokobanja je jedno od najpoznatijih banjskih i turističkih mesta u Srbiji, smešteno u slikovitom okruženju planina Ozren i Rtanj. Poznata je po lekovitim izvorima, čistom vazduhu i brojnim prirodnim i kulturnim atrakcijama, uključujući Sokograd, vodopadu Ripaljka, Lepteriji i mnogim drugim. Kroz interaktivnu mapu na našem portalu možete se bolje upoznati sa Sokobanjom i svim njenim znamenitostima, sadržajima za odmor i rekreaciju kao i ostalim turističkim sadržajima.</p>
						-->
						<?php
							include "database.php";
							$sql = "SELECT * FROM vw_city_get WHERE id = 1";
							$result = $conn->query($sql);
							$red = $result->fetch_assoc();
						?>
						<p id="nameId"><?php echo htmlspecialchars($red['description']); ?></p>
						<p id="nameEngId" style="display:none;"><?php echo htmlspecialchars($red['description_eng']); ?></p>
					</header>
				</div>
				<!-- <a href="#one" class="more">Learn More</a> -->
			</section>

			<!-- One
			<section id="one" class="wrapper post bg-img" data-bg="banner2.jpg"><div class="inner">
					<article class="box"><header><h2>Nibh non lobortis mus nibh</h2>
							<p>01.01.2017</p>
						</header><div class="content">
							<p>Scelerisque enim mi curae erat ultricies lobortis donec velit in per cum consectetur purus a enim platea vestibulum lacinia et elit ante scelerisque vestibulum. At urna condimentum sed vulputate a duis in senectus ullamcorper lacus cubilia consectetur odio proin sociosqu a parturient nam ac blandit praesent aptent. Eros dignissim mus mauris a natoque ad suspendisse nulla a urna in tincidunt tristique enim arcu litora scelerisque eros suspendisse.</p>
						</div>
						<footer><a href="generic.html" class="button alt">Learn More</a>
						</footer></article></div>
				<a href="#two" class="more">Learn More</a>
			</section>
			-->

			<!-- Two 
			<section id="two" class="wrapper post bg-img" data-bg="banner5.jpg"><div class="inner">
					<article class="box"><header><h2>Mus elit a ultricies at</h2>
							<p>12.21.2016</p>
						</header><div class="content">
							<p>Scelerisque enim mi curae erat ultricies lobortis donec velit in per cum consectetur purus a enim platea vestibulum lacinia et elit ante scelerisque vestibulum. At urna condimentum sed vulputate a duis in senectus ullamcorper lacus cubilia consectetur odio proin sociosqu a parturient nam ac blandit praesent aptent. Eros dignissim mus mauris a natoque ad suspendisse nulla a urna in tincidunt tristique enim arcu litora scelerisque eros suspendisse.</p>
						</div>
						<footer><a href="generic.html" class="button alt">Learn More</a>
						</footer></article></div>
				<a href="#three" class="more">Learn More</a>
			</section>
			-->

			<!-- Three
			<section id="three" class="wrapper post bg-img" data-bg="banner4.jpg"><div class="inner">
					<article class="box"><header><h2>Varius a cursus aliquet</h2>
							<p>11.11.2016</p>
						</header><div class="content">
							<p>Scelerisque enim mi curae erat ultricies lobortis donec velit in per cum consectetur purus a enim platea vestibulum lacinia et elit ante scelerisque vestibulum. At urna condimentum sed vulputate a duis in senectus ullamcorper lacus cubilia consectetur odio proin sociosqu a parturient nam ac blandit praesent aptent. Eros dignissim mus mauris a natoque ad suspendisse nulla a urna in tincidunt tristique enim arcu litora scelerisque eros suspendisse.</p>
						</div>
						<footer><a href="generic.html" class="button alt">Learn More</a>
						</footer></article></div>
				<a href="#four" class="more">Learn More</a>
			</section>
			-->

			<!-- Four 
			<section id="four" class="wrapper post bg-img" data-bg="banner3.jpg"><div class="inner">
					<article class="box"><header><h2>Luctus blandit mi lectus in nascetur</h2>
							<p>10.30.2016</p>
						</header><div class="content">
							<p>Scelerisque enim mi curae erat ultricies lobortis donec velit in per cum consectetur purus a enim platea vestibulum lacinia et elit ante scelerisque vestibulum. At urna condimentum sed vulputate a duis in senectus ullamcorper lacus cubilia consectetur odio proin sociosqu a parturient nam ac blandit praesent aptent. Eros dignissim mus mauris a natoque ad suspendisse nulla a urna in tincidunt tristique enim arcu litora scelerisque eros suspendisse.</p>
						</div>
						<footer><a href="generic.html" class="button alt">Learn More</a>
						</footer></article></div>
			</section>
			-->

			<!-- Footer 
			<footer id="footer"><div class="inner">

					<h2>Contact Me</h2>

					<form action="#" method="post">

						<div class="field half first">
							<label for="name">Name</label>
							<input name="name" id="name" type="text" placeholder="Name"></div>
						<div class="field half">
							<label for="email">Email</label>
							<input name="email" id="email" type="email" placeholder="Email"></div>
						<div class="field">
							<label for="message">Message</label>
							<textarea name="message" id="message" rows="6" placeholder="Message"></textarea></div>
						<ul class="actions"><li><input value="Send Message" class="button alt" type="submit"></li>
						</ul></form>

					<ul class="icons"><li><a href="#" class="icon round fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon round fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon round fa-instagram"><span class="label">Instagram</span></a></li>
					</ul></div>
			</footer>
			-->

			<!-- Copyright 
			<div class="copyright">
				Site made with: <a href="https://templated.co/">Templated</a> Distributed by <a href="https://themewagon.com/">ThemeWagon</a>
			</div>
			-->
			
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

			<script src="assets/js/englishText.js"></script>
			<script src="assets/js/serbianText.js"></script>
			<script src="assets/js/translate.js"></script>
			
			<script>
			    window.onload = catchCurrentLanguage();
			</script>
		</body>
	</html>

