<?php
/**
 * Template Name: Homepage
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Hard Cell
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="site-wrapper">
				
				<div class="home-slider">
					<ul id="home-slider">
						<?php

						// check if the repeater field has rows of data
						if( have_rows('slider') ):

							// loop through the rows of data
							while ( have_rows('slider') ) : the_row();

								// display a sub field value
								echo '<li><img src="'.get_sub_field('slider_image').'" width="684" height="525" alt="'.get_sub_field('image_alt').'" /></li>';

							endwhile;

						else :

							echo '<h1 style="text-transform: uppercase; text-align: center; padding-top: 30%;">Please edit the homepage and upload the image sliders.</h1>';

						endif;

						?>
					</ul>
				</div>
				
			</div>
			
			<div class="divider"></div>
			
			<div class="product-pdf">
				<div class="site-wrapper">
					
					<div class="sales"><?php if( get_field('sales_content_text') ) { the_field('sales_content_text'); } ?></div>
					
					<?php if( get_field('pdf_file') ) : ?>
						<p>
							<?php if( get_field('pdf_icon') ) : ?> <img src="<?php the_field('pdf_icon'); ?>" alt="PDF Icon"/> <?php endif; ?>
							<span>See How HARDCELL </span><a target="_blank" href="<?php the_field('pdf_file'); ?>"><?php the_field('pdf_text'); ?></a>
						</p>
					<?php endif; ?>
				
				</div>
			</div>
			
			<?php if( get_field('ignite_your_core_image') ) : ?>
			<img class="ignite-your-core" src="<?php the_field('ignite_your_core_image'); ?>" alt="Ignite You Core"/>
			<?php endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
