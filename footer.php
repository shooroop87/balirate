</main>
<?
 $lang= pll_current_language();
 if ($lang=='en') {$topmenu_id =51; } else {$topmenu_id =6;}
           $menu_info = wp_get_nav_menu_items($topmenu_id);
if ($lang=='en') {$menurealt_id =49; } else {$menurealt_id =7;}
           $menu_realt = wp_get_nav_menu_items($menurealt_id);
           //print_r($menu_info);


          ?>
<footer class="footer">
			<div class="footer__container">
				<a href="index.html" aria-label="Ссылка на главную" class="footer__logo"><img src="<?php the_field('logo_footer', 'options'); ?>" class="ibg ibg--contain" alt="logo"></a>
				<nav class="footer__menubody">
					<div class="footer__menublock">
						<div class="footer__menulistname"><?php the_field('text_info_'.$lang, 'options'); ?></div>
						<ul class="footer__menulist">
							<? foreach ($menu_info as $menu) { ?>
							<li class="footer__menuitem">
								<a href="<?=$menu->url?>" class="footer__menulink"><?=$menu->title?></a>
							</li>
							<? } ?>
							 
						</ul>
					</div>
					<div class="footer__menublock">
						<div class="footer__menulistname"><?php the_field('text_realt_'.$lang, 'options'); ?></div>
						<ul class="footer__menulist">
							<? foreach ($menu_realt as $menu) { ?>
							<li class="footer__menuitem">
								<a href="<?=$menu->url?>" class="footer__menulink"><?=$menu->title?></a>
							</li>
							<? } ?>
						</ul>
					</div>
				</nav>
				<div class="footer__right">
					<div class="search-form">

					<?php echo do_shortcode('[asearch  image="false" source="stroys,agencies"]'); ?>
					</div>
					<? if ( is_user_logged_in() ) { ?> 
						  <a href="/wp-login.php?action=logout"><button type="button" class="header-bottom__popuplink button-login icon-logout" ><span><?php the_field('text_logout_'.$lang, 'options'); ?></span></button></a>
						<? } else { ?>
						  <button type="button" class="button-login icon-login" data-popup="#popup"><span><?php the_field('text_auth_'.$lang, 'options'); ?></span></button>
						<? }	?>
					
				</div>
				<div class="footer__info">
					<div class="footer__copy"><span>©Balirate 2025.</span> <?php the_field('text_allr_'.$lang, 'options'); ?></div>
					<div class="footer__site"><!--<?php the_field('text_sitectreat_'.$lang, 'options'); ?> --></div>
				</div>
			</div>
		</footer>
	</div>

	<div id="popup" aria-hidden="true" class="popup">
    <div class="popup__wrapper">
        <div class="popup__content">
            <button data-close type="button" class="popup__close icon-close"></button>
            <div class="popup__body">
                <h2 class="popup__title"><?php the_field('text_auth_'.$lang, 'options'); ?></h2>
                
                <form class="popup__form" action="functions.php" method="POST">
                    <div class="popup__lines">
                        <div class="popup__line">
                            <div class="popup__linetop">Через соцсети</div>
                            <button type="button" class="popup__google">
                                <?php echo do_shortcode('[google_login button_text="Войти через Google" force_display="yes"]'); ?>
                            </button>
                        </div>
                    </div>

                    <div class="popup__separator">или</div>

                    <div class="popup__lines">
                        <div class="popup__line">
                            <div class="popup__linetop">Ваш e-mail</div>
                            <input type="text" data-required="email" name="e-mail" placeholder="Введите ваш e-mail" class="input popup__input">
                        </div>
                        <div class="popup__line">
                            <div class="popup__linetop">Пароль</div>
                            <input type="password" data-required name="password" placeholder="Введите пароль" class="input popup__input">
                        </div>
                    </div>
                    
                    <button type="submit" class="popup__submit">Войти</button>
                </form>
            </div>
        </div>
    </div>
</div>


	<div id="popup-filter" aria-hidden="true" class="popup popup-filter">
		<div class="popup__wrapper">
			<div class="popup__content">
				<button data-close type="button" class="popup__close icon-close">
				</button>
				<div class="popup__body">
					<div class="popup-filter__body">

					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="popup-feed" aria-hidden="true" class="popup popup-feed">
		<div class="popup__wrapper">
			<div class="popup__content">
				<button data-close type="button" class="popup__close icon-close">
				</button>
				<div class="popup__body">
					<div class="popup__title"><?php the_field('text_btn_'.$lang, 'options'); ?></div>
					<div class="popup__text"><?php the_field('text_form_'.$lang, 'options'); ?></div>
						<? echo do_shortcode( '[contact-form-7  id="012e18d" title="Контактная форма 1" html_class="popup__form"]' ); ?>
					
				</div>
			</div>
		</div>
	</div>
    <div id="popup-developer" aria-hidden="true" class="popup popup-feed">
		<div class="popup__wrapper">
			<div class="popup__content">
				<button data-close type="button" class="popup__close icon-close">
				</button>
				<div class="popup__body">
					<div class="popup__title"><?php the_field('text_btn_'.$lang, 'options'); ?></div>
					<div class="popup__text">Оставьте свои контакты, мы свяжемся с вами в ближайшее время</div>
						<? echo do_shortcode( '[contact-form-7 id="498dd46" title="Cвязаться - Застройщик" html_class="popup__form"]' ); ?>
				</div>
			</div>
		</div>
	</div>
	<div id="popup-agency" aria-hidden="true" class="popup popup-feed">
		<div class="popup__wrapper">
			<div class="popup__content">
				<button data-close type="button" class="popup__close icon-close">
				</button>
				<div class="popup__body">
					<div class="popup__title"><?php the_field('text_btn_'.$lang, 'options'); ?></div>
					<div class="popup__text">Оставьте свои контакты, мы свяжемся с вами в ближайшее время</div>
						<? echo do_shortcode( '[contact-form-7 id="0783fb9" title="Cвязаться - Агентство" html_class="popup__form"]' ); ?>
				</div>
			</div>
		</div>
	</div>
<div id="popup-lead" aria-hidden="true" class="popup popup-feed">
	<div class="popup__wrapper">
		<div class="popup__content popup__content--wide">
			<button data-close type="button" class="popup__close icon-close"></button>
			<div class="popup__grid">
				<!-- Левая колонка: форма -->
				<div class="popup__form-block">
					<h2 class="popup__title">Оставить заявку</h2>
					<p class="popup__text">Оставьте свои контакты, мы свяжемся с вами в ближайшее время</p>
					<?php echo do_shortcode('[contact-form-7 id="1790" title="Pop-Up 10 секунд" html_class="popup__form"]'); ?>
				</div>

				<!-- Правая колонка: изображение -->
				<div class="popup__image-block">
                	<img src="<?php echo esc_url(get_option('popup_image_url', 'https://balirate.com/wp-content/uploads/2025/04/374x526-min.jpg')); ?>" alt="Изображение" class="popup__image"></div>
			</div>

		</div>
	</div>
</div>
	<script  defer src="<?=get_template_directory_uri()?>/js/common.js?ver=<?=wp_get_theme()->get( 'Version' );?><?=time();?>"></script>
	<script  defer src="<?=get_template_directory_uri()?>/js/app.min.js?ver=<?=wp_get_theme()->get( 'Version' );?><?=time();?>"></script>
	<?php wp_footer(); ?>
</body>
</html>