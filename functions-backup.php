<?php
/**
 * Основной файл функций темы (functions.php).
 * Этот файл подключает дополнительные модули, регистрирует настройки,
 * добавляет пользовательские функции и обеспечивает интеграцию с плагинами.
 *
 * @package actions
 */

// Подключаем файл инициализации темы
require_once(trailingslashit(get_template_directory()) . 'inc/init.php');

// Подключаем файл фреймворка темы
require_once(trailingslashit(get_template_directory()) . 'inc/framework.php');

// Подключаем файл кастомизатора (настройки темы через WordPress Customizer)
require_once(trailingslashit(get_template_directory()) . 'inc/customizer/class-customize.php');

// Подключаем файлы для интеграции с Elementor
require_once(trailingslashit(get_template_directory()) . 'elementor/custom.php');
require_once(trailingslashit(get_template_directory()) . 'elementor/helper-functions.php');

/**
 * Функция для добавления новых элементов в Elementor.
 * Проверяет версию PHP и подключает виджет контактной формы.
 */
function actions_new_elements() {
    // Проверяем версию PHP
    if (!version_compare(PHP_VERSION, '5.2', '>=')) {
        return;
    }
    // Подключаем файл виджета контактной формы
    require_once(trailingslashit(get_template_directory()) . 'elementor/widgets/contact-form.php');
}

// Отключаем админ-бар для пользователей с ролью "подписчик"
if (current_user_can('subscriber')) {
    show_admin_bar(false);
}

// Перенаправляем пользователей с ролью "подписчик" на главную страницу
add_action('admin_init', function() {
    if (current_user_can('subscriber')) {
        add_filter('show_admin_bar', '__return_false');
        wp_redirect(site_url());
        die();
    }
});

// Регистрируем новые элементы в Elementor
add_action('elementor/widgets/widgets_registered', 'actions_new_elements');

// Регистрируем строки для мультиязычности (плагин Polylang)
pll_register_string('more_btn', 'Подробнее');
pll_register_string('bron_btn', 'Забронировать место');
pll_register_string('subscribe_btn', 'Подписаться');
pll_register_string('text_home', 'Главная');
pll_register_string('text_rating', 'Рейтинг');
pll_register_string('text_name', 'Ваше имя');
pll_register_string('text_mark', 'Поставьте оценку');
pll_register_string('text_rev', 'Ваш отзыв');
pll_register_string('text_sendrev', 'Отправить отзыв');
pll_register_string('text_s1', 'Нажимая кнопку вы даете согласие на обработку');
pll_register_string('text_s2', 'персональных данных');
pll_register_string('text_s3', 'в соответствии с');
pll_register_string('text_s4', 'политикой конфиденциальности');
pll_register_string('text_auths', 'Авторизуйтесь чтобы оставить отзыв');
pll_register_string('text_namep', 'Введите ваше имя');
pll_register_string('text_revp', 'Введите ваш отзыв');
pll_register_string('text_thank', 'thank');
pll_register_string('text_other_offer', 'other_offer');
pll_register_string('text_see_all', 'see_all');
pll_register_string('text_in', 'in');
pll_register_string('text_srok', 'srok');
pll_register_string('text_premi', 'premi');
pll_register_string('text_supp', 'supp');
pll_register_string('text_quality', 'quality');
pll_register_string('text_katalog', 'katalog');

/**
 * Фильтр для добавления ссылки на пост в контактную форму (Divi Builder).
 */
add_filter('et_pb_module_shortcode_attributes', 'dbc_add_post_link_to_contact_form', 10, 3);
function dbc_add_post_link_to_contact_form($props, $attrs, $render_slug) {
    if ($render_slug !== 'et_pb_contact_form' || !is_array($props)) {
        return $props;
    }
    if (!empty($props['custom_message'])) {
        $title = get_the_title();
        $url = get_permalink();
        $props['custom_message'] = str_replace('%%post_name%%', $title, $props['custom_message']);
        $props['custom_message'] = str_replace('%%post_url%%', $url, $props['custom_message']);
        $props['custom_message'] = str_replace('%%post_link%%', '<a href="' . esc_attr($url) . '" target="_blank">' . esc_html($title) . '</a>', $props['custom_message']);
    }
    return $props;
}

