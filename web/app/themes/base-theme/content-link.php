<?php
/**
 * The template for displaying link post formats
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Base_Foundation
 * @since Base Foundation 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php shatteredmm_post_thumbnail(); ?>

    <header class="entry-header">
        <?php
        if (is_single()) :
            the_title(sprintf('<h1 class="entry-title"><a href="%s">', esc_url(twentyfifteen_get_link_url())), '</a></h1>');
        else :
            the_title(sprintf('<h2 class="entry-title"><a href="%s">', esc_url(twentyfifteen_get_link_url())), '</a></h2>');
        endif;
        ?>
    </header>
    <!-- .entry-header -->

    <div class="entry-content">
        <?php
        /* translators: %s: Name of current post */
        the_content(sprintf(
            __('Continue reading %s'),
            the_title('<span class="screen-reader-text">', '</span>', false)
        ));

        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ));
        ?>
    </div>

    <footer class="entry-footer">
        <?php twentyfifteen_entry_meta(); ?>
        <?php edit_post_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
    </footer>
</article>
