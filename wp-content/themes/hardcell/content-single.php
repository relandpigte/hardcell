<?php
/**
 * @package Hard Cell
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="blog-entry-header">
		<?php the_title( '<h1 class="blog-entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php hardcell_awesome_cooltheme_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'hardcell-awesome-cooltheme' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php hardcell_awesome_cooltheme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
