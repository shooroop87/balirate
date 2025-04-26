<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Подключаем необходимые файлы
require_once($_SERVER["DOCUMENT_ROOT"] . "/wp-load.php");
require_once(ABSPATH . "wp-admin/includes/image.php");
require_once(ABSPATH . "wp-admin/includes/file.php");
require_once(ABSPATH . "wp-admin/includes/media.php");

// Получение отправленных данных
$user_name    = trim($_POST["name"]);
$user_message = trim($_POST["message"]);
$mark1  = trim($_POST["mark1"]);
$mark2  = trim($_POST["mark2"]);
$mark3  = trim($_POST["mark3"]);
$mark4  = trim($_POST["mark4"]);
$type_rec  = trim($_POST["type_rec"]);
$object  = trim($_POST["post_id"]);
// $review_type = trim($_POST["review_type"]); # можно передать термин таксономии

$post_data = array(
    "post_author"   => 1,
    "post_status"   => "publish",               # статус - «На утверждении»
    "post_type"     => "review",               # тип записи - «Отзывы»
    "post_title"    => "Отзыв - " . $user_name, # заголовок отзыва
    "post_content"  => $user_message,           # текст отзыва
    // "tax_input" => ["{Название таксономии}" => array($review_type)],
);

// Вставляем запись в базу данных
$post_id = wp_insert_post($post_data);
$k=0; $oc=0;
if ($mark1>0) { $k++; $oc=$oc+$mark1; update_field("mark1", $mark1, $post_id);}
if ($mark2>0) { $k++; $oc=$oc+$mark2; update_field("mark2", $mark2, $post_id);}
if ($mark3>0) { $k++; $oc=$oc+$mark3; update_field("mark3", $mark3, $post_id);}
if ($mark4>0) { $k++; $oc=$oc+$mark4; update_field("mark4", $mark4, $post_id);}
$user_rating = round($oc/$k,1);

// Добавляем остальные поля

if ($user_rating>0 ) { update_field("mark", $user_rating, $post_id);}

update_field("object", $object, $post_id); 
update_field("type_rec", $type_rec, $post_id);
if ($user_rating>0 ) { update_field("rating", getRate($object), $object); }
update_field("nums_rev", gettotalrev($object), $object);
//update_field("name", $user_name, $post_id);      # имя

// Необходимо для записи таксономии «tax_input»
// wp_set_object_terms( $post_id, $review_type, "{Название таксономии}" );
?>