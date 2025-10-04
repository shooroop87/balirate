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
$rate = $filds['rating'];

// Определяем поле для сайта в зависимости от типа записи
$site_field = ($post_type === 'propertymanagement') ? 'website' : 'sait';
?>

<!-- Элемент списка -->
<div class="first__row first-row <?php if ($filds['premium']) echo 'vipitem'; ?>">

    <!-- Логотип -->
    <?php if ($filds['f_logo']) : ?>
        <a href="<?php echo get_permalink($id); ?>" aria-label="Ссылка на страницу <?php echo $post_type === 'propertymanagement' ? 'управляющей компании' : 'застройщика'; ?>" class="first-row__image">
            <img src="<?php echo $filds['f_logo']['sizes']['logo_small'] ?>" class="ibg ibg--contain2" alt="<?php echo $args->post_title ?>" loading="lazy">
        </a>
    <?php endif; ?>

    <!-- Название + значки -->
    <a href="<?php echo get_permalink($id); ?>" class="first-row__name">
        <?php echo $args->post_title ?>
        <?php if ($filds['verif']) : ?>
            <span class="first-row__name first-row__name--check"></span>
        <?php endif; ?>
        <?php if ($filds['cup']) : ?>
            <span class="first-row__name first-row__name--cup"></span>
        <?php endif; ?>
    </a>

    <!-- Правая панель: рейтинг, сайт, стрелка -->
    <div class="first-row__right">
        <div data-rating data-rating-show data-rating-value="<?php echo $rate ?>" class="rating"></div>

        <?php if ($filds[$site_field]) : ?>
            <a href="<?php echo $filds[$site_field] ?>" class="first-row__site first-row__site--top icon-arrow-r-t" target="_blank" rel="nofollow">
                <?php the_field('text_sait_' . $lang, 'options'); ?>
            </a>
        <?php endif; ?>

        <button type="button" aria-label="Кнопка раскрытия блока с показателями" class="first-row__arrow icon-arrow-d-b"></button>
    </div>

    <!-- Скрытый блок: преимущества и оценки -->
    <div class="first-row__descs" hidden>

        <!-- Список преимуществ -->
        <?php if (!empty($filds['advantages'])) : ?>
            <div class="first-row__descsitems">
                <?php foreach ($filds['advantages'] as $advantage) : ?>
                    <div class="first-row__descsitem"><?php echo $advantage['name'] ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Оценки по категориям -->
        <div class="first-row__descsrows">
            <?php if ($post_type === 'propertymanagement'): ?>
                <!-- Оценки для управляющих компаний -->
                <?php if (getMark($page_id, 'mark1') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Качество услуг</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" style="width: <?php echo getMark($page_id, 'mark1') / 5 * 100 ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?php echo getMark($page_id, 'mark1') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark2') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Скорость реагирования</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" style="width: <?php echo getMark($page_id, 'mark2') / 5 * 100 ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?php echo getMark($page_id, 'mark2') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark3') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Клиентский сервис</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" style="width: <?php echo getMark($page_id, 'mark3') / 5 * 100 ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?php echo getMark($page_id, 'mark3') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark4') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Соотношение цена/качество</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" style="width: <?php echo getMark($page_id, 'mark4') / 5 * 100 ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?php echo getMark($page_id, 'mark4') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Оценки для застройщиков/агентств -->
                <?php if (getMark($page_id, 'mark1') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Срок сдачи</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" style="width: <?php echo getMark($page_id, 'mark1') / 5 * 100 ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?php echo getMark($page_id, 'mark1') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark2') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Премиальность</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" style="width: <?php echo getMark($page_id, 'mark2') / 5 * 100 ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?php echo getMark($page_id, 'mark2') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark3') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Поддержка</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" style="width: <?php echo getMark($page_id, 'mark3') / 5 * 100 ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?php echo getMark($page_id, 'mark3') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (getMark($page_id, 'mark4') > 0) : ?>
                    <div class="first-row__descsrow">
                        <div class="first-row__descsrowleft">Качество строительства</div>
                        <div class="first-row__descsrowright">
                            <div class="first-row__descsrowline">
                                <div class="first-row__descsrowlinevalue" style="width: <?php echo getMark($page_id, 'mark4') / 5 * 100 ?>%"></div>
                            </div>
                            <div class="first-row__descsrowrating"><?php echo getMark($page_id, 'mark4') ?>/5</div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Нижний блок с общей информацией -->
    <div class="first-row__bottom">
        <div class="first-row__bottominfos">

            <?php if ($post_type === 'propertymanagement'): ?>
                <!-- Информация для управляющих компаний -->
                <?php if ($filds['objects_count']) : ?>
                    <div class="first-row__bottominfo">
                        <span>Управляет объектами:</span>
                        <span><?php echo $filds['objects_count'] ?> <?php echo num_word($filds['objects_count'], [
                            get_field('text_obj1_' . $lang, 'options'),
                            get_field('text_obj2_' . $lang, 'options'),
                            get_field('text_obj3_' . $lang, 'options')
                        ]) ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($filds['founded_year']) : ?>
                    <div class="first-row__bottominfo">
                        <span>На рынке с:</span>
                        <span><?php echo $filds['founded_year'] ?> года</span>
                    </div>
                <?php endif; ?>

                <?php if ($filds['city']) : ?>
                    <div class="first-row__bottominfo">
                        <span>Город:</span>
                        <span><?php echo $filds['city'] ?></span>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Информация для застройщиков/агентств -->
                <?php if ($filds['sdano']) : ?>
                    <div class="first-row__bottominfo">
                        <span><?php the_field('text_submitted_' . $lang, 'options'); ?>:</span>
                        <span>
                            <?php echo $filds['sdano'] ?>
                            <?php echo num_word($filds['sdano'], [
                                get_field('text_obj1_' . $lang, 'options'),
                                get_field('text_obj2_' . $lang, 'options'),
                                get_field('text_obj3_' . $lang, 'options')
                            ]) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ($filds['stroitsya']) : ?>
                    <div class="first-row__bottominfo">
                        <span><?php the_field('text_under_' . $lang, 'options'); ?>:</span>
                        <span>
                            <?php echo $filds['stroitsya'] ?>
                            <?php echo num_word($filds['stroitsya'], [
                                get_field('text_obj1_' . $lang, 'options'),
                                get_field('text_obj2_' . $lang, 'options'),
                                get_field('text_obj3_' . $lang, 'options')
                            ]) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ($filds['sdano'] && $filds['stroitsya']) : ?>
                    <div class="first-row__bottominfo">
                        <span><?php the_field('text_total_' . $lang, 'options'); ?>:</span>
                        <span>
                            <?php echo $filds['sdano'] + $filds['stroitsya'] ?>
                            <?php echo num_word($filds['sdano'] + $filds['stroitsya'], [
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
            <a href="<?php echo get_permalink($id); ?>" target="_blank" rel="nofollow" class="first-row__comments icon-comments">
                <?php echo $total_rev ?>
                <?php echo num_word($total_rev, [
                    get_field('_text_rev1_' . $lang, 'options'),
                    get_field('_text_rev2_' . $lang, 'options'),
                    get_field('_text_rev3_' . $lang, 'options')
                ]) ?>
            </a>
        <?php endif; ?>

        <!-- Ссылка на сайт -->
        <?php if ($filds[$site_field]) : ?>
            <a href="<?php echo $filds[$site_field] ?>" class="first-row__site first-row__site--bottom icon-arrow-r-t" target="_blank" rel="nofollow">
                <?php the_field('text_sait_' . $lang, 'options'); ?>
            </a>
        <?php endif; ?>
    </div>
</div>