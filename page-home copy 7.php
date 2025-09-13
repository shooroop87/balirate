<?php
/**
 * Главный шаблон страницы (page-home.php) с динамическими баннерами.
 */

get_header(); 

$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
?>

<?php if (!empty($page_fields['tabs'])) { ?>
<section class="first">
  <div class="first__container">

    <!-- Рекламный баннер сверху (динамический) -->
    <div class="dynamic-top-banner">
      <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
        <?php if (!empty($tab['list'])) : ?>
          <div class="banner-content" data-tab="<?= esc_attr($num) ?>" style="<?= $num === 0 ? '' : 'display: none;' ?>">
            <?php if (!empty($tab['banner_pk'])) : ?>
              <a href="#" data-popup="#popup-lead" class="w-100">
                <img src="<?= esc_url($tab['banner_pk']['sizes']['banner_desc']) ?>" class="banner-pk" alt="<?= esc_attr($tab['banner_pk']['alt']) ?>">
              </a>
            <?php endif; ?>
            
            <?php if (!empty($tab['banner_mob'])) : ?>
              <a href="#" data-popup="#popup-lead" class="w-100">
                <img src="<?= esc_url($tab['banner_mob']['sizes']['banner-vertical']) ?>" class="banner-mob" alt="<?= esc_attr($tab['banner_mob']['alt']) ?>">
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <h1 class="first__title title"><?= esc_html($page_fields['rating_title'] ?? '') ?></h1>

    <div class="first__body">
      <div class="first__left">
        <!-- Вкладки -->
        <div data-tabs class="first__tabs">
          <?php
          // Массив иконок для каждой вкладки
          $tab_icons = [
              'Лучшие девелоперы' => 'https://balirate.com/wp-content/uploads/2025/06/group-1.png',
              'Выбор Агентов' => 'https://balirate.com/wp-content/uploads/2025/06/group-7.png', 
              'Надежные девелоперы' => 'https://balirate.com/wp-content/uploads/2025/06/group-4.png',
              'Девелоперы премиум сегмента' => 'https://balirate.com/wp-content/uploads/2025/06/group-5.png',
              'Девелоперы бизнес+ сегмента' => 'https://balirate.com/wp-content/uploads/2025/06/group-8.png',
              'Агентства недвижимости' => 'https://balirate.com/wp-content/uploads/2025/06/group-4-1.png'
          ];
          ?>

          <nav data-tabs-titles class="first__tabsnavigation">
            <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
              <?php if (!empty($tab['list'])) : ?>
                <button type="button" class="first__tabstitle <?= $num === 0 ? '_tab-active' : '' ?>" data-tab-index="<?= esc_attr($num) ?>">
                  <?php 
                    $title = $tab['title'] ?? '';
                    $icon_url = isset($tab_icons[$title]) ? $tab_icons[$title] : '';
                  ?>
                  <?php if ($icon_url): ?>
                    <img src="<?= esc_url($icon_url) ?>" alt="<?= esc_attr($title) ?>" class="tab-icon">
                  <?php endif; ?>
                  <span class="tab-text"><?= esc_html($title) ?></span>
                </button>
              <?php endif; ?>
            <?php endforeach; ?>
          </nav>

          <!-- Контент вкладок -->
          <div data-tabs-body class="first__tabscontent">
            <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
              <?php if (!empty($tab['list'])) : ?>
                <div class="first__tabsbody" data-tab-content="<?= esc_attr($num) ?>">
                  <div class="first__rows">
                    <?php foreach ($tab['list'] as $item): ?>
                      <?php get_template_part('templates/item', null, $item); ?>
                    <?php endforeach; ?>
                  </div>
                  <div class="first__leftbottom">
                    <a href="<?= esc_url(get_permalink(132)) ?>" class="first__leftlink button button--gray">Смотреть весь список</a>
                    <div class="first__tippy"
                      data-tippy-content="<strong><?= esc_attr($page_fields['rate_text'] ?? '') ?></strong><br/><br/><p><?= esc_attr($page_fields['rate_text2'] ?? '') ?></p>"
                      data-tippy-allowhtml="true"
                      data-tippy-placement="bottom-end"
                      data-tippy-arrow="false">
                      <?= esc_html($page_fields['rate_text'] ?? '') ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Боковые баннеры (динамические) -->
      <div class="first__right first__right--mt">
        <div class="first__rightitems adsitems">
          <div class="dynamic-side-banners">
            <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
              <?php if (!empty($tab['list'])) : ?>
                <div class="side-banners-content" data-tab="<?= esc_attr($num) ?>" style="<?= $num === 0 ? '' : 'display: none;' ?>">
                  <?php if (!empty($tab['side_banners'])) : ?>
                    <?php foreach ($tab['side_banners'] as $banner): ?>
                      <div class="adsitems__item adsitems-item">
                        <a href="#" data-popup="#popup-lead">
                          <img src="<?= esc_url($banner['image']['sizes']['banner-vertical']) ?>" alt="<?= esc_attr($banner['name'] ?? '') ?>" loading="lazy">
                        </a>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Нижний баннер (динамический) -->
    <div class="dynamic-bottom-banner">
      <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
        <?php if (!empty($tab['list'])) : ?>
          <div class="bottom-banner-content" data-tab="<?= esc_attr($num) ?>" style="<?= $num === 0 ? '' : 'display: none;' ?>">
            <?php if (!empty($tab['bottom_banner_pk'])) : ?>
              <a href="#" data-popup="#popup-lead" class="w-100">
                <img src="<?= esc_url($tab['bottom_banner_pk']['sizes']['banner_desc']) ?>" class="banner-pk __bottom" alt="<?= esc_attr($tab['bottom_banner_pk']['alt']) ?>">
              </a>
            <?php endif; ?>
            
            <?php if (!empty($tab['bottom_banner_mob'])) : ?>
              <a href="#" data-popup="#popup-lead" class="w-100">
                <img src="<?= esc_url($tab['bottom_banner_mob']['sizes']['banner-vertical']) ?>" class="banner-mob __bottom" alt="<?= esc_attr($tab['bottom_banner_mob']['alt']) ?>">
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- JavaScript для смены баннеров -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const tabButtons = document.querySelectorAll('.first__tabstitle');
  tabButtons.forEach(button => {
    button.addEventListener('click', function() {
      const tabIndex = this.getAttribute('data-tab-index');
      document.querySelectorAll('[data-tab]').forEach(el => { el.style.display = 'none'; });
      document.querySelectorAll('[data-tab="'+tabIndex+'"]').forEach(el => { el.style.display = ''; });
    });
  });
});
</script>
<?php } ?>

