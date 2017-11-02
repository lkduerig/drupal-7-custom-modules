<?php
/**
 * @file
 * Template for Panopoly Sutro Double.
 *
 * Variables:
 * - $css_id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 * panel of the layout. This layout supports the following sections:
 */
?>

<div class="panel-display conceptpage clearfix <?php if (!empty($class)) { print $class; } ?>" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>

  <div class="conceptpage-container conceptpage-header clearfix panel-panel">
    <div class="conceptpage-container-inner conceptpage-header-inner panel-panel-inner">
      <?php print $content['row1']; ?>
    </div>
  </div>

   <div class="conceptpage-container conceptpage-header clearfix panel-panel">
    <div class="conceptpage-container-inner conceptpage-header-inner panel-panel-inner">
      <?php print $content['row2']; ?>
    </div>
  </div>

   <div class="conceptpage-container conceptpage-header clearfix panel-panel">
    <div class="conceptpage-container-inner conceptpage-header-inner panel-panel-inner">
      <?php print $content['row3']; ?>
    </div>
  </div>

   <div class="conceptpage-container conceptpage-header clearfix panel-panel">
    <div class="conceptpage-container-inner conceptpage-header-inner panel-panel-inner">
      <?php print $content['row4']; ?>
    </div>
  </div>

   <div class="conceptpage-container conceptpage-header clearfix panel-panel">
    <div class="conceptpage-container-inner conceptpage-header-inner panel-panel-inner">
      <?php print $content['row5']; ?>
    </div>
  </div>

   <div class="conceptpage-container conceptpage-header clearfix panel-panel">
    <div class="conceptpage-container-inner conceptpage-header-inner panel-panel-inner">
      <?php print $content['row6']; ?>
    </div>
  </div>

</div><!-- /.conceptpage -->
