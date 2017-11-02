<?php
// Plugin definition
$plugin = array(
  'title' => t('Frontpage'),
  'icon' => 'frontpage.png',
  'category' => t('Tieto'),
  'theme' => 'frontpage',
  'css' => 'frontpage.css',
  'regions' => array(
    'row1-sidebar' => t('Row 1 Sidebar'),
    'row1-content' => t('Row 1 Content'),
    'row2-sidebar' => t('Row 2 Sidebar'),
    'row2-content' => t('Row 2 Content'),
    'row3-sidebar' => t('Row 3 Sidebar'),
    'row3-content' => t('Row 3 Content'),
  ),
);
