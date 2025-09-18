<?php
/**
 * Основной файл функций темы (functions.php).
 * Этот файл подключает дополнительные модули, регистрирует настройки,
 * добавляет пользовательские функции и обеспечивает интеграцию с плагинами.
 *
 * @package actions
 */

// Предотвращаем прямой доступ к файлу
if (!defined('ABSPATH')) {
    exit;
}



/**
 * Инициализация темы
 * Подключаем основные файлы после правильной загрузки WordPress
 */
add_action('after_setup_theme', function() {
    // Подключаем файл инициализации темы
    $init_file = trailingslashit(get_template_directory()) . 'inc/init.php';
    if (file_exists($init_file)) {
        require_once($init_file);
    }

    // Подключаем файл фреймворка темы
    $framework_file = trailingslashit(get_template_directory()) . 'inc/framework.php';
    if (file_exists($framework_file)) {
        require_once($framework_file);
    }

    // Подключаем файл кастомизатора
    $customizer_file = trailingslashit(get_template_directory()) . 'inc/customizer/class-customize.php';
    if (file_exists($customizer_file)) {
        require_once($customizer_file);
    }

    // Подключаем файлы для интеграции с Elementor
    $elementor_custom = trailingslashit(get_template_directory()) . 'elementor/custom.php';
    if (file_exists($elementor_custom)) {
        require_once($elementor_custom);
    }
    
    $elementor_helpers = trailingslashit(get_template_directory()) . 'elementor/helper-functions.php';
    if (file_exists($elementor_helpers)) {
        require_once($elementor_helpers);
    }
});

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
    $contact_form_widget = trailingslashit(get_template_directory()) . 'elementor/widgets/contact-form.php';
    if (file_exists($contact_form_widget)) {
        require_once($contact_form_widget);
    }
}

/**
 * Настройки для пользователей с ролью "подписчик"
 */
add_action('init', function() {
    // Отключаем админ-бар для подписчиков
    if (current_user_can('subscriber') && !is_admin()) {
        show_admin_bar(false);
        add_filter('show_admin_bar', '__return_false');
    }
});

// Перенаправляем подписчиков из админки на главную страницу
add_action('admin_init', function() {
    if (current_user_can('subscriber') && is_admin() && !wp_doing_ajax()) {
        wp_redirect(home_url());
        exit;
    }
});

// Регистрируем новые элементы в Elementor
add_action('elementor/widgets/widgets_registered', 'actions_new_elements');

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
 * Безопасный загрузчик для ActionsMB (Meta Box).
 */
add_action('init', 'actionsmb_loader_safe', 10);
function actionsmb_loader_safe() {
    // Загружаем только в админке
    if (!is_admin()) {
        return;
    }
    
    // Если ActionsMB еще не загружен, загружаем его
    if (!defined('ACTIONSMB_LOADED')) {
        define('ACTIONSMB_LOADED', true);
        
        $actionsmb_file = trailingslashit(get_template_directory()) . 'inc/class-actionsmb.php';
        if (file_exists($actionsmb_file)) {
            require_once($actionsmb_file);
        }
    }
}

/**
 * Регистрация пользовательских размеров изображений
 */
add_action('after_setup_theme', function() {
    // Основные размеры
    add_image_size('logo_small', 260, 216, false);
    add_image_size('banner-vertical', 748, 1052, false);
    add_image_size('obj_big', 1246, 744, true);
    add_image_size('obj_small', 230, 150, true);
    add_image_size('offer_prev', 560, 320, true);
    add_image_size('agent_prev', 240, 240, true);
    
    // Размеры для событий
    add_image_size('event_prev', 1160, 680, true);
    add_image_size('event_big', 1600, 1072, true);
    add_image_size('event_small', 360, 320, true);
    
    // Размеры для новостей и баннеров
    add_image_size('news_big', 2360, 870, true);
    add_image_size('banner_desc', 2680, 400, true);
    add_image_size('news_prev', 760, 440, true);
    
    // Размеры для базы данных
    add_image_size('bazaimage', 758, 594, true);
    add_image_size('baza_prev', 360, 240, true);
    add_image_size('logo_dev', 1160, 732, false);
    
    // Высококачественные размеры
    add_image_size('high_quality', 1800, 1200, false);
});

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
    if ($pagination) {
        echo str_replace("page-numbers", "pagination", $pagination);
    }
}

