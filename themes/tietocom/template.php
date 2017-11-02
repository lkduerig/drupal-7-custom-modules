<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * A QUICK OVERVIEW OF DRUPAL THEMING
 *
 *   The default HTML for all of Drupal's markup is specified by its modules.
 *   For example, the comment.module provides the default HTML markup and CSS
 *   styling that is wrapped around each comment. Fortunately, each piece of
 *   markup can optionally be overridden by the theme.
 *
 *   Drupal deals with each chunk of content using a "theme hook". The raw
 *   content is placed in PHP variables and passed through the theme hook, which
 *   can either be a template file (which you should already be familiary with)
 *   or a theme function. For example, the "comment" theme hook is implemented
 *   with a comment.tpl.php template file, but the "breadcrumb" theme hooks is
 *   implemented with a theme_breadcrumb() theme function. Regardless if the
 *   theme hook uses a template file or theme function, the template or function
 *   does the same kind of work; it takes the PHP variables passed to it and
 *   wraps the raw content with the desired HTML markup.
 *
 *   Most theme hooks are implemented with template files. Theme hooks that use
 *   theme functions do so for performance reasons - theme_field() is faster
 *   than a field.tpl.php - or for legacy reasons - theme_breadcrumb() has "been
 *   that way forever."
 *
 *   The variables used by theme functions or template files come from a handful
 *   of sources:
 *   - the contents of other theme hooks that have already been rendered into
 *     HTML. For example, the HTML from theme_breadcrumb() is put into the
 *     $breadcrumb variable of the page.tpl.php template file.
 *   - raw data provided directly by a module (often pulled from a database)
 *   - a "render element" provided directly by a module. A render element is a
 *     nested PHP array which contains both content and meta data with hints on
 *     how the content should be rendered. If a variable in a template file is a
 *     render element, it needs to be rendered with the render() function and
 *     then printed using:
 *       <?php print render($variable); ?>
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. With this file you can do three things:
 *   - Modify any theme hooks variables or add your own variables, using
 *     preprocess or process functions.
 *   - Override any theme function. That is, replace a module's default theme
 *     function with one you write.
 *   - Call hook_*_alter() functions which allow you to alter various parts of
 *     Drupal's internals, including the render elements in forms. The most
 *     useful of which include hook_form_alter(), hook_form_FORM_ID_alter(),
 *     and hook_page_alter(). See api.drupal.org for more information about
 *     _alter functions.
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   If a theme hook uses a theme function, Drupal will use the default theme
 *   function unless your theme overrides it. To override a theme function, you
 *   have to first find the theme function that generates the output. (The
 *   api.drupal.org website is a good place to find which file contains which
 *   function.) Then you can copy the original function in its entirety and
 *   paste it in this template.php file, changing the prefix from theme_ to
 *   tietocom_. For example:
 *
 *     original, found in modules/field/field.module: theme_field()
 *     theme override, found in template.php: tietocom_field()
 *
 *   where tietocom is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_field() function.
 *
 *   Note that base themes can also override theme functions. And those
 *   overrides will be used by sub-themes unless the sub-theme chooses to
 *   override again.
 *
 *   Zen core only overrides one theme function. If you wish to override it, you
 *   should first look at how Zen core implements this function:
 *     theme_breadcrumbs()      in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called theme hook suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node--forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and theme hook suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440 and http://drupal.org/node/1089656
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function tietocom_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  tietocom_preprocess_html($variables, $hook);
  tietocom_preprocess_page($variables, $hook);
}
// */


/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */

/*
 * Play with Drupal <head> and add some icons
 */
