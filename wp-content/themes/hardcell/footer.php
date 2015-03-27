<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Hard Cell
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="divider"></div>
		
		<div class="site-wrapper">
			
			<div class="latest-box">
				<div class="latest-blogs">
					<h3>Latest from our blog</h3>
					
					<div class="blog-block">
						<div class="blog-thumb">
							<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/product-thumb.png" alt="" /></a>
						</div>
						<div class="blog-description">
							<h4><a href="#">Blog Post Title</a></h4>
							<p>Teaser sebntence goes here and here. and  here...</p>
							<a class="readmore" href="#">Read More &gt;</a>
						</div>
					</div>
					<div class="blog-block">
						<div class="blog-thumb">
							<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/product-thumb.png" alt="" /></a>
						</div>
						<div class="blog-description">
							<h4><a href="#">Blog Post Title</a></h4>
							<p>Teaser sebntence goes here and here. and  here...</p>
							<a class="readmore" href="#">Read More &gt;</a>
						</div>
					</div>
					<div class="blog-block">
						<div class="blog-thumb">
							<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/product-thumb.png" alt="" /></a>
						</div>
						<div class="blog-description">
							<h4><a href="#">Blog Post Title</a></h4>
							<p>Teaser sebntence goes here and here. and  here...</p>
							<a class="readmore" href="#">Read More &gt;</a>
						</div>
					</div>

				</div>
				<div class="latest-product">
					<h3>Cool new product</h3>
					<div class="cool-product">
						<img src="<?php echo get_template_directory_uri(); ?>/images/cool-product.png" alt="" />
						<h3>4 Head Dispenser!</h3>
					</div>
				</div>
			</div>
			
			<div class="footer-menu">
				<?php wp_nav_menu( array( 'menu' => 'Footer menu', 'menu_id' => 'footer-menu' ) ); ?>
			</div>
			
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.png" alt="Hard Cell Logo" /></a></h1>
				<p class="copy">Copyright 2015 <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HARDCELL</a> | Website Design by <a href="http://claytowne.com">Claytowne</a></p>
				<p class="footer-text">HardCell Performance Energy Shots - Naturally Flavored PepperMental, GingerGasmic, CinnaBurn and Licorage Wholesale Orders Welcome - Bulk Energy Shots in 24oz Aluminum Bottles - Retail Ready</p>
			</div>
			
			<div class="social-button site-wrapper">
				<ul>
					<li><a class="twitter" href="#twitter.com">Twitter</a></li>
					<li><a class="facebook" href="#facebook.com">Facebook</a></li>
				</ul>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