/**
 * Функция для отложенной загрузки JavaScript.
 */
function defer_parsing_of_js($url) {
    if (is_user_logged_in() || is_admin()) {
        return $url; // Не применяем к админке
    }
    
    if (strpos($url, '.js') === false) {
        return $url;
    }
    
    if (strpos($url, 'jquery.min.js') !== false) {
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
    $lang = substr(get_locale(), 0, 2);
    $label = function_exists('get_field') ? get_field('text_search_' . $lang, 'options') : 'Поиск';
    $source = sanitize_text_field($atts["source"]);
    $image = sanitize_text_field($atts["image"]);

    $sForam = '
    <form class="search-form__form asearch" id="asearch' . $asearch_first_call . '" action="/" method="get" autocomplete="off">
        <input type="text" name="s" placeholder="' . esc_attr($label) . '..." id="keyword" class="search-form__input input_search" onkeyup="searchFetch(this)">
        <button id="mybtn" class="search-form__button icon-search" aria-label="Кнопка поиска"></button>
    </form>
    <div class="search_result search-form__content" id="datafetch" style="display: none;">
        <ul class="search-form__links">
            Please wait..
        </ul>
    </div>';

    $java = '<script>
    function searchFetch(e) {
        var datafetch = e.parentElement.nextSibling;
        if (e.value.trim().length > 0) { 
            datafetch.style.display = "block"; 
        } else { 
            datafetch.style.display = "none"; 
            return;
        }
        
        const searchForm = e.parentElement;
        var formdata' . $asearch_first_call . ' = new FormData(searchForm);
        formdata' . $asearch_first_call . '.append("source", "' . $source . '");
        formdata' . $asearch_first_call . '.append("image", "' . $image . '");
        formdata' . $asearch_first_call . '.append("action", "asearch");
        formdata' . $asearch_first_call . '.append("nonce", "' . wp_create_nonce('asearch_nonce') . '");
        
        AjaxAsearch(formdata' . $asearch_first_call . ', e);
    }
    
    async function AjaxAsearch(formdata, e) {
        try {
            const url = "' . admin_url("admin-ajax.php") . '";
            const response = await fetch(url, {
                method: "POST",
                body: formdata,
            });
            const data = await response.text();
            if (data) {
                e.parentElement.nextSibling.innerHTML = data;
            } else {
                e.parentElement.nextSibling.innerHTML = `<ul><li>Ничего не найдено</li></ul>`;
            }
        } catch (error) {
            console.error("Search error:", error);
            e.parentElement.nextSibling.innerHTML = `<ul><li>Ошибка поиска</li></ul>`;
        }
    }
    
    document.addEventListener("click", function(e) {
        if (!document.activeElement.classList.contains("input_search")) {
            [...document.querySelectorAll("div.search_result")].forEach(el => el.style.display = "none");
        } else {
            if (e.target.value.trim().length > 0) {
                e.target.parentElement.nextSibling.style.display = "block";
            }
        }
    });
    </script>';

    if ($asearch_first_call == 1) {
        $asearch_first_call++;
        return $sForam . $java;
    } else {
        $asearch_first_call++;
        return $sForam;
    }
}

// Обработчик AJAX-запросов для поиска
add_action('wp_ajax_asearch', 'asearch_handler');
add_action('wp_ajax_nopriv_asearch', 'asearch_handler');
function asearch_handler() {
    // Проверка безопасности
    if (!wp_verify_nonce($_POST['nonce'], 'asearch_nonce')) {
        wp_die('Security check failed');
    }
    
    $search_term = sanitize_text_field($_POST['s']);
    $post_types = array_map('sanitize_text_field', explode(",", $_POST['source']));
    
    if (empty($search_term)) {
        wp_die();
    }
    
    $the_query = new WP_Query([
        'posts_per_page' => 10,
        's'             => $search_term,
        'post_type'     => $post_types,
        'post_status'   => 'publish'
    ]);

    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <a class="search-form__link icon-arrow-r-t-s" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
        <?php endwhile;
        
        echo '<div class="search-form__bottom">
                <div class="search-form__bottomtitle">Категории</div>
                <div class="search-form__bottomlinks">
                    <a href="' . esc_url(get_permalink(132)) . '" class="search-form__bottomlink">Застройщики</a>
                    <a href="' . esc_url(get_permalink(191)) . '" class="search-form__bottomlink">Объекты</a>
                </div>
              </div>';
        wp_reset_postdata();
    endif;
    
    wp_die();
}

/**
 * Функция для склонения слов в зависимости от числа.
 */
function num_word($value, $words, $show = true) {
    $num = absint($value) % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    $out = '';
    switch ($num) {
        case 1:  $out = $words[0]; break;
        case 2:
        case 3:
        case 4:  $out = $words[1]; break;
        default: $out = $words[2]; break;
    }

    return $out;
}

/**
 * Безопасные функции для работы с мета-данными.
 */
function getValuesMeta($meta) {
    global $wpdb;
    
    $meta = sanitize_text_field($meta);
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value != '' GROUP BY meta_value",
        $meta
    ));
    
    return $results;
}

