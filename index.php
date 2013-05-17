<?php

/*************************************************
			Index Page
**************************************************
	Author: Charlie McClung
	Updated: 3/26/2013
		CNerdForum Homepage
*************************************************/

// Include configuration file
require_once $_SERVER['DOCUMENT_ROOT'] . 'config.php';

// Get instance of CN class and initialize site
$cn =& CN::getInstance();
$cn->init();

// Require header global
require_once( CN_DIR_GLOBALS . 'header.php' );
?>
				<div class="home">
					<div class="right">
<!-- 						<button class="button" onclick="window.location='<?php echo CN_WEBROOTPAGE . 'topics'; ?>'">View All Topics</button> -->
						<h4>Recent Topics</h4>
						<ul>
						<?php
							$topics = CN_Topic::getRecent();
							foreach( $topics as $topic ) {
								echo '<li><a href="' . CN_WEBROOTPAGE . 'topic?tid=' . $topic->id . '">' . $topic->title . '</a></li>';
							}
						?>
						</ul>
						<h4>Recent Posts</h4>
						<ul>
						<?php
							$posts = CN_Post::getRecent();
							foreach( $posts as $post ) {
								echo '<li><a href="' . CN_WEBROOTPAGE . 'post?pid=' . $post->id . '">' . $post->title . '</a></li>';
							}
						?>
						</ul>
					</div>
					<div class="left">
						<h3>Allowed Tags</h3>
						<p>
							<?php echo htmlentities(CN_ALLOWED_TAGS); ?>
						</p>
						<hr>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec gravida posuere purus ut lacinia. Nam tincidunt sapien augue. Vestibulum vulputate tellus et dui varius sed hendrerit quam fermentum. Aenean adipiscing, purus id tincidunt feugiat, est felis elementum enim, non condimentum felis massa nec felis. Phasellus non lorem metus. Integer ac orci nisl. Phasellus sagittis lectus tempor justo tincidunt suscipit. Praesent iaculis ultrices felis, vitae faucibus sem mollis vel. Donec elementum nisi vel purus ultrices consectetur. Nam tincidunt nunc eget nibh tempor non rhoncus eros aliquam. Aliquam erat volutpat.</p>

<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer ornare mollis aliquam. Donec hendrerit, orci non posuere vehicula, enim dui volutpat neque, sit amet pellentesque odio arcu egestas orci. Donec malesuada pharetra justo quis sollicitudin. Etiam vulputate, purus vitae tincidunt tempus, diam lectus iaculis tellus, eget egestas risus orci non magna. Proin sagittis urna nec nisi elementum ullamcorper porta metus malesuada. In sodales purus a lacus ornare gravida fermentum sem elementum. Fusce interdum velit eu felis sodales et facilisis nisi sollicitudin. Proin facilisis ultrices odio non sollicitudin. Cras blandit dictum justo ut sagittis. Curabitur porttitor consectetur tristique. Pellentesque ultricies placerat turpis, quis accumsan tortor malesuada vel. Curabitur a ipsum vel nunc facilisis viverra. Proin vel leo sed est mollis commodo.</p>

<p>Phasellus vehicula dignissim lectus a feugiat. Morbi ultricies nisi eget tortor venenatis lobortis. Morbi vitae magna nec leo fermentum blandit. Integer facilisis venenatis tellus, eu pretium lorem elementum eu. Maecenas nec purus lectus. Vivamus ultricies, ante facilisis tempus molestie, ligula est mollis nisl, vel rutrum arcu est ut libero. Donec condimentum felis non justo rutrum facilisis. Etiam dictum pulvinar enim dapibus pretium.</p>

<p>Vestibulum id tortor eu sem pharetra tincidunt. Etiam consequat dui turpis. Vestibulum in diam lacus, eu placerat ligula. Phasellus ornare fringilla velit, vel laoreet nibh ultricies vel. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi convallis massa eget nibh vestibulum pulvinar. Vestibulum tellus lorem, tempor vitae elementum sed, varius vitae massa. Nullam rhoncus ipsum et eros consequat hendrerit. Pellentesque condimentum velit sit amet felis laoreet lobortis. Nunc nunc odio, commodo sit amet aliquet a, ullamcorper eu ligula. Vivamus et purus neque, eu tempor nibh. Donec eget erat in felis vehicula mollis a et enim. Nullam fermentum blandit nunc ut bibendum. Sed condimentum sollicitudin risus at pulvinar. Nullam pharetra diam quis sem hendrerit blandit. Etiam rutrum porta nunc, eu tincidunt enim placerat eget.</p>

<p>Mauris massa leo, consectetur lacinia mollis et, eleifend at odio. Proin felis sapien, aliquet non posuere at, fermentum in leo. Nulla dui lorem, pulvinar pulvinar pretium nec, aliquam id nunc. Phasellus et ipsum urna. Quisque sed nibh eget est gravida imperdiet et eu lorem. Curabitur ac arcu a nibh pellentesque accumsan. Nullam orci velit, ultrices in hendrerit nec, tempus vel tellus. Sed vehicula pellentesque urna, eget pulvinar augue feugiat sed. Nullam blandit purus mi, eu sodales dui. Aenean commodo lorem tristique ipsum vestibulum vehicula. Integer id purus erat. Aliquam et arcu dolor, non mattis urna. Vivamus quam purus, posuere eu suscipit nec, aliquet in nibh. Integer tellus lorem, rhoncus sit amet volutpat quis, euismod non mi. Nullam in nunc sit amet lectus elementum bibendum eget eget diam. Sed placerat tortor ut eros tincidunt nec sagittis ante mollis.</p>

<p>Sed euismod sollicitudin metus, sed blandit nulla faucibus vel. Suspendisse potenti. Donec sit amet enim quis urna accumsan semper ut eget est. Suspendisse non velit lacus. Suspendisse mattis urna ut velit faucibus laoreet. In pretium sodales tempus. Donec libero libero, vehicula vel blandit ac, sodales ut odio. Quisque sodales, tellus id aliquet ultricies, lorem massa molestie urna, a fringilla lorem nibh et metus. Sed lacus tortor, gravida eget tempus pharetra, suscipit et velit.</p>

<p>Nam lorem nunc, dapibus sit amet iaculis vitae, ornare sed est. Integer molestie, purus id consequat luctus, lacus lorem interdum dolor, eget placerat felis lacus ut magna. Proin vitae neque ut urna varius adipiscing. Vestibulum at tempus erat. Nulla sed lacus libero. Nunc ante lectus, scelerisque eu cursus sed, porttitor et metus. Praesent sit amet auctor lectus. Proin porta ultrices lobortis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed vitae auctor nibh. Phasellus lectus leo, pharetra et semper id, pellentesque porta tortor. Cras rutrum diam quis risus vehicula vitae elementum neque aliquam. Nunc quis faucibus lorem. Suspendisse potenti. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
					</div>
				</div>
				
<input type="hidden" id="page" name="page" value="home" />
				
<?php
// Require footer global
require_once( CN_DIR_GLOBALS . 'footer.php' );
?>