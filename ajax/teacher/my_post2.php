<div class="my_posts" style="padding: 1%; border: 1px solid #ccc; background: white;  border: 1px solid #20b99d; max-width: 700px; margin: 1% auto">
	<?php 
$cls = $_GET['cls'];
$subject = $_GET['subject'];
$chapter = $_GET['chapter'];
$page = $_GET['page'];

$q = ' AND ';
if ($cls!='') {
	
}
$limit = 25;
$ps = ($page-1)*$limit;
$sql = "SELECT id FROM question WHERE setter = '$user'";
$m = mysqli_query($db,$sql);
$row1 = mysqli_num_rows($m);

$sql = "SELECT id FROM question WHERE setter = '$user' AND pending=0";
$m = mysqli_query($db,$sql);
$row2 = mysqli_num_rows($m);
$sql = "SELECT id FROM question WHERE setter = '$user' AND pending=1";
$m = mysqli_query($db,$sql);
$row3 = mysqli_num_rows($m);
$sql = "SELECT id FROM question WHERE setter = '$user' AND pending=2";
$m = mysqli_query($db,$sql);
$row4 = mysqli_num_rows($m);
?>
<style>
.area {
  display: inline-block;
  text-align: center;
  padding: 3.2%;
  background: linear-gradient(#39d0b5,#7efbef);
  border: 1px solid #20b99d;
  box-shadow: 0px 1px 3px 1px #ccc;
}
@media (max-width: 744px) {
	.area{
		width: 40%;
		margin: 1%;
		font-size: 15px
	}
}
</style>
<div class="area">
	<h3>Total Added</h3>
	<h4  style="font-family: arial; padding-top: 7px; color: #0077f5"><?php echo $row1 ?></h4>
</div>
<div class="area">
	<h3>Total Pending</h3>
	<h4  style="font-family: arial; padding-top: 7px; color: #0077f5"><?php echo $row2 ?></h4>
</div>
<div class="area">
	<h3>Total Approved</h3>
	<h4  style="font-family: arial; padding-top: 7px; color: #0077f5"><?php echo $row3 ?></h4>
</div>
<div class="area">
	<h3>Total Rejected</h3>
	<h4  style="font-family: arial; padding-top: 7px; color: #0077f5"><?php echo $row4 ?></h4>
</div>
<?php
$sql = "SELECT * FROM question WHERE setter = '$user' ORDER BY id DESC LIMIT $ps,$limit";
$m = mysqli_query($db,$sql);
while ($row=mysqli_fetch_array($m)) {
?>
<div class="question" style="margin: 1% 0%; background: #fff; padding: 1%; border: 1px solid #20b99d;">
	<div class="status" style="float:right; background: #20b99d; padding: 10px;"><?php if($row['pending']==1){echo color("Approved","lightgreen");} if($row['pending']==0){echo color("Pending","white");} if($row['pending']==2){echo color("Rejected","tomato");} ?></div>
	<div class="header" style="font-weight: bold; overflow: hidden;"><?php echo "<h3 style='float: left'>".color(arial(translate(get_number($row['id']))),"green").".</h3> ".$row['question'] ?></div>
	<div class="body">
		<div class="r" style="overflow: hidden;"><div class="as" style="float: left"><?php echo translate("A") ?>. </div><div class="as" style="float:left"><?php echo $row['opt1'] ?></div></div>
		<div class="r" style="overflow: hidden;"><div class="as" style="float: left"><?php echo translate("B") ?>. </div><div class="as" style="float:left"><?php echo $row['opt2'] ?></div></div>
		<div class="r" style="overflow: hidden;"><div class="as" style="float: left"><?php echo translate("C") ?>. </div><div class="as" style="float:left"><?php echo $row['opt3'] ?></div></div>
		<div class="r" style="overflow: hidden;"><div class="as" style="float: left"><?php echo translate("D") ?>. </div><div class="as" style="float:left"><?php echo $row['opt4'] ?></div></div>
		<div class="r" style="overflow: hidden;"><div class="as" style="float: left; font-weight: bold">Answer:&nbsp;&nbsp;</div><div class="as" style="float:left"> <?php echo $row['currect'] ?></div></div>
		<div class="r" style="overflow: hidden;"><div class="as" style="float: left; font-weight: bold">Explaination: </div><div class="as" style="float:left"> <?php echo $row['details'] ?> </div></div>
		<div class="r" style="overflow: hidden;"><div class="as" style="float: left;font-weight: bold">Audio explaination:&nbsp;&nbsp;</div><div class="as" style="float:left"> <?php if($row['audio_explain']==''){echo color("No","red");}else { echo color("Yes","green");} ?> </div></div>
		<?php 
if ($row['pending']==2) {
	$q_id = $row['id'];
	$sql = "SELECT * FROM `reject_msg` WHERE q_id='$q_id' ORDER BY id DESC LIMIT 1";
	$s = mysqli_query($db,$sql);
	$co = mysqli_fetch_array($s);
?>
<div class="r" style="overflow: hidden;"><div class="as" style="float: left; font-weight: bold">Reason for Rejection:&nbsp;&nbsp;</div><div class="as" style="float:left; color: #e22bdf;"> <?php echo $co['msg'] ?></div></div>
<?php
}
		?>
	</div>
</div>
<?php
}
if (mysqli_num_rows($m)==0) {
	echo "No Questions Found !";
}
	?>
</div>
<?php
$st = "SELECT * FROM question WHERE setter = '$user' ORDER BY id DESC";
$r = mysqli_query($db,$st);
$total = mysqli_num_rows($r);
pagination($page,$total,$limit);

function pagination($page,$total,$limit){
$crnt = $page;
$page_number = ceil($total/$limit);
echo "<ul class='pagination_bar'>";
if ($crnt==1) {
		?>
<li class="pagenation_list"><a href="javascript:void(0)"><<</a></li>
<li class="pagenation_list"><a href="javascript:void(0)"><</a></li>
		<?php 
	} else {
	?>
<li class="pagenation_list"><a onclick="search_d52(1)" href="javascript:void(0)"><<</a></li>
<li class="pagenation_list"><a onclick="search_d52(<?php echo ($crnt-1) ?>)" href="javascript:void(0)"><</a></li>
	<?php
}
for ($i=0; $i < $page_number; $i++) { 
	if (($i+1)==$crnt) {
		?>
<li class="pagenation_list"><a href="javascript:void(0)" class="selected_crnt_page"><?php echo ($i+1) ?></a></li>
		<?php 
	} else {
	?>
<li class="pagenation_list"><a onclick="search_d52(<?php echo ($i+1) ?>)" href="javascript:void(0)"><?php echo ($i+1) ?></a></li>
	<?php
}
}
if ($crnt==$page_number) {
		?>
<li class="pagenation_list"><a href="javascript:void(0)" disabled>></a></li>
<li class="pagenation_list"><a href="javascript:void(0)" disabled>>></a></li>
		<?php 
	} else {
	?>
<li class="pagenation_list"><a onclick="search_d52(<?php echo ($crnt+1) ?>)" href="javascript:void(0)">></a></li>
<li class="pagenation_list"><a onclick="search_d52(<?php echo ($page_number) ?>)" href="javascript:void(0)">>></a></li>
	<?php
}
echo "</ul>";
?>
<style>
	p {
		background: none !important;
	}
</style>

<style>
	.pagination_bar{
	width: 99%;
	text-align: center;
	background: white;
	padding: 1%;
}
.pagenation_list {
	display: inline-block;
	margin-left: -3px;
}
.pagenation_list a {
	text-decoration: none;
	color: #242424;
	background: linear-gradient(rgba(215,215,220),rgba(225,225,230));
	padding: 10px 20px;
	display: block;
}
.pagenation_list a.selected_crnt_page {
	background: tomato !important;
}
.pagenation_list a:hover {
	background: yellowgreen;
}

</style>
<?php
}
?>
</div>