<?php

/**
 * @file
 * Definition of the 'back_link' panel style.
 * Only adds a classname to the pane for the theme to style
 */

// Plugin definition
$plugin = array(
  'title' => t('Back link'),
  'description' => t('Pane for a single "return" navigation link'),
  'theme' => 'back_link',
  'render pane' => 'tietocom_back_link_style_render_pane',
);

/**
 * Render callback for a single pane.
 */
function theme_tietocom_back_link_style_render_pane($vars) {
  $content = $vars['content'];
  $display = $vars['display'];
  $pane = $vars['pane'];
  if (empty($content->content)) {
    return;
  }

  if (empty($content->css_class)) {
    $content->css_class = 'back-link';
  } else {
    $content->css_class .= ' back-link';
  }

  //drupal_add_css(drupal_get_path('theme', 'tietocom') . '/styles/back_link/back_link.css');
  $output = theme('panels_pane', array('content' => $content, 'pane' => $pane, 'display' => $display));

  return $output;
}