function tietocom_preprocess_html(&$variables, $hook) {
  // Setup IE meta tag to force IE rendering mode
  $meta_ie_render_engine = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'content' =>  'IE=8',
      'http-equiv' => 'X-UA-Compatible',
    ),
    '#weight' => '-99999',
  );
  //drupal_add_html_head($meta_ie_render_engine, 'meta_ie_render_engine');

  //set Metatag for Yandex verification only for RU
  global $language;
  $meta_ru_yandex = array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'yandex-verification',
      'content' =>  '4834d974d7afc44a',
    ),
    '#weight' => '0',
  );
  if($language->language == "ru"){
      drupal_add_html_head($meta_ru_yandex, 'meta_ru_yandex');
  }

  /*
   * <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
   */
  $precomposed = file_create_url(drupal_get_path('theme', 'tietocom') . '/apple-touch-icon-precomposed.png');
  $rel = 'apple-touch-icon-precomposed';
  drupal_add_html_head_link(array('rel' => $rel, 'href' => drupal_strip_dangerous_protocols($precomposed)));

  /*
   * <!-- For first- and second-generation iPad: -->
   */
  $precomposed = file_create_url(drupal_get_path('theme', 'tietocom') . '/apple-touch-icon-72x72-precomposed.png');
  $rel = 'apple-touch-icon-precomposed';
  $sizes = '72x72';
  drupal_add_html_head_link(array('rel' => $rel, 'sizes' => $sizes, 'href' => drupal_strip_dangerous_protocols($precomposed)));

  /*
  * <!-- For iPhone with high-resolution Retina display: -->
  */
  $precomposed = file_create_url(drupal_get_path('theme', 'tietocom') . '/apple-touch-icon-114x114-precomposed.png');
  $rel = 'apple-touch-icon-precomposed';
  $sizes = '114x114';
  drupal_add_html_head_link(array('rel' => $rel, 'sizes' => $sizes, 'href' => drupal_strip_dangerous_protocols($precomposed)));

  /*
   * <!-- For third-generation iPad with high-resolution Retina display: -->
   */
  $precomposed = file_create_url(drupal_get_path('theme', 'tietocom') . '/apple-touch-icon-144x144-precomposed.png');
  $rel = 'apple-touch-icon-precomposed';
  $sizes = '144x144';
  drupal_add_html_head_link(array('rel' => $rel, 'sizes' => $sizes, 'href' => drupal_strip_dangerous_protocols($precomposed)));

  /*
  * Set Drupal default favicon as type of image/x-icon
  */
  $favicon = theme_get_setting('favicon');
  $type = 'image/x-icon'; //@TODO check if this really work in all browsers
  drupal_add_html_head_link(array('rel' => 'shortcut icon', 'href' => drupal_strip_dangerous_protocols($favicon), 'type' => $type));

  /*
   * This class will be replace with 'js' using javascript - do not use no-js, this conflicts with flexslider
   */
  //$variables['html_attributes_array']['class'] = 'non-js';
  $variables['classes_array'][] = 'non-js';
  
  /* Jira id - TIET-1375	
   * Code to set title of the page careers/all-open-jobs?job=* to job title
   *  variable 'view_open_job_title' is being set in views_pre_render hook of tieto jobs module
   */
  $subject = request_uri();
  $pattern = '/.+\?job=\d+/';
  $urlMatched = preg_match($pattern, $subject);
  if($urlMatched){
    $variables['head_title'] = variable_get('view_open_job_title');
  }

  if (isset($_GET['viewmode'])) {
    $variables['theme_hook_suggestions'][] = 'html__node__' . $_GET['viewmode'];
    $variables['classes_array'][] = drupal_html_class('viewmode-' . $_GET['viewmode']);
  }
	
	/* Adding CSS for IE
   * */
  drupal_add_css(
		path_to_theme() . '/css/ie.css',
		array(
			'group' => CSS_THEME,
			'weight' => 115,
			'browsers' => array(
				'IE' => 'IE',
				'!IE' => FALSE),
			'preprocess' => FALSE
		)
	);
	
}


/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function tietocom_preprocess_page(&$variables, $hook) {
  global $language;
  $variables['title_hidden'] = theme_get_setting('tietocom_hide_title');

  if (isset($_GET['viewmode'])) {
    $variables['theme_hook_suggestions'][] = 'page__node__' . $_GET['viewmode'];
  }

  if (isset($variables['node']) && $variables['node']->type == 'tieto_news_article') {
    tietocom_hide_page_title(TRUE);
  }
  if (drupal_is_front_page()) {
    $variables['title_hidden'] = TRUE;
  }
  if (tietocom_hide_page_title()) {
    $variables['title'] = FALSE;
  }
  $variables['classes_array'][] = isset($variables['node']->panelizer) ? 'panelized' : 'not-panelized';

  //provide key topic pages sub-title to page.tpl
  if (isset($variables['node']) && $variables['node']->type == 'key_topics') {
    $nid = arg(1);
    $variables['node_type'] = 'key_topics';
    if (arg(0) == 'node' && is_numeric($nid)) {
      $node = node_load($nid);
      $variables['sub_title'] = $node->field_sub_title[$language->language][0]['value'];
    }
  }

//  drupal_add_js(drupal_get_path('theme', 'tietocom') . '/js/megamenu.js', array('scope' => 'footer'));
  drupal_add_js(drupal_get_path('theme', 'tietocom') . '/js/footer-script.js', array('scope' => 'footer'));


}

