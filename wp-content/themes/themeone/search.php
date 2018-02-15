<?php get_header(); ?>
<div class="content-wrapper">
  <div class="content-main">

    <div class="content">


      <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
        <div class="articles">
          <?php if ( has_post_thumbnail() ) {?>
            <div class="articles-gen-img">
              <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a>
            </div>
          <?php }?>
          <div class="articles-head">
            <span class="articles-date"><img src="<?php bloginfo('template_url')?>/images/articles-autor.jpg" alt="admin" /> <span><?php the_author(); ?></span> <?php the_date(); ?></span>
            <span class="articles-comments"><img src="<?php bloginfo('template_url')?>/images/articles-comment.jpg" alt="commets" /> <a href="#"><?php comments_popup_link('Комментариев пока нет','1 комментарий', '% комментариев'); ?></a></span>
          </div>

          <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
          <p><?php the_excerpt(); ?></p> <?php //echo get_post_meta($post->ID, 'keywords', true); ?>

          <p><a href="<?php the_permalink(); ?>">Read More</a></p>

        </div>
      <?php endwhile; ?>
        <?php else: ?>
        <p>По вашему запросу ничего не найдено</p>
      <?php endif; ?>





      <div class="pager">
        <?php bootstrap_pagination(); ?>
      </div>

    </div>

    <?php get_sidebar(); ?>
  </div>

</div>
<?php get_footer(); ?>