<?php 
// --- СЕКЦИЯ "ПРЕДЛОЖЕНИЯ" (объекты) ---
if (!empty($page_fields['offers'])) { ?>
<section class="offers">
  <div class="offers__container">
    
    <!-- Заголовок и кнопки в одной строке -->
    <div class="offers__header-row">
      <h2 class="offers__title title"><?= esc_html($page_fields['offer_title'] ?? '') ?></h2>
      <div class="offers__buttons">
        <a href="#" data-popup="#popup-lead" class="offers__link2 button catalog-btn">Скачать каталог</a>
        <a href="<?= esc_url(get_permalink(195)) ?>" class="offers__link button button--gray">Смотреть все объекты</a>
      </div>
    </div>

    <!-- Слайдер -->
    <div class="offers__slidercont slidercont">
      <div class="offers__slider swiper">
        <div class="offers__wrapper swiper-wrapper">
          <?php foreach ($page_fields['offers'] as $item): ?>
            <?php get_template_part('templates/offer', null, $item); ?>
          <?php endforeach; ?>
        </div>
      </div>
      <button class="offers__swiper-button-prev swiper-button icon-arrow-d-b"></button>
      <button class="offers__swiper-button-next swiper-button icon-arrow-d-b"></button>
    </div>
    
  </div>
</section>
<?php } ?>

<?php
// --- СЕКЦИЯ "ВИДЕО ОТ ЗАСТРОЙЩИКОВ" ---
$page_fields = get_fields(get_queried_object_id());
if (!empty($page_fields['video_section_enable']) && !empty($page_fields['video_list'])) {
  get_template_part('templates/video_section', null, [
    'video_title' => $page_fields['video_title'] ?? '',
    'video_list'  => $page_fields['video_list']
  ]);
}
?>

