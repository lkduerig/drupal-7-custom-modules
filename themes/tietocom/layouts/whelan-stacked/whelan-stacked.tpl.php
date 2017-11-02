<?php
/**
 * @file
 * Template for Tieto's modified Whelan (Stacked).
 *
 * Variables:
 * - $css_id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 * panel of the layout. This layout supports the following sections:
 */
?>

<div class="panel-display whelan-stacked clearfix <?php if (!empty($class)) { print $class; } ?>" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>

  <div class="whelan-stacked-container whelan-stacked-column-content clearfix">
    <div class="whelan-stacked-column-content-region whelan-stacked-column1 panel-panel">
      <div class="whelan-stacked-column-content-region-inner whelan-stacked-column1-inner panel-panel-inner">
        <?php print $content['column1']; ?>
      </div>
    </div>
    <div class="whelan-stacked-column-content-region whelan-stacked-content panel-panel">
      <div class="whelan-stacked-column-content-region-inner whelan-stacked-content-inner panel-panel-inner">
        <?php print $content['contentmain']; ?>
      </div>
      <div class="whelan-stacked-column-content-bottom-region-inner whelan-stacked-content-bottom-inner panel-panel-inner">
        <?php print $content['contentbottom']; ?>
      </div>
    </div>
    <div class="whelan-stacked-column-content-region whelan-stacked-column2 panel-panel">
      <div class="whelan-stacked-column-content-region-inner whelan-stacked-column2-inner panel-panel-inner">
        <?php print $content['column2']; ?>
      </div>
    </div>
  </div>

</div>
