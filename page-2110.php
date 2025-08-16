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

?>
<div class="crumbs">
	<div class="crumbs__container">
		<a href="<?= get_home_url(); ?>" class="crumbs__link">Главная</a>
		<span class="crumbs__link"><?= the_title() ?></span>
	</div>
</div>
<section class="news-page">
	<div class="news-page__container">
		<h1 class="news-page__title title"><?= the_title() ?></h1>

		<? get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<div class="news-page__row">
			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			if (have_posts()):
				query_posts(array(
					'posts_per_page' => 5,
					'post_type' => array('obzori'),
					'paged' => $paged
				)); ?>
				<? if (have_posts()) { ?>
					<div class="news-page__row">
						<? $k = 0; ?>
						<?php while (have_posts()): ?>
							<? $k++;
							if ($k == 1 or $k == 11) {
								get_template_part('templates/newbig', null, the_post());
							} else {
								get_template_part('templates/new_prev', null, the_post());
							} ?>
						<?php endwhile; ?>
						<? $k = 0; ?>


					</div>

					<div class="pagging">


						<? wp_pagenavi(); ?>

					</div>
				<? } else { ?>
					<h3>Ничего не найдено</h3>
				<? } ?>
			<?php endif;
			wp_reset_query(); ?>

		</div>

	<? get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>
	</div>

</section>

<?php
get_footer();