/**
 * Implements hook_preprocess_panels_pane().
 *
 * @param $variables
 */
function tietocom_preprocess_panels_pane(&$variables) {

  $pane = $variables['pane'];
  $display = $variables['display'];

  $content_type = isset($display->context['panelizer']->data->type) ? $display->context['panelizer']->data->type : '' ;

  if(isset($variables['content']['#field_type'])) {
    switch ($variables['content']['#field_type']) {
      case 'taxonomy_term_reference' :

        // TODO: replace below code with something more flexible, testing perhaps the positioning of terms to apply
        // commas in other places than news article

        $has_industry = count($variables['content']['#object']->field_industry);

        if ($content_type == 'tieto_news_article' && $has_industry /* && $variables['content']['#field_name'] == 'field_industry'*/) {
          foreach (element_children($variables['content']) as $key => $element) {
            $variables['content'][$key]['#suffix'] = ', ';
          }
          if ($variables['content']['#field_name'] == 'field_industry') {
            unset($variables['content'][count(element_children($variables['content'])) - 1]['#suffix']);
          }
        }
        break;
    };
  }

  // Hide default page title when page title is printed with panels.
  if ($pane->subtype == 'page_title') {
    tietocom_hide_page_title(TRUE);
  }
  // Add collapsible css class to every facetapi block.
  elseif (strpos($pane->subtype, 'facetapi-') === 0) {
    $variables['classes_array'][] = 'tieto-collapsible-filter';
  }

  // Filter list html customization
  elseif (strpos($pane->subtype,'current_search-') === 0) {

    if(is_array($variables['content']) && isset($variables['content']['active_items'])) {

      // modify render array, add title as label
      // This causes array to string conversion error somewhere
      $variables['content']['active_items'] = array(
        'label' => array(
          '#type' => 'html_tag',
          '#tag' => 'span',
          '#attributes' => array(
              'class' => array(
                  'filters-label'
                )
            ),
          '#value' => $variables['title'],
          ),
        'filters' => $variables['content']['active_items'],
      );
    }

    $variables['title_attributes_array']['class'][] = 'element-hidden';
  }

}

/**
 * Tell Tietocom that page title should not be rendered.
 *
 * When using page_title panels pane, we want to hide default title
 * which is normally displayed in page.tpl.php.
 *
 * @see tietocom_preprocess_page().
 * @see tietocom_preprocess_panels_pane().
 */
function tietocom_hide_page_title($hide = NULL) {
  $status = &drupal_static(__FUNCTION__, FALSE);
  if (isset($hide)) {
    $status = $hide;
  }
  return $status;
}

// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 *
 * NOTE: This function will never be executed for a panelized node!!
 */
/* -- Delete this line if you want to use this function*/
function tietocom_preprocess_node(&$vars, $hook) {
  // Optionally, run node-type-specific preprocess functions, like
  // tietocom_preprocess_node_page() or tietocom_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $vars['node']->type;
  if (function_exists($function)) {
    $function($vars, $hook);
  }
}

function tietocom_preprocess_node_contact(&$vars) {
  // In order to make sure the title doesn't display as a link in teaser views
  $vars['content'] = array(
    'contact_title' => array('#markup' => '<div class="contact-title">' . $vars['title'] . '</div>')
  ) + $vars['content'];
  unset($vars['title']);
}

function tietocom_preprocess_node_tieto_carousel_content(&$variables, $hook) {
  if (!empty($variables['field_destination_link']['und'][0]['value'])) {
    $variables['node_url'] = url($variables['field_destination_link']['und'][0]['value']);
  }
  else {
    $variables['node_url'] = NULL;
  }
}

/*
 * Implementation of hook_field_attach_view_alter()
 * This really needs a better way to work. Either context or a new field formatter in UI would be good.
 */
