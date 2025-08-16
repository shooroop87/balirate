<?php
// Подключаем header шаблона
get_header();

// Получаем текущий объект таксономии и его ID
$page_id = get_queried_object_id();
$term = get_queried_object();

// Получаем ACF-поля, связанные с текущим термином
$page_fields = get_fields($term);

// Подготовка фильтров по рейтингу девелопера
$filter = array();
$rating = false;

if (isset($_POST['rating1'])) {
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
    $filter['relation'] = 'OR';
    $rating = true;
    $filter[] = array(
        'key' => 'rating',
        'value' => array(1.5, 2.5),
        'type' => 'numeric',
        'compare' => 'BETWEEN'
    );
}
if (isset($_POST['rating3'])) {
    $filter['relation'] = 'OR';
    $rating = true;
    $filter[] = array(
        'key' => 'rating',
        'value' => array(2.6, 3.5),
        'type' => 'numeric',
        'compare' => 'BETWEEN'
    );
}
if (isset($_POST['rating4'])) {
    $filter['relation'] = 'OR';
    $rating = true;
    $filter[] = array(
        'key' => 'rating',
        'value' => array(3.6, 4.6),
        'type' => 'numeric',
        'compare' => 'BETWEEN'
    );
}
if (isset($_POST['rating5'])) {
    $filter['relation'] = 'OR';
    $rating = true;
    $filter[] = array(
        'key' => 'rating',
        'value' => 4.5,
        'type' => 'numeric',
        'compare' => '>'
    );
}

// Получаем список ID девелоперов, подходящих по рейтингу
if ($filter) {
    $arrstr = array(0); // массив для ID
    if (have_posts()) :
        query_posts(array(
            'posts_per_page' => 100,
            'post_type' => array('stroys'),
            'meta_query' => $filter,
        ));
        while (have_posts()) {
            the_post();
            $arrstr[] = get_the_ID();
        }
    endif;
    wp_reset_query();
}

// Получаем значения для фильтрации (из метаполей)
$city_list = getValuesMeta('city');
$rooms_list = getValuesMeta('rooms');

$minprice = getMinMeta('price');
$maxprice = getMaxMeta('price');
$set_minprice = $minprice;
$set_maxprice = $maxprice;

$minsq = getMinMeta('sq');
$maxsq = getMaxMeta('sq');
$set_minsq = $minsq;
$set_maxsq = $maxsq;

// Начинаем формировать meta_query для вывода объектов
$filter = array();
$filter['relation'] = 'AND';

// Фильтр по ID девелоперов (по рейтингу)
if ($arrstr) {
    $ids = implode(',', $arrstr);
    $filter[10][] = array(
        'key' => 'developer',
        'value' => $ids,
        'compare' => 'IN'
    );
}

// Фильтрация по городу
if (isset($_POST['city'])) {
    $array_city = array_values($_POST['city']);
    $filter[3]['relation'] = 'OR';
    foreach ($_POST['city'] as $city) {
        $filter[3][] = array(
            'key' => 'city',
            'value' => $city,
            'compare' => 'LIKE'
        );
    }
}

// Фильтрация по количеству комнат
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

// Фильтрация по доп. параметрам (линии, терасса, бассейн, парковка)
if (isset($_POST['line1'])) {
    $filter[3] = array(
        'key' => 'line1',
        'compare' => '!=',
        'value' => ''
    );
}
if (isset($_POST['line2'])) {
    $filter[4] = array(
        'key' => 'line2',
        'compare' => '!=',
        'value' => ''
    );
}
if (isset($_POST['terasa'])) {
    $filter[5] = array(
        'key' => 'terasa',
        'compare' => '!=',
        'value' => ''
    );
}
if (isset($_POST['bas'])) {
    $filter[6] = array(
        'key' => 'bas',
        'compare' => '!=',
        'value' => ''
    );
}
if (isset($_POST['park'])) {
    $filter[6] = array(
        'key' => 'park',
        'compare' => '!=',
        'value' => ''
    );
}

// Фильтр по цене
if (isset($_POST['price_min'])) {
    $set_minprice = $_POST['price_min'];
    $set_maxprice = $_POST['price_max'];
    $filter[7]['relation'] = 'AND';
    $filter[7][] = array(
        'key' => 'price',
        'value' => array($_POST['price_min'] - 1, $_POST['price_max'] + 1),
        'compare' => 'BETWEEN'
    );
}

