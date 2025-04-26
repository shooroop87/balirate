<?php

/**
 * Отключение логотипа/брендинга в шапке сайта, если у записи стоит специальная мета-галочка.
 */
function actions_disable_header() {
	global $post;

	// Если установлено пользовательское поле "_actions_site_header" — удаляем брендирование
	if ( isset($post) ? get_post_meta($post->ID, '_actions_site_header', true) : '' ) {
		remove_action('actions_header_elements', 'actions_site_branding', 20);
	}
}
add_action('template_redirect', 'actions_disable_header');

/**
 * Отключение основного меню в шапке, если задано соответствующее мета-поле.
 */
function actions_disable_menu() {
	global $post;

	// Если установлено пользовательское поле "_actions_site_menu" — убираем меню
	if ( isset($post) ? get_post_meta($post->ID, '_actions_site_menu', true) : '' ) {
		remove_action('actions_header_elements', 'actions_primary_navigation', 40);
	}
}
add_action('template_redirect', 'actions_disable_menu');

/**
 * Отключение заголовка страницы, если это указано в мета-поле.
 */
function actions_disable_title() {
	global $post;

	// Если установлено поле "_actions_page_title" — удаляем заголовки
	if ( isset($post) ? get_post_meta($post->ID, '_actions_page_title', true) : '' ) {
		remove_action('actions_page_elements', 'actions_page_header', 10);
		remove_action('post_header', 'actions_post_header', 20);
		remove_action('actionshomepage_entry_top', 'actionshomepage_entry_header', 10);
	}
}
add_action('template_redirect', 'actions_disable_title');

/**
 * Отключение футера (кредита в подвале), если задано специальное поле.
 */
function actions_disable_footer() {
	global $post;

	// Если установлено поле "_actions_site_footer" — удаляем футерный кредит
	if ( isset($post) ? get_post_meta($post->ID, '_actions_site_footer', true) : '' ) {
		remove_action('actions_footer_elements', 'actions_footer_credit', 20);
	}
}
add_action('template_redirect', 'actions_disable_footer');

/**
 * Добавляет классы в <body>, в зависимости от пользовательских настроек страницы.
 */
function actions_dev_body_classes($classes) {
	// Получаем все мета-поля текущей страницы
	$meta = get_post_meta(get_the_ID());

	// Определяем тип лейаута (расположение сайдбара и контента)
	$content_layout = isset($meta['_actions_layout_options'][0]) && $meta['_actions_layout_options'][0] !== ''
		? $meta['_actions_layout_options'][0]
		: 'content-sidebar';

	// Определяем тип конструктора страниц (если используется)
	$page_builder = isset($meta['_actions_builder_options'][0]) && $meta['_actions_builder_options'][0] !== ''
		? $meta['_actions_builder_options'][0]
		: '';

	// Добавляем классы в зависимости от выбранного лейаута
	if ($content_layout === 'content-sidebar') {
		$classes[] = 'sidebar-right';
	} elseif ($content_layout === 'sidebar-content') {
		$classes[] = 'sidebar-left';
	} elseif ($content_layout === 'content') {
		$classes[] = 'no-sidebar';
	}

	// Класс для полной ширины
	if (isset($meta['_actions_fullwidth_content'][0]) && $meta['_actions_fullwidth_content'][0] !== '') {
		$classes[] = 'full-width-content';
	}

	// Классы для конструктора страниц (если выбран)
	if ($page_builder === 'builder-standard') {
		$classes[] = 'builder-standard-content';
	}
	if ($page_builder === 'builder-blank') {
		$classes[] = 'builder-blank-content';
	}

	return $classes;
}
add_filter('body_class', 'actions_dev_body_classes');

/**
 * Отключает вывод различных элементов страницы при использовании конструктора страниц.
 */
function actions_page_builder() {
	global $post;

	// Получаем тип конструктора из мета-поля
	$page_builder = get_post_meta(get_the_ID(), '_actions_builder_options', true);

	// Если выбран пустой шаблон — отключаем почти всё
	if ($page_builder === 'builder-blank') {
		remove_action('actions_content_body_before', 'actions_body_top', 10);
		remove_action('actions_content_body_after', 'actions_body_bottom', 10);
		remove_action('actions_header_elements', 'actions_site_branding', 20);
		remove_action('actions_header_elements', 'actions_primary_navigation', 40);
		remove_action('actions_page_elements', 'actions_page_header', 10);
		remove_action('actions_page_elements', 'actions_display_comments', 30);
		remove_action('actions_footer_elements', 'actions_footer_credit', 20);
	}

	// Если выбран стандартный шаблон конструктора — убираем шапку и комментарии
	if ($page_builder === 'builder-standard') {
		remove_action('actions_content_body_before', 'actions_body_top', 10);
		remove_action('actions_content_body_after', 'actions_body_bottom', 10);
		remove_action('actions_page_elements', 'actions_page_header', 10);
		remove_action('actions_page_elements', 'actions_display_comments', 30);
	}
}
add_action('template_redirect', 'actions_page_builder');
