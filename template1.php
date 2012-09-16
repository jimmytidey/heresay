<?php

$page_title = $page_data->title;
$window_title = "$page_title - ".DEFAULT_WINDOW_TITLE;
$optional_styles = <<<CSS

CSS;

include_once('template-header.php');

?>

<div id='summary_slideshow'>
	<?php $img_dir = "images/gallery"; include('modules/rubric_gallery.php'); ?>
</div>


<div class="sixteen columns">
	<h1><?= $page_data->title ?></h1>
	<h2 class='subtitle'>Exchange Quay is a highly connected business location</h2>
	<div class='column one-third alpha'><?php echo $page_data->text01;?></div>
	<div class='column one-third'><?php echo $page_data->text02;?></div>
	<div class='column one-third omega'><?php echo $page_data->text03;?></div>

</div>
<br class='clearfix' />
<?php include_once('template-footer.php');?>
