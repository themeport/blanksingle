<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blanksingle
 */
?>

<div id="secondary">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
		<aside class="left-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside><!-- .left-sidebar -->
	<?php } ?>

	<?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
		<aside class="middle-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</aside><!-- .middle-sidebar -->
	<?php } ?>

	<?php if ( is_active_sidebar( 'sidebar-3' ) ) { ?>
		<aside class="right-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</aside><!-- .right-sidebar -->
	<?php } ?>
</div>