function tietocom_field_attach_view_alter(&$output, $context) {
  // Ensure that if there is no meta description on a node in search results, at least SOMETHING is displayed
  if ($context['display'] == 'search_result') {
//    if ($context['view_mode'] == 'search_result') {
    if (!isset($output['field_meta_description'])) {
      $entity = $context['entity'];

      if ($entity->field_ingress && element_children($entity->field_ingress)) {
        $replacement_field = 'field_ingress';
      } elseif ($entity->body && element_children($entity->body)) {
        $replacement_field = 'body';
      }

      if ($replacement_field && !isset($output[$replacement_field])) {
        $replacement = field_view_field('node', $entity, $replacement_field, array(
          'label' => 'hidden',
          'type' => 'text_summary_or_trimmed',
        ));

        $replacement['#weight'] = 1;
        $replacement = array(
          'field_meta_description_substitution' => $replacement,
        );
        $output = array_merge($replacement, $output);
      }
    }
    foreach (element_children($output) as $element) {
      // Just double-check and make sure there's no markup in any field visible.
      $output[$element][0]['#markup'] = strip_tags($output[$element][0]['#markup']);
    }
  }
}


// following has been done in the wee hours of the morning with a tight
//deadline, should be reviewed if there's time. At least needs documenting.

function tietocom_preprocess_date_display_single(&$vars) {
  $date = wrap_dm_date($vars['date'], $vars['dates']['format']);
  $vars['date'] = implode(' ', $date);
}

function tietocom_preprocess_date_display_range(&$vars) {
  if ($vars['date1'] == $vars['dates']['value']['formatted']) {
    // This is a range over dates

    $date1 = wrap_dm_date($vars['date1'], $vars['dates']['format'], 'date1');
    $date2 = wrap_dm_date($vars['date2'], $vars['dates']['format'], 'date2');

    if ($vars['dates']['format'] == 'd M' && $date1[1] == $date2[1]) {
      unset($date1[1]);
    }

    $vars['date1'] = implode(' ', $date1);
    $vars['date2'] = implode(' ', $date2);
  }
}

/**
 * Date part prefixes
 */
function tietocom_date_time_prefixes($format) {

  $r = &drupal_static(__FUNCTION__);

  if (!isset($r)) {
    $r = array(
      'd M H:i' => array(
        'date1' => '<span class="label">' . t('Start') . ' </span>',
        'date2' => '<span class="label">' . t('End') . ' </span>',
      ),
      'H:i' => array(
        'date1' => '<span class="label">' . t('Start') . ' </span>',
        'date2' => '<span class="label">' . t('End') . ' </span>',
      ),
    );
  }

  //return $r[$format];
  $return = isset($r[$format]) ? $r[$format] : array();
  return $return;
}

function tietocom_date_display_range($vars) {
  $date1 = $vars['date1'];
  $date2 = $vars['date2'];
  $timezone = $vars['timezone'];
  $attributes_start = $vars['attributes_start'];
  $attributes_end = $vars['attributes_end'];

  if ($vars['date1'] == $vars['dates']['value']['formatted_time']) {
    $prefixes = tietocom_date_time_prefixes($vars['dates']['format']);
    $date1 = $prefixes['date1'] . $date1;
    $date2 = $prefixes['date2'] . $date2;
  }

  // Wrap the result with the attributes.
  return t('!start-date !separator !end-date', array(
    '!start-date' => '<span class="date-display-range"><span class="date-display-start"' . drupal_attributes($attributes_start) . '>' . $date1 . '</span>',
    '!separator' => '<div class="date-display-seperator">-</div>',
    '!end-date' => '<span class="date-display-end"' . drupal_attributes($attributes_end) . '>' . $date2 . $timezone . '</span></span>',
  ));
}

/**
 * Wrap date parts
 *
 * @param $date String - date parts
 * @param $format String - how to format date parts
 * @param $timemode String - date type, date1 or date2 (start / end)
 *
 * @return formatted date string
 */
