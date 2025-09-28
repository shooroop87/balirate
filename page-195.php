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
		<a href="<?php echo get_home_url(); ?>" class="crumbs__link">Главная</a>
		<span class="crumbs__link"><?php the_title(); ?></span>
	</div>
</div>
<section class="first">
	<div class="first__container">
		<h1 class="first__title title"><?php the_title(); ?></h1>

		<?php get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<div class="first__body first__body--reverce first__body--full">
			<div class="first__left">
				<div class="first__objects ">

					<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					if (have_posts()):
						query_posts(array(
							'posts_per_page' => 12,
							'post_type' => array('offers'),
							//'meta_query' => $filter,
							'paged' => $paged
						)); ?>
						<?php while (have_posts()): ?>
							<?php get_template_part('templates/offer-list', null, the_post()); ?>
						<?php endwhile; ?>
					</div>
					<?php if (have_posts()) { ?>
						<div class="pagging">
							<?php wp_pagenavi(); ?>
						</div>
					<?php } else { ?>
						<h3 class="norezult">Ничего не найдено</h3>
					<?php } ?>
				<?php endif;
					wp_reset_query(); ?>
			</div>
			
		</div>

		<?php get_template_part('templates/bottom_advertising_banner', null, $page_fields); ?>

	</div>
</section>
<?php if (have_posts()):
	query_posts(array(
		'posts_per_page' => 20,
		'post_type' => array('review')
	)); ?>
	<?php if (have_posts()) { ?>
		<section class="devscomments">
			<div class="devscomments__container">
				<div class="devscomments__top">
					<h2 class="devscomments__title title">Отзывы на девелоперов</h2>
					<div class="devscomments__toptiv"><?php echo wp_count_posts('review')->publish; ?></div>
				</div>
				<div class="devscomments__slidercont slidercont">
					<div class="devscomments__slider swiper">
						<div class="devscomments__wrapper swiper-wrapper">

							<?php while (have_posts()): ?>
								<?php get_template_part('templates/review', null, the_post()); ?>
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
	<?php } ?>
<?php endif;
wp_reset_query(); ?>
<?php
get_footer();