function getMinMeta($meta) {
    global $wpdb;
    
    $meta = sanitize_text_field($meta);
    $result = $wpdb->get_var($wpdb->prepare(
        "SELECT MIN(CAST(meta_value AS UNSIGNED)) FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value != ''",
        $meta
    ));
    
    return $result;
}

function getMaxMeta($meta) {
    global $wpdb;
    
    $meta = sanitize_text_field($meta);
    $result = $wpdb->get_var($wpdb->prepare(
        "SELECT MAX(CAST(meta_value AS UNSIGNED)) FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value != ''",
        $meta
    ));
    
    return $result;
}

/**
 * Функции для работы с отзывами и рейтингами.
 */
function gettotalrev($post_id) {
    global $wpdb;
    
    $post_id = absint($post_id);
    $total = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->postmeta} pm 
         INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID 
         WHERE p.post_status = 'publish' AND pm.meta_key = 'object' AND pm.meta_value = %s",
        $post_id
    ));
    
    return absint($total);
}

/**
 * Функция для получения среднего рейтинга поста.
 */
function getRate($post_id) {
    global $wpdb;
    
    $post_id = absint($post_id);
    
    // Получаем ID всех опубликованных отзывов для данного объекта
    $review_ids = $wpdb->get_col($wpdb->prepare(
        "SELECT pm.post_id FROM {$wpdb->postmeta} pm 
         INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID 
         WHERE p.post_status = 'publish' AND pm.meta_key = 'object' AND pm.meta_value = %s",
        $post_id
    ));
    
    if (empty($review_ids)) {
        return 0;
    }
    
    // Получаем средний рейтинг
    $placeholders = implode(',', array_fill(0, count($review_ids), '%d'));
    $query = "SELECT AVG(CAST(meta_value AS DECIMAL(3,2))) FROM {$wpdb->postmeta} 
              WHERE meta_key = 'mark' AND post_id IN ($placeholders)";
    
    $result = $wpdb->get_var($wpdb->prepare($query, $review_ids));
    
    // Округляем до ближайшего 0.5
    return round(floatval($result) * 2) / 2;
}

/**
 * Функция для получения среднего значения определенного мета-поля.
 */
function getMark($post_id, $type) {
    global $wpdb;
    
    $post_id = absint($post_id);
    $type = sanitize_text_field($type);
    
    // Получаем ID всех опубликованных отзывов для данного объекта
    $review_ids = $wpdb->get_col($wpdb->prepare(
        "SELECT pm.post_id FROM {$wpdb->postmeta} pm 
         INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID 
         WHERE p.post_status = 'publish' AND pm.meta_key = 'object' AND pm.meta_value = %s",
        $post_id
    ));
    
    if (empty($review_ids)) {
        return 0;
    }
    
    // Получаем среднее значение для указанного мета-поля
    $placeholders = implode(',', array_fill(0, count($review_ids), '%d'));
    $query = "SELECT AVG(CAST(meta_value AS DECIMAL(3,2))) FROM {$wpdb->postmeta} 
              WHERE meta_key = %s AND post_id IN ($placeholders)";
    
    $params = array_merge([$type], $review_ids);
    $result = $wpdb->get_var($wpdb->prepare($query, $params));
    
    // Округляем до ближайшего 0.5
    return round(floatval($result) * 2) / 2;
}

