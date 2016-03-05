<?php
/**
 * Custom template tags for Twenty Fifteen
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

if (!function_exists('twentyfifteen_comment_nav')) :
    /**
     * Display navigation to next/previous comments when applicable.
     *
     * @since Twenty Fifteen 1.0
     */
    function twentyfifteen_comment_nav()
    {
        // Are there comments to navigate through?
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php _e('Comment navigation', 'twentyfifteen'); ?></h2>
                <div class="nav-links">
                    <?php
                    if ($prevLink = get_previous_comments_link(__('Older Comments', 'twentyfifteen'))) :
                        printf('<div class="nav-previous">%s</div>', $prevLink);
                    endif;

                    if ($nextLink = get_next_comments_link(__('Newer Comments', 'twentyfifteen'))) :
                        printf('<div class="nav-next">%s</div>', $nextLink);
                    endif;
                    ?>
                </div><!-- .nav-links -->
            </nav><!-- .comment-navigation -->
            <?php
        endif;
    }
endif;

if (!function_exists('twentyfifteen_entry_meta')) :
    /**
     * Prints HTML with meta information for the categories, tags.
     *
     * @since Twenty Fifteen 1.0
     */
    function twentyfifteen_entry_meta()
    {
        if (is_sticky() && is_home() && !is_paged()) {
            printf('<span class="sticky-post">%s</span>', __('Featured', 'twentyfifteen'));
        }

        $format = get_post_format();
        if (current_theme_supports('post-formats', $format)) {
            printf('<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
                sprintf('<span class="screen-reader-text">%s </span>', _x('Format', 'Used before post format.', 'twentyfifteen')),
                esc_url(get_post_format_link($format)),
                get_post_format_string($format)
            );
        }

        if (in_array(get_post_type(), array('post', 'attachment'))) {
            $timeString = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

            if (get_the_time('U') !== get_the_modified_time('U')) {
                $timeString = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $timeString = sprintf($timeString,
                esc_attr(get_the_date('c')),
                get_the_date(),
                esc_attr(get_the_modified_date('c')),
                get_the_modified_date()
            );

            printf('<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
                _x('Posted on', 'Used before publish date.', 'twentyfifteen'),
                esc_url(get_permalink()),
                $timeString
            );
        }

        if ('post' == get_post_type()) {
            if (is_singular() || is_multi_author()) {
                printf('<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
                    _x('Author', 'Used before post author name.', 'twentyfifteen'),
                    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                    get_the_author()
                );
            }

            $categoriesList = get_the_category_list(_x(', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen'));
            if ($categoriesList && shatteredmm_categorized_blog()) {
                printf('<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                    _x('Categories', 'Used before category names.', 'twentyfifteen'),
                    $categoriesList
                );
            }

            $tagsList = get_the_tag_list('', _x(', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen'));
            if ($tagsList) {
                printf('<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                    _x('Tags', 'Used before tag names.', 'twentyfifteen'),
                    $tagsList
                );
            }
        }

        if (is_attachment() && wp_attachment_is_image()) {
            // Retrieve attachment metadata.
            $metadata = wp_get_attachment_metadata();

            printf('<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
                _x('Full size', 'Used before full size attachment link.', 'twentyfifteen'),
                esc_url(wp_get_attachment_url()),
                $metadata['width'],
                $metadata['height']
            );
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            /* translators: %s: post title */
            comments_popup_link(sprintf(__('Leave a comment<span class="screen-reader-text"> on %s</span>', 'twentyfifteen'), get_the_title()));
            echo '</span>';
        }
    }
endif;

/**
 * Find out if blog has more than one category.
 *
 * @return boolean true if blog has more than 1 category
 */
function shatteredmm_categorized_blog()
{
    if (false === ($allTheCoolCats = get_transient('shatteredmm_category_count'))) {
        // Create an array of all the categories that are attached to posts
        $allTheCoolCats = get_categories(array(
            'hide_empty' => 1,
        ));

        // Count the number of categories that are attached to the posts
        $allTheCoolCats = count($allTheCoolCats);

        set_transient('shatteredmm_category_count', $allTheCoolCats);
    }

    return (1 !== (int)$allTheCoolCats) ? true : false;
}

if (!function_exists('shatteredmm_posted_on')) :
    /**
     * Print HTML with meta information for the current post-date/time and author.
     *
     * @return void
     */
    function shatteredmm_posted_on()
    {
        if (is_sticky() && is_home() && !is_paged()) {
            echo '<span class="featured-post">' . __('Sticky') . '</span>';
        } ?>
        <div class="post-date" data-equalizer-watch> <?php

            // Set up and print post meta information.
            //			printf( '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
            printf('<p class="entry-date"><time class="entry-date" datetime="%1$s"><span class="day">%2$s</span>&nbsp;%3$s<br/><span class="year">%4$s</span></time></p>',
                esc_attr(get_the_date('c')),
                esc_html(get_the_date('d')),
                esc_html(get_the_date('M')),
                esc_html(get_the_date('Y'))
//				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
//				get_the_author()
            ); ?>
        </div> <?php
    }
endif;

/**
 * Flush out the transients used in shatteredmm_categorized_blog.
 *
 * @return void
 */
function shatteredmm_category_transient_flusher()
{
    // Like, beat it. Dig?
    delete_transient('shatteredmm_category_count');
}

add_action('edit_category', 'shatteredmm_category_transient_flusher');
add_action('save_post', 'shatteredmm_category_transient_flusher');

if (!function_exists('shatteredmm_post_thumbnail')) :
    /**
     * Display an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index
     * views, or a div element when on single views.
     *
     * @return void
     */
    function shatteredmm_post_thumbnail()
    {
        if (post_password_required() || !has_post_thumbnail()) {
            return;
        }
        if (is_singular()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('post-thumbnail', array('alt' => get_the_title())); ?>
            </a>
        <?php endif; // End is_singular()
    }
endif;

/**
 *    Returns the excerpt if one has been set. If not, returns the first x words, defaulting to 50.
 **/
function the_custom_excerpt($numWords = 50, $content = null)
{
    if (!$content) {
        global $post;

        $content = $post->post_content;

        if (strlen($post->post_excerpt) > 0) {
            return $post->excerpt;
        }
    }

    $strippedContent = strip_tags(strip_shortcodes($content));
    $ex = explode(' ', $strippedContent);
    $slice = array_slice($ex, 0, $numWords);
    $excerpt = implode(' ', $slice) . '...';
    return $excerpt;
}


if (!function_exists('twentyfifteen_get_link_url')) :
    /**
     * Return the post URL.
     *
     * Falls back to the post permalink if no URL is found in the post.
     *
     * @since Twenty Fifteen 1.0
     *
     * @see get_url_in_content()
     *
     * @return string The Link format URL.
     */
    function twentyfifteen_get_link_url()
    {
        $hasUrl = get_url_in_content(get_the_content());

        return $hasUrl ? $hasUrl : apply_filters('the_permalink', get_permalink());
    }
endif;

if (!function_exists('twentyfifteen_excerpt_more') && !is_admin()) :
    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
     *
     * @since Twenty Fifteen 1.0
     *
     * @return string 'Continue reading' link prepended with an ellipsis.
     */
    function twentyfifteen_excerpt_more($more)
    {
        $link = sprintf('<a href="%1$s" class="more-link">%2$s</a>',
            esc_url(get_permalink(get_the_ID())),
            /* translators: %s: Name of current post */
            sprintf(__('Continue reading %s', 'twentyfifteen'), '<span class="screen-reader-text">' . get_the_title(get_the_ID()) . '</span>')
        );
        return ' &hellip; ' . $link;
    }

    add_filter('excerpt_more', 'twentyfifteen_excerpt_more');
endif;

if (!function_exists('shatteredmm_paging_nav')) :
    /**
     * Display navigation to next/previous set of posts when applicable
     *
     * @return void
     */
    function shatteredmm_paging_nav()
    {
        // Don't print empty markup if there's only one page.
        if ($GLOBALS['wp_query']->max_num_pages < 2) {
            return;
        }

        $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $pagenumLink = html_entity_decode(get_pagenum_link());
        $queryArgs = array();
        $urlParts = explode('?', $pagenumLink);

        if (isset($urlParts[1])) {
            wp_parse_str($urlParts[1], $queryArgs);
        }

        $pagenumLink = remove_query_arg(array_keys($queryArgs), $pagenumLink);
        $pagenumLink = trailingslashit($pagenumLink) . '%_%';

        $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenumLink, 'index.php') ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links(array(
            'base' => $pagenumLink,
            'format' => $format,
            'total' => $GLOBALS['wp_query']->max_num_pages,
            'current' => $paged,
            'mid_size' => 1,
            'add_args' => array_map('urlencode', $queryArgs),
            'prev_text' => __('&larr; Previous'),
            'next_text' => __('Next &rarr;'),
        ));

        if ($links) : ?>
            <nav class="navigation paging-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e('Posts navigation'); ?></h1>
                <div class="pagination loop-pagination">
                    <?php echo $links; ?>
                </div>
            </nav>
            <?php
        endif;
    }
endif;
