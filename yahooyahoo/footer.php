<footer>
		<div class="container">
			<h4>The Safe Online Guide is brought to you by</h4>
			<div class="row">
				<div class="col-sm-offset-3 col-sm-6 col-xs-12">
					<ul>
						<li>
							<a href="http://cchubnigeria.com" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cchub.png" alt="Co-Creation Hub"></a>
						</li>
						<li class="pull-right">
							<a href="http://osiwa.org" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/osiwa.png" alt="OSIWA"></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	

	<?php wp_footer(); ?>

	<!-- analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-46691706-27', 'auto');
	  ga('send', 'pageview');

	</script>

	<!--Magnific popup  -->
<script>
		$(document).ready(function() {
			$('.video-1').magnificPopup({
				items: {
					src: "https://www.youtube.com/watch?v=lvR3o2JINMc"
				},
				type: 'iframe',
				iframe: {
					markup: '<div class="mfp-iframe-scaler">' +
						'<div class="mfp-close"></div>' +
						'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
						'</div>',
					patterns: {
						youtube: {
							index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

							id: 'v=', // String that splits URL in a two parts, second part should be %id%
							// Or null - full URL will be returned
							// Or a function that should return %id%, for example:
							// id: function(url) { return 'parsed id'; }

							src: 'https://www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
						},
					},
					srcAction: 'iframe_src'
				}

			});
		});

	</script>

	</body>
</html>
