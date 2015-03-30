<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if( get_field('before_title_image') ) : 
?>
<img src="<?php the_field('before_title_image'); ?>" alt="<?php the_title(); ?>" />
<?php endif; ?>
<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
