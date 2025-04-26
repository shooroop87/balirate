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
//get developers list
$filter = array();

if (isset($_POST['rating1'])) {
	$arrstr = array(0);
	$filter['relation'] = 'OR';
	$rating = true;
	$filter[] = array(
		'key' => 'rating',
		'value' => array(0.1, 1.4),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating2'])) {
	$arrstr = array(0);
	if ($rating) {
		$filter['relation'] = 'OR';
	}
	$rating = true;
	$filter[] = array(

		'key' => 'rating',
		'value' => array(1.5, 2.5),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating3'])) {
	$arrstr = array(0);
	if (!$rating) {
		$filter['relation'] = 'OR';
	}
	$rating = true;
	$filter[] = array(

		'key' => 'rating',
		'value' => array(2.6, 3.5),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating4'])) {
	$arrstr = array(0);
	if (!$rating) {
		$filter['relation'] = 'OR';
	}
	$rating = true;
	$filter[] = array(

		'key' => 'rating',
		'value' => array(3.6, 4.6),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating5'])) {
	$arrstr = array(0);
	if (!$rating) {
		$filter['relation'] = 'OR';
	}
	$rating = true;
	$filter[] = array(

		'key' => 'rating',
		'value' => 4.5,
		'type' => 'numeric',
		'compare' => '>'
	);
}

if ($filter) {
	//print_r($filter);
	if (have_posts()):
		query_posts(array(
			'posts_per_page' => 100,
			'post_type' => array('stroys'),
			'meta_query' => $filter,
		));
		while (have_posts()) {
			the_post();
			$arrstr[] = $id = get_the_ID();
		}
		;
	endif;
	wp_reset_query();
}

//end list

$city_list = getValuesMeta('city');
$rooms_list = getValuesMeta('rooms');
$array_city = array();
$array_rooms = array();
$minprice = getMinMeta('price');
$maxprice = getMaxMeta('price');

$set_minprice = $minprice;
$set_maxprice = $maxprice;

$minsq = getMinMeta('sq');
$maxsq = getMaxMeta('sq');
$set_minsq = $minsq;
$set_maxsq = $maxsq;
$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
$filter = array();
;
$filter['relation'] = 'AND';
if ($arrstr) {
	$ids = implode(',', $arrstr);
	$filter[10][] = array(
		'key' => 'developer',
		'value' => $ids,
		'compare' => 'IN'
	);
}

if (isset($_POST['city'])) {

	$array_city = array_values($_POST['city']);
	//print_r($array_city);
	$filter[3]['relation'] = 'OR';
	foreach ($_POST['city'] as $city) {
		$filter[3][] = array(
			'key' => 'city',
			'value' => $city,
			'compare' => 'LIKE'
		);
	}
}

if (isset($_POST['rooms'])) {
	$array_rooms = array_values($_POST['rooms']);
	$filter[3]['relation'] = 'OR';
	foreach ($_POST['rooms'] as $room) {
		$filter[3][] = array(
			'key' => 'rooms',
			'value' => $room,
			'compare' => '='
		);
	}
}

if (isset($_POST['lin1'])) {
	$total = true;
	$filter[3] = array(
		'key' => 'line1',
		'compare' => '!=',
		'value' => ''
	);
}
if (isset($_POST['line2'])) {
	$total = true;
	$filter[4] = array(
		'key' => 'line2',
		'compare' => '!=',
		'value' => ''
	);
}
if (isset($_POST['terasa'])) {
	$total = true;
	$filter[5] = array(
		'key' => 'terasa',
		'compare' => '!=',
		'value' => ''
	);
}
if (isset($_POST['bas'])) {
	$total = true;
	$filter[6] = array(
		'key' => 'bas',
		'compare' => '!=',
		'value' => ''
	);
}
if (isset($_POST['park'])) {
	$total = true;
	$filter[6] = array(
		'key' => 'park',
		'compare' => '!=',
		'value' => ''
	);
}
if (isset($_POST['price_min'])) {
	$set_minprice = $_POST['price_min'];
	$set_maxprice = $_POST['price_max'];
	$filter[7]['relation'] = 'AND';
	$total = true;
	$filter[7][] = array(
		'key' => 'price',
		'value' => array($_POST['price_min'] - 1, $_POST['price_max'] + 1),
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['sq_min'])) {
	$set_minsq = $_POST['sq_min'];
	$set_maxsq = $_POST['sq_max'];
	$filter[7]['relation'] = 'AND';
	$total = true;
	$filter[7][] = array(
		'key' => 'sq',
		'value' => array($_POST['sq_min'] - 1, $_POST['sq_max'] + 1),
		'compare' => 'BETWEEN'
	);
}

//print_r($filter);

?>
<div class="crumbs">
	<div class="crumbs__container">
		<a href="<?= get_home_url(); ?>" class="crumbs__link">Главная</a>
		<span class="crumbs__link"><?= the_title() ?></span>
	</div>
</div>
<section class="first">
	<div class="first__container">
		<h1 class="first__title title"><?= the_title() ?></h1>

		<? get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<?php
		$args = array(

			'child_of' => 0,
			'parent' => '',
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => 0,
			'hierarchical' => 1,
			'taxonomy' => 'catobj',
			'pad_counts' => false
		);
		$categories = get_categories($args);
		?>
		<ul class="tabs-def d-none d-lg-flex">
			<? $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
			<? foreach ($categories as $category) {
				if ($category->term_id > 1) {
					$catID = $category->term_id;
					;
					$url = get_term_link($category); ?>
					<li class="tabs-def__item"><a class="tabs-def__link " href="<?= $url ?>"><?php echo $category->name; ?></a>
					</li>
				<? }
			} ?>

		</ul>
		<div class="first__body first__body--reverce">
			<div class="first__left">
				<div class="first__objects">

					<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					if (have_posts()):
						query_posts(array(
							'posts_per_page' => 12,
							'post_type' => array('offers'),
							'meta_query' =>
								$filter
							,
							'paged' => $paged
						)); ?>
						<?php while (have_posts()): ?>
							<? get_template_part('templates/offer-list', null, the_post()); ?>
						<?php endwhile; ?>
					</div>
					<? if (have_posts()) { ?>
						<div class="pagging">
							<? wp_pagenavi(); ?>
						</div>
					<? } else { ?>
						<h3 class="norezult">Ничего не найдено</h3>
					<? } ?>
				<?php endif;
					wp_reset_query(); ?>
			</div>

			<div class="first__right">
				<button type="button" class="first__popuplink icon-filter" data-popup="#popup-filter">Фильтры</button>
				<div class="first-filter" data-da=".popup-filter__body, 767.92, 0">
					<div class="first-filter__title">Фильтры</div>
					<form action="" class="first-filter__form" method="post">
						<div class="first-filter__blocks">
							<div class="first-filter__block">
								<div class="first-filter__blockname">Рейтинг застройщика</div>
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
								<div class="first-filter__blockname">Расположение объекта</div>
								<div class="first-filter__checks">
									<div data-showmore="items" class="first-filter__show _showmore-active">
										<div data-showmore-content="5" class="first-filter__showcontent">
											<? foreach ($city_list as $item) { ?>
												<label class="checkbox__label">
													<input class="checkbox__input" <? if (in_array($item->meta_value, $array_city)) { ?> checked <? } ?>type="checkbox"
														value="<?= $item->meta_value ?>" name="city[]">
													<span class="checkbox__text"><?= $item->meta_value ?></span>
												</label>
											<? } ?>
										</div>
										<button data-showmore-button="" type="button"
											class="first-filter__showmore"><span>Еще</span><span>Скрыть</span></button>
									</div>
								</div>
							</div>
							<div class="first-filter__block">
								<div class="first-filter__blockname">Стоимость</div>
								<div class="first-filter__range-slider range-slider" data-range>
									<input type="hidden" data-min="<?= $minprice ?>" value="<?= $minprice ?>">
									<input type="hidden" data-max="<?= $maxprice ?>" value="<?= $maxprice ?>">
									<div class="range-slider__values">
										<div class="range-slider__inputcont"><span>от</span><input
												data-range-min="<?= $minprice ?>" value="<?= $set_minprice ?>" type="text"
												name="price_min" /><span>$</span></div>
										<div class="range-slider__inputcont"><span>до</span><input
												data-range-max="<?= $maxprice ?>" value="<?= $set_maxprice ?>" type="text"
												name="price_max" /><span>$</span></div>
									</div>
									<div data-range-slider></div>
								</div>
							</div>
							<div class="first-filter__block">
								<div class="first-filter__blockname">Площадь</div>
								<div class="first-filter__range-slider range-slider" data-range>
									<input type="hidden" data-min value="<?= $minsq ?>">
									<input type="hidden" data-max value="<?= $maxsq ?>">
									<div class="range-slider__values">
										<div class="range-slider__inputcont"><span>от</span><input data-range-min
												value="<?= $set_minsq ?>" type="text" name="sq_min" /><span>м²</span>
										</div>
										<div class="range-slider__inputcont"><span>до</span><input data-range-max
												value="<?= $set_maxsq ?>" type="text" name="sq_max" /><span>м²</span>
										</div>
									</div>
									<div data-range-slider></div>
								</div>
							</div>
							<div class="first-filter__block">
								<div class="first-filter__blockname">Количество комнат</div>
								<div class="first-filter__checks">
									<? foreach ($rooms_list as $item) { ?>
										<label class="checkbox__label">
											<input class="checkbox__input" <? if (in_array($item->meta_value, $array_rooms)) { ?> checked <? } ?> type="checkbox" value="<?= $item->meta_value ?>"
												name="rooms[]">
											<span class="checkbox__text"><?= $item->meta_value ?></span>
										</label>
									<? } ?>
								</div>
							</div>
							<div class="first-filter__block">
								<div class="first-filter__blockname">Дополнительно</div>
								<div class="first-filter__checks">
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['line1'])) { ?>checked<? } ?>
											type="checkbox" value="1" name="line1">
										<span class="checkbox__text">Первая линия у океана</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['line2'])) { ?>checked<? } ?>
											type="checkbox" value="1" name="line2">
										<span class="checkbox__text">Вторая линия у океана</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['terasa'])) { ?>checked<? } ?>
											type="checkbox" value="1" name="terasa">
										<span class="checkbox__text">Терасса</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['bas'])) { ?>checked<? } ?>
											type="checkbox" value="1" name="bas">
										<span class="checkbox__text">Бассейн</span>
									</label>
									<label class="checkbox__label">
										<input class="checkbox__input" <? if (isset($_POST['park'])) { ?>checked<? } ?>
											type="checkbox" value="1" name="park">
										<span class="checkbox__text">Парковка</span>
									</label>
								</div>
							</div>
						</div>
						<button type="submit"
							class="button button--blue first-filter__button button--fw">Применить</button>
						<button type="reset" class="button button--white first-filter__button button--fw">Сбросить
							фильтры</button>
					</form>
				</div>
			</div>
		</div>

		<? get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>

	</div>
</section>

<?php if (have_posts()):
	query_posts(array(
		'posts_per_page' => 20,
		'post_type' => array('review')
	)); ?>
	<? if (have_posts()) { ?>
		<section class="devscomments">
			<div class="devscomments__container">
				<div class="devscomments__top">
					<h2 class="devscomments__title title">Отзывы на девелоперов</h2>
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