/**
 * Загрузчик для ActionsMB (Meta Box).
 */
add_action('init', 'actionsmb_loader_100', 9999);
if (!function_exists('actionsmb_loader_100')) {
    function actionsmb_loader_100() {
        // Загружаем только в админке
        if (!is_admin()) {
            return;
        }
        // Если ActionsMB еще не загружен, загружаем его
        if (!defined('ACTIONSMB_LOADED')) {
            define('ACTIONSMB_LOADED', true);
            require_once(trailingslashit(get_template_directory()) . 'inc/class-actionsmb.php');
        }
    }
}

// Регистрируем пользовательские размеры изображений
add_image_size('logo_small', 260, 216, false);
add_image_size('banner-vertical', 748, 1052, false);
add_image_size('obj_big', 1246, 744, true);
add_image_size('obj_small', 230, 150, true);
add_image_size('offer_prev', 560, 320, true);
add_image_size('agent_prev', 240, 240, true);
add_image_size('event_prev', 1160, 680, true);
add_image_size('event_big', 1600, 1072, true);
add_image_size('event_small', 360, 320, true);
add_image_size('news_big', 2360, 870, true);
add_image_size('banner_desc', 2680, 400, true);
add_image_size('news_prev', 760, 440, true);
add_image_size('bazaimage', 758, 594, true);
add_image_size('baza_prev', 360, 240, true);
add_image_size('logo_dev', 1160, 732, false);

/**
 * Функция для вывода пагинации.
 */
function my_pagination() {
    global $wp_query;

    // Определяем текущую страницу
    if (is_front_page()) {
        $currentPage = (get_query_var("page")) ? get_query_var("page") : 1;
    } else {
        $currentPage = (get_query_var("paged")) ? get_query_var("paged") : 1;
    }

    // Генерируем пагинацию
    $pagination = paginate_links([
        "base"      => str_replace(999999999, "%#%", get_pagenum_link(999999999)),
        "format"    => "",
        "current"   => max(1, $currentPage),
        "total"     => $wp_query->max_num_pages,
        "type"      => "list",
        "prev_text" => "«",
        "next_text" => "»",
    ]);

    // Выводим пагинацию
    echo str_replace("page-numbers", "pagination", $pagination);
}

/**
 * Функция для отложенной загрузки JavaScript.
 */
function defer_parsing_of_js($url) {
    if (is_user_logged_in()) {
        return $url; // Не применяем к админке
    }
    if (FALSE === strpos($url, '.js')) {
        return $url;
    }
    if (strpos($url, 'jquery.min.js')) {
        return $url;
    }
    return str_replace(' src', ' defer src', $url);
}
add_filter('script_loader_tag', 'defer_parsing_of_js', 10);

/**
 * AJAX-поиск по сайту.
 */
add_shortcode('asearch', 'asearch_func');
function asearch_func($atts) {
    $atts = shortcode_atts([
        'source' => 'page,post,stroys,agencies',
        'image'  => 'true'
    ], $atts, 'asearch');

    static $asearch_first_call = 1;
    $lang = pll_current_language();
    $langs = get_field('text_search_' . $lang, 'options');
    $source = $atts["source"];
    $image = $atts["image"];

    $sForam = '
    <form class="search-form__form asearch" id="asearch' . $asearch_first_call . '" action="/" method="get" autocomplete="off">
        <input type="text" name="s" placeholder="' . $langs . '..." id="keyword" class="search-form__input input_search" onkeyup="searchFetch(this)"><button id="mybtn" class="search-form__button icon-search" aria-label="Кнопка поиска"></button>
    </form><div class="search_result search-form__content" id="datafetch" style="display: none;">
        <ul class="search-form__links">
            Please wait..
        </ul>
    </div>';

    $java = '<script>
    function searchFetch(e) {
        var datafetch = e.parentElement.nextSibling;
        if (e.value.trim().length > 0) { datafetch.style.display = "block"; } else { datafetch.style.display = "none"; }
        const searchForm = e.parentElement;
        e.nextSibling.value = "Please wait..."
        var formdata' . $asearch_first_call . ' = new FormData(searchForm);
        formdata' . $asearch_first_call . '.append("source", "' . $source . '");
        formdata' . $asearch_first_call . '.append("image", "' . $image . '");
        formdata' . $asearch_first_call . '.append("action", "asearch");
        AjaxAsearch(formdata' . $asearch_first_call . ', e);
    }
    async function AjaxAsearch(formdata, e) {
        const url = "' . admin_url("admin-ajax.php") . '?action=asearch";
        const response = await fetch(url, {
            method: "POST",
            body: formdata,
        });
        const data = await response.text();
        if (data) {
            e.parentElement.nextSibling.innerHTML = data;
        } else {
            e.parentElement.nextSibling.innerHTML = `<ul><a href="#"><li>Sorry, nothing found</li></a></ul>`;
        }
    }
    document.addEventListener("click", function(e) {
        if (document.activeElement.classList.contains("input_search") == false) {
            [...document.querySelectorAll("div.search_result")].forEach(e => e.style.display = "none");
        } else {
            if (e.target.value.trim().length > 0) {
                e.target.parentElement.nextSibling.style.display = "block";
            }
        }
    });
    </script>';

    if ($asearch_first_call == 1) {
        $asearch_first_call++;
        return "{$sForam}{$java}";
    } elseif ($asearch_first_call > 1) {
        $asearch_first_call++;
        return "{$sForam}";
    }
}