/**
 * Удаляет jQuery Migrate для оптимизации загрузки JavaScript.
 */
add_filter('wp_default_scripts', 'remove_jquery_migrate');
function remove_jquery_migrate($scripts) {
    if (empty($scripts->registered['jquery']) || is_admin()) {
        return;
    }

    $deps = &$scripts->registered['jquery']->deps;
    $deps = array_diff($deps, ['jquery-migrate']);
}

/**
 * Улучшение качества изображений
 */
add_filter('jpeg_quality', function($quality) {
    return 90;
});

add_filter('wp_editor_set_quality', function($quality) {
    return 90;
});

/**
 * Подключение дополнительных файлов Meta Box
 */
add_action('init', function() {
    $files_to_include = [
        'inc/actionsmb.php',
        'inc/mb-functions.php'
    ];
    
    foreach ($files_to_include as $file) {
        $file_path = trailingslashit(get_template_directory()) . $file;
        if (file_exists($file_path)) {
            require_once($file_path);
        }
    }
}, 15);

/**
 * Настройки поп-апа с изображением
 */
add_action('admin_menu', 'popup_image_settings_page');
function popup_image_settings_page() {
    add_options_page(
        'Настройки изображения поп-апа',
        'Изображение поп-апа',
        'manage_options',
        'popup-image',
        'popup_image_settings_page_html'
    );
}

function popup_image_settings_page_html() {
    if (isset($_POST['popup_image_url']) && wp_verify_nonce($_POST['_wpnonce'], 'popup_image_settings')) {
        update_option('popup_image_url', esc_url_raw($_POST['popup_image_url']));
        echo '<div class="notice notice-success"><p>Настройки сохранены!</p></div>';
    }
    
    $image_url = get_option('popup_image_url', 'https://balirate.com/wp-content/uploads/2025/04/374x526-min.jpg');
    $nonce = wp_create_nonce('popup_image_settings');
    ?>
    <div class="wrap">
        <h1>Настройка изображения для поп-апа</h1>
        <form method="post">
            <?php wp_nonce_field('popup_image_settings'); ?>
            <table class="form-table">
                <tr>
                    <th>URL изображения:</th>
                    <td>
                        <input type="url" name="popup_image_url" value="<?php echo esc_attr($image_url); ?>" class="regular-text">
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

/**
 * Регистрация кастомных типов записей
 */
add_action('init', 'register_custom_post_types');
function register_custom_post_types() {
    // Регистрация типа записи "Партнеры"
    register_post_type('partners', [
        'labels' => [
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
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'partners'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => ['title', 'editor', 'thumbnail'],
        'show_in_rest'        => true
    ]);

    // Регистрация типа записи "Статьи"
    register_post_type('stati', [
        'labels' => [
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
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'stati'],
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 26,
        'menu_icon'           => 'dashicons-edit-large',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'        => true
    ]);

    // Регистрация типа записи "Обзоры"
    register_post_type('reviews_posts', [
        'labels' => [
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
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'obzori'],
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 27,
        'menu_icon'           => 'dashicons-visibility',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'        => true
    ]);
}

// Обновляем правила перезаписи URL при активации темы
add_action('after_switch_theme', 'flush_rewrite_rules');

/**
 * Функции для ротации баннеров
 */
function rotate_banners_on_refresh() {
    $refresh_count = get_option('banner_refresh_count', 0);
    $current_banner_set = get_option('current_banner_set', 0);
    
    $refresh_count++;
    
    if ($refresh_count >= 3) {
        $current_banner_set = ($current_banner_set + 1) % 4;
        $refresh_count = 0;
        
        update_option('current_banner_set', $current_banner_set);
    }
    
    update_option('banner_refresh_count', $refresh_count);
    
    return $current_banner_set;
}

/**
 * Получение текущего набора баннеров
 */
function get_current_banner_set() {
    // return get_option('current_banner_set', 0);
    return 0;
}

/**
 * Сброс счетчика (для админки)
 */
function reset_banner_rotation() {
    update_option('banner_refresh_count', 0);
    update_option('current_banner_set', 0);
}

/**
 * Хук для ротации баннеров при загрузке главной страницы
 */
add_action('template_redirect', function() {
    if (is_front_page() && !is_admin()) {
        rotate_banners_on_refresh();
    }
});

/**
 * Добавляем CSS и JavaScript для ротации баннеров
 */
add_action('wp_head', function() {
    if (is_front_page()) {
        $current_set = get_current_banner_set();
        ?>
        <style>
        .banner-rotation-active {
            animation: bannerFadeIn 0.5s ease-in-out;
        }
        
        @keyframes bannerFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .dynamic-banner-container [data-tab]:not([data-tab="<?php echo esc_attr($current_set); ?>"]) {
            display: none !important;
        }
        
        .dynamic-banner-container [data-tab="<?php echo esc_attr($current_set); ?>"] {
            display: block !important;
            animation: bannerFadeIn 0.5s ease-in-out;
        }
        </style>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentBannerSet = <?php echo absint($current_set); ?>;
            
            // Показываем текущий набор баннеров
            showBannerSet(currentBannerSet);
            
            // Функция показа набора баннеров
            function showBannerSet(setIndex) {
                // Скрываем все баннеры
                document.querySelectorAll('.dynamic-top-banner [data-tab], .dynamic-side-banners [data-tab], .dynamic-bottom-banner [data-tab]').forEach(function(el) {
                    el.style.display = 'none';
                });
                
                // Показываем баннеры для текущего набора
                document.querySelectorAll('[data-tab="' + setIndex + '"]').forEach(function(el) {
                    el.style.display = '';
                    el.classList.add('banner-rotation-active');
                });
                
                // Активируем соответствующую вкладку
                const tabButtons = document.querySelectorAll('.first__tabstitle');
                const tabContents = document.querySelectorAll('.first__tabsbody');
                
                tabButtons.forEach(function(btn, index) {
                    if (index === setIndex) {
                        btn.classList.add('_tab-active');
                    } else {
                        btn.classList.remove('_tab-active');
                    }
                });
                
                tabContents.forEach(function(content, index) {
                    if (index === setIndex) {
                        content.style.display = 'block';
                    } else {
                        content.style.display = 'none';
                    }
                });
            }
            
            // Обработчик клика по вкладкам
            const tabButtons = document.querySelectorAll('.first__tabstitle');
            tabButtons.forEach(function(button, index) {
                button.addEventListener('click', function() {
                    showBannerSet(index);
                });
            });
        });
        </script>
        <?php
    }
});

