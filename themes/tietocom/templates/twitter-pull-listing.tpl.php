<?php
/*
 * About to do some hackish stuff and add only js and css to pages we need.
 */
$path = current_path();
if (!path_is_admin($path)) {
  //drupal_add_js(drupal_get_path('module', 'scald_twitter_channel') . '/js/jquery.flexslider.js');
  drupal_add_css(drupal_get_path('module', 'scald_twitter_channel') . '/css/scald_twitter_channel.css');
  flexslider_add('twitter_carousel', 'twitter_channel');
}
/**
 * @file
 * Theme template for a list of tweets and making them carousel.
 *
 * Available variables in the theme include:
 *
 * 1) An array of $tweets, where each tweet object has:
 *   $tweet->id
 *   $tweet->username
 *   $tweet->userphoto
 *   $tweet->text
 *   $tweet->timestamp
 *   $tweet->time_ago
 *
 * 2) $twitkey string containing initial keyword.
 *
 * 3) $title
 *
 */
?>
<?php if ($lazy_load): ?>
<?php print $lazy_load; ?>
<?php else: ?>


<div id="twitter_carousel" class="tweets-pulled-carousel">
  <div class="flex-nav-container">
    <div class="flexslider">
      <?php if (!empty($title)): ?>
      <h2><?php print $title; ?></h2>
      <?php endif; ?>

      <?php if (is_array($tweets)): ?>
      <?php $tweet_count = count($tweets); ?>

      <ul class="slides tweets-pulled-listing">
        <?php foreach ($tweets as $tweet_key => $tweet): ?>
        <li>
          <!--span class=""><?php print $twitkey; ?>: </span-->
          <span class="tweet-author"><?php print l($tweet->username, 'http://twitter.com/' . $tweet->username); ?></span>
          <span class="tweet-text"><?php print twitter_pull_add_links($tweet->text); ?></span>

          <div class="tweet-time"><?php print l($tweet->time_ago, 'http://twitter.com/' . $tweet->username . '/status/' . $tweet->id);?></div>

          <?php if ($tweet_key < $tweet_count - 1): ?>
          <div class="tweet-divider"></div>
          <?php endif; ?>

        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php endif; ?>
