<?php
/* gzip сжатие*/

function obSaveCookieAfter($s)
{
  setcookie("page_size_after", strlen($s));
  return $s;
}
// Аналогично, но для Cookie page_size_before.
function obSaveCookieBefore($s)
{
  setcookie("page_size_before", strlen($s));
  return $s;
}
// Устанавливаем конвейер обработчиков.
ob_start("obSaveCookieAfter");
ob_start("ob_gzhandler", 9);
ob_start("obSaveCookieBefore");

/**
* загружаемые  стили и скрипты
 */
function loadStyleScript()
{
  // подключаем стили сайта
  wp_enqueue_style('styleThemeOne', get_stylesheet_uri());

  // подключаем скрипты
  wp_enqueue_script('jqFancyTransitionsThemeOne', get_template_directory_uri() . '/js/jqFancyTransitions.1.8.min.js', [], null, true);
  wp_enqueue_script('jqueryThemeOne', get_template_directory_uri() . '/js/script.js', [], null, true);
}
// загружаем стили
add_action('wp_enqueue_scripts', 'loadStyleScript');


// хук для title
add_action('after_setup_theme', 'titleThemeOne');

function titleThemeOne()
{
  /*добавляем title*/
  add_theme_support('title-tag');
}


/**
 * удаляем теги из html
 */
add_filter('the_generator', '__return_empty_string');

remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
// убрать вывод коротких ссылок
remove_action('wp_head', 'wp_shortlink_wp_head');
// Убрать вывод канонических ссылок:
remove_action('wp_head','rel_canonical');

remove_action('wp_head','adjacent_posts_rel_link_wp_head');
remove_action('wp_head','feed_links_extra', 3);

remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');

remove_action( 'wp_head', 'wp_resource_hints', 2 );
// Отключаем сам REST API
add_filter('rest_enabled', '__return_false');

// Отключаем фильтры REST API
remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );
remove_action( 'wp_head',                    'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect',          'rest_output_link_header', 11, 0 );
remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Отключаем события REST API
remove_action( 'init',          'rest_api_init' );
remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
remove_action( 'parse_request', 'rest_api_loaded' );

// Отключаем Embeds связанные с REST API
remove_action( 'rest_api_init',          'wp_oembed_register_route'              );
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

/**
 * удаляем теги из html
 */


/**
 * Поддержка миниатюр
*/
add_theme_support('post-thumbnails');
set_post_thumbnail_size( 180,180 );

/**
 *
 * Сколько записей выводить
 */

/*add_action('pre_get_posts', 'getElementsCategory');
function getElementsCategory($query) {
  if (!is_admin() && $query->is_main_query()) {
    if ($query->is_archive && $query->is_post_type_archive('banner')) {
      $query->set('posts_per_page', 10);
    }
  }
    if ($query->is_archive && $query->is_post_type_archive('playlist2')) {
      $query->set('posts_per_page', 15);
    }
}*/

/**
 *
 * End Сколько записей выводить
 */

/**
Регистрируем новый тип записи
 */
add_action('init', 'themeOnePostTypes');

