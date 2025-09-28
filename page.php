<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>

<?php
$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
if (isset($page_fields['main'])){
	$topbaza = $page_fields['main'];
	$idmain = $topbaza->ID;
	$itemmain = get_fields($idmain);
}else{
	$topbaza = '';
}

?>
<div class="crumbs">
	<div class="crumbs__container">
		<a href="<?php echo get_home_url(); ?>" class="crumbs__link"><?php pll_e('Главная'); ?></a>
		<span class="crumbs__link"><?php the_title(); ?></span>
	</div>
</div>

<section class="knowledge-page">
	<div class="knowledge-page__container">
		<h1 class="knowledge-page__title title"><?php the_title(); ?></h1>

		<?php get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<div class="knowledge-page__bottom">
			<?php the_content(); ?>
		</div>

		<?php get_template_part( 'templates/bottom_advertising_banner', null, $page_fields ); ?>

	</div>
</section>


<?php
get_footer();