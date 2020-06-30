//ADD TO FUNCTIONS.PHP and change line 11 as needed for post types. This will generate a sitemap at DOMAIN.COM/sitemap.xml
add_action( 'publish_post', 'ow_create_sitemap' );
add_action( 'publish_page', 'ow_create_sitemap' );
add_action( 'save_post',    'ow_create_sitemap' );

function ow_create_sitemap() {
    $postsForSitemap = get_posts(array(
        'numberposts' => -1,
        'orderby'     => 'modified',
        // 'custom_post' should be replaced with your own Custom Post Type (one or many)
        'post_type'   => array( 'post', 'page', 'faq', 'portfolio' ),
        'order'       => 'DESC'
    ));

    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

    foreach( $postsForSitemap as $post ) {
        setup_postdata( $post );

        $postdate = explode( " ", $post->post_modified );

        $sitemap .= '<url>'.
                    '<loc>' . get_permalink( $post->ID ) . '</loc>' .
                    '<lastmod>' . $postdate[0] . '</lastmod>' .
                    '<changefreq>monthly</changefreq>' .
                    '</url>';
      }

    $sitemap .= '</urlset>';

    $fp = fopen( ABSPATH . 'sitemap.xml', 'w' );

    fwrite( $fp, $sitemap );
    fclose( $fp );
}