function themeOnePostTypes () {
  // регистрация баннеров
  register_post_type('banner', [
    'labels' => [
      'name'               => 'Баннеры', // основное название для типа записи
      'singular_name'      => 'Баннер', // название для одной записи этого типа
      'add_new'            => 'Добавить новый', // для добавления новой записи
      'add_new_item'       => 'Добавить новый баннер', // заголовка у вновь создаваемой записи в админ-панели.
      'edit_item'          => 'Редактирование баннер', // для редактирования типа записи
      'new_item'           => 'Новый баннер', // текст новой записи
      'view_item'          => 'Смотреть баннер', // для просмотра записи этого типа.
      'search_items'       => 'Искать баннеры', // для поиска по этим типам записи
      'not_found'          => 'Баннер не найдено', // если в результате поиска ничего не было найдено
      'not_found_in_trash' => 'Не найдено в корзине баннера', // если не было найдено в корзине
      'parent_item_colon'  => '', // для родителей (у древовидных типов)
      'menu_name'          => 'Баннеры', // название меню
    ],
    'public'              => true,
    'publicly_queryable'  => false, // убираем возможность перейти
    'exclude_from_search' => true, // убираем из поиска
    'menu_position'       => 25,
    'menu_icon'           => 'dashicons-format-gallery',
    'hierarchical'        => false,
    'supports'            => array('title', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
    'query_var'           => false
  ]);

  // регистрация слайдера
  register_post_type('slider', [
    'labels' => [
      'name'               => 'Слайдшоу на главной', // основное название для типа записи
      'singular_name'      => 'Слайд', // название для одной записи этого типа
      'add_new'            => 'Добавить новый', // для добавления новой записи
      'add_new_item'       => 'Добавить новый слайд', // заголовка у вновь создаваемой записи в админ-панели.
      'edit_item'          => 'Редактирование слайд', // для редактирования типа записи
      'new_item'           => 'Новый слайд', // текст новой записи
      'view_item'          => 'Смотреть слайд', // для просмотра записи этого типа.
      'search_items'       => 'Искать слайды', // для поиска по этим типам записи
      'not_found'          => 'Слайд не найдено', // если в результате поиска ничего не было найдено
      'not_found_in_trash' => 'Не найдено в корзине слайда', // если не было найдено в корзине
      'parent_item_colon'  => '', // для родителей (у древовидных типов)
      'menu_name'          => 'Слайдшоу на главной', // название меню
    ],
    'public'              => true,
    'publicly_queryable'  => false, // убираем возможность перейти
    'exclude_from_search' => true, // убираем из поиска
    'menu_position'       => 25,
    'menu_icon'           => 'dashicons-images-alt2',
    'hierarchical'        => false,
    'supports'            => array('title', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
    'query_var'           => false
  ]);
}
/**
End Регистрируем новый тип записи
 */
/**
 * End Поддержка миниатюр
 */

/**
 * Добавляем виджиты
 */
register_sidebar([
  'name'          => 'Верхнее меню',
  'id'          => 'menu_header',
  'class'         => '',
  'before_widget' => '',
  'after_widget'  => '',
]);

register_sidebar([
  'name'          => 'Sidebar',
  'id'          => 'sidebar',
  'class'         => '',
  'before_widget' => '<div class="sidebar-widget">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3>',
  'after_title'   => '</h3>'
]);

register_sidebar([
  'name'          => 'Footer',
  'id'          => 'footer',
  'class'         => '',
  'before_widget' => '<div class="footer-info">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3>',
  'after_title'   => '</h3>'
]);

/*$args = array(
  'name'          => __( 'Sidebar name', 'theme_text_domain' ),
  'id'            => 'unique-sidebar-id',    // ID should be LOWERCASE  ! ! !
  'description'   => '',
  'class'         => '',
  'before_widget' => '<li id="%1$s" class="widget %2$s">',
  'after_widget'  => '</li>',
  'before_title'  => '<h2 class="widgettitle">',
  'after_title'   => '</h2>' );*/

/**
 * END Добавляем виджиты
 */

/**
Длина анонса в блоге
 */
function new_excerpt_length($length) {
  return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');

/**
end Длина анонса в блоге
 */
/**
Окончание  анонса в блоге
 */
add_filter('excerpt_more', function($more) {
  return '...';
});
/**
end Окончание  анонса в блоге
 */

/**
 * постраничная навигация
 */

function bootstrap_pagination( $echo = true ) {
  global $wp_query;

  $big = 999999999; // need an unlikely integer

  $pages = paginate_links( array(
      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'format' => '?paged=%#%',
      'current' => max( 1, get_query_var('paged') ),
      'total' => $wp_query->max_num_pages,
      'type'  => 'array',
      'prev_next'   => true,
      'prev_text'    => __('« Prev'),
      'next_text'    => __('Next »'),
    )
  );

  if( is_array( $pages ) ) {
    $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');


    $pagination = '<ul class="pagination-page__list list-marked list-marked-type-2 list-marked-type-2-dot-1 list-marked-silver-chalice">';

    foreach ( $pages as $page ) {
      $pagination .= "<li>$page</li>";
    }

    $pagination .= '</ul>';

    if ( $echo ) {
      echo $pagination;
    } else {
      return $pagination;
    }
  }
}

/**
 * end постраничная навигация
 */