// Обработчик AJAX-запросов для поиска
add_action('wp_ajax_asearch', 'asearch');
add_action('wp_ajax_nopriv_asearch', 'asearch');
function asearch() {
    $the_query = new WP_Query([
        'posts_per_page' => 10,
        's'             => esc_attr($_POST['s']),
        'post_type'     => explode(",", esc_attr($_POST['source']))
    ]);

    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <a class="search-form__link icon-arrow-r-t-s" href="<?php echo esc_url(post_permalink()); ?>"><?php the_title(); ?></a>
        <?php endwhile;
        echo '<div class="search-form__bottom">
                <div class="search-form__bottomtitle">Категории</div>
                <div class="search-form__bottomlinks">
                    <a href="' . get_permalink(132) . '" class="search-form__bottomlink">Застройщики</a>
                    <a href="' . get_permalink(191) . '" class="search-form__bottomlink">Объекты</a>
                </div>
              </div>';
        wp_reset_postdata();
    endif;
    die();
}

/**
 * Функция для склонения слов в зависимости от числа.
 */
function num_word($value, $words, $show = true) {
    $num = $value % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    $out = '';
    switch ($num) {
        case 1:  $out .= $words[0]; break;
        case 2:  $out .= $words[1]; break;
        case 3:  $out .= $words[1]; break;
        case 4:  $out .= $words[1]; break;
        default: $out .= $words[2]; break;
    }

    return $out;
}

/**
 * Функции для работы с мета-данными.
 */
function getValuesMeta($meta) {
    global $wpdb;
    $posts = $wpdb->get_results("SELECT DISTINCT meta_value FROM `wp_postmeta` WHERE `meta_key` LIKE '" . $meta . "' GROUP BY `meta_value`");
    return $posts;
}

function getMinMeta($meta) {
    global $wpdb;
    $rez = $wpdb->get_var("SELECT MIN(meta_value) FROM `wp_postmeta` WHERE `meta_key` LIKE '" . $meta . "'");
    return $rez;
}

function getMaxMeta($meta) {
    global $wpdb;
    $rez = $wpdb->get_var("SELECT MAX(meta_value) FROM `wp_postmeta` WHERE `meta_key` LIKE '" . $meta . "'");
    return $rez;
}

/**
 * Функции для работы с отзывами и рейтингами.
 */
function gettotalrev($post_id) {
    global $wpdb;
    $total = $wpdb->get_var("SELECT COUNT(*) as total FROM `wp_postmeta` WHERE `post_id` IN (SELECT `id` FROM `wp_posts` WHERE `post_status` = 'publish') AND `meta_key` LIKE 'object' AND `meta_value`='" . $post_id . "'");
    return $total;
}
/**
 * Функция для получения среднего рейтинга поста.
 * Использует глобальный объект $wpdb для выполнения SQL-запросов.
 *
 * @param int $post_id ID поста, для которого нужно получить рейтинг.
 * @return float Средний рейтинг, округленный до ближайшего 0.5.
 */