<?php 
// --- СЕКЦИЯ "АГЕНТЫ" (пока закомментирована) ---
if (!empty($page_fields['agent_list'])) : ?>
  <!-- Тут выводятся агенты через шаблон templates/agent.php -->
<?php endif; ?>

<?php 
// --- СЕКЦИЯ "МЕРОПРИЯТИЯ" (events) ---
query_posts([
  'posts_per_page' => 6,
  'post_type'      => 'events',
  'meta_key'       => 'date',
  'orderby'        => 'meta_value',
  'order'          => 'DESC',
  'meta_query'     => [[
    'key'     => 'date',
    'value'   => date('Y/m/d'),
    'type'    => 'date',
    'compare' => '>',
  ]]
]);
if (have_posts()) { ?>
<section class="events">
  <div class="events__container">
    <h2 class="events__title title">Мероприятия</h2>
    <div class="events__slidercont slidercont">
      <div class="events__slider swiper">
        <div class="events__wrapper swiper-wrapper">
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/event'); ?>
          <?php endwhile; ?>
        </div>
      </div>
      <button class="events__swiper-button-prev swiper-button icon-arrow-d-b"></button>
      <button class="events__swiper-button-next swiper-button icon-arrow-d-b"></button>
    </div>
  </div>
</section>
<?php } wp_reset_query(); ?>

<?php
// --- СЕКЦИЯ "ОТЗЫВЫ" ---
$reviews_query = new WP_Query([
  'posts_per_page' => 200,
  'post_type'      => 'review'
]);
if ($reviews_query->have_posts()): ?>
  <section class="devscomments">
    <div class="devscomments__container">
      <div class="devscomments__top">
        <h2 class="devscomments__title title">Отзывы на девелоперов</h2>
        <div class="devscomments__toptiv"><?= esc_html(wp_count_posts('review')->publish) ?></div>
      </div>

      <div class="devscomments__slidercont slidercont">
        <div class="devscomments__slider swiper">
          <div class="devscomments__wrapper swiper-wrapper">
            <?php while ($reviews_query->have_posts()): $reviews_query->the_post(); ?>
              <?php get_template_part('templates/review', null, get_post()); ?>
            <?php endwhile; ?>
          </div>
        </div>

        <!-- Кнопки слайдера -->
        <button type="button" aria-label="Кнопка слайдера предыдущая"
          class="devscomments__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
        <button type="button" aria-label="Кнопка слайдера следующая"
          class="devscomments__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
      </div>
    </div>
  </section>
<?php endif;
wp_reset_postdata(); ?>

<?php 
// --- СЕКЦИЯ "НОВОСТИ" ---
query_posts([
  'posts_per_page' => 4,
  'post_type'      => 'news',
]);
if (have_posts()) { ?>
<section class="news">
  <div class="news__container">
    <h2 class="news__title title">Новости</h2>
    <?php $k = 0; ?>
    <?php while (have_posts()) : the_post(); $k++; ?>
      <?php
      if ($k == 1) {
        get_template_part('templates/newbig');
      } else {
        get_template_part('templates/null');
      }
      ?>
    <?php endwhile; ?>

    <!-- Слайдер новостей -->
    <div class="news__slidercont slidercont">
      <div class="news__slider swiper">
        <div class="news__wrapper swiper-wrapper">
          <?php
          $k = 0;
          while (have_posts()) : the_post(); $k++;
            if ($k > 1) {
              get_template_part('templates/new_prev');
            } else {
              get_template_part('templates/null');
            }
          endwhile;
          ?>
        </div>
      </div>
      <button class="news__swiper-button-prev swiper-button icon-arrow-d-b"></button>
      <button class="news__swiper-button-next swiper-button icon-arrow-d-b"></button>
    </div>
  </div>
</section>
<?php } wp_reset_query(); ?>

