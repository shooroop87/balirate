<?php
/**
 * Шаблон карточки застройщика/агентства/УК для главной страницы
 * Файл: templates/item.php
 * Поддерживает: stroys, agencies, propertymanagement
 */

// Получаем текущий язык
$lang = pll_current_language();

// Получаем ID и данные поста
$id = $args->ID;
$page_id = $id;
$filds = get_fields($id);
$post_type = get_post_type($id);

// Получаем общее количество отзывов
$total_rev = gettotalrev($id);

// Рейтинг
$rate = !empty($filds['rating']) ? $filds['rating'] : 0;

// Определяем поле для сайта в зависимости от типа записи
$site_field = ($post_type === 'propertymanagement' || $post_type === 'pm') ? 'website' : 'sait';
$site_url = !empty($filds[$site_field]) ? $filds[$site_field] : '';
?>

<!-- Элемент списка -->
<div class="first__row first-row <?php if (!empty($filds['premium'])) echo 'vipitem'; ?>">

    <!-- Логотип -->
    <?php if (!empty($filds['f_logo'])) : ?>
        <a href="<?= esc_url(get_permalink($id)) ?>" 
           aria-label="Ссылка на страницу <?= $post_type === 'propertymanagement' ? 'управляющей компании' : 'застройщика' ?>" 
           class="first-row__image">
            <img src="<?= esc_url($filds['f_logo']['sizes']['logo_small']) ?>" 
                 class="ibg ibg--contain2" 
                 alt="<?= esc_attr($args->post_title) ?>" 
                 loading="lazy">
        </a>
    <?php endif; ?>

    <!-- Название + значки -->
    <a href="<?= esc_url(get_permalink($id)) ?>" class="first-row__name">
        <?= esc_html($args->post_title) ?>
        <?php if (!empty($filds['verif'])) : ?>
            <span class="first-row__name first-row__name--check"></span>
        <?php endif; ?>
        <?php if (!empty($filds['cup'])) : ?>
            <span class="first-row__name first-row__name--cup"></span>
        <?php endif; ?>
    </a>

    <!-- Правая панель: рейтинг, сайт, стрелка -->
    <div class="first-row__right">
        <?php if ($rate > 0) : ?>
            <div data-rating data-rating-show data-rating-value="<?= esc_attr($rate) ?>" class="rating"></div>
        <?php endif; ?>

        <?php if ($site_url) : ?>
            <a href="<?= esc_url($site_url) ?>" 
               class="first-row__site first-row__site--top icon-arrow-r-t" 
               target="_blank" 
               rel="nofollow">
                <?php the_field('text_sait_' . $lang, 'options'); ?>
            </a>
        <?php endif; ?>

        <button type="button" 
                aria-label="Кнопка раскрытия блока с показателями" 
                class="first-row__arrow icon-arrow-d-b"></button>
    </div>

    <!-- Скрытый блок: преимущества и оценки -->
    <div class="first-row__descs" hidden>

        <!-- Список преимуществ -->
        <?php if (!empty($filds['advantages'])) : ?>
            <div class="first-row__descsitems">
                <?php foreach ($filds['advantages'] as $advantage) : ?>
                    <div class="first-row__descsitem"><?= esc_html($advantage['name']) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Оценки по категориям -->
        <div class="first-row__descsrows">
            <?php if ($post_type === 'propertymanagement' || $post_type === 'pm'): ?>
                <!-- Оценки для управляющих компаний -->
                <?php
                $pm_marks = [
                    'mark1' => 'Качество услуг',
                    'mark2' => 'Скорость реагирования',
                    'mark3' => 'Клиентский сервис',
                    'mark4' => 'Соотношение цена/качество'
                ];
                
                foreach ($pm_marks as $mark_key => $mark_label) :
                    $mark_value = getMark($page_id, $mark_key);
                    if ($mark_value > 0) :
                ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft"><?= esc_html($mark_label) ?></div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" 
                                     style="width: <?= ($mark_value / 5 * 100) ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?= esc_html($mark_value) ?>/5</div>
                        </div>
                    </div>
                <?php 
                    endif;
                endforeach;
                ?>

            <?php else: ?>
                <!-- Оценки для застройщиков/агентств -->
                <?php
                $dev_marks = [
                    'mark1' => 'Срок сдачи',
                    'mark2' => 'Премиальность',
                    'mark3' => 'Поддержка',
                    'mark4' => 'Качество строительства'
                ];
                
                foreach ($dev_marks as $mark_key => $mark_label) :
                    $mark_value = getMark($page_id, $mark_key);
                    if ($mark_value > 0) :
                ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft"><?= esc_html($mark_label) ?></div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" 
                                     style="width: <?= ($mark_value / 5 * 100) ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?= esc_html($mark_value) ?>/5</div>
                        </div>
                    </div>
                <?php 
                    endif;
                endforeach;
                ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Нижний блок с общей информацией -->
    <div class="first-row__bottom">
        <div class="first-row__bottominfos">

            <?php if ($post_type === 'propertymanagement' || $post_type === 'pm'): ?>
                <!-- Информация для управляющих компаний -->
                <?php if (!empty($filds['objects_count'])) : ?>
                    <div class="first-row__bottominfo">
                        <span>Управляет объектами:</span>
                        <span>
                            <?= absint($filds['objects_count']) ?>
                            <?= num_word($filds['objects_count'], [
                                get_field('text_obj1_' . $lang, 'options'),
                                get_field('text_obj2_' . $lang, 'options'),
                                get_field('text_obj3_' . $lang, 'options')
                            ]) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($filds['founded_year'])) : ?>
                    <div class="first-row__bottominfo">
                        <span>На рынке с:</span>
                        <span><?= absint($filds['founded_year']) ?> года</span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($filds['city'])) : ?>
                    <div class="first-row__bottominfo">
                        <span>Город:</span>
                        <span><?= esc_html($filds['city']) ?></span>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Информация для застройщиков/агентств -->
                <?php if (!empty($filds['sdano'])) : ?>
                    <div class="first-row__bottominfo">
                        <span><?php the_field('text_submitted_' . $lang, 'options'); ?>:</span>
                        <span>
                            <?= absint($filds['sdano']) ?>
                            <?= num_word($filds['sdano'], [
                                get_field('text_obj1_' . $lang, 'options'),
                                get_field('text_obj2_' . $lang, 'options'),
                                get_field('text_obj3_' . $lang, 'options')
                            ]) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($filds['stroitsya'])) : ?>
                    <div class="first-row__bottominfo">
                        <span><?php the_field('text_under_' . $lang, 'options'); ?>:</span>
                        <span>
                            <?= absint($filds['stroitsya']) ?>
                            <?= num_word($filds['stroitsya'], [
                                get_field('text_obj1_' . $lang, 'options'),
                                get_field('text_obj2_' . $lang, 'options'),
                                get_field('text_obj3_' . $lang, 'options')
                            ]) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($filds['sdano']) && !empty($filds['stroitsya'])) : ?>
                    <div class="first-row__bottominfo">
                        <span><?php the_field('text_total_' . $lang, 'options'); ?>:</span>
                        <span>
                            <?= absint($filds['sdano'] + $filds['stroitsya']) ?>
                            <?= num_word($filds['sdano'] + $filds['stroitsya'], [
                                get_field('text_obj1_' . $lang, 'options'),
                                get_field('text_obj2_' . $lang, 'options'),
                                get_field('text_obj3_' . $lang, 'options')
                            ]) ?>
                        </span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Отзывы -->
        <?php if ($total_rev > 0) : ?>
            <a href="<?= esc_url(get_permalink($id)) ?>" 
               target="_blank" 
               rel="nofollow" 
               class="first-row__comments icon-comments">
                <?= absint($total_rev) ?>
                <?= num_word($total_rev, [
                    get_field('_text_rev1_' . $lang, 'options'),
                    get_field('_text_rev2_' . $lang, 'options'),
                    get_field('_text_rev3_' . $lang, 'options')
                ]) ?>
            </a>
        <?php endif; ?>

        <!-- Ссылка на сайт -->
        <?php if ($site_url) : ?>
            <a href="<?= esc_url($site_url) ?>" 
               class="first-row__site first-row__site--bottom icon-arrow-r-t" 
               target="_blank" 
               rel="nofollow">
                <?php the_field('text_sait_' . $lang, 'options'); ?>
            </a>
        <?php endif; ?>
    </div>
</div>