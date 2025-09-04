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

// Инициализация слайдера видео на главной странице
document.addEventListener('DOMContentLoaded', function() {
    // Слайдер видео на главной
    const videosSlider = document.querySelector('.videos__slider');
    if (videosSlider) {
        const swiper = new Swiper(videosSlider, {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true, // Включаем loop для корректной работы
            loopAdditionalSlides: 3,
            loopPreventsSlide: false,
            navigation: {
                nextEl: '.videos__swiper-button-next',
                prevEl: '.videos__swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                }
            },
            on: {
                init: function() {
                    console.log('Videos slider initialized');
                    this.loopFix();
                }
            }
        });

        // Функция для убирания класса disabled (как в рабочем слайдере)
        function removeDisabledClass() {
            document.querySelectorAll(".swiper-button-disabled").forEach(button => {
                button.classList.remove("swiper-button-disabled");
                button.removeAttribute("disabled");
            });
        }

        // Наблюдатель за изменениями DOM для автоматического удаления disabled класса
        const observer = new MutationObserver(() => {
            removeDisabledClass();
        });

        observer.observe(videosSlider, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ["class"]
        });

        // Убираем disabled класс сразу
        removeDisabledClass();
    }

    // Слайдер видео застройщика
    const developerVideosSlider = document.querySelector('.developer-videos__slider');
    if (developerVideosSlider) {
        new Swiper(developerVideosSlider, {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            navigation: {
                nextEl: '.developer-videos__swiper-button-next',
                prevEl: '.developer-videos__swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                }
            },
            on: {
                init: function() {
                    console.log('Developer videos slider initialized');
                }
            }
        });
    }

    // Общий обработчик для всех видео кнопок
    document.addEventListener('click', function(e) {
        const videoTrigger = e.target.closest('[data-video-id]');
        if (videoTrigger) {
            e.preventDefault();
            const videoId = videoTrigger.getAttribute('data-video-id');
            openVideoModal(videoId);
        }
    });

    // Функция открытия видео модального окна
    function openVideoModal(videoId) {
        if (!videoId) return;
        
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('videoFrame');
        
        if (modal && iframe) {
            const embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&modestbranding=1`;
            
            iframe.src = embedUrl;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            
            // Отслеживание события просмотра видео (для аналитики)
            if (typeof gtag !== 'undefined') {
                gtag('event', 'video_play', {
                    'video_id': videoId,
                    'video_provider': 'youtube'
                });
            }
        }
    }

    // Закрытие видео модального окна
    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('videoFrame');
        
        if (modal && iframe) {
            modal.style.display = 'none';
            iframe.src = '';
            document.body.style.overflow = '';
        }
    }

    // Обработчики закрытия модального окна
    const closeVideoBtn = document.getElementById('closeVideoModal');
    const videoOverlay = document.querySelector('.video-modal__overlay');
    
    if (closeVideoBtn) {
        closeVideoBtn.addEventListener('click', closeVideoModal);
    }
    
    if (videoOverlay) {
        videoOverlay.addEventListener('click', closeVideoModal);
    }
    
    // Закрытие по ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('videoModal');
            if (modal && modal.style.display === 'block') {
                closeVideoModal();
            }
        }
    });

    // Предзагрузка превью при наведении (оптимизация)
    document.addEventListener('mouseenter', function(e) {
        const videoThumbnail = e.target.closest('.video-item__thumbnail, .developer-video-item__thumbnail, .developer-video-large__thumbnail');
        if (videoThumbnail) {
            const videoId = videoThumbnail.getAttribute('data-video-id');
            if (videoId) {
                // Предзагружаем iframe для более быстрого открытия
                const iframe = document.getElementById('videoFrame');
                if (iframe && !iframe.src) {
                    const embedUrl = `https://www.youtube.com/embed/${videoId}?rel=0&showinfo=0&modestbranding=1`;
                    // Можно добавить предзагрузку здесь если нужно
                }
            }
        }
    }, true);
});