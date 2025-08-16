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

		<?php get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<div class="news-page__row">
			<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			// ИСПРАВЛЕНИЕ: Используем WP_Query вместо query_posts
			$stati_query = new WP_Query(array(
				'posts_per_page' => 4,
				'post_type' => array('stati'),
				'paged' => $paged,
				'post_status' => 'publish' // Убеждаемся что берем только опубликованные
			));
			
			if ($stati_query->have_posts()) : ?>
				<div class="news-page__row">
					<?php 
					$k = 0;
					while ($stati_query->have_posts()) : 
						$stati_query->the_post();
						$k++;
						
						if ($k == 1 or $k == 11) {
							// ИСПРАВЛЕНИЕ: Передаем get_post() вместо the_post()
							get_template_part('templates/article_big', null, get_post());
						} else {
							// ИСПРАВЛЕНИЕ: Передаем get_post() вместо the_post()
							get_template_part('templates/article_prev', null, get_post());
						}
					endwhile;
					wp_reset_postdata(); // ИСПРАВЛЕНИЕ: Сбрасываем данные запроса
					?>
				</div>

				<div class="pagging">
					<?php 
					// Пагинация для кастомного запроса
					if (function_exists('wp_pagenavi')) {
						wp_pagenavi(array('query' => $stati_query));
					} else {
						echo paginate_links(array(
							'total' => $stati_query->max_num_pages,
							'current' => $paged
						));
					}
					?>
				</div>
			<?php else : ?>
				<h3>Ничего не найдено</h3>
			<?php endif; ?>
		</div>

		<?php get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>
	</div>
</section>

<?php get_footer(); ?>