function getRate($post_id) {
    global $wpdb;

    // Инициализируем переменную для хранения ID постов
    $arr = "";

    // Получаем все записи из таблицы wp_postmeta, где meta_key = 'object' и meta_value = $post_id
    $posts = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `post_id` IN (SELECT `id` FROM `wp_posts` WHERE `post_status` = 'publish') AND `meta_key` LIKE 'object' AND `meta_value`='" . $post_id . "'");

    // Собираем ID постов в строку, разделенную запятыми
    foreach ($posts as $post) {
        $arr .= $post->post_id . ',';
    }

    // Убираем последнюю запятую
    $arr = chop($arr, ",");

    // Вычисляем средний рейтинг для найденных постов
    $result = $wpdb->get_var("SELECT AVG(meta_value) as mark FROM `wp_postmeta` WHERE `meta_key` LIKE 'mark' AND `post_id` IN (" . $arr . ")");

    // Округляем результат до ближайшего 0.5
    return round($result * 2) / 2;
}

/**
 * Функция для получения среднего значения определенного мета-поля.
 * Аналогична getRate, но позволяет указать тип мета-поля.
 *
 * @param int $post_id ID поста, для которого нужно получить значение.
 * @param string $type Тип мета-поля (например, 'mark', 'quality' и т.д.).
 * @return float Среднее значение, округленное до ближайшего 0.5.
 */
function getMark($post_id, $type) {
    global $wpdb;

    // Инициализируем переменную для хранения ID постов
    $arr = "";

    // Получаем все записи из таблицы wp_postmeta, где meta_key = 'object' и meta_value = $post_id
    $posts = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `post_id` IN (SELECT `id` FROM `wp_posts` WHERE `post_status` = 'publish') AND `meta_key` LIKE 'object' AND `meta_value`='" . $post_id . "'");

    // Собираем ID постов в строку, разделенную запятыми
    foreach ($posts as $post) {
        $arr .= $post->post_id . ',';
    }

    // Убираем последнюю запятую
    $arr = chop($arr, ",");

    // Вычисляем среднее значение для указанного мета-поля
    $result = $wpdb->get_var("SELECT AVG(meta_value) as mark FROM `wp_postmeta` WHERE `meta_key` LIKE '" . $type . "' AND `post_id` IN (" . $arr . ")");

    // Округляем результат до ближайшего 0.5
    return round($result * 2) / 2;
}

/**
 * Удаляет jQuery Migrate для оптимизации загрузки JavaScript.
 * jQuery Migrate используется для обратной совместимости, но часто не нужен.
 *
 * @param object $scripts Объект, содержащий зарегистрированные скрипты.
 */
add_filter('wp_default_scripts', 'remove_jquery_migrate');
function remove_jquery_migrate($scripts) {
    // Проверяем, зарегистрирован ли jQuery и не находимся ли мы в админке
    if (empty($scripts->registered['jquery']) || is_admin()) {
        return;
    }

    // Убираем jQuery Migrate из зависимостей jQuery
    $deps = &$scripts->registered['jquery']->deps;
    $deps = array_diff($deps, ['jquery-migrate']);
}

// Подключаем дополнительные файлы для работы с Meta Box
require_once(trailingslashit(get_template_directory()) . 'inc/actionsmb.php');
require_once(trailingslashit(get_template_directory()) . 'inc/mb-functions.php');

/**
 * Примечание: Не добавляйте пользовательский код здесь. Используйте дочернюю тему или плагин,
 * чтобы изменения не были потеряны при обновлениях.
 * http://wpdevhq.com/theme-customisations
 */
 
 
 // Добавляем страницу настроек
function popup_image_settings_page() {
    add_options_page(
        'Настройки изображения поп-апа',
        'Изображение поп-апа',
        'manage_options',
        'popup-image',
        'popup_image_settings_page_html'
    );
}
add_action('admin_menu', 'popup_image_settings_page');

