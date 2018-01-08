<?php if(get_field('videos')) {  ?>
<div class="video-reel">
  <div class="title">
    <p>Videos</p>
  </div>
  <!-- <ul>
    <li>
      <a class="video-1" href="https://www.youtube.com/watch?v=lvR3o2JINMc"><img src="img/thumb1.jpg" alt="">
        <span>How to encrypt data on your computer</span></a>
    </li>
    <li>
      <a class="video-1" href="https://www.youtube.com/watch?v=lvR3o2JINMc"><img src="img/thumb2.jpg" alt="">
        <span>Remote wiping on Android/iOS phone</span></a>
    </li>
  </ul> -->
  <?php //echo get_post_meta($post->ID, 'videos', true); ?>
  <?php 
 
$videos = the_field('videos');
if( count( $videos ) != 0 ) { ?>
<ul class="videos">
<?php foreach($videos as $video) { ?>
           <?php echo '<li>'.$video.'</li>' ;
            }
            ?>
</ul>
<?php 
} else { 
// do nothing; 
}
?>
</div>

<?php } ?>