function wrap_dm_date($date, $format, $datemode = NULL) {

  // How NOT to parse HTML. Should find a better way to do this.
  if (strpos($date, 'span')) {
    $placeholder = strstr($date, '<span');
    $placeholder = substr($placeholder, 0, strrpos($placeholder, '>') + 1);
    $date = str_replace($placeholder, 'placeholder', $date);
  }

  $date = explode(' ', $date);
  if (isset($placeholder)) {
    $date[array_search('placeholder', $date)] = $placeholder;
  }

  $format = explode(' ', $format);

  foreach($date as $key => $value) {
    $prefixes = tietocom_date_time_prefixes($format[$key]);
    $prefix = ($datemode && $prefixes) ? $prefixes[$datemode] : '';

    // TODO: test if drupal_html_class($format[$key]) would work instead of preg_replace
    $date[$key] = '<span class="date-formatter-'. preg_replace("/[^a-zA-Z 0-9]+/", "", $format[$key]) .'">' . $prefix . $date[$key] . '</span>';
  }
  return $date;
} // end late-night deadline code


/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function tietocom_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function*/
function tietocom_preprocess_region(&$vars, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
  $vars['front_page'] = variable_get('site_frontpage', 'node');

  switch ($vars['region']) {
    case 'header':
      $vars['classes_array'][] = 'clearfix';
      break;

    case 'footer':
      if (theme_get_setting('footer_logo')) {
        if (file_exists($footer_logo = drupal_get_path('theme', 'tietocom') . '/footer-logo.png')) {
          $vars['footer_logo'] = file_create_url($footer_logo);
        } else {
          $vars['footer_logo'] = file_create_url(drupal_get_path('theme', 'tietocom') . '/logo-light-blue.png');
        }
      }
      break;
  }
}


// */


/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function*/
function tietocom_preprocess_block(&$vars, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}

  $block = $vars['block'];

  if ($block->region == 'header') {
    $vars['title_prefix'] = '<div class="block-title-wrapper">';
    $vars['title_suffix'] = '</div>';

    $vars['nav_breadcrumb'] = theme('breadcrumb', array('breadcrumb' => drupal_get_breadcrumb()));

    $domains = tieto_worldwide_get_languages();
    global $language;

    $vars['home_link'] = $domains && isset($domains[$language->language]) ? $domains[$language->language][0] : 'tieto.com';
    $vars['home_link'] = l(t($vars['home_link']), '', array('attributes' => array('class' => 'home-link')));
  }


  switch ($vars['block_html_id']) {
    case 'block-menu-menu-tieto-worldwide':
      $domains = tieto_worldwide_get_languages();
      global $language;
      $vars['elements']['#block']->subject = $domains && isset($domains[$language->language]) ? $domains[$language->language][0] : 'tieto.com';
      break;
    case 'block-search-form':
      $vars['content'] = '<div class="search-block-link">' . l(t('Search'), 'search') . '</div>' . $vars['content'];
      break;
  }

  $vars['content'] = '<div class="' . $block->region . '-block-inner">' . $vars['content'] . '</div>';

}
// */

/**
 * Modify the breadcrumb
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 */
function tietocom_preprocess_breadcrumb(&$variables) {
  if (isset($variables['breadcrumb'][0])) {
    //@TODO complete hack, but atleast it does not diplay just "Taxonomy term"
    if($variables['breadcrumb'][1]=="Taxonomy term") {
      $variables['breadcrumb'][1] = t('Magazines');
    }
    $variables['breadcrumb'][0] = l('', NULL, array ('attributes' => array('class' => 'home')));
  }
}


/**
 * Returns HTML for an atom rendered in the "Editor Representation" context.
 */
function tietocom_sdl_editor_item($variables) {
  $data = !empty($variables['informations']->player) ? $variables['informations']->player : $variables['image'];
  return "{$data}";
}

/**
 * Returns HTML for the legend of an atom.
 */
function tietocom_sdl_editor_legend($variables) {
  $atom = $variables['atom'];
  $caption = $atom->field_image_caption['und'][0]['safe_value'];
  //dsm($caption);
  if (!empty($caption)) {
    return "<div class='caption'><!--copyright={$atom->sid}-->{$caption}<!--END copyright={$atom->sid}--></div>";
  }
  else {
    return "<!--copyright={$atom->sid}--><!--END copyright={$atom->sid}-->";
  }
}

/*
 * Override or insert variables into the views-view template
 */
