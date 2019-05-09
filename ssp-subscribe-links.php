<?php
/**
 * Plugin Name: Seriously Simple Subscribe Links
 * Version: 1.0.0
 * Plugin URI: https://www.castos.com/seriously-simple-podcasting
 * Description: Manage your podcast subscribe links
 * Author: Castos
 * Author URI: https://www.castos.com/
 * Requires PHP: 5.3.3
 * Requires at least: 4.4
 * Tested up to: 5.1.1
 *
 */

add_filter( 'ssp_include_podcast_subscribe_links', 'myprefix_ssp_include_podcast_subscribe_links' );
function myprefix_ssp_include_podcast_subscribe_links( $subscribe_display ) {

	$episode_id = get_the_ID();
	$terms      = get_the_terms( $episode_id, 'series' );

	/**
	 * Get the default feed subscribe urls
	 */
	$itunes_url      = get_option( 'ss_podcasting_itunes_url', '' );
	$stitcher_url    = get_option( 'ss_podcasting_stitcher_url', '' );
	$google_play_url = get_option( 'ss_podcasting_google_play_url', '' );
	$spotify_url     = get_option( 'ss_podcasting_spotify_url', '' );

	/**
	 * If a series, get the series feed subscribe links, if they are set
	 */
	if ( is_array( $terms ) ) {
		if ( isset( $terms[0] ) ) {
			if ( false !== get_option( 'ss_podcasting_itunes_url_' . $terms[0]->term_id ) ) {
				$itunes_url = get_option( 'ss_podcasting_itunes_url_' . $terms[0]->term_id, '' );
			}
			if ( false !== get_option( 'ss_podcasting_stitcher_url_' . $terms[0]->term_id ) ) {
				$stitcher_url = get_option( 'ss_podcasting_stitcher_url_' . $terms[0]->term_id, '' );
			}
			if ( false !== get_option( 'ss_podcasting_google_play_url_' . $terms[0]->term_id ) ) {
				$google_play_url = get_option( 'ss_podcasting_google_play_url_' . $terms[0]->term_id, '' );
			}
			if ( false !== get_option( 'ss_podcasting_spotify_url_' . $terms[0]->term_id ) ) {
				$spotify_url = get_option( 'ss_podcasting_spotify_url_' . $terms[0]->term_id, '' );
			}
		}
	}

	/**
	 * Output and capture the new subscribe links html
	 * Modify this HTML to modify how your subscribe links look
	 */
	ob_start();
	?>
	<p>Subscribe:
		<a href="<?php echo $itunes_url ?>" target="_blank" title="Subscribe to iTunes" class="podcast-meta-itunes"><img src="https://castos.com/wp-content/uploads/2019/05/iTunes.png"></a> |
		<a href="<?php echo $stitcher_url ?>" target="_blank" title="Subscribe to Stitcher" class="podcast-meta-itunes">Subscribe to Stitcher</a> |
		<a href="<?php echo $google_play_url ?>" target="_blank" title="Subscribe to Google Play" class="podcast-meta-itunes">Subscribe to Google Play</a> |
		<a href="<?php echo $spotify_url ?>" target="_blank" title="Subscribe to Spotify" class="podcast-meta-itunes">Subscribe to Spotify</a>
	</p>
	<?php
	$subscribe_display = ob_get_clean();

	return $subscribe_display;
}