// Содержимое страницы настроек
function popup_image_settings_page_html() {
    // Сохраняем URL при отправке формы
    if (isset($_POST['popup_image_url'])) {
        update_option('popup_image_url', sanitize_text_field($_POST['popup_image_url']));
        echo '<div class="notice notice-success"><p>Настройки сохранены!</p></div>';
    }
    
    // Получаем текущий URL
    $image_url = get_option('popup_image_url', 'https://balirate.com/wp-content/uploads/2025/04/374x526-min.jpg');
    ?>
    <div class="wrap">
        <h1>Настройка изображения для поп-апа</h1>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th>URL изображения:</th>
                    <td>
                        <input type="text" name="popup_image_url" value="<?php echo esc_attr($image_url); ?>" class="regular-text">
                        <p class="description">Введите URL изображения для поп-апа</p>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="Сохранить">
            </p>
        </form>
    </div>
    <?php
}

// Улучшаем качество JPEG изображений (значение от 0 до 100)
add_filter('jpeg_quality', function($arg) {
    return 90; // Меняем качество на 90% (по умолчанию обычно 82%)
});

// Отключаем автоматическое сжатие WebP изображений (если такое есть)
add_filter('wp_editor_set_quality', function($quality) {
    return 90; // Устанавливаем качество 90% для всех типов изображений
}, 10, 1);

// При необходимости можно увеличить размеры существующих миниатюр
// Например, увеличим размер миниатюры event_big
add_image_size('event_big', 1200, 800, true); // было 800, 536

// Также можно добавить новые высококачественные размеры
add_image_size('high_quality', 1800, 1200, false);

// Регистрация типа записи "Партнеры"
function register_partners_post_type() {
    $labels = array(
        'name'               => 'Партнеры',
        'singular_name'      => 'Партнер',
        'add_new'            => 'Добавить нового',
        'add_new_item'       => 'Добавить нового партнера',
        'edit_item'          => 'Редактировать партнера',
        'new_item'           => 'Новый партнер',
        'view_item'          => 'Просмотреть партнера',
        'search_items'       => 'Найти партнера',
        'not_found'          => 'Партнеры не найдены',
        'not_found_in_trash' => 'Партнеры не найдены в корзине',
        'menu_name'          => 'Партнеры'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'partners'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => array('title')
    );

    register_post_type('partners', $args);
}
add_action('init', 'register_partners_post_type');

/**
 * Регистрация кастомных типов записей для статей и обзоров
 * Добавить в functions.php
 */

// Регистрируем тип записей "Статьи"
add_action('init', 'register_articles_post_type');
function register_articles_post_type() {
    $labels = array(
        'name'               => 'Статьи',
        'singular_name'      => 'Статья',
        'menu_name'          => 'Статьи',
        'add_new'            => 'Добавить статью',
        'add_new_item'       => 'Добавить новую статью',
        'edit_item'          => 'Редактировать статью',
        'new_item'           => 'Новая статья',
        'view_item'          => 'Посмотреть статью',
        'search_items'       => 'Найти статью',
        'not_found'          => 'Статьи не найдены',
        'not_found_in_trash' => 'В корзине статей не найдено'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'stati'), // URL: /stati/название-статьи/
        'capability_type'     => 'post',
        'has_archive'         => false, // Архив отключен, используем кастомную страницу
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-edit-large',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'        => true, // Для Gutenberg
    );

    register_post_type('articles', $args);
}

// Регистрируем тип записей "Обзоры"
add_action('init', 'register_reviews_post_type');
function register_reviews_post_type() {
    $labels = array(
        'name'               => 'Обзоры',
        'singular_name'      => 'Обзор',
        'menu_name'          => 'Обзоры',
        'add_new'            => 'Добавить обзор',
        'add_new_item'       => 'Добавить новый обзор',
        'edit_item'          => 'Редактировать обзор',
        'new_item'           => 'Новый обзор',
        'view_item'          => 'Посмотреть обзор',
        'search_items'       => 'Найти обзор',
        'not_found'          => 'Обзоры не найдены',
        'not_found_in_trash' => 'В корзине обзоров не найдено'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'obzori'), // URL: /obzori/название-обзора/
        'capability_type'     => 'post',
        'has_archive'         => false, // Архив отключен, используем кастомную страницу
        'hierarchical'        => false,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-visibility',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'        => true, // Для Gutenberg
    );

    register_post_type('reviews_posts', $args);
}

// Обновляем правила перезаписи URL при активации темы
add_action('after_switch_theme', 'flush_rewrite_rules');

