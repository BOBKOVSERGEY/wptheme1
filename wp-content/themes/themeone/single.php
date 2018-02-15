<?php get_header(); ?>
<div class="content-wrapper">
  <div class="content-main">

    <div class="content">
      <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
        <div class="articles">
          <div class="articles-head">
            <span class="articles-date"><img src="<?php bloginfo('template_url')?>/images/articles-autor.jpg" alt="admin" /> <span><?php the_author(); ?></span> <?php the_date(); ?></span>
            <span class="articles-comments"><img src="<?php bloginfo('template_url')?>/images/articles-comment.jpg" alt="commets" /> <a href="#"><?php comments_popup_link('Комментариев пока нет','1 комментарий', '% комментариев'); ?></a></span>
          </div>

          <h1><?php the_title(); ?></h1>
          <p><?php the_content(); ?></p>



        </div>

      <?php endwhile; ?>
      <?php endif; ?>

      <?php comments_template();?>
    </div>

    <?php get_sidebar(); ?>
  </div>


</div>
<?php get_footer(); ?>
