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
					
					<?php $the_query = new WP_Query( 'showposts=3' ); ?>
					<?php while ($the_query -> have_posts()) : $the_query -> the_post(); 
					$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
					$image       	= get_the_post_thumbnail( $post->ID, 'full', array(
						'title'	=> $image_title,
						'alt'	=> $image_title
					) ); ?>
					<div class="blog-block">
						<div class="blog-thumb">
							<?php if( $image ) : ?>
								<a href="<?php the_permalink(); ?>"><?php echo $image; ?></a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/product-thumb.png" alt="" /></a>
							<?php endif; ?>
						</div>
						<div class="blog-description">
							<h4><a href="<?php the_permalink(); ?>"><?php echo substr(get_the_title(), 0, 20);?><?php echo (strlen(get_the_title()) > 20)? '...':''; ?></a></h4>
							<p><?php echo substr(get_the_excerpt(), 0, 50);?><?php echo (strlen(get_the_excerpt()) > 20)? '...':''; ?></p>
							<a class="readmore" href="<?php the_permalink(); ?>">Read More &gt;</a>
						</div>
					</div>
					<?php endwhile; wp_reset_query(); ?>

				</div>
				<div class="latest-product">
					<h3>Cool new product</h3>
					<?php $args = array(  
						'post_type' => 'product',  
						'meta_key' => '_featured',  
						'meta_value' => 'yes',  
						'posts_per_page' => 1,
						'showposts' => 1
					);  
					  
					$featured_query = new WP_Query( $args );  
					if ($featured_query->have_posts()) :   
					  
						while ($featured_query->have_posts()) :   
							$featured_query->the_post();  
							
							$product		= get_product( $featured_query->post->ID );
							$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
							$image       	= get_the_post_thumbnail( $post->ID, 'full', array(
								'title'	=> $image_title,
								'alt'	=> $image_title
							) ); ?>
							
							<div class="cool-product">
								<?php echo $image; ?>
								<h3><?php the_title(); ?></h3>
							</div> <?php 
					
						endwhile;  
						  
					endif;  
					wp_reset_query(); ?>
					
				</div>
			</div>
			
			<div class="footer-menu">
				<?php wp_nav_menu( array( 'menu' => 'Footer menu', 'menu_id' => 'footer-menu' ) ); ?>
			</div>
			
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.png" alt="Drink Hardcell" /></a></h1>
				<p class="copy">Copyright 2015 <a href="<?php echo esc_url( home_url( '/' ) ); ?>">HARDCELL</a> | Website Design by <a href="http://claytowne.com">Claytowne</a></p>
				<p class="footer-text">HardCell Performance Energy Shots - Naturally Flavored PepperMental, GingerGasmic, CinnaBurn and Licorage Wholesale Orders Welcome - Bulk Energy Shots in 24oz Aluminum Bottles - Retail Ready</p>
			</div>
			
			<div class="social-button site-wrapper">
				<ul>
					<li><a class="twitter" href="https://twitter.com/drinkhardcell">Twitter</a></li>
					<li><a class="facebook" href="https://www.facebook.com/drinkhardcell">Facebook</a></li>
				</ul>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
