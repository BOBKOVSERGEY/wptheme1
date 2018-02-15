<!doctype html>
<html lang="ru">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php include  'wp-content/themes/themeone/gz.htm';?>
<div class="head-wrapper">
  <div class="head">
    <div class="head-logo">
      <a href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_url')?>/images/logo.jpg" alt="" /></a>
    </div>
    <div class="head-banner">
      <?php $bannerMain = new WP_Query( [
        'post_type' => 'banner',
        'posts_per_page' => 1
      ] );?>
      <?php if ($bannerMain->have_posts()) :  while ($bannerMain->have_posts()) : $bannerMain->the_post(); ?>
        <?php if ( has_post_thumbnail() ) {?>
          <?php the_post_thumbnail('full');?>
        <?php }?>
      <?php endwhile; ?>
        <?php else: ?>
        <p>Место для баннера 728x90</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<div class="menu-wrapper">
  <div class="menu-main">
    <?php if(!dynamic_sidebar('menu_header')){ ?>
      <span>Это область меню, добавляемого из виджетов</span>
    <?php } ?>
    <ul class="ico-social">
      <li><a href="#"><img src="<?php bloginfo('template_url')?>/images/ico-vk.png" alt="мы вконтакте" /></a></li>
      <li><a href="#"><img src="<?php bloginfo('template_url')?>/images/ico-youtobe.png" alt="канал youtobe" /></a></li>
      <li><a href="#"><img src="<?php bloginfo('template_url')?>/images/ico-facebook.png" alt="мы на facebook" /></a></li>
      <li><a href="#"><img src="<?php bloginfo('template_url')?>/images/ico-twitter.png" alt="наш twitter" /></a></li>
    </ul>
  </div>
</div>