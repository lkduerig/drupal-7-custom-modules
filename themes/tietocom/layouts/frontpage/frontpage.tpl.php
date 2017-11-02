<?php
/**
 * @file
 * Template for Tieto Frontpage.
 *
 * Variables:
 * - $css_id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 * panel of the layout. This layout supports the following sections:
 */
?>

<div class="panel-display frontpage clearfix <?php if (!empty($class)) { print $class; } ?>" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>

    <div class="frontpage-container frontpage-row-1 clearfix panel-panel">
        <div class="frontpage-container-inner frontpage-sidebar panel-panel-inner">
            <div class="frontpage-sidebar-inner">
              <?php print $content['row1-sidebar']; ?>
            </div>
        </div>

        <div class="frontpage-container-inner frontpage-content panel-panel-inner">
            <div class="frontpage-content-inner">
              <?php print $content['row1-content']; ?>
            </div>
        </div>
    </div>

    <div class="frontpage-container frontpage-row-2 clearfix panel-panel">
        <div class="frontpage-container-inner frontpage-sidebar panel-panel-inner">
            <div class="frontpage-sidebar-inner">
              <?php print $content['row2-sidebar']; ?>
            </div>
        </div>

        <div class="frontpage-container-inner frontpage-content panel-panel-inner">
            <div class="frontpage-content-inner">
              <?php print $content['row2-content']; ?>
            </div>
        </div>
    </div>

    <div class="frontpage-container frontpage-row-3 clearfix panel-panel">
        <div class="frontpage-container-inner frontpage-sidebar panel-panel-inner">
            <div class="frontpage-sidebar-inner">
              <?php print $content['row3-sidebar']; ?>
            </div>
        </div>

        <div class="frontpage-container-inner frontpage-content panel-panel-inner">
            <div class="frontpage-content-inner">
              <?php print $content['row3-content']; ?>
            </div>
        </div>
    </div>

</div><!-- /.frontpage -->
