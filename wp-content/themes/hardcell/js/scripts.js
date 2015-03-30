(function($){
	$(document).ready(function(){
		Cufon.replace('#primary-menu > li > a, #footer-menu > li > a', {
			fontFamily: 'AkzidenzGrotesk',
			color: '-linear-gradient(#00b2e2, #ffffff)',
			hover: {
				color: '-linear-gradient(#ffffff, #00b2e2)'
			}
		});
		Cufon.replace('.latest-box > div > h3', {
			fontFamily: 'AkzidenzGrotesk',
			color: '-linear-gradient(#00b2e2, #ffffff)'
		});
		Cufon.replace('.copy, .footer-text', {
			fontFamily: 'AkzidenzGrotesk',
			textShadow: '2px 2px 2px black'
		});
		
		Cufon.replace('.cool-product h3', {
			fontFamily: 'AkzidenzGroteskExtraBold',
			color: '-linear-gradient(#ffb400, #caf4fa)'
		});
		
		Cufon.replace('.entry-title, .post-type-archive.woocommerce .page-title', {
			fontFamily: 'AkzidenzGrotesk',
			color: '-linear-gradient(#00b2e2, #ffffff)'
		});
		
		
		$('#home-slider').rhinoslider({
			effect: 'explode',
			easing: 'easeInOutBounce',
			controlsPrevNext: false,
			controlsPlayPause: false,
			autoPlay: true,
			parts: '20,10',
			showBullets: 'never',
			showControls: 'never'
		});
	});
})(jQuery);