<?php
/**
 * init.php — центральный загрузчик функционала темы
 * Подключает ключевые модули: настройки, кастомайзер, шаблонные функции и вспомогательные утилиты.
 *
 * @package actions
 */

//
// 1. Настройки темы (setup): здесь обычно регистрируются меню, поддержка миниатюр, 
//    пользовательские типы записей (CPT), таксономии и другие глобальные параметры темы.
//
require_once( trailingslashit(get_template_directory()) . 'inc/functions/setup.php' );


//
// 2. Настройки Customizer — подключает возможности редактирования темы из админки
//    через интерфейс "Внешний вид" → "Настроить".
//
require_once( trailingslashit(get_template_directory()) . 'inc/customizer/customizer.php' );


//
// 3. Структура шаблонов — подключение различных функций, управляющих разметкой и логикой
//    для различных частей сайта: посты, страницы, шапка, подвал, теги шаблонов и поиск.
//

// Общие функции для HTML-разметки
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/markup-functions.php' );

// Подключение хуков (add_action, do_action)
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/hooks.php' );

// Функции, связанные с отображением постов (записей)
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/post.php' );

// Функции для страниц
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/page.php' );

// Шапка сайта
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/header.php' );

// Подвал сайта
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/footer.php' );

// Комментарии
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/comments.php' );

// Дополнительные шаблонные теги (например: кастомные pagination, breadcrumbs и т.д.)
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/template-tags.php' );

// Подключение функций поиска (если кастомизирован)
require_once( trailingslashit(get_template_directory() ) . 'inc/structure/search.php' );


//
// 4. Вспомогательные функции, не привязанные напрямую к шаблонам.
// Обычно здесь находятся утилиты, фильтры, короткие коды и глобальные хелперы
