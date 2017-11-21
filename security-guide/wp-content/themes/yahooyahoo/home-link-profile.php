<ul>
  <?php 

    $tag = get_term_by('name', 'ngo', 'post_tag');
    $tag_id = $tag->term_id;
    $tag_permalink = get_tag_link($tag_id);
  ?>

  <li><a href="<?php echo $tag_permalink;?>">an NGO</a></li>
  <?php 

    $tag = get_term_by('name', 'journalist', 'post_tag');
    $tag_id = $tag->term_id;
    $tag_permalink = get_tag_link($tag_id);
  ?>

  <li><a href="<?php echo $tag_permalink;?>">Journalist</a></li>
  <?php 

    $tag = get_term_by('name', 'developer', 'post_tag');
    $tag_id = $tag->term_id;
    $tag_permalink = get_tag_link($tag_id);
  ?>
  <li><a href="<?php echo $tag_permalink;?>">Developer</a></li>
  <?php 

    $tag = get_term_by('name', 'blogger', 'post_tag');
    $tag_id = $tag->term_id;
    $tag_permalink = get_tag_link($tag_id);
  ?>
  <li><a href="<?php echo $tag_permalink;?>">Blogger</a></li>
  <?php 

    $tag = get_term_by('name', 'human rights activist', 'post_tag');
    $tag_id = $tag->term_id;
    $tag_permalink = get_tag_link($tag_id);
  ?>
  <li><a href="<?php echo $tag_permalink;?>">Human Rights Activitist</a></li>
</ul>