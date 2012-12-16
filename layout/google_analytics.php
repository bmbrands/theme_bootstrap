<?php
/* This code modifies the URL's send to Google analytics
 * A standard moodle url looks like:
 * http://www.someurl.com/course/view.php?id=5
 * 
 * This code changes these URL into something like
 * http://www.someurl.com/Starters+Course
 * 
 * This makes analyzing your Google analytics stats much more fun!
 * 
 * author: Bas Brands, Sonsbeekmedia.nl bmbrands@gmail.com
 */


$trackurl = '';

global $DB;
if ($COURSE->id != 1 ){
	//Get role in course
    $userroles = get_user_roles_in_course($USER->id,$COURSE->id);
	$trackurl .= '/' . strip_tags($userroles);
	
	
	//Add course category name
	if ($category = $DB->get_record('course_categories',array('id'=>$COURSE->category))){
	    $trackurl .= '/' . urlencode($category->name);
	}
	
	//Add course name
	$trackurl .= '/' . urlencode($COURSE->shortname);
}

//Use navigation bar to get items
$navbar = $OUTPUT->page->navbar->get_items();

//remove first item (home)
$first = array_shift($navbar);

foreach ($navbar as $item) {
    //get section name
    if ($item->type == "30") {
        $trackurl .= '/' . urlencode($item->title) ;
    }
    //get activity type
    if ($item->type == "40") {
        $trackurl .= '/' . urlencode($item->text) ;
        $trackurl .= '/' . urlencode($item->title) ;
    }
    //get action type
    if ($item->type == "60") {
        $trackurl .= '/' . urlencode($item->title) ;
    }
}
//for debugging
//echo $trackurl;
?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $PAGE->theme->settings->gakey;?>']);
  _gaq.push(['_trackPageview','<?php echo $trackurl;?>']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

