<?php
/**
 * Главный шаблон для страницы рейтинга застройщиков
 *
 * Здесь выводятся вкладки с застройщиками из ACF, применяются фильтры из формы, 
 * а также сортировка по "premium". Также будет возвращена правая колонка с фильтрами.
 */

get_header();

// Получаем текущий язык через Polylang
$lang = pll_current_language();
// Получаем ID текущей страницы
$page_id = get_queried_object_id();
// Получаем поля ACF текущей страницы
$page_fields = get_fields($page_id);

// Сбор фильтров из POST-запроса
$filter = array();
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
	if ($total) $filter[0]['relation'] = 'OR';
	$total = true;
	$filter[0][] = array(
		'key' => 'nums_rev',
		'value' => array(50, 100),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['total3'])) {
	if (!$total) $filter[0]['relation'] = 'OR';
	$total = true;
	$filter[0][] = array(
		'key' => 'nums_rev',
		'value' => array(100, 500),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['total4'])) {
	if (!$total) $filter[0]['relation'] = 'OR';
	$total = true;
	$filter[0][] = array(
		'key' => 'nums_rev',
		'value' => array(500, 1000),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['total5'])) {
	if (!$total) $filter[0]['relation'] = 'OR';
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
	if (!$offers) $filter[1]['relation'] = 'OR';
	$offers = true;
	$filter[1][] = array(
		'key' => 'sdano',
		'value' => array(50, 250),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['offers3'])) {
	if (!$offers) $filter[1]['relation'] = 'OR';
	$offers = true;
	$filter[1][] = array(
		'key' => 'sdano',
		'value' => array(250, 1000),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['offers4'])) {
	if (!$offers) $filter[1]['relation'] = 'OR';
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
	if ($rating) $filter[2]['relation'] = 'OR';
	$rating = true;
	$filter[2][] = array(
		'key' => 'rating',
		'value' => array(1.5, 2.5),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating3'])) {
	if (!$rating) $filter[2]['relation'] = 'OR';
	$rating = true;
	$filter[2][] = array(
		'key' => 'rating',
		'value' => array(2.6, 3.5),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating4'])) {
	if (!$rating) $filter[2]['relation'] = 'OR';
	$rating = true;
	$filter[2][] = array(
		'key' => 'rating',
		'value' => array(3.6, 4.5),
		'type' => 'numeric',
		'compare' => 'BETWEEN'
	);
}
if (isset($_POST['rating5'])) {
	if (!$rating) $filter[2]['relation'] = 'OR';
	$rating = true;
	$filter[2][] = array(
		'key' => 'rating',
		'value' => 4.5,
		'type' => 'numeric',
		'compare' => '>'
	);
}

?>

<!-- Хлебные крошки -->
<div class="crumbs">
	<div class="crumbs__container">
		<a href="<?= get_home_url(); ?>" class="crumbs__link">Главная</a>
		<span class="crumbs__link"><?= the_title() ?></span>
	</div>
</div>

<!-- Основной контент -->
<section class="first">
	<div class="first__container">
		<h1 class="first__title title"><?= the_title() ?></h1>
		<? get_template_part('templates/advertising_banner', null, $page_fields); ?>

		<div class="first__body">
			<div class="first__left">
				<!-- Вкладки рейтинга -->
				<div data-tabs class="first__tabs">
					<nav data-tabs-titles class="first__tabsnavigation" style="display: none;">
						<?php foreach ($page_fields['tabs'] as $num => $tab): ?>
							<?php if ($tab['list']) : ?>
								<button type="button" class="first__tabstitle <?= $num === 0 ? '_tab-active' : '' ?>">
									<?= $tab['title'] ?>
								</button>
							<?php endif; ?>
						<?php endforeach; ?>
					</nav>
					<div data-tabs-body class="first__tabscontent">
						<?php foreach ($page_fields['tabs'] as $num => $tab): ?>
							<?php if ($tab['list']) : ?>
								<div class="first__tabsbody">
									<div class="first__rows">
										<?php
										$args = array(
											'post_type' => 'stroys',
											'post__in' => wp_list_pluck($tab['list'], 'ID'),
											'orderby' => 'meta_value_num',
											'order' => 'ASC',
											'meta_key' => 'premium',
											'meta_query' => $filter
										);
										$tab_query = new WP_Query($args);
										while ($tab_query->have_posts()): $tab_query->the_post();
											get_template_part('templates/item-list', null, get_post());
										endwhile;
										wp_reset_postdata();
										?>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<!-- Правая колонка с фильтрами -->
			<?php get_template_part('templates/filters'); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
