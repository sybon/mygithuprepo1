
<?php
// Report all errors
//error_reporting(E_ALL);
date_default_timezone_set('Europe/Paris');
$datetimezone = new DateTimeZone('Europe/Paris');

$srvroot = '/kunden/homepages/23/d214254552/htdocs/www.lus-new';

$filepath =$srvroot.'/courses/course_list.xml';

$ar_removed_course = array();

$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->formatOutput = false;
$dom->load($filepath);

//#######  BACKUP before removing the courses that have already happened !    ######
$dom->save($srvroot.'/courses/backups/course_list_'.date("Y-m-d H:i").'_beforeclean.xml');


$course_list = $dom->documentElement;

//echo file_get_contents('../b/courses/course_list_test_edit.xml');
//$courseslist=$dom->documentElement;
/*
$xpath = new DOMXPath($dom);
$query='//course';
$coursenodes = $xpath->query($query); //OK2
*/
$root = $dom->documentElement;

$coursenodes = $root->getElementsByTagName("course");
$length = $coursenodes->length;
//echo $length;


// Iterate backwards by decrementing the loop counter 

//var_dump($coursenodes);

$i=0;

$nb_del_pastcourse=0;

for ($i=$length-1;$i>=0;$i--)
{
$resnode_course=$coursenodes->item($i);
//var_dump($resnode_course);

$del_this_pastcourse = FALSE;
//$qry_parent="ancestor::course";
//$course_id = $xpath->query($qry_parent,$resnode)->item(0)->getAttribute("id");
//echo "cid:".$course_id;
$resnode = $resnode_course->getElementsByTagName('info')->item(0);

$course_start_date = $resnode->getElementsByTagName('start_date')->item(0)->nodeValue;
$course_end_date = $resnode->getElementsByTagName('end_date')->item(0)->nodeValue;

//echo $course_start_date;
$course_start_date_dt= new DateTime((string)$course_start_date, $datetimezone);
$course_end_date_dt= new DateTime((string)$course_end_date, $datetimezone);
$date_current = new DateTime('now',$datetimezone);
$interval = $date_current->diff($course_start_date_dt);
$interval_int = (int)$interval->format('%R%a');
if($interval_int<0) $del_this_pastcourse = TRUE;


if($del_this_pastcourse==TRUE)
  {
  $ar_removed_course[]= (string) $resnode_course->getAttribute("id");
  $parent_node = $resnode_course->parentNode;
    $parent_node->removeChild($resnode_course);
    $nb_del_pastcourse++;
  //$ar_courseToRemove[] = $resnode_course;
  }

} //END foreach

$dom->save($filepath);

echo "Nombre de stages passes de date supprimes : ".count($ar_removed_course);
echo "   ###   id des stages supprimes : ".implode(",",$ar_removed_course);

?>
