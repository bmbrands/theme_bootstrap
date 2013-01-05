<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hasheader = (empty($PAGE->layout_options['noheader']));


$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));
$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));


$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';
if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

$doctype = $OUTPUT->doctype() ?>
<!DOCTYPE html>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <?php 
    if (!empty($PAGE->theme->settings->gakey)) {
    include($CFG->dirroot . "/theme/bootstrap/layout/google_analytics.php"); 
    };?>
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>


<?php if ($hascustommenu) { ?>
<div id="custommenuwrap"><div id="custommenu"><?php echo $custommenu; ?></div></div>
<?php } ?>

<div id="page">

<?php if ($hasheader) { ?>
<!-- START OF HEADER -->
    <div id="page-header">
		<div id="page-header-wrapper" class="wrapper clearfix">
		    <?php if (empty($PAGE->theme->settings->logo_url)) {?>
	        <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
	        <?php } else { ?>
	        <img src="<?php echo $PAGE->theme->settings->logo_url; ?>">
	        <?php }?>
	        
	        <?php 
	                echo $OUTPUT->login_info();
	        ?>
    	    
    	    <div class="headermenu">
        		<?php
	        	    echo $PAGE->headingmenu;
		        ?>
	    	</div>
	    	<?php if ($hasnavbar) { ?>
            <div class="navbar clearfix">
                <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
                <div class="navbutton"> <?php echo $PAGE->button; ?></div>
            </div>
            <?php } ?>
                    <?php if (!empty($courseheader)) { ?>
            <div id="course-header"><?php echo $courseheader; ?></div>
        <?php } ?>
	    </div>
    </div>

<!-- END OF HEADER -->
<?php } ?>

<!--  BOOTSTRAP RESPONSIVE -->
<div id="page-content-wrapper" class="wrapper clearfix">
<div id="page-content" class="row-fluid">


<?php if ($hassidepre) { ?>
	<div class="span3">
	<?php echo $OUTPUT->blocks_for_region('side-pre') ?>
	</div>
<?php } ?>


<?php if ($hassidepre && $hassidepost) { ?>
	<div class="span6">
<?php } elseif ($hassidepre || $hassidepost) { ?>
	<div class="span9">
<?php } else { ?>
    <div class="span12">
<?php };?>
    <?php echo $coursecontentheader; ?>
	<?php echo $OUTPUT->main_content() ?>
	<?php echo $coursecontentfooter; ?>
	</div>
             
<?php if ($hassidepost) { ?>                
	<div class="span3">
	<?php echo $OUTPUT->blocks_for_region('side-post') ?>
    </div>
<?php }; ?>          
</div>
<!--  END BOOTSTRAP RESPONSIVE -->

<!-- START OF FOOTER -->
    <div id="page-footer" class="wrapper">
        <p class="helplink">
        <?php echo page_doc_link(get_string('moodledocslink')) ?>
        </p>

        <?php
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
<!-- END OF FOOTER -->

</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>

<?php if (!empty($PAGE->theme->settings->enablejquery)) {?>

<script src="<?php echo $CFG->wwwroot;?>/theme/bootstrap/js/jquery.js"></script>
<script src="<?php echo $CFG->wwwroot;?>/theme/bootstrap/js/bootstrap.min.js"></script>

<?php }?>

</body>
</html>