// Фильтр по площади
if (isset($_POST['sq_min'])) {
    $set_minsq = $_POST['sq_min'];
    $set_maxsq = $_POST['sq_max'];
    $filter[7]['relation'] = 'AND';
    $filter[7][] = array(
        'key' => 'sq',
        'value' => array($_POST['sq_min'] - 1, $_POST['sq_max'] + 1),
        'compare' => 'BETWEEN'
    );
}

// Определяем ID страницы "Объекты" для хлебных крошек
$lang = pll_current_language();
$catid = ($lang == 'en') ? 339 : 195;
?>

<!-- HTML-разметка: хлебные крошки и заголовок -->
<div class="crumbs">
    <div class="crumbs__container">
        <a href="<?= get_home_url(); ?>" class="crumbs__link"><?php pll_e('Главная'); ?></a>
        <a href="<?= get_permalink($catid); ?>" class="crumbs__link"><?= get_the_title($catid) ?></a>
        <span class="crumbs__link"><?= $page_fields['h1'] ?></span>
    </div>
</div>

<section class="first">
    <div class="first__container">
        <h1 class="first__title title"><?= $page_fields['h1'] ?></h1>

        <?php
        // Получаем список категорий (дочерние термины таксономии catobj)
        $categories = get_categories(array(
            'taxonomy' => 'catobj',
            'hide_empty' => 0,
            'orderby' => 'name',
            'order' => 'ASC'
        ));
        ?>

        <!-- Вкладки категорий -->
        <ul class="tabs-def d-none d-lg-flex">
            <?php foreach ($categories as $category) :
                if ($category->term_id > 1) :
                    $url = get_term_link($category); ?>
                    <li class="tabs-def__item">
                        <a class="tabs-def__link <?= ($page_id == $category->term_id) ? 'active' : '' ?>" href="<?= $url ?>">
                            <?= $category->name ?>
                        </a>
                    </li>
            <?php endif; endforeach; ?>
        </ul>

        <div class="first__body first__body--reverce first__body--full">
            <div class="first__left">
                <div class="first__objects">
                    <?php
                    // Выводим объекты недвижимости по фильтрам и текущей категории
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $args = array(
                        'posts_per_page' => 12,
                        'post_type' => array('offers'),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'catobj',
                                'field' => 'id',
                                'terms' => $page_id
                            )
                        ),
                        'meta_query' => $filter,
                        'paged' => $paged,
                        'orderby' => array(
                            'menu_order' => 'ASC',
                            'date' => 'DESC',
                            'ID' => 'ASC'
                        ),
                        'order' => 'ASC'
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            get_template_part('templates/offer-list', null, ['post' => get_the_ID()]);
                        endwhile;
                    endif;
                    ?>
                </div>

                <!-- Пагинация -->
                <?php if ($query->max_num_pages > 1) : ?>
                    <div class="pagging">
                        <?php wp_pagenavi(array('query' => $query)); ?>
                    </div>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
            </div>

            <!-- Боковой фильтр (форму см. выше в вашем коде) -->
            <div class="first__right">
                <!-- Здесь фильтры (города, рейтинг, площадь, цена и т.д.) -->
                <!-- ... -->
            </div>
        </div>
    </div>
</section>

<?php
// Блок отзывов на девелоперов
if (have_posts()) :
    query_posts(array(
        'posts_per_page' => 20,
        'post_type' => array('review')
    ));

    if (have_posts()) : ?>
        <section class="devscomments">
            <div class="devscomments__container">
                <div class="devscomments__top">
                    <h2 class="devscomments__title title">Отзывы на девелоперов</h2>
                    <div class="devscomments__toptiv"><?= wp_count_posts('review')->publish ?></div>
                </div>
                <div class="devscomments__slidercont slidercont">
                    <div class="devscomments__slider swiper">
                        <div class="devscomments__wrapper swiper-wrapper">
                            <?php while (have_posts()) :
                                the_post();
                                get_template_part('templates/review', null, get_the_ID());
                            endwhile; ?>
                        </div>
                    </div>
                    <button type="button" class="swiper-button-prev icon-arrow-d-b"></button>
                    <button type="button" class="swiper-button-next icon-arrow-d-b"></button>
                </div>
            </div>
        </section>
<?php
    endif;
endif;

wp_reset_query();

// Подключаем footer шаблона
get_footer();