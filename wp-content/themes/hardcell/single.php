<?php
/**
 * The template for displaying all single posts.
 *
 * @package Hard Cell
 */

get_header(); ?>

	<div class="site-wrapper single-blog-detail">
		
		<header class="entry-header" style="margin-bottom: 15px;">
			<h1 class="entry-title" style="margin:0;line-height:30px;">BLOG</h1>
		</header><!-- .entry-header -->
		
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php #the_post_navigation(); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>
			</main><!-- #main -->
		</div><!-- #primary -->
	

		<?php get_sidebar(); ?>
	</div>
	<img class="ignite-your-core" src="<?php echo get_template_directory_uri(); ?>/images/ignite-your-core.png" alt="Ignite You Core"/>
	
<?php get_footer(); ?>
