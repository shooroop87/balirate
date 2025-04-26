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
$filter = array();
;
$filter['relation'] = 'AND';
if (isset($_POST['special'])) {
	$total = true;
	$filter[3] = array(
		'key' => 'special',
		'compare' => '!=',
		'value' => ''
	);
}
if (isset($_POST['uk'])) {
	$total = true;
	$filter[4] = array(
		'key' => 'uk',
		'compare' => '!=',
		'value' => ''
	);
}
if (isset($_POST['vznos'])) {
	$total = true;
	$filter[3] = array(
		'key' => 'vznos',
		'compare' => '!=',
		'value' => ''
	);
}
if (isset($_POST['total1'])) {
	$filter[0]['relation'] = 'OR';
	$total = true;
	$filter[0][] = array(
		'key' => 'nums_rev',
		'value' => '50',
		'compare' => '<'
	);
}
if (isset($_POST['total2'])) {
	if ($total) {
		$filter[0]['relation'] = 'OR';
	}
	$total = true;
	$filter[0][] = array(

		'key' => 'nums_rev',
		'value' => array(50, 100),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['total3'])) {
	if (!$total) {
		$filter[0]['relation'] = 'OR';
	}
	$total = true;
	$filter[0][] = array(

		'key' => 'nums_rev',
		'value' => array(100, 500),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['total4'])) {
	if (!$total) {
		$filter[0]['relation'] = 'OR';
	}
	$total = true;
	$filter[0][] = array(

		'key' => 'nums_rev',
		'value' => array(500, 1000),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['total5'])) {
	if (!$total) {
		$filter[0]['relation'] = 'OR';
	}
	$total = true;
	$filter[0][] = array(

		'key' => 'nums_rev',
		'value' => 1000,
		'type' => 'numeric',
		'compare' => '>'
	);
}