function tietocom_preprocess_views_view(&$vars) {
  $view = $vars['view'];
  if ($view->name == 'tieto_jobs' && $view->current_display == 'panel_pane_1') {
    unset($vars['pager']);
  }
  /* This replaces the more link "news" with the country specific version. We get the first item
   * from the view and use its url alias to replace the "news" this is for press page view only.
   */
  if ($view->name == 'news_category_news' && $view->current_display == 'pane_press_releases' or 'pane_se_releases') {
    if(isset($vars['view']->result[0]->nid)){
      $nid = $vars['view']->result[0]->nid;
      $path = dirname(url('node/'. $nid));
      $more_link = $vars['more'];
      $short = parse_url($path, PHP_URL_PATH);
      $vars['more'] = str_replace("/news", $short, $more_link);
    }
  }
}

/*
 * Override or insert variables into the views-view-list template
 */
function tietocom_preprocess_views_view_list(&$vars) {
  $view = $vars['view'];

  switch ($view->name) {
    case 'tieto_highlights':
      $link_displays = array('panel_pane_1', 'panel_pane_2', 'events');
      if (in_array($view->current_display, $link_displays)) {
        foreach ($view->result as $id => $result) {
          if (isset($result->field_field_destination_link) && $result->field_field_destination_link) {
            $link = $result->field_field_destination_link[0]['raw']['value'];
          } else {
            $link = 'node/' . $result->nid;
          }
          $text = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $vars['rows'][$id]);
          $vars['rows'][$id] = l($text, $link, array('html' => TRUE));
        }
      }
      break;
  }
}

/*
 * Override or insert variables into the views-view-fields template
 */

function tietocom_preprocess_views_view_fields(&$vars) {
  $view = $vars['view'];
  $fields = $vars['fields'];

  if ($view->name == 'tieto_events_solr_search') {
    foreach($fields as $id => $field) {
      // If there is no ingress on the event, replace it with meta description
        if(strstr($field->content, 'replacement')) {
          $replace = explode("replacement", preg_replace("/[^ \w]+/", " ", $field->content));
          $replace = substr(trim($replace[1]), 0, strpos(trim($replace[1]), ' '));
          if(strlen(trim(strip_tags($fields[$replace]->content))) == 0) {
            $vars['fields'][$replace]->content = $field->wrapper_prefix . $field->content . $field->wrapper_suffix;
          }
          unset($vars['fields'][$id]);
        }
    }
  }
}

/*
 * Corrects some missing functionality in Flexslider Views Slideshow plugin
 */
function tietocom_preprocess_flexslider_views_slideshow_main_frame(&$vars) {

  /* Congratulations, you have stumbled upon the World's Worst Hack, you are now
  morally bound and obligated to do something about it. From this point
  forwards, for every hour that you do not devote to trying to correct this
  situation, two hours will be deducted from the end of your life.

  For moral support, see flexslider_views_slideshow.theme.inc to observe the
  original author's own difficulties.*/

  /* EDIT: Nevermind. Don't touch it. Ever. */

  $settings = $vars['settings'];

  $view = $vars['view'];
  $vss_id = $vars['vss_id'];
  $rows = $vars['rows'];

  $settings = flexslider_optionset_load($settings['optionset']);
  $settings = $settings->options;

  $max = 0;
  $min = 0;

  if (isset($settings['minItems'])) {
    $min = ($settings['minItems'] && $settings['minItems'] > 1) ? $settings['minItems'] : 0;
  }
  if (isset($settings['maxItems'])) {
    $max = ($settings['maxItems'] && $settings['maxItems'] > 1) ? $settings['maxItems'] : 0;
  }

  if (!$min && !$max) {
    // Don't mess with it if neither of these settings is set, anyway
    return;
  }

  // Render the rows
  $rendered_rows = '';
  $slide = '';
  $itemCount = 0;

  foreach ($rows as $count => $row) {

    $itemCount++;

    $slide .= '<div class="slide-item slide-item-' . $itemCount . '">' . $row . '</div>';

    if (($count+1 == count($rows) && $itemCount >= $min) || ($max && $itemCount >= $max)) {
      $rendered_rows .= theme('flexslider_views_slideshow_main_frame_row', array('vss_id' => $vss_id, 'items' => array($slide), 'count' => $count, 'view' => $view));
      $slide = '';
      $itemCount = 0;
    }

    // Save the rendered rows
    $vars['rendered_rows'] = $rendered_rows;
  }
}

/**
 * Field preprocessing
 */
