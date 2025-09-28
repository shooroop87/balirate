<?php
// Получаем текущий язык сайта (используется Polylang)
$lang = pll_current_language();

// Получаем ID текущего поста из переданного аргумента
$id = $args->ID;
$page_id = $id;

// Получаем все ACF-поля этого поста (девелопера)
$filds = get_fields($id);

// Получаем общее количество отзывов по девелоперу (через кастомную функцию)
$total_rev = gettotalrev($id);

// Рейтинг девелопера
$rate = $filds['rating'];
?>

<!-- Элемент списка девелоперов -->
<div class="first__row first-row <?php if ($filds['premium']) echo 'vipitem'; ?>">

    <!-- Логотип девелопера -->
    <?php if ($filds['f_logo']) : ?>
        <a href="<?php echo get_permalink($id); ?>" aria-label="Ссылка на страницу застройщика" class="first-row__image">
            <img src="<?php echo $filds['f_logo']['sizes']['logo_small'] ?>" class="ibg ibg--contain2" alt="<?php echo $args->post_title ?>" loading="lazy">
        </a>
    <?php endif; ?>

<!-- Название девелопера + проверка -->
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

        <?php if ($filds['sait']) : ?>
            <a href="<?php echo $filds['sait'] ?>" class="first-row__site first-row__site--top icon-arrow-r-t" target="_blank" rel="nofollow">
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
        </div>
    </div>

    <!-- Нижний блок с общей информацией -->
    <div class="first-row__bottom">
        <div class="first-row__bottominfos">

            <!-- Объекты: сдано -->
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

            <!-- Объекты: строится -->
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

            <!-- Объекты: всего -->
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

        <!-- Повтор ссылки на сайт -->
        <?php if ($filds['sait']) : ?>
            <a href="<?php echo $filds['sait'] ?>" class="first-row__site first-row__site--bottom icon-arrow-r-t" target="_blank" rel="nofollow">
                <?php the_field('text_sait_' . $lang, 'options'); ?>
            </a>
        <?php endif; ?>
    </div>
</div>