if (isset($_POST['offers1'])) {
	$filter[1]['relation'] = 'OR';
	$offers = true;
	$filter[1][] = array(

		'key' => 'sdano',
		'value' => array(10, 50),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['offers2'])) {
	if (!$offers) {
		$filter[1]['relation'] = 'OR';
	}
	$offers = true;
	$filter[1][] = array(

		'key' => 'sdano',
		'value' => array(50, 250),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['offers3'])) {
	if (!$offers) {
		$filter[1]['relation'] = 'OR';
	}
	$offers = true;
	$filter[1][] = array(

		'key' => 'sdano',
		'value' => array(250, 1000),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['offers4'])) {
	if (!$offers) {
		$filter[1]['relation'] = 'OR';
	}
	$offers = true;
	$filter[1][] = array(

		'key' => 'sdano',
		'value' => 1000,
		'type' => 'numeric',
		'compare' => '>'
	);
}
if (isset($_POST['rating1'])) {
	$filter[2]['relation'] = 'OR';
	$rating = true;
	$filter[2][] = array(
		'key' => 'rating',
		'value' => array(0.1, 1.4),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating2'])) {
	if ($rating) {
		$filter[2]['relation'] = 'OR';
	}
	$rating = true;
	$filter[2][] = array(

		'key' => 'rating',
		'value' => array(1.5, 2.5),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating3'])) {
	if (!$rating) {
		$filter[2]['relation'] = 'OR';
	}
	$rating = true;
	$filter[2][] = array(

		'key' => 'rating',
		'value' => array(2.6, 3.5),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating4'])) {
	if (!$rating) {
		$filter[2]['relation'] = 'OR';
	}
	$rating = true;
	$filter[2][] = array(

		'key' => 'rating',
		'value' => array(3.6, 4.5),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating5'])) {
	if (!$rating) {
		$filter[2]['relation'] = 'OR';
	}
	$rating = true;
	$filter[2][] = array(

		'key' => 'rating',
		'value' => 4.5,
		'type' => 'numeric',
		'compare' => '>'
	);
}
//print_r($filter);

?>
<div class="crumbs">
	<div class="crumbs__container">
		<a href="<?= get_home_url(); ?>" class="crumbs__link">Home</a>
		<span class="crumbs__link"><?= the_title() ?></span>
	</div>
</div>
<section class="first">
	<div class="first__container">
		<h1 class="first__title title"><?= the_title() ?></h1>

		<? get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<div class="first__body first__body--reverce">
			<div class="first__left">

				<div class="first__rows">


					<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					if (have_posts()):
						query_posts(array(
							'posts_per_page' => 10,
							'post_type' => array('agencies'),
							"meta_key" => "premium",
							"orderby" => "meta_value_num",
							"order" => "ASC",
							'meta_query' =>
								$filter
							,
							'paged' => $paged
						)); ?>
						<?php while (have_posts()): ?>
							<? get_template_part('templates/item-list', null, the_post()); ?>
						<?php endwhile; ?>
					</div>
					<? if (have_posts()) { ?>
						<div class="pagging">
							<? wp_pagenavi(); ?>
						</div>
					<? } else { ?>
						<h3 class="norezult">not found</h3>
					<? } ?>
				<?php endif;
					wp_reset_query(); ?>

			</div>

			<div class="first__right">
				<button type="button" class="first__popuplink icon-filter" data-popup="#popup-filter">Filters</button>
				<div class="first-filter" data-da=".popup-filter__body, 767.92, 0">
					<div class="first-filter__title">Filters</div>
					<form action="" class="first-filter__form" method="post">
						<div class="first-filter__blocks">
							<div class="first-filter__block">
								<div class="first-filter__blockname">Rating</div>
								<div class="first-filter__checks">
									<label class="checkbox__label">
										<input class="checkbox__input" aria-label="Рейтинг 5 звезд" <? if (isset($_POST['rating5'])) { ?>checked<? } ?> type="checkbox" value="1"
											name="rating5">
										<span class="checkbox__text checkbox__rating">
											<img src="/img/rating-5.svg" alt="Image">
										</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['rating4'])) { ?>checked<? } ?> aria-label="Рейтинг 4 звезды" type="checkbox" value="1" name="rating4">
										<span class="checkbox__text checkbox__rating">
											<img src="/img/rating-4.svg" alt="Image">
										</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['rating3'])) { ?>checked<? } ?> aria-label="Рейтинг 3 звезды" type="checkbox" value="1" name="rating3">
										<span class="checkbox__text checkbox__rating">
											<img src="/img/rating-3.svg" alt="Image">
										</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['rating2'])) { ?>checked<? } ?> aria-label="Рейтинг 2 звезды" type="checkbox" value="1" name="rating2">
										<span class="checkbox__text checkbox__rating">
											<img src="/img/rating-2.svg" alt="Image">
										</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['rating1'])) { ?>checked<? } ?> aria-label="Рейтинг 1 звезда" type="checkbox" value="1" name="rating1">
										<span class="checkbox__text checkbox__rating">
											<img src="/img/rating-1.svg" alt="Image">
										</span>
									</label>
								</div>
							</div>
							<div class="first-filter__block">
								<div class="first-filter__blockname">Number of reviews</div>
								<div class="first-filter__checks">
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['total1'])) { ?>checked<? } ?>
											type="checkbox" value="50" name="total1">
										<span class="checkbox__text">to 50</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['total2'])) { ?>checked<? } ?>
											type="checkbox" value="50-100" name="total2">
										<span class="checkbox__text">from 50 to 100</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['total3'])) { ?>checked<? } ?>
											type="checkbox" value="100-500" name="total3">
										<span class="checkbox__text">from 100 to 500</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['total4'])) { ?>checked<? } ?>
											type="checkbox" value="500-1000" name="total4">
										<span class="checkbox__text">from 500 to 1 000</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['total5'])) { ?>checked<? } ?>
											type="checkbox" value="1000" name="total5">
										<span class="checkbox__text">more 1 000</span>
									</label>
								</div>
							</div>
							<div class="first-filter__block">
								<div class="first-filter__blockname">Number of completed objects</div>
								<div class="first-filter__checks">
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['offers1'])) { ?>checked<? } ?> type="checkbox" value="10-50" name="offers1">
										<span class="checkbox__text">from 10 to 50</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['offers2'])) { ?>checked<? } ?> type="checkbox" value="50-250" name="offers2">
										<span class="checkbox__text">from 50 to 250</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['offers3'])) { ?>checked<? } ?> type="checkbox" value="250-1000" name="offers3">
										<span class="checkbox__text">from 250 to 1 000</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['offers4'])) { ?>checked<? } ?> type="checkbox" value="10000" name="offers4">
										<span class="checkbox__text">more 1 000</span>
									</label>
								</div>
							</div>
							<div class="first-filter__block">
								<div class="first-filter__blockname">Additionally</div>
								<div class="first-filter__checks">
									<label class="checkbox__label">
										<input class="checkbox__input" type="checkbox" value="spec" <? if (isset($_POST['special'])) { ?>checked<? } ?> name="special">
										<span class="checkbox__text">Availability of shares</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['uk'])) { ?>checked<? } ?>
											type="checkbox" value="uk" name="uk">
										<span class="checkbox__text">own management company</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['vznos'])) { ?>checked<? } ?>
											type="checkbox" value="vznos" name="vznos">
										<span class="checkbox__text">First installment 20%</span>
									</label>
								</div>
							</div>
						</div>
						<button type="submit" class="button button--blue first-filter__button button--fw">Apply</button>
						<button type="reset" class="button button--white first-filter__button button--fw">Reset
							Filters</button>
					</form>
				</div>
			</div>
		</div>

		<? get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>
		
	</div>
</section>

<?php if (have_posts()):
	query_posts(array(
		'posts_per_page' => 200,
		'post_type' => array('review'),
		'meta_query' => array(
			array(
				'key' => 'type_rec',
				'value' => 2,

				'compare' => '='
			)
		),
	)); ?>
	<? if (have_posts()) { ?>
		<section class="devscomments">
			<div class="devscomments__container">
				<div class="devscomments__top">
					<h2 class="devscomments__title title">Reviews of agencies</h2>
					<div class="devscomments__toptiv"><?= wp_count_posts('review')->publish ?></div>
				</div>
				<div class="devscomments__slidercont slidercont">
					<div class="devscomments__slider swiper">
						<div class="devscomments__wrapper swiper-wrapper">

							<?php while (have_posts()): ?>
								<? get_template_part('templates/review', null, the_post()); ?>
							<?php endwhile; ?>

						</div>
					</div>
					<button type="button" aria-label="Кнопка слайдера предыдущая"
						class="devscomments__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
					<button type="button" aria-label="Кнопка слайдера следующая"
						class="devscomments__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
				</div>
			</div>
		</section>
	<? } ?>
<?php endif;
wp_reset_query(); ?>
<?php
get_footer();