function tietocom_preprocess_field(&$variables) {
  // News article
  if($variables['element']['#bundle'] == 'tieto_news_article') {
    switch($variables['element']['#field_name']) {
      case 'field_release_date':
        $variables['label'] = t("Published on");
      break;

      case 'field_news_type':
        $variables['label'] = t("This article is about");
      break;
    }
  }
}

/**
 * Facet theme prepocessing
 */

/**
 * Returns HTML for the facet title, usually the title of the block.
 *
 * @param $variables
 *   An associative array containing:
 *   - title: The title of the facet.
 *   - facet: The facet definition as returned by facetapi_facet_load().
 *
 * @ingroup themeable
 */
function tietocom_facetapi_title($variables) {
  return t($variables['title']);
}

/**
 * Returns HTML for an active facet item.
 *
 * @param $variables
 *   An associative array containing the keys 'text', 'path', 'options', and
 *   'count'. See the l() and theme_facetapi_count() functions for information
 *   about these variables.
 *
 * @ingroup themeable
 */
function tietocom_facetapi_link_inactive($variables) {
  // Builds accessible markup.
  // @see http://drupal.org/node/1316580
  $accessible_vars = array(
    'text' => $variables['text'],
    'active' => FALSE,
  );
  $accessible_markup = theme('facetapi_accessible_markup', $accessible_vars);

  // Sanitizes the link text if necessary.
  $sanitize = empty($variables['options']['html']);
  $variables['text'] = ($sanitize) ? check_plain($variables['text']) : $variables['text'];

  // Adds count to link if one was passed.
  if (isset($variables['count'])) {
    $variables['text'] .= ' ' . theme('facetapi_count', $variables);
  }

  // Resets link text, sets to options to HTML since we already sanitized the
  // link text and are providing additional markup for accessibility.

  $activate_widget =  theme('html_tag', array(
    'element' => array(
      '#tag' => 'span',
      '#attributes' => array(
        'class' => 'filter-icon icons-filter-blue-inactive',
      ),
      '#value' => 'Activate facet',
    ),
  ));

  $variables['text'] = $activate_widget . $variables['text'];
  $variables['text'] .= $accessible_markup;
  $variables['options']['html'] = TRUE;
  return theme_link($variables);
}

/**
 * Returns HTML for an inactive facet item.
 *
 * @param $variables
 *   An associative array containing the keys 'text', 'path', and 'options'. See
 *   the l() function for information about these variables.
 *
 * @see l()
 *
 * @ingroup themeable
 */
function tietocom_facetapi_link_active($variables) {

  // Sanitizes the link text if necessary.
  $sanitize = empty($variables['options']['html']);
  $link_text = ($sanitize) ? check_plain($variables['text']) : $variables['text'];

  // Theme function variables fro accessible markup.
  // @see http://drupal.org/node/1316580
  $accessible_vars = array(
    'text' => $variables['text'],
    'active' => TRUE,
  );

  // Builds link, passes through t() which gives us the ability to change the
  // position of the widget on a per-language basis.
  $deactivate_widget =  theme('html_tag', array(
    'element' => array(
      '#tag' => 'span',
      '#attributes' => array(
        'class' => 'filter-icon icons-filter-blue-active',
      ),
      '#value' => 'Deactivate facet',
    ),
  ));
  $replacements = array(
    '!facetapi_deactivate_widget' => $deactivate_widget,
    '!facetapi_accessible_markup' => theme('facetapi_accessible_markup', $accessible_vars),
  );
  $variables['text'] = t('!facetapi_deactivate_widget !facetapi_accessible_markup', $replacements) . $link_text;

  // Adds count to link if one was passed.
  if (isset($variables['count'])) {
    $variables['text'] .= ' ' . theme('facetapi_count', $variables);
  }

  $variables['options']['html'] = TRUE;
  return theme_link($variables);
}

/*
 * Implements hook_css_alter()
 */
function tietocom_css_alter(&$css) {
  // Panopoly CSS isn't terribly useful
  unset($css[drupal_get_path('module', 'panopoly_theme') . '/css/panopoly-accordian.css']);
  //unset($css[drupal_get_path('module', 'panopoly_core') . '/css/panopoly-jquery-ui-theme.css']);
}

/*
 * Implements hook_form_alter()
 * TODO: Move to tieto_global_search
 */
function tietocom_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['#submit'][] = 'tieto_common_search_box_form_submit';
  }
}
