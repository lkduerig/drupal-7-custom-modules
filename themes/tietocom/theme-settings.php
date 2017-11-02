<?php
/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function tietocom_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  // Create the form using Forms API: http://api.drupal.org/api/7
  $form['logo']['footer_logo'] = array(
    '#type' => 'checkbox',
    '#title' => 'Also display logo in footer',
    '#default_value' => theme_get_setting('footer_logo'),
    '#description' => 'Specify a different image in theme directory as footer-logo.png. Otherwise default theme logo will be used.',
  );

  $form['custom'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom settings'),
  );
  $form['custom']['tietocom_hide_title'] = array(
    '#type' => 'checkbox',
    '#title' => t('Hide title'),
    '#default_value' => theme_get_setting('tietocom_hide_title'),
    '#description' => t("Hide page title via CSS"),
  );
  // */

  // Remove some of the base theme's settings.
  /* -- Delete this line if you want to turn off this setting.
 unset($form['themedev']['zen_wireframes']); // We don't need to toggle wireframes on this site.
 // */

  // We are editing the $form in place, so we don't need to return anything.
}