/**
 * Админ-панель для управления ротацией баннеров
 */
add_action('admin_menu', function() {
    add_submenu_page(
        'options-general.php',
        'Ротация баннеров',
        'Ротация баннеров',
        'manage_options',
        'banner-rotation',
        'banner_rotation_admin_page'
    );
});

function banner_rotation_admin_page() {
    if (isset($_POST['reset_rotation']) && wp_verify_nonce($_POST['_wpnonce'], 'banner_rotation_reset')) {
        reset_banner_rotation();
        echo '<div class="notice notice-success"><p>Ротация баннеров сброшена!</p></div>';
    }
    
    $refresh_count = get_option('banner_refresh_count', 0);
    $current_set = get_option('current_banner_set', 0);
    
    ?>
    <div class="wrap">
        <h1>Управление ротацией баннеров</h1>
        
        <table class="form-table">
            <tr>
                <th>Текущий счетчик обновлений:</th>
                <td><?php echo absint($refresh_count); ?> из 3</td>
            </tr>
            <tr>
                <th>Текущий набор баннеров:</th>
                <td>Набор <?php echo absint($current_set) + 1; ?></td>
            </tr>
            <tr>
                <th>До смены набора:</th>
                <td><?php echo 3 - absint($refresh_count); ?> обновлений</td>
            </tr>
        </table>
        
        <form method="post">
            <?php wp_nonce_field('banner_rotation_reset'); ?>
            <p class="submit">
                <input type="submit" name="reset_rotation" class="button-primary" value="Сбросить ротацию">
            </p>
        </form>
        
        <h3>Инструкция по настройке</h3>
        <ol>
            <li>В ACF для каждой вкладки добавьте поля:
                <ul>
                    <li><code>banner_pk</code> - верхний баннер для десктопа</li>
                    <li><code>banner_mob</code> - верхний баннер для мобилок</li>
                    <li><code>banner_url</code> - ссылка верхнего баннера</li>
                    <li><code>bottom_banner_pk</code> - нижний баннер для десктопа</li>
                    <li><code>bottom_banner_mob</code> - нижний баннер для мобилок</li>
                    <li><code>bottom_banner_url</code> - ссылка нижнего баннера</li>
                    <li><code>side_banners</code> - боковые баннеры (repeater)</li>
                </ul>
            </li>
            <li>Баннеры будут автоматически меняться каждые 3 обновления главной страницы</li>
            <li>Пользователи могут вручную переключать вкладки, что также меняет баннеры</li>
        </ol>
    </div>
    <?php
}

