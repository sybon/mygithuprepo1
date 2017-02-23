<?php

$xmlbupfile_2brestored = $_POST["bupfiles"];
$xmlfile_saved_beforerestore = "course_list_".date("Y-m-d-H-i-s")."_beforerestore.xml";

echo "Ce fichier de backup a été restauré online (".$xmlbupfile_2brestored.") pour remplacer le précédent fichier course_list.xml - qui a été sauvegardé auparavant sous le nom : ".$xmlfile_saved_beforerestore."";

copy("../courses/course_list.xml","../courses/backups/".$xmlfile_saved_beforerestore);
$xmlfile_2brestored = "../courses/backups/".$xmlbupfile_2brestored;
$xmlfile_new =  "../courses/course_list.xml";
copy($xmlfile_2brestored,$xmlfile_new);

?>