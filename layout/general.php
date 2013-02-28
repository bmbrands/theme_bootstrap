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
    if (!right_to_left()) {
        $bodyclasses[] = 'side-pre-only';
    }else{
        $bodyclasses[] = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-post-only';
    }else{
        $bodyclasses[] = 'side-pre-only';
    }
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
    }?>
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<?php if ($hascustommenu) { ?>
    <div id="custommenuwrap"><div id="custommenu"><?php echo $custommenu; ?></div></div>
<?php } ?>

<div id=page class=container-fluid>

<?php if ($hasheader) { ?>
    <header id=page-header class=clearfix>
            <?php if (empty($PAGE->theme->settings->logo_url)) { ?>
                <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
            <?php } else { ?>
                <img src="<?php echo $PAGE->theme->settings->logo_url; ?>">
            <?php } ?>

            <?php echo $OUTPUT->login_info(); ?>

            <div class="headermenu"><?php echo $PAGE->headingmenu; ?></div>
            <?php if ($hasnavbar) { ?>
            <div class="navbar clearfix">
                <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
                <div class="navbutton"> <?php echo $PAGE->button; ?></div>
            </div>
            <?php } ?>
            <?php if (!empty($courseheader)) { ?>
                <div id="course-header"><?php echo $courseheader; ?></div>
            <?php } ?>
    </header>
<?php } ?>

<div id="page-content" class="row-fluid">

<?php if ($hassidepre && $hassidepost) { ?>
    <div class=span9>
        <div class=row-fluid>
            <section class=span8>
<?php } elseif ($hassidepre || $hassidepost) { ?>
    <section class="span9">
<?php } else { ?>
    <section class="span12">
<?php }?>
    <?php echo $coursecontentheader; ?>
    <?php echo $OUTPUT->main_content() ?>
    <?php echo $coursecontentfooter; ?>
    </section>
<?php if ($hassidepre OR (right_to_left() AND $hassidepost)) {
          if ($hassidepost OR (right_to_left() AND $hassidepre)) { ?>
            <aside id=region-pre class="span4 block-region">
    <?php } else { ?>
            <aside id=region-pre class="span3 block-region">
          <?php } ?>
            <div class=region-content>
                <?php
                    if (!right_to_left()) {
                        echo $OUTPUT->blocks_for_region('side-pre');
                    } elseif ($hassidepost) {
                        echo $OUTPUT->blocks_for_region('side-post');
                    }
                ?>
            </div>
            </aside>
      <?php if ($hassidepost OR (right_to_left() AND $hassidepre)) {
             echo "</div></div>"; // close row-fluid & span9
        }
    }

    if ($hassidepost OR (right_to_left() AND $hassidepre)) { ?>
        <aside id=region-post class="span3 block-region">
        <div class=region-content>
        <?php if (!right_to_left()) {
                echo $OUTPUT->blocks_for_region('side-post');
              } elseif ($hassidepre) {
                echo $OUTPUT->blocks_for_region('side-pre');
              } ?>
        </div>
        </aside>
<?php } ?>
</div>

<footer id="page-footer">
    <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
    <?php echo $OUTPUT->standard_footer_html(); ?>
</footer>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</div>

<?php if (!empty($PAGE->theme->settings->enablejquery)) {?>

<script src="<?php echo $CFG->wwwroot;?>/theme/bootstrap/js/jquery.js"></script>
<script src="<?php echo $CFG->wwwroot;?>/theme/bootstrap/js/bootstrap.min.js"></script>

<?php }?>

</body>
</html>
