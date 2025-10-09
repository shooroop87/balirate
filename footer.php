</main>
<?php
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
							<?php foreach ($menu_info as $menu) { ?>
							<li class="footer__menuitem">
								<a href="<?php echo $menu->url?>" class="footer__menulink"><?php echo $menu->title?></a>
							</li>
							<?php } ?>
							 
						</ul>
					</div>
					<div class="footer__menublock">
						<div class="footer__menulistname"><?php the_field('text_realt_'.$lang, 'options'); ?></div>
						<ul class="footer__menulist">
							<?php foreach ($menu_realt as $menu) { ?>
							<li class="footer__menuitem">
								<a href="<?php echo $menu->url?>" class="footer__menulink"><?php echo $menu->title?></a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</nav>
<div class="footer__right">
    <div class="footer__menulistname">Связаться с нами</div>
    <?php echo do_shortcode('[contact-form-7 id="7f5f198" html_class="contact-form"]'); ?>
    <p class="contact-form-note">Оставьте свои контакты, чтобы задать любой вопрос. Мы свяжемся с вами в течение рабочего дня.</p>
</div>






				<div class="footer__info">
					<div class="footer__copy"><span>©Balirate 2025.</span> <?php the_field('text_allr_'.$lang, 'options'); ?>This site is protected by reCAPTCHA and the Google<a href="https://policies.google.com/privacy">Privacy Policy</a> and<a href="https://policies.google.com/terms">Terms of Service</a> apply.</div>
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
					<div class="popup__text">Заполните контактную информацию, и наш специалист свяжется с вами в кратчайшие сроки</div>
						<?php echo do_shortcode( '[contact-form-7 id="80efce5" title="Связаться - Объект недвижимости" html_class="popup__form"]' ); ?>
					
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
						<?php echo do_shortcode( '[contact-form-7 id="498dd46" title="Cвязаться - Застройщик" html_class="popup__form"]' ); ?>
				</div>
			</div>
		</div>
	</div>
    <div id="popup-invest" aria-hidden="true" class="popup popup-feed">
          <div class="popup__wrapper">
    <div class="popup__content popup__content--investment">
      <button data-close type="button" class="popup__close icon-close"></button>
      
      <div class="popup__investment-header">
        <h2 class="popup__investment-title">Закрытые <span style="color: #fff;">инвестиционные предложения</span></h2>
        <p class="popup__investment-subtitle">Подборка закрытых инвестиционных предложений от девелоперов, эксклюзивно для BaliRate со скидкой до 30%</p>
      </div>
      
      <div class="popup__investment-body">
        <div class="popup__investment-form">
          <?php echo do_shortcode('[contact-form-7 id="f85f5b7" title="Инвестиционные объекты 2025 года"]'); ?>
        </div>
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
					<div class="popup__text">Эксклюзивный каталог лучших застройщиков Бали — получите в WhatsApp прямо сейчас</div>
						<?php echo do_shortcode( '[contact-form-7 id="0783fb9" title="Cвязаться - Агентство" html_class="popup__form"]' ); ?>
				</div>
			</div>
		</div>
	</div>
<div id="popup-lead" aria-hidden="true" class="popup popup-feed">
    
    
    <div class="popup__wrapper">
    <div class="popup__content popup__content--investment">
      <button data-close type="button" class="popup__close icon-close"></button>
      
      <div class="popup__investment-header">
        <h2 class="popup__investment-title">Закрытые <span style="color: #fff;">инвестиционные предложения</span></h2>
        <p class="popup__investment-subtitle">Подборка закрытых инвестиционных предложений от девелоперов, эксклюзивно для BaliRate со скидкой до 30%</p>
      </div>
      
      <div class="popup__investment-body">
        <div class="popup__investment-form">
          <?php echo do_shortcode('[contact-form-7 id="1790" title="Pop-Up 10 секунд" html_class="popup__form"]'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
	<script  defer src="<?php echo get_template_directory_uri()?>/js/common.js?ver=<?php echo wp_get_theme()->get( 'Version' );?><?php echo time();?>"></script>
	<script  defer src="<?php echo get_template_directory_uri()?>/js/app.min.js?ver=<?php echo wp_get_theme()->get( 'Version' );?><?php echo time();?>"></script>

<script>
// Добавьте этот скрипт в footer.php или в отдельный JS файл

document.addEventListener('DOMContentLoaded', function() {
    // Находим все ссылки переключения языка
    const langLinks = document.querySelectorAll('.lang-option');
    
    langLinks.forEach(function(link) {
        const hreflang = link.getAttribute('hreflang');
        
        // Если это ссылка на русский язык
        if (hreflang === 'ru_RU') {
            // Получаем текущий URL
            let currentUrl = window.location.pathname;
            
            // Убираем языковые префиксы
            let cleanUrl = currentUrl;
            if (cleanUrl.startsWith('/en/')) {
                cleanUrl = cleanUrl.substring(4); // убираем '/en/'
                if (cleanUrl === '') cleanUrl = '/';
            } else if (cleanUrl.startsWith('/id/')) {
                cleanUrl = cleanUrl.substring(4); // убираем '/id/'
                if (cleanUrl === '') cleanUrl = '/';
            }
            
            // Формируем правильную ссылку для русского (без префикса)
            const baseUrl = window.location.origin;
            let russianUrl;
            
            if (cleanUrl === '/') {
                russianUrl = baseUrl + '/';
            } else {
                russianUrl = baseUrl + '/' + cleanUrl.replace(/^\/+/, '');
            }
            
            // Обновляем ссылку
            link.href = russianUrl;
            
            console.log('Обновлена ссылка на русский:', russianUrl);
        }
        
        // Если это ссылка на английский язык
        if (hreflang === 'en_US') {
            let currentUrl = window.location.pathname;
            let cleanUrl = currentUrl;
            
            // Убираем существующие префиксы
            if (cleanUrl.startsWith('/en/')) {
                cleanUrl = cleanUrl.substring(4);
            } else if (cleanUrl.startsWith('/id/')) {
                cleanUrl = cleanUrl.substring(4);
            } else {
                // Для русского убираем начальный слеш
                cleanUrl = cleanUrl.substring(1);
            }
            
            const baseUrl = window.location.origin;
            let englishUrl;
            
            if (cleanUrl === '' || cleanUrl === '/') {
                englishUrl = baseUrl + '/en/';
            } else {
                englishUrl = baseUrl + '/en/' + cleanUrl;
            }
            
            link.href = englishUrl;
            console.log('Обновлена ссылка на английский:', englishUrl);
        }
        
        // Если это ссылка на индонезийский язык
        if (hreflang === 'id_ID') {
            let currentUrl = window.location.pathname;
            let cleanUrl = currentUrl;
            
            // Убираем существующие префиксы
            if (cleanUrl.startsWith('/en/')) {
                cleanUrl = cleanUrl.substring(4);
            } else if (cleanUrl.startsWith('/id/')) {
                cleanUrl = cleanUrl.substring(4);
            } else {
                // Для русского убираем начальный слеш
                cleanUrl = cleanUrl.substring(1);
            }
            
            const baseUrl = window.location.origin;
            let indonesianUrl;
            
            if (cleanUrl === '' || cleanUrl === '/') {
                indonesianUrl = baseUrl + '/id/';
            } else {
                indonesianUrl = baseUrl + '/id/' + cleanUrl;
            }
            
            link.href = indonesianUrl;
            console.log('Обновлена ссылка на индонезийский:', indonesianUrl);
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Предотвращаем закрытие попапа при submit формы
    document.querySelectorAll('.popup__investment-cf7').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.stopPropagation(); // Останавливаем всплытие события
        });
    });

    // Закрываем попап только при успешной отправке
    document.addEventListener('wpcf7mailsent', function(event) {
        setTimeout(function() {
            const popup = event.target.closest('.popup');
            if (popup) {
                popup.classList.remove('popup_show');
                popup.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('popup-show');
                
                // Очищаем форму через 2 секунды после закрытия
                setTimeout(function() {
                    event.target.reset();
                }, 2000);
            }
        }, 2000); // Закрываем через 2 сек после успешной отправки
    });

    // Закрытие только по крестику
    document.querySelectorAll('[data-close]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const popup = this.closest('.popup');
            if (popup) {
                popup.classList.remove('popup_show');
                popup.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('popup-show');
            }
        });
    });
});
</script>
	<?php wp_footer(); ?>
<a href="https://wa.me/62812278673919" class="social-button whatsapp" target="_blank">
  <i class="fa fa-whatsapp"></i>
</a>
<a href="https://t.me/balirate" class="social-button telegram" target="_blank">
  <i class="fa fa-telegram"></i>
</a>

</body>
</html>