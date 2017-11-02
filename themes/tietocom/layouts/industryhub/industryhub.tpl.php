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

<div class="panel-display industryhub clearfix <?php if (!empty($class)) { print $class; } ?>" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>

  <div class="industryhub-container industryhub-header clearfix panel-panel">
    <div class="industryhub-container-inner industryhub-header-inner panel-panel-inner">
      <?php print $content['header']; ?>
    </div>
  </div>

  <div class="industryhub-container industryhub-column-content industryhub-first-column-content clearfix">
    <div class="industryhub-column-content-region industryhub-column1 industryhub-column panel-panel">
      <div class="industryhub-column-content-region-inner industryhub-column1-inner industryhub-column-inner panel-panel-inner">
        <?php print $content['column1']; ?>
      </div>
    </div>
    <div class="industryhub-column-content-region industryhub-column2 industryhub-column panel-panel">
      <div class="industryhub-column-content-region-inner industryhub-column2-inner industryhub-column-inner panel-panel-inner">
        <?php print $content['column2']; ?>
      </div>
    </div>
  </div>

  <div class="industryhub-container industryhub-middle clearfix panel-panel">
    <div class="industryhub-container-inner industryhub-middle-inner panel-panel-inner">
      <?php print $content['middle']; ?>
    </div>
  </div>

  <div class="industryhub-container industryhub-column-content industryhub-second-column-content clearfix">
    <div class="industryhub-column-content-region industryhub-column1 industryhub-column panel-panel">
      <div class="industryhub-column-content-region-inner industryhub-column1-inner industryhub-column-inner panel-panel-inner">
        <?php print $content['secondcolumn1']; ?>
      </div>
    </div>
    <div class="industryhub-column-content-region industryhub-column2 industryhub-column panel-panel">
      <div class="industryhub-column-content-region-inner industryhub-column2-inner industryhub-column-inner panel-panel-inner">
        <?php print $content['secondcolumn2']; ?>
      </div>
    </div>
  </div>

  <div class="industryhub-container industryhub-footer clearfix panel-panel">
    <div class="industryhub-container-inner industryhub-footer-inner panel-panel-inner">
      <?php print $content['footer']; ?>
    </div>
  </div>

</div><!-- /.industryhub -->
