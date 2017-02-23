<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/header_admin.php' ?>

<select id="bupfiles" name="bupfiles" onchange="if(this.selectedIndex) ajax_restorebup(this);"><option selected value='-1'>choisir le fichier xml des stages à restaurer</option>
<?php
    $dirname = $_SERVER['DOCUMENT_ROOT']."/courses/backups/";
    //$dirhandle = opendir($dirname);
    //while($file = readdir($dirhandle))
    $files = scandir($dirname);
    rsort($files);
    foreach ($files as $file)
    {
    if ((preg_match("/course_list/i",$file)) && ($file != ".") && ($file != ".."))
    {
      if (is_file($dirname.$file))
        {
        echo "<option value='" . $file ."'>" . $file . "</option>"; 
        }
      else
        {
        echo "mappe : " . $file . "<br>";
        }
    }
    }
     ?> 
</select>
<script>
document.getElementById('bupfiles').value="-1";

function ajax_restorebup()
{
//var selboxval = document.getElementById('bupfiles').value;
//alert(selboxval);
var xmlhttp;
//if (param.length==0){document.getElementById("txtHint").innerHTML="";return;}
if(window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("ajaxresponse").innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("POST","/admin/restore_stages_xml_ajax.php",true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//var formData = new FormData(document.getElementById("formdata"));
// ou var data = new FormData();
//data.append('user', 'person');
//data.append('organization', 'place');

var selboxval = document.getElementById('bupfiles').value;
//alert(selboxval);
var u_confirm=confirm("Sûr de vouloir revenir à la version antérieure de la liste des stages : "+selboxval+" ? ");
    if(u_confirm){
        xmlhttp.send("bupfiles="+selboxval);
        //xmlhttp.send("bupfiles="+selboxval+"&inputfield2="+inputfieldval2);
    }
}

</script>
<br/><br/><span style="color:red;" id="ajaxresponse"></span><br/><br/>

<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/footer_admin.php' ?>