/**
 * Дополнительные функции безопасности
 */

// Защита от прямого доступа к PHP файлам
add_action('init', function() {
    if (!defined('ABSPATH')) {
        exit;
    }
});

// Удаление лишних мета-тегов из head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

// Отключение XML-RPC для безопасности
add_filter('xmlrpc_enabled', '__return_false');

// Скрытие версии WordPress
function remove_wp_version_strings($src) {
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (isset($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'remove_wp_version_strings');
add_filter('style_loader_src', 'remove_wp_version_strings');

/**
 * Оптимизация производительности
 */

// Отключение эмодзи для ускорения сайта
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

// Отключение лишних RSS-ссылок
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);

/**
 * Улучшение SEO
 */

// Очистка тега title от лишнего текста
add_filter('wp_title', function($title) {
    return trim($title);
});

// Добавление мета-тега viewport для мобильных устройств
add_action('wp_head', function() {
    if (!is_admin()) {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
    }
}, 1);

/**
 * Обработка ошибок и логирование
 */

// Функция для безопасного логирования
function safe_error_log($message) {
    if (WP_DEBUG && WP_DEBUG_LOG) {
        error_log('[Theme Functions] ' . $message);
    }
}

// Обработчик критических ошибок
function handle_critical_error($error) {
    safe_error_log('Critical error: ' . $error);
    
    if (!is_admin()) {
        wp_die('На сайте произошла критическая ошибка. Пожалуйста, обратитесь к администратору.');
    }
}

/**
 * Финальная инициализация
 */
add_action('wp_loaded', function() {
    // Проверяем, что все критически важные функции загружены
    if (!function_exists('wp_verify_nonce')) {
        handle_critical_error('WordPress core functions not loaded');
        return;
    }
    
    // Логируем успешную загрузку темы
    safe_error_log('Theme functions loaded successfully');
});

/**
 * Примечание: Не добавляйте пользовательский код здесь. 
 * Используйте дочернюю тему или плагин, чтобы изменения не были потеряны при обновлениях.
 * http://wpdevhq.com/theme-customisations
 */

//define( 'PLL_REMOVE_ALL_DATA', true );

function yourtheme_setup() {
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'yourtheme_setup' );


// Добавить в functions.php или создать отдельный файл inc/acf-video-fields.php

// ACF поля для главной страницы (ID = 2)
if( function_exists('acf_add_local_field_group') ):

// Группа полей для видео на главной странице
acf_add_local_field_group(array(
    'key' => 'group_video_homepage',
    'title' => 'Видео секция на главной',
    'fields' => array(
        array(
            'key' => 'field_video_section_enable',
            'label' => 'Включить секцию видео',
            'name' => 'video_section_enable',
            'type' => 'true_false',
            'default_value' => 0,
        ),
        array(
            'key' => 'field_video_title',
            'label' => 'Заголовок секции',
            'name' => 'video_title',
            'type' => 'text',
            'default_value' => 'Видео от застройщиков',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_video_section_enable',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_video_list',
            'label' => 'Список видео',
            'name' => 'video_list',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Добавить видео',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_video_section_enable',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'sub_fields' => array(
                array(
                    'key' => 'field_video_url',
                    'label' => 'YouTube URL',
                    'name' => 'video_url',
                    'type' => 'url',
                    'placeholder' => 'https://www.youtube.com/watch?v=...',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_video_title',
                    'label' => 'Название видео',
                    'name' => 'video_title',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_video_developer',
                    'label' => 'Застройщик',
                    'name' => 'video_developer',
                    'type' => 'post_object',
                    'post_type' => array('stroys'),
                    'return_format' => 'object',
                ),
                array(
                    'key' => 'field_video_thumbnail',
                    'label' => 'Кастомная обложка (необязательно)',
                    'name' => 'video_thumbnail',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page',
                'operator' => '==',
                'value' => '2', // ID главной страницы
            ),
        ),
    ),
));

// Группа полей для видео застройщиков
acf_add_local_field_group(array(
    'key' => 'group_developer_videos',
    'title' => 'Видео застройщика',
    'fields' => array(
        array(
            'key' => 'field_developer_videos',
            'label' => 'Видео компании',
            'name' => 'company_videos',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Добавить видео',
            'sub_fields' => array(
                array(
                    'key' => 'field_company_video_url',
                    'label' => 'YouTube URL',
                    'name' => 'video_url',
                    'type' => 'url',
                    'placeholder' => 'https://www.youtube.com/watch?v=...',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_company_video_title',
                    'label' => 'Название видео',
                    'name' => 'video_title',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_company_video_description',
                    'label' => 'Описание',
                    'name' => 'video_description',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'stroys',
            ),
        ),
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'agencies',
            ),
        ),
    ),
));

endif;


/**
 * Получает ID видео из YouTube URL
 */
function get_youtube_video_id($url) {
    if (empty($url)) return false;
    
    $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
    preg_match($pattern, $url, $matches);
    
    return isset($matches[1]) ? $matches[1] : false;
}

/**
 * Получает URL превью для YouTube видео
 */
function get_youtube_thumbnail($video_id, $quality = 'maxresdefault') {
    if (empty($video_id)) return false;
    
    // Попробуем высокое качество, если не найдет - используем стандартное
    $high_quality = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
    $standard_quality = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
    
    // Проверяем доступность высокого качества
    $headers = @get_headers($high_quality);
    if ($headers && strpos($headers[0], '200')) {
        return $high_quality;
    }
    
    return $standard_quality;
}

/**
 * Генерирует embed URL для YouTube
 */
function get_youtube_embed_url($video_id, $autoplay = false, $controls = true) {
    if (empty($video_id)) return false;
    
    $params = array(
        'rel' => 0,
        'showinfo' => 0,
        'modestbranding' => 1,
    );
    
    if ($autoplay) {
        $params['autoplay'] = 1;
    }
    
    if (!$controls) {
        $params['controls'] = 0;
    }
    
    $query = http_build_query($params);
    
    return "https://www.youtube.com/embed/{$video_id}?{$query}";
}

/**
 * Безопасное получение информации о видео через oEmbed
 */
function get_youtube_video_info($url) {
    if (empty($url)) return false;
    
    $oembed_url = "https://www.youtube.com/oembed?url=" . urlencode($url) . "&format=json";
    
    $response = wp_remote_get($oembed_url, array(
        'timeout' => 10,
        'sslverify' => false
    ));
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return false;
    }
    
    return $data;
}

