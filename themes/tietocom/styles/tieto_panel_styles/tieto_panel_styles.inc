<?php

/**
 * @file
 * Definition of the 'tieto_panel_styles' panel style.
 */

// Plugin definition
$plugin = array(
  'title' => t('Tieto panel pane styles'),
  'description' => t('Settings to control width and style of panes'),
  'theme' => 'tieto_panel_styles',
  'render region' => 'tietocom_tieto_panel_styles_style_render_region',
  'render pane' => 'tietocom_tieto_panel_styles_style_render_pane',
    'settings form' => 'tietocom_tieto_panel_styles_style_settings_form',
  'pane settings form' => 'tietocom_tieto_panel_styles_pane_style_settings_form',
);

/**
 * Render callback for a region.
 */
function theme_tietocom_tieto_panel_styles_style_render_region($vars) {

  $content = implode('<div class="panel-separator"></div>', $vars['panes']);

  if (empty($content)) {
    return;
  }

  $classes=array();
  foreach($vars['settings'] as $key => $value) {
    $classes[] = 'panel-' . $value;
  }
  $classes = implode(' ', $classes);

  $content = '<div class = "tieto-panel-styles-region ' . $classes . '">' . $content . '</div>';

  drupal_add_css(drupal_get_path('theme', 'tietocom') . '/styles/tieto_panel_styles/stylesheets/tieto-panel-styles.css');
  drupal_add_js(drupal_get_path('theme', 'tietocom') . '/styles/tieto_panel_styles/tieto_panel_styles.js');
  return $content;
}


/**
 * Render callback for a single pane.
 */
function theme_tietocom_tieto_panel_styles_style_render_pane($vars) {
  $content = $vars['content'];
  $display = $vars['display'];
  $pane = $vars['pane'];
  if (empty($content->content)) {
    return;
  }

  $classes = '';
  foreach($vars['settings'] as $key => $value) {
    $classes[] = $value;
  }

  if($pane->position == 0) {
    $classes[] = "panel-first-pane";
  }

  if($pane->position + 1 == count($display->panels[$pane->panel])) {
    $classes[] = "panel-last-pane";
  }
  $classes = implode(' ', $classes);

  drupal_add_css(drupal_get_path('theme', 'tietocom') . '/styles/tieto_panel_styles/stylesheets/tieto-panel-styles.css');
  drupal_add_js(drupal_get_path('theme', 'tietocom') . '/styles/tieto_panel_styles/tieto_panel_styles.js');

  $output = '<div class="tieto-pane-wrapper '. $classes .'">';
  $output .= theme('panels_pane', array('content' => $content, 'pane' => $pane, 'display' => $display));
  $output .= '</div>';

  return $output;
}


/**
 * Region settings form callback.
 */
function tietocom_tieto_panel_styles_style_settings_form($style_settings) {

  $form['region_columns'] = array(
    '#type' => 'select',
    '#title' => t('Number of columns'),
    '#options' => array(
      'region_no_col' => t('Unspecified'),
      'region_two_col' => t('2 columns'),
      'region_three_col' => t('3 columns'),
      'region_four_col' => t('4 columns'),
      'region_ten_col' => t('10 columns'),
    ),
    '#description' => t('The number of columns this region should be divided into.'),
    '#default_value' => (isset($style_settings['region_columns'])) ? $style_settings['region_columns'] : 'region_no_col',
  );

//  $form['region_background'] = array(
//    '#type' => 'select',
//    '#title' => t('Region background color'),
//    '#options' => array(
//      'style_background_none' => t('None'),
//      'style_background_blue' => t('Blue'),
//      'style_background_white' => t('White'),
//    ),
//    '#default_value' => (isset($style_settings['region_background'])) ? $style_settings['region_background'] : 'region_background_none',
//    '#description' => t('Set the background color for all panes in this panel region.'),
//  );
  return $form;
}


/**
 * Pane settings form callback.
 */
function tietocom_tieto_panel_styles_pane_style_settings_form($style_settings) {

  $form['pane_width'] = array(
    '#type' => 'select',
    '#title' => t('Pane width'),
    '#options' => array(
      'pane_span_unspecified' => t('Unspecified'),
      'pane_span_one_col' => t('1 column'),
      'pane_span_two_col' => t('2 columns'),
      'pane_span_three_col' => t('3 columns'),
      'pane_span_four_col' => t('4 columns'),
      'pane_span_five_col' => t('5 columns'),
      'pane_span_six_col' => t('6 columns'),
      'pane_span_seven_col' => t('7 columns'),
      'pane_span_eight_col' => t('8 columns'),
      'pane_span_nine_col' => t('9 columns'),
      'pane_span_ten_col' => t('10 columns'),
    ),
    '#default_value' => (isset($style_settings['pane_width'])) ? $style_settings['pane_width'] : 'pane_span_unspecified',
    '#description' => t('Make sure you have set a column number on the panel region containing this pane, and do not set this pane width to be greater than the maximum number of columns allowed by the panel region.'),
  );

 /* $form['pane_title_style'] = array(
    '#type' => 'select',
    '#title' => t('Pane title style'),
    '#options' => array(
      'style_default_title' => t('Default h2, Helvetica Neue Light'),
      'style_h1_title' => t('h1, Helvetica Neue Light'),
      'style_h2_title' => t('h2'),
      'style_h3_title' => t('h3'),
    ),
    '#default_value' => (isset($style_settings['pane_title_style'])) ? $style_settings['pane_title_style'] : 'style_default_title',
  );*/

//  $form['pane_background'] = array(
//    '#type' => 'select',
//    '#title' => t('Pane background color'),
//    '#options' => array(
//      'style_background_none' => t('Default'),
//      'style_background_blue' => t('Blue'),
//      'style_background_white' => t('White'),
//    ),
//    '#default_value' => (isset($style_settings['pane_background'])) ? $style_settings['pane_background'] : 'pane_background_white',
//    '#description' => t('This setting will override any background color set in the panel region.')
//  );

  $form['pane_highlight_icon'] = array(
    '#type' => 'select',
    '#title' => t('Pane highlight icon and title style'),
    '#options' => array(
      'pane_icon_none' => t('No icon'),
      'pane_h1_title' => t('Large title style'),
      'pane_icon_event' => t('Events highlight'),
      'pane_icon_ircorner' => t('IR Corner'),
      'pane_icon_jobsearch' => t('Jobs search'),
      'pane_icon_news' => t('News highlight'),
      'pane_icon_topstories' => t('Top stories'),
      'pane_icon_search' => t('Search icon'),
      'pane_icon_users' => t('User icon'),
      'pane_icon_world' => t('World icon'),
    ),
    '#default_value' => (isset($style_settings['pane_highlight_icon'])) ? $style_settings['pane_highlight_icon'] : 'pane_icon_none',
    '#description' => t('Set a specific icon or style on the pane title.')
  );

  return $form;
}
