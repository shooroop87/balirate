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
$topbaza = $page_fields['main'];
$idmain = $topbaza->ID;
$itemmain = get_fields($idmain);
?>
<div class="crumbs">
	<div class="crumbs__container">
		<a href="<?= get_home_url(); ?>" class="crumbs__link">Главная</a>
		<span class="crumbs__link"><?= the_title() ?></span>
	</div>
</div>
<section class="knowledge-page">
	<div class="knowledge-page__container">
		<h1 class="knowledge-page__title title"><?= the_title() ?></h1>

		<? get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<div class="news-topitem knowledge-page__topitem">
			<? if ($itemmain['image']) { ?><img src="<?= $itemmain['image']['sizes']['news_big'] ?>"
					alt="<?php the_title(); ?>" loading="lazy"><? } ?>
			<div class="news-topitem__content">
				<div class="news-topitem__date"><?= get_the_date(); ?></div>
				<a href="<?php the_permalink(); ?>" class="news-topitem__name"><?= $topbaza->post_title ?></a>
				<div class="news-topitem__text"><?= $itemmain['text_mini'] ?> </div>
				<a href="<?php the_permalink(); ?>"
					class="news-topitem__link icon-arrow-r-t"><?php pll_e('more_btn'); ?></a>
			</div>
		</div>



		<div class="knowledge-page__blocks">
			<?php
			$args = array(
				'type' => 'knowledge',
				'child_of' => 0,
				'parent' => '',
				'orderby' => 'name',
				'order' => 'ASC',
				'hide_empty' => 1,
				'hierarchical' => 1,
				'taxonomy' => 'category',
				'pad_counts' => false
			);
			$categories = get_categories($args);


			foreach ($categories as $category) {
				if ($category->term_id > 1) {
					$catID = $category->term_id;
					;
					$url = get_term_link($category); ?>
					<div class="knowledge-page__block">
						<h2 class="knowledge-page__blocktitle title-s"><?php echo $category->name; ?> </h2>
						<div class="knowledge-page__slidercont slidercont">
							<div class="news__slider swiper">
								<div class="news__wrapper swiper-wrapper">
									<?php if (have_posts()):
										query_posts(array(
											'posts_per_page' => 8,
											'cat' => $catID,
											'post_type' => array('knowledge')
										)); ?>
										<?php while (have_posts()): ?>
											<? get_template_part('templates/baza_slide', null, the_post()); ?>
										<?php endwhile; ?>
									<?php endif;
									wp_reset_query(); ?>
								</div>
							</div>
						</div>
					</div>

					<?php
				}
			}

			?>
		</div>


		<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if (have_posts()):
			query_posts(array(
				'posts_per_page' => 6,
				'post_type' => array('knowledge'),
				'paged' => $paged
			)); ?>
			<? if (!have_posts()) { ?>
				<div class="knowledge-page__bottom">
					<h3>Ничего не найдено</h3>
				</div> <? } ?>
		<?php endif;
		wp_reset_query(); ?>


		<? get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>

	</div>
	</div>
</section>


<?php
get_footer();