<?php 
// --- СЕКЦИЯ "БАЗА ЗНАНИЙ" ---
query_posts([
  'posts_per_page' => 4,
  'post_type'      => 'knowledge',
]);
if (have_posts()) { ?>
<section class="knowledge">
  <div class="knowledge__container">
    <div class="knowledge__left">
      <?php if (!empty($page_fields['baza_image'])): ?>
        <img src="<?= esc_url($page_fields['baza_image']['sizes']['bazaimage']) ?>" alt="<?= esc_attr($page_fields['title'] ?? '') ?>" loading="lazy">
      <?php endif; ?>
      <div class="knowledge__lefttop">
        <h2 class="knowledge__lefttitle title"><?= esc_html($page_fields['baza_title'] ?? '') ?></h2>
        <div class="knowledge__lefttext"><?= wp_kses_post($page_fields['baza_text'] ?? '') ?></div>
      </div>
      <a href="<?= esc_url(get_permalink(177)) ?>" class="knowledge__leftbutton button button--gray button--fw">Больше о недвижимости</a>
    </div>
    <div class="knowledge__right">
      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('templates/baza_prev'); ?>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php } wp_reset_query(); ?>
    
<?php 
// --- СЕКЦИЯ "ОФИЦИАЛЬНЫЕ ПАРТНЕРЫ" ---
$partners_query = new WP_Query([
  'posts_per_page' => -1,
  'post_type'      => 'partners',
  'orderby'        => 'meta_value_num',
  'meta_key'       => 'partner_order',
  'order'          => 'ASC'
]);

if ($partners_query->have_posts()): ?>
  <section class="partners">
    <div class="partners__container">
      <div class="partners__top">
        <h2 class="partners__title title">Официальные партнеры</h2>
      </div>

      <div class="partners__slidercont slidercont">
        <div class="partners__slider swiper">
          <div class="partners__wrapper swiper-wrapper">
            <?php while ($partners_query->have_posts()): $partners_query->the_post(); 
              $partner_id  = get_the_ID();
              $partner_logo = get_field('partner_logo', $partner_id);
              $partner_url  = get_field('partner_link', $partner_id);
            ?>
              <div class="partners__slide swiper-slide partner-item">
                <?php if ($partner_url): ?>
                  <a href="<?= esc_url($partner_url); ?>" target="_blank" rel="nofollow" class="partner-item__link">
                <?php endif; ?>
                  
                  <?php if ($partner_logo): ?>
                    <div class="partner-item__image">
                      <img src="<?= esc_url($partner_logo['sizes']['logo_small']); ?>" 
                           class="ibg ibg--contain" 
                           alt="<?= esc_attr(get_the_title()); ?>" 
                           loading="lazy">
                    </div>
                  <?php endif; ?>
                  
                <?php if ($partner_url): ?>
                  </a>
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
        
        <!-- Кнопки слайдера -->
        <button type="button" aria-label="Предыдущий партнер"
          class="partners__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
        <button type="button" aria-label="Следующий партнер"
          class="partners__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
      </div>
    </div>
  </section>
<?php endif;
wp_reset_postdata(); ?>

<?php
/**
 * ===== FAQ СЕКЦИЯ (с правильной поддержкой TranslatePress) =====
 */

$page_id = isset($page_id) ? $page_id : get_queried_object_id();

// Проверяем наличие Repeater'а
$has_repeater = function_exists('have_rows') && have_rows('faq_items', $page_id);

// Фолбек на одиночные поля
$single_q = get_field('question', $page_id);
$single_a = get_field('ansanswerwer', $page_id);