/**
 * =================================================================
 * ИСПРАВЛЕНИЕ TRANSLATEPRESS
 * =================================================================
 */

// Принудительная регистрация строк для TranslatePress
function force_translatepress_strings() {
    if (function_exists('trp_get_current_language')) {
        add_filter('gettext', function($translation, $text, $domain) {
            // Список строк для перевода
            $strings_to_translate = [
                'Вопросы и ответы',
                'Последние новости', 
                'Мероприятия',
                'Новости',
                'Отзывы на девелоперов',
                'Официальные партнеры',
                'Смотреть весь список',
                'Скачать каталог',
                'Смотреть все объекты',
                'Больше о недвижимости',
                'Лучшие девелоперы',
                'Выбор Агентов',
                'Надежные девелоперы',
                'Девелоперы премиум сегмента',
                'Девелоперы бизнес+ сегмента',
                'Агентства недвижимости'
            ];
            
            if (in_array($text, $strings_to_translate)) {
                return apply_filters('trp_translate_gettext', $translation, $text, $domain);
            }
            
            return $translation;
        }, 10, 3);
    }
}
add_action('init', 'force_translatepress_strings', 20);

// Принудительное сканирование строк
function custom_translatepress_scan_strings($strings) {
    $custom_strings = [
        'Вопросы и ответы',
        'Последние новости',
        'Мероприятия', 
        'Новости',
        'Отзывы на девелоперов',
        'Официальные партнеры',
        'Смотреть весь список',
        'Скачать каталог',
        'Смотреть все объекты',
        'Больше о недвижимости',
        'Лучшие девелоперы',
        'Выбор Агентов',
        'Надежные девелоперы',
        'Девелоперы премиум сегмента',
        'Девелоперы бизнес+ сегмента',
        'Агентства недвижимости'
    ];
    
    foreach ($custom_strings as $string) {
        $strings[] = $string;
    }
    
    return $strings;
}
add_filter('trp_scan_gettext_strings', 'custom_translatepress_scan_strings');

