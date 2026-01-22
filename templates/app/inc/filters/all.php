<?php

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', fn() => sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', '{{TEXT_DOMAIN}}')));