if ( $has_repeater || (!empty($single_q) && !empty($single_a)) ) : ?>
  <section class="faq" id="faq" aria-labelledby="faq-title">
    <div class="faq__container">
      <h2 id="faq-title" class="faq__title title">
        <?php 
        // ИСПРАВЛЕНО: Используем правильный подход для TranslatePress
        echo function_exists('trp_translate') && get_locale() !== 'ru_RU' 
            ? trp_translate('Вопросы и ответы', 'ru_RU', get_locale()) 
            : 'Вопросы и ответы';
        ?>
      </h2>

      <div class="faq__list">
        <?php if ($has_repeater) : ?>
          <?php while (have_rows('faq_items', $page_id)) : the_row(); 
            $q = get_sub_field('question');
            $a = get_sub_field('answer');
            $slug = sanitize_title($q); ?>
            <details class="faq__item" id="faq-<?= esc_attr($slug) ?>">
              <summary class="faq__question">
                <?php 
                // ИСПРАВЛЕНО: Используем хелпер функцию или прямой вызов
                if (function_exists('get_translatable_acf_field')) {
                    echo get_translatable_acf_field('question', $page_id . '_' . get_row_index());
                } else {
                    echo function_exists('trp_translate') && get_locale() !== 'ru_RU' 
                        ? trp_translate($q, 'ru_RU', get_locale()) 
                        : esc_html($q);
                }
                ?>
                <span class="faq__icon" aria-hidden="true"></span>
              </summary>
              <div class="faq__answer">
                <?php 
                // ИСПРАВЛЕНО: Аналогично для ответа
                if (function_exists('get_translatable_acf_field')) {
                    echo get_translatable_acf_field('answer', $page_id . '_' . get_row_index());
                } else {
                    echo function_exists('trp_translate') && get_locale() !== 'ru_RU' 
                        ? trp_translate($a, 'ru_RU', get_locale()) 
                        : wp_kses_post($a);
                }
                ?>
              </div>
            </details>
          <?php endwhile; ?>
        <?php else : ?>
          <details class="faq__item">
            <summary class="faq__question">
              <?php 
              echo function_exists('trp_translate') && get_locale() !== 'ru_RU' 
                  ? trp_translate($single_q, 'ru_RU', get_locale()) 
                  : esc_html($single_q);
              ?>
              <span class="faq__icon" aria-hidden="true"></span>
            </summary>
            <div class="faq__answer">
              <?php 
              echo function_exists('trp_translate') && get_locale() !== 'ru_RU' 
                  ? trp_translate($single_a, 'ru_RU', get_locale()) 
                  : wp_kses_post($single_a);
              ?>
            </div>
          </details>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
// SEO-текст (после FAQ) с правильной поддержкой TranslatePress
$seo_text = get_field('seo_text', $page_id);
if (!empty($seo_text)) : ?>
  <section class="seo-text">
    <div class="seo-text__container">
      <div class="seo-text__content">
        <?php 
        // ИСПРАВЛЕНО: Правильный подход для TranslatePress
        echo function_exists('trp_translate') && get_locale() !== 'ru_RU' 
            ? trp_translate($seo_text, 'ru_RU', get_locale()) 
            : wp_kses_post($seo_text);
        ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php 
// --- СЕКЦИЯ "НОВОСТИ" (4 последние новости) ---
$news_query = new WP_Query([
  'posts_per_page' => 4,
  'post_type'      => 'news',
  'post_status'    => 'publish',
  'orderby'        => 'date',
  'order'          => 'DESC'
]);

if ($news_query->have_posts()) : ?>
<section class="news">
  <div class="news__container">
    <h2 class="news__title title">
      <?php 
      if (function_exists('_e')) {
          _e('Новости', 'textdomain'); 
      } else {
          echo 'Новости';
      }
      ?>
    </h2>
    
    <?php 
    $k = 0;
    while ($news_query->have_posts()) : 
        $news_query->the_post(); 
        $k++; 
        
        if ($k == 1) {
            // Первая новость - большая
            get_template_part('templates/newbig', null, get_post());
        } else {
            // Остальные скрыты, покажем в слайдере
            get_template_part('templates/null', null, get_post());
        }
    endwhile;
    ?>

    <!-- Слайдер для остальных 3 новостей -->
    <div class="news__slidercont slidercont">
      <div class="news__slider swiper">
        <div class="news__wrapper swiper-wrapper">
          <?php
          $k = 0;
          $news_query->rewind_posts(); // Сбрасываем указатель
          while ($news_query->have_posts()) : 
              $news_query->the_post(); 
              $k++;
              
              if ($k > 1) {
                  // Показываем 2,3,4 новость в слайдере
                  get_template_part('templates/new_prev', null, get_post());
              } else {
                  get_template_part('templates/null', null, get_post());
              }
          endwhile;
          wp_reset_postdata();
          ?>
        </div>
      </div>
      <button type="button" aria-label="Кнопка слайдера предыдущая" 
        class="news__swiper-button-prev swiper-button swiper-button-prev icon-arrow-d-b"></button>
      <button type="button" aria-label="Кнопка слайдера следующая" 
        class="news__swiper-button-next swiper-button swiper-button-next icon-arrow-d-b"></button>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
// Подключаем footer
get_footer();