// Включаем динамический перевод
add_filter('trp_enable_dynamic_translation', '__return_true');
add_filter('trp_allow_tp_to_run', '__return_true');


// ==============================================
// 3. ДОБАВИТЬ В САМЫЙ КОНЕЦ ФАЙЛА
// ==============================================
// Отключаем ACF переводы
if (function_exists('acf_get_setting')) {
    remove_action('plugins_loaded', 'acf_load_textdomain', 5);
}

// Константа PLL (исправленная версия)
if (!defined('PLL_REMOVE_ALL_DATA')) {
    define('PLL_REMOVE_ALL_DATA', true);
}

// Регистрация управляющих компаний
add_action('init', function() {
    register_post_type('propertymanagement', [
        'labels' => [
            'name'               => 'Управляющие компании',
            'singular_name'      => 'Управляющая компания',
            'add_new'            => 'Добавить новую',
            'add_new_item'       => 'Добавить управляющую компанию',
            'edit_item'          => 'Редактировать УК',
            'new_item'           => 'Новая УК',
            'view_item'          => 'Просмотреть УК',
            'search_items'       => 'Найти УК',
            'not_found'          => 'УК не найдены',
            'not_found_in_trash' => 'УК не найдены в корзине',
            'menu_name'          => 'Управляющие компании'
        ],
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => [
            'slug' => 'property-management', 
            'with_front' => false
        ],
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 28,
        'menu_icon'           => 'dashicons-building',
        'supports'            => ['title', 'editor', 'thumbnail'],
        'show_in_rest'        => true
    ]);
    
    // Правила для uk-rating
    add_rewrite_rule(
        '^uk-rating/?([0-9]+)?/?$',
        'index.php?pagename=uk-rating&paged=$matches[1]',
        'top'
    );
}, 15);

// Обработка шаблонов
add_filter('template_include', function($template) {
    if (is_singular('propertymanagement')) {
        $new_template = locate_template(['single-propertymanagement.php']);
        if ($new_template) return $new_template;
    }
    
    global $wp_query;
    if (isset($wp_query->query_vars['pagename']) && $wp_query->query_vars['pagename'] === 'uk-rating') {
        $new_template = locate_template(['page-ukrating.php']);
        if ($new_template) return $new_template;
    }
    
    return $template;
});

// Виртуальная страница uk-rating
add_filter('the_posts', function($posts, $query) {
    if ($query->is_main_query() && 
        isset($query->query_vars['pagename']) && 
        $query->query_vars['pagename'] === 'uk-rating') {
        
        $virtual_post = new stdClass();
        $virtual_post->ID = -999;
        $virtual_post->post_title = 'Рейтинг управляющих компаний';
        $virtual_post->post_content = '';
        $virtual_post->post_status = 'publish';
        $virtual_post->post_type = 'page';
        $virtual_post->post_author = 1;
        $virtual_post->post_date = current_time('mysql');
        $virtual_post->post_name = 'uk-rating';
        $virtual_post->guid = home_url('/uk-rating/');
        $virtual_post->comment_status = 'closed';
        $virtual_post->ping_status = 'closed';
        
        $virtual_post = new WP_Post($virtual_post);
        $posts = [$virtual_post];
        
        $query->is_page = true;
        $query->is_singular = true;
        $query->is_home = false;
        $query->is_archive = false;
        $query->is_404 = false;
        $query->found_posts = 1;
        $query->post_count = 1;
    }
    
    return $posts;
}, 10, 2);

// ВРЕМЕННО - раскомментировать на 1 минуту
/*
add_action('wp_loaded', function() {
    flush_rewrite_rules(true);
}, 999);
*/