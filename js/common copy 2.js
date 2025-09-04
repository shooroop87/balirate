jQuery(document).ready(function($) {
    // Ваш существующий код
    $(".first-filter__form button.button--white").click(function () {
        var curr = $(location).attr('href');
        window.location.href = curr;
    });
    
    // Функция активации таба агентств
    function activateAgencyTab() {
        $('.first__tabstitle').removeClass('_tab-active');
        $('.first__tabsbody').removeClass('_tab-active');
        $('.first__tabstitle').eq(5).addClass('_tab-active');
        $('.first__tabsbody').eq(5).addClass('_tab-active');
        
        var $tabsSection = $('.first__tabs');
        if ($tabsSection.length) {
            $('html, body').animate({
                scrollTop: $tabsSection.offset().top - 100
            }, 500);
        }
    }
    
    // Функция активации таба разработчиков
    function activateDevelopersTab() {
        $('.first__tabstitle').removeClass('_tab-active');
        $('.first__tabsbody').removeClass('_tab-active');
        $('.first__tabstitle').eq(1).addClass('_tab-active');
        $('.first__tabsbody').eq(1).addClass('_tab-active');
        
        var $tabsSection = $('.first__tabs');
        if ($tabsSection.length) {
            $('html, body').animate({
                scrollTop: $tabsSection.offset().top - 100
            }, 500);
        }
    }
    
    // Обработчик для ссылок на агентства и разработчиков
    $(document).on('click', 'a', function(e) {
        var href = $(this).attr('href');
        if (!href) return;
        
        var linkText = $(this).text().toLowerCase();
        
        // Проверяем, является ли это ссылкой на агентства
        var isAgencyLink = href.indexOf('#agency') !== -1 || 
                          href.indexOf('/agency/') !== -1 || 
                          href.indexOf('?tab=5') !== -1 ||
                          linkText.indexOf('агентств') !== -1;
        
        // Проверяем, является ли это ссылкой на разработчиков
        var isDevelopersLink = href.indexOf('#developers') !== -1 || 
                              href.indexOf('/developers/') !== -1 || 
                              href.indexOf('?tab=1') !== -1 ||
                              linkText.indexOf('разработчик') !== -1;
        
        if (isAgencyLink || isDevelopersLink) {
            e.preventDefault(); // Всегда отменяем стандартное поведение
            
            var isHomePage = window.location.pathname === '/' || window.location.pathname === '/index.php';
            
            if (isHomePage) {
                // Если мы на главной странице - активируем таб без перезагрузки
                if (isAgencyLink) {
                    activateAgencyTab();
                    if (history.pushState) {
                        history.pushState(null, null, '/?tab=5');
                    }
                } else if (isDevelopersLink) {
                    activateDevelopersTab();
                    if (history.pushState) {
                        history.pushState(null, null, '/?tab=1');
                    }
                }
            } else {
                // Если мы НЕ на главной странице - переходим на главную с активной вкладкой
                if (isAgencyLink) {
                    window.location.href = 'https://balirate.com/?tab=5';
                } else if (isDevelopersLink) {
                    window.location.href = 'https://balirate.com/?tab=1';
                }
            }
        }
    });
    
    // Проверяем URL и хэш при загрузке страницы (только для главной)
    var isHomePage = window.location.pathname === '/' || window.location.pathname === '/index.php';
    
    if (isHomePage) {
        var hash = window.location.hash;
        var urlParams = new URLSearchParams(window.location.search);
        var tabParam = urlParams.get('tab');
        
        if (hash === '#agency' || tabParam === '5') {
            setTimeout(activateAgencyTab, 100);
        } else if (hash === '#developers' || tabParam === '1') {
            setTimeout(activateDevelopersTab, 100);
        }
    }
});