
<?

// Login Password to edit.

$password = 'dayz';

// Database details
$dbhost = 'localhost';
$dbname = '';
$dbuser = '';
$dbpass = '';



session_start();

// open Sql connection
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $conn);
if(isset($_POST['login'])) {
if($_POST['password'] == $password); {
         $_SESSION['is_logged_in'] = 1;
		 }
     }
// Check if we'r logged in.
if(!isset($_SESSION['is_logged_in'])) {
    echo "<form method=\"post\">Password: <input type=\"password\" name=\"password\"><br><input type=\"submit\" name=\"login\"></form>";
	die();
} else {

}
//Gets the item name from the database.
function item_name($classname) {
$q = mysql_query("Select * from items where classname = '$classname' limit 1");
$d = mysql_fetch_array($q);
if(!$d['name']) {
return false;
}
else {
return $d['name'];
}
}
//Gets the type
function get_type($classname) {
$q = mysql_query("Select * from items where classname = '$classname' limit 1");
$d = mysql_fetch_array($q);
if(!$d['slot_type']) {
return false;
}
else {
return $d['slot_type'];
}
}

//Select wich array we'r editing.
switch($_GET['type']){
case 'helicrash':
$table = "helicrash";
$title = "Heli crash sites";
	$sql = mysql_query("select * from helicrash");
	break;
case 'carepackage':
$title = "Care-packages";
	$table = "carepackage";
	break;
default:
$table = "helicrash";
$title = "Heli crash sites";
	$sql = mysql_query("select * from helicrash");
	break;
$sql = mysql_query("select * from carepackage");
}
//List all items in the dropdown menu
$sql="SELECT * FROM  `items`"; 
$result=mysql_query($sql) or die(mysql_error());

$options=""; 

while ($row=mysql_fetch_array($result)) { 

    $id=$row["classname"]; 
    $thing=$row["name"]; 
    $options.="<option value=\"$id\">".$thing."</option>\n"; 
}

//Delete item from list
if(isset($_GET['del']) && isset($_GET['type'])) {
$id = mysql_escape_string($_GET['id']);
$del = mysql_query("Delete from $table where id = $id");

}
//Update dropchance
if(isset($_POST['update']) && isset($_GET['type'])) {
$id = $_REQUEST['id='];
$chance = $_REQUEST['chance='];
print_r($_REQUEST);
$qr = "Update $table set chance = '$chance' WHERE id = '$id'";
$q = mysql_query($qr) or die(mysql_error());


}

//Insert new item.
if(isset($_POST['submit'])) {
$chance = mysql_escape_string($_POST['chance']);
$item = mysql_escape_string($_POST['item']);
$type = get_type(mysql_escape_string($_POST['item']));
$q = mysql_query("Insert into $table (type, classname, chance) VALUES ('$type','$item','$chance')") or die(mysql_error());
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type"text/css">
body{ background-color: #E0D8A6; }
</style>
</head>
<body>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>
<script>
$(document).ready(function() {
        $('#item').change(function() {
		 $('#preview').attr('src', 'items/' + $('#item :selected').val() + '.png');
            });
        });
</script>
<h1>Now editing <?=$title?></h1>
<a href="?type=carepackage">Care-packages</a><br>
<a href="?type=helicrash">Heli crash sites</a><br>
<h2>Export</h2>
<?
//Entire export to array function, its dirty but it works.
$q2 = mysql_query("select * from $table order by chance asc");
$num = mysql_num_rows($q2);
$stop = $num - 1;
while ($i < $num) {
$class = mysql_result($q2,$i,"classname");
$type = mysql_result($q2,$i,"type");
$chance = mysql_result($q2,$i,"chance");
$loot.="[\"$class\", \"$type\"]";
if($i >= $stop) {
}
else {
$loot.=", ";
}
$lootc.="$chance";
if($i >= $stop) {
}
else {
$lootc.=", ";
}
$i++;
}
$loot = htmlspecialchars($loot);
echo "<input type=\"text\" size=\"200\" value=\"_ItemType = [$loot];\">";
echo "<br>";
echo "<input type=\"text\" size=\"200\"  value=\"_itemChance = [$lootc];\">";
$i = 0;
?>


<br>
<img src="" id="preview">
<br>
<form method="post" action="?type=<?=$table;?>">
<select name="item" id="item" class="inputbox" size="1">
<?=$options?> 
</select> 
<label for="chance">Dropchance</label>
<input type="text" id="chance" name="chance" value="0.2">
<input type="submit" name="submit" value="Add weapon">
</form>
<br>
<table border="0" width=50% style="font-size: 12pt;">
<tr>
<td><b></b></td> <td width=180><b>Item name</b></td><td width=150><b>Classname</b></td> <td width=50><b>Dropchance</b></td><td><b>Delete</b></td>
</tr>
<?

//Lists current item in the selected loot database
$result1 = mysql_query("SELECT * FROM $table ORDER BY id desc") or die(mysql_error()); 
$number1 = mysql_num_rows($result1);

while ($i < $number1)
{
$classname = mysql_result($result1,$i,"classname");
$chance = mysql_result($result1,$i,"chance");
$id = mysql_result($result1,$i,"id");
$name = item_name(mysql_result($result1,$i,"classname"));
echo "
<tr style=\"font-size: 12pt; border-bottom:1px solid black;\">

<td><img src=\"items/$classname.png\"></td><td  width=\"350\" >$name</td> <td>$classname</td> <td style=\"font-size: 10pt;\" width=\"200\"> <form name=\"update\" method=\"post\" action=\"?type=$table\"><input type=\"hidden\" name=\"id=\" value=\"$id\"><input type=\"text\" name=\"chance=\" size=\"5\" value=\"$chance\"> <input type=\"submit\" name=\"update\" value=\"Update\"></form> </font></td><td><input type=\"button\" value=\"Delete\" onClick=\"location.href='?type=$table&del&id=$id'\"></tr></tr>";
$i++;
}
?>

</table>
<br>
<h5>Loot array generator by meistrr! Love and peace <3 </h5>
</body>
</html>
