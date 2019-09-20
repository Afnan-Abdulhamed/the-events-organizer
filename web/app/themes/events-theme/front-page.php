<?php
/**
 * Home Page
 */
get_header();
?>
    <div class="hedaer-cover" style="height:100vh; background-image:url(<?php echo get_template_directory_uri()?>/assets/images/cover.png)">
    
    <h1 class="home-title">
        Salungat sa kaalaman ng marami, ang Lorem Ipsum
    </h1>
    <div class="home-txt">
        <a class="past-link home-link" href="<?php echo get_home_url() ?>/events">Check Our Events</a>
    </div>
</div>
<?php get_footer(); ?>