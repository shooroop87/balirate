<?php
/**
 * Главный шаблон страницы (page-home.php) с динамическими баннерами.
 */

get_header(); 

$page_id = get_queried_object_id();
$page_fields = get_fields($page_id);
?>

<?php if ($page_fields['tabs']) { ?>
<section class="first">
  <div class="first__container">

    <!-- Рекламный баннер сверху (динамический) -->
    <div class="dynamic-top-banner">
      <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
        <?php if ($tab['list']) : ?>
          <div class="banner-content" data-tab="<?= $num ?>" style="<?= $num === 0 ? '' : 'display: none;' ?>">
            <?php if (!empty($tab['banner_pk'])) : ?>
              <a href="#" data-popup="#popup-lead" class="w-100">
                <img src="<?= $tab['banner_pk']['sizes']['banner_desc'] ?>" class="banner-pk" alt="<?= $tab['banner_pk']['alt'] ?>">
              </a>
            <?php endif; ?>
            
            <?php if (!empty($tab['banner_mob'])) : ?>
              <a href="#" data-popup="#popup-lead" class="w-100">
                <img src="<?= $tab['banner_mob']['sizes']['banner-vertical'] ?>" class="banner-mob" alt="<?= $tab['banner_mob']['alt'] ?>">
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <h1 class="first__title title"><?= $page_fields['rating_title'] ?></h1>

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
        <?php if ($tab['list']) : ?>
            <button type="button" class="first__tabstitle <?= $num === 0 ? '_tab-active' : '' ?>" data-tab-index="<?= $num ?>">
                <?php 
                // Получаем иконку для текущей вкладки
                $icon_url = isset($tab_icons[$tab['title']]) ? $tab_icons[$tab['title']] : '';
                ?>
                <?php if ($icon_url): ?>
                    <img src="<?= $icon_url ?>" alt="<?= $tab['title'] ?>" class="tab-icon">
                <?php endif; ?>
                <span class="tab-text"><?= $tab['title'] ?></span>
            </button>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>

          <!-- Контент вкладок -->
          <div data-tabs-body class="first__tabscontent">
            <?php foreach ($page_fields['tabs'] as $num => $tab): ?>
              <?php if ($tab['list']) : ?>
                <div class="first__tabsbody" data-tab-content="<?= $num ?>">
                  <div class="first__rows">
                    <?php foreach ($tab['list'] as $item): ?>
                      <?php get_template_part('templates/item', null, $item); ?>
                    <?php endforeach; ?>
                  </div>
                  <div class="first__leftbottom">
                    <a href="<?= get_permalink(132); ?>" class="first__leftlink button button--gray">Смотреть весь список</a>
                    <div class="first__tippy"
                      data-tippy-content="<strong><?= $page_fields['rate_text'] ?></strong><br/><br/><p><?= $page_fields['rate_text2'] ?></p>"
                      data-tippy-allowhtml="true"
                      data-tippy-placement="bottom-end"
                      data-tippy-arrow="false">
                      <?= $page_fields['rate_text'] ?>
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
              <?php if ($tab['list']) : ?>
                <div class="side-banners-content" data-tab="<?= $num ?>" style="<?= $num === 0 ? '' : 'display: none;' ?>">
                  <?php if (!empty($tab['side_banners'])) : ?>
                    <?php foreach ($tab['side_banners'] as $banner): ?>
                      <div class="adsitems__item adsitems-item">
                        <a href="#" data-popup="#popup-lead">
                          <img src="<?= $banner['image']['sizes']['banner-vertical'] ?>" alt="<?= $banner['name'] ?>" loading="lazy">
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
        <?php if ($tab['list']) : ?>
          <div class="bottom-banner-content" data-tab="<?= $num ?>" style="<?= $num === 0 ? '' : 'display: none;' ?>">
            <?php if (!empty($tab['bottom_banner_pk'])) : ?>
              <a href="#" data-popup="#popup-lead" class="w-100">
                <img src="<?= $tab['bottom_banner_pk']['sizes']['banner_desc'] ?>" class="banner-pk __bottom" alt="<?= $tab['bottom_banner_pk']['alt'] ?>">
              </a>
            <?php endif; ?>
            
            <?php if (!empty($tab['bottom_banner_mob'])) : ?>
              <a href="#" data-popup="#popup-lead" class="w-100">
                <img src="<?= $tab['bottom_banner_mob']['sizes']['banner-vertical'] ?>" class="banner-mob __bottom" alt="<?= $tab['bottom_banner_mob']['alt'] ?>">
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
            
            // Скрываем все баннеры
            document.querySelectorAll('[data-tab]').forEach(el => {
                el.style.display = 'none';
            });
            
            // Показываем баннеры для текущей вкладки
            document.querySelectorAll(`[data-tab="${tabIndex}"]`).forEach(el => {
                el.style.display = '';
            });
        });
    });
});
</script>

<?php } ?>

<?php 
// --- СЕКЦИЯ "ПРЕДЛОЖЕНИЯ" (объекты) ---
if ($page_fields['offers']) { ?>
<section class="offers">
  <div class="offers__container">
    
    <!-- Заголовок и кнопки в одной строке -->
    <div class="offers__header-row">
      <h2 class="offers__title title"><?= $page_fields['offer_title'] ?></h2>
      <div class="offers__buttons">
        <a href="#" data-popup="#popup-lead" class="offers__link2 button catalog-btn">Скачать каталог</a>
        <a href="<?= get_permalink(195); ?>" class="offers__link button button--gray">Смотреть все объекты</a>
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
// Добавить в page-home.php после секции offers и перед секцией events

// --- СЕКЦИЯ "ВИДЕО ОТ ЗАСТРОЙЩИКОВ" ---
$page_fields = get_fields(get_queried_object_id());

if (!empty($page_fields['video_section_enable']) && !empty($page_fields['video_list'])) {
    get_template_part('templates/video_section', null, [
        'video_title' => $page_fields['video_title'],
        'video_list' => $page_fields['video_list']
    ]);
}
?>

<?php 
// --- СЕКЦИЯ "АГЕНТЫ" (пока закомментирована) ---
if ($page_fields['agent_list']) : ?>
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
				<div class="devscomments__toptiv"><?= wp_count_posts('review')->publish ?></div>
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
      <img src="<?= $page_fields['baza_image']['sizes']['bazaimage'] ?>" alt="<?= $page_fields['title'] ?>" loading="lazy">
      <div class="knowledge__lefttop">
        <h2 class="knowledge__lefttitle title"><?= $page_fields['baza_title'] ?></h2>
        <div class="knowledge__lefttext"><?= $page_fields['baza_text'] ?></div>
      </div>
      <a href="<?= get_permalink(177); ?>" class="knowledge__leftbutton button button--gray button--fw">Больше о недвижимости</a>
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
                            $partner_id = get_the_ID();
                            $partner_logo = get_field('partner_logo', $partner_id);
                            $partner_url = get_field('partner_link', $partner_id);
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
// Подключаем footer
get_footer();