<?php
$counter = 1;
$conn = mysqli_connect("localhost","nout_sub_user","TGynUGVLen","nout_sub_arena");

while (have_posts()) : the_post();


?>

<?php get_template_part('content', 'page'); ?>

<?php
// If comments are open or we have at least one comment, load up the comment template
if (comments_open() || get_comments_number()) :
comments_template();
endif;
?>

<?php endwhile; // end of the loop. ?>

<?php
if(is_user_logged_in())
{
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
//user gamer post
$args = array('author'=>$user_id,'post_type'=>'gamer');
$attachments = get_posts( $args );
if ( $attachments ) {
foreach ( $attachments as $post ) {
setup_postdata( $post );
$gamer_name = get_the_title();
$gamer_id = get_the_ID();
//echo $gamer_name.$gamer_id;
if ( has_post_thumbnail() ) {
$user_avatar= get_the_post_thumbnail($gamer_id,"custom",array( 'title' => 'Ավատար' ));
}
else {
$user_avatar= '<img src="' . get_bloginfo( 'stylesheet_directory' ) 
. '/images/avatar.png" class = "imgs" title = "Ավատար"/>';
}
}
wp_reset_postdata();
}

//end user gamer post//




 //requests update





$of = mysqli_query($conn,"select * from wp_team_request where team_request = '0'");
while($ofe = mysqli_fetch_assoc($of)){
$asa = $ofe['user_id'];
echo "<style>#form_request$asa{display:none;}</style>";
}











//isset team
if(isset($_POST["addteam"])){
if(isset($_POST["tname"])){
$team = strtoupper($_POST["tname"]);
$team_cat = $_POST["gametype"];
$find_team = mysqli_query($conn,"select * from wp_usermeta where meta_value ='$team'");
if(!mysqli_num_rows($find_team)){

$post_team_settings = array(
'post_title'=>$team,
'post_category'=>array($team_cat),
'post_status' => 'publish',
'post_type'=>'clubs');
$post_t =wp_insert_post( $post_team_settings );
add_post_meta($post_t,"captain",$gamer_name,false);
wp_set_post_terms($gamer_id,$team,"clubtags",true);
update_user_meta($user_id,"role".$team_cat,"captain",false);
update_user_meta($user_id,"team".$team_cat,$team,false);

}}}

 

 


//isset status

 

 


if(isset($_POST['lose_team'])){
$team_name = $_POST['lose_team_name'];
$loteam_id = $_POST['lose_team_id'];
$team_cat = $_POST['lose_team_cat'];
//echo $team_name." ".$team_id." ".$team_cat;

update_user_meta($user_id,'role'.$team_cat,'gamer', 'captain');
update_user_meta($user_id,'team'.$team_cat,'-', $team_name);
update_post_meta($gamer_id, 'status', 'gamer', 'captain');
update_post_meta($loteam_id, 'captain', '-', $gamer_name);
wp_remove_object_terms( $gamer_id, strtoupper($team_name),'clubtags');
//echo '<meta http-equiv=Refresh content="0;url=index.php?reload=1">';
mysqli_query($conn,"delete from wp_team_request where user_id = '$user_id'");
}


//echo $team_id.'role'.$k;

 


 




if(isset($_POST["lose_status"])){
$team_name = $_POST['lose_team_name'];
$lteam_id = $_POST['lose_team_id'];
$team_cat = $_POST['lose_team_cat'];
//echo $team_name." ".$team_id." ".$team_cat;
update_user_meta($user_id,'role'.$team_cat,'gamer', 'captain');
update_post_meta($gamer_id, 'status'.$team_cat, 'gamer', 'captain');
update_post_meta($lteam_id, 'captain', '-', $gamer_name);
//echo '<meta http-equiv=Refresh content="0;url=index.php?reload=1">';
}?>


<h6 style = "text-align: center;">Բարի գալուստ <?=$gamer_name;?> . Ինչպե՞ս ես:</h6>



<div class = "row">
<!-- user avatar -->
<div class = "col-md-12" style = "text-align: center;">
<?php echo $user_avatar;?>
<form id="featured_upload" method="post" action="" enctype="multipart/form-data" style = "margin-bottom:30px;">
<label for = 'my_image_upload' style = 'color: white;padding:7px 24px; background-color: #55f502 !important;cursor:pointer;margin-top: 15px;' >Վերբեռնել Ավատար</label>
<input type="file" class = 'upform' name="my_image_upload" id="my_image_upload" multiple="false" style = 'display:none;' />
<input type="hidden" name="post_id" id="post_id" value="<?=$gamer_id;?>" />
<?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
<!-- <input id="submit_my_image_upload" class = 'avat' name="submit_my_image_upload" type="submit" value="Վերբեռնել նկարը" style = "margin-top:15px;background:#8080806b;"/> -->
</form>
</div>
<!-- end user avatar -->
<!-- user data change -->
<div class = "col-md-6" style = "display:none">
<form action = "" method= "post">
Ձեր անունը: <input type = "text" name = "changeName" value = "<?=$gamer_name?>"/> <input type = "submit" name = "chName" value = "Փոխել" style = "color: white;">
</form>
</div>
</div>
<div class = "row">
<ul class = "events" style = "list-style:none;">
<?php
$gamer_team = "";
$gamer_role = "";
$captain_teams = array();
for($k =80;$k<=82;$k++){
$testTeam = get_user_meta($user_id,"team".$k,true);
//echo $testTeam;

 

$gamer_role = get_user_meta($user_id,"role".$k,true);
$gamer_team = get_user_meta($user_id,"team".$k,true);
//print_r($gamer_role);
//$testTeam = get_user_meta($user_id,"team",true);
//echo $testTeam;

 


//del members
if(isset($_POST["del"])){
$members_post_id = $_POST["team_gamers_id"];
$members_cat_id = $_POST["team_gamers_cat"]; 
$members_user_id = $_POST["gamer_user_id"]; 
$members_user_team = $_POST["theTeam"];
$sel = mysqli_query($conn,"select ID from wp_users where user_login = '$members_user_id'");
$sels = mysqli_fetch_assoc($sel);
$userik = $sels['ID'];
mysqli_query($conn,"delete from wp_team_request where user_id = '$userik'");

update_user_meta($userik,'team'.$members_cat_id,'-', $members_user_team);
wp_remove_object_terms( $members_post_id, strtoupper($members_user_team),'clubtags');
//echo '<meta http-equiv=Refresh content="0;url=index.php?reload=1">'; 
}




//request delete
if(isset($_POST['delet_request'])){
$user_req_id = $_POST['us_id'];
$del_memb = $_POST['del_memb'];
mysqli_query($conn,"delete from wp_team_request where user_id = '$user_req_id'");
echo "<style>#form_request$del_memb{display:none;}</style>";
}



if(isset($_POST['update_request'])){
$user_req_name = $_POST['us_name'];
$user_req_id = $_POST['us_id'];
$team_req_name = $_POST['team_name'];
$req_team_cat = $_POST['req_team_cat'];
//$up_memb = $_POST['up_memb'];
$del_memb = $_POST['del_memb'];
$current_user_settings = array("post_type"=>"gamer","title"=>$user_req_name);
$current_user_post = get_posts($current_user_settings);
if($current_user_post){
foreach($current_user_post as $post){
setup_postdata($post);
$current_user_post_id = get_the_ID();
}


wp_reset_postdata();
}

update_user_meta($user_req_id,"team".$req_team_cat,$team_req_name,"-");
wp_set_post_terms($current_user_post_id,strtoupper($team_req_name),"clubtags",true);
mysqli_query($conn,"update wp_team_request set team_request = '0' where user_id = '$user_req_id'");
//echo "<style>#form_request$user_req_id{display:none;}</style>";

 }



 //requests update





$of = mysqli_query($conn,"select * from wp_team_request where team_request = '0'");
while($ofe = mysqli_fetch_assoc($of)){
$asa = $ofe['user_id'];
echo "<style>#form_request$asa{display:none;}</style>";
}







//current team
$team_args = array('title'=>$gamer_team,'post_type'=>'clubs');
$post_team= get_posts( $team_args );
if ( $post_team ) {
foreach ( $post_team as $post ) {
setup_postdata( $post );
$team_id = get_the_ID();
$cap = get_post_meta($team_id,"captain",true);
if(get_user_meta($user_id,"role".$k,true)=="captain"){$captain_teams[] =$team_id;}
//the_title();
if ( has_post_thumbnail() ) {
$team_logo= get_the_post_thumbnail($team_id,"custom",array( 'title' => 'Թիմի լոգո' ));
}
else {
$team_logo= '<img src="' . get_bloginfo( 'stylesheet_directory' ) 
. '/images/team-logo.png" class = "imgs" title = "Թիմի լոգո" />'; 
}
} 
wp_reset_postdata();
}



//end loged in if

 

?>


<?php


if($k=='80'){

?><li id = 'k<?php echo $k; ?>' style= 'text-align:center;background:#80808040;padding:10px; margin-top:0;cursor: pointer;float:left;width:270px;border-left: 1px solid rgb(238, 238, 238);border-right: 1px solid rgb(238, 238, 238);border-bottom: 1px solid rgb(238, 238, 238);border-top: 3px solid #55f502;font-weight: bold;
background: rgb(249, 249, 249) none repeat scroll 0% 0%;'>CS:GO ՄՐՑՈՒՅԹ

<div class = 'row' id = 'c<?php echo $k; ?>' style = 'border:1px solid #80808040;margin-bottom:30px;display:none;margin-left:0px;margin-right:0px;position:absolute;top:100%;left:0;'>

<div class='col-md-12'>
<div class='col-md-5' style = 'padding: 0;'>
<?php if($testTeam=="-"){?>
<form action = "" method = "post">
<input type = "text" name = "tname" placeholder = "Ձեր թիմի անունը... " style="margin-top: 3px;padding: 11px 8px;margin-left: 1px;"/>
<input type = "hidden" name = "gametype" value = "<?php echo $k;?>"/>
<input type = "submit" name = "addteam" value = "Ստեղծել թիմ" style = "color: white;line-height: 39px;"/>
</form>
<?php
} ?>
</div>


<div class='col-md-7'>
<ul id = 'relative' style = 'position:relative;width:100%;margin: 4px 7px 12px 43px;'>
<li class = 'relative_li' style = 'list-style: none;float: left;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;
padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;
width:100%;display:inline-block;'>Փոփոխել տվյալները</span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; border: 1px solid #eee!important; background: #f9f9f9;width: 94%; margin-left:0;
min-height: 240px;
position: absolute;'>


<form action='https://arena.nout.am/my-account-2/' method='post' style='margin-top: 30px;'>

<?php

 


if(($gamer_team!='-') && ($gamer_role=='gamer')){
echo "
<input type = 'submit' class = 'lose_team' name = 'lose_team' data-name = '$gamer_name' data-team = '$gamer_team' data-user = '$user_id' data-gamer = '$gamer_id' data-team = '$team_id' id = 'lose_team' value = 'Հրաժարվել թիմից' style = 'background:#3fd533;cursor:pointer;border:3px solid white;margin-top:30px;'>
<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";


}elseif(($gamer_team!='-') && ($gamer_role=='captain')){
echo "<input type = 'submit' name = 'lose_status' value = 'Հրաժարվել պաշտոնից' id = 'lose_status' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a; float:left;margin-left:12px;margin-top:30px;'>
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";
echo "<input type = 'submit' class = 'lose_team' name = 'lose_team' data-name = '$gamer_name' data-team = '$gamer_team' data-user = '$user_id' data-gamer = '$gamer_id' data-team = '$team_id' id = 'lose_team' value = 'Հրաժարվել թիմից' style = 'display:inline-block;background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a;margin-top:30px;'>

<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";

}elseif(($gamer_team=='-') && ($gamer_role=='gamer')){
echo "<a href='https://arena.nout.am/gamers-and-teams/?g=$k' id = 'add_teams' style='color: white;background-color: #55f502 !important;;padding: 10px;font-weight: bold;border:3px solid white;margin-top:30px;'>Միանալ թիմի</a>";
}
?>
</form>
</ul></li>

<li class = 'relative_li' style = 'list-style: none;float: left; margin-left: 12px;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;width:100%;display:inline-block;'>Մրցույթներ</span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; border: 1px solid #eee!important; background: #f9f9f9; width: 94%;margin-left:0;
min-height: 240px;
position: absolute;'>
<?php 
if($gamer_team!='-'){
//echo "<a href = 'https://arena.nout.am/gamers-and-teams/' style = 'color: white;display:inline-block;background:#3fd533;cursor:pointer;border:3px solid white;margin-top:30px;padding: 9px 45px;font-weight: bold;'>Միանալ թիմի</a>";
echo "<h4>Իմ թիմը: ".$gamer_team."</h4><h4>Իմ թիմի մրցույթները՝</h4>";
$league = get_the_terms($team_id,'clubtags');
$league_title = $league[0]->name;
if($league_title){
echo "<span style = 'display: inline-block;background:#3fd533;color: white;padding: 10px 20px;'>".$league_title."</span>";

}else{
echo "<a href = 'https://arena.nout.am/liga/' style = 'color: white;display:inline-block;background-color: #55f502 !important;cursor:pointer;border:3px solid white;margin-top:30px;font-weight: bold;padding:9px;'>Մասնակցել Մրցույթին</a>";
}

 

} 
else{
// echo "<a href='https://arena.nout.am/gamers-and-teams/' style='color: black;background:#3fd533;padding: 10px;font-weight: bold'>Միանալ թիմի</a>";
} 
?>
</ul></li>


<li class = 'relative_li' style = 'list-style: none;float: left; margin-left: 12px;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;width:100%;display:inline-block;position:relative;'>Հարցումներ<?php
$count_not = mysqli_query($conn,"SELECT COUNT(team_request) AS NumberOfProducts FROM wp_team_request where captain_name = '$gamer_name' and team_request = '1' and team_id = '$team_id'");
$data=mysqli_fetch_assoc($count_not);
$data_count = $data['NumberOfProducts'];
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){

$conn = mysqli_connect("localhost","nout_sub_user","TGynUGVLen","nout_sub_arena");
$count_not = mysqli_query($conn,"SELECT COUNT(team_request) AS NumberOfProducts FROM wp_team_request where captain_name = '$gamer_name' and team_request = '1' and team_id = '$team_id'");
$data=mysqli_fetch_assoc($count_not);
$data_count = $data['NumberOfProducts'];
//echo $data_count;
if($data_count!=0){
 echo "<span style = 'position: absolute;top: 0;color:#55f502;right: 13px;font-size: 16px;'>".$data_count."</span>"; } } ?></span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; width: 94%;
min-height: 240px;
background: white;
border:3px solid grey;
position: absolute;margin-left:0;'>

<?php
$cin = 0;
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){ 

$conn = mysqli_connect("localhost","nout_sub_user","TGynUGVLen","nout_sub_arena");
$team_req = mysqli_query($conn,"select * from wp_team_request where captain_name = '$gamer_name' and team_id = '$team_id'");

while($team_requests = mysqli_fetch_assoc($team_req)){
$user_request = $team_requests['user_id'];
$sql = mysqli_query($conn,"SELECT `user_login` FROM `wp_users` WHERE `ID` = '$user_request'");
while($sql_req = mysqli_fetch_assoc($sql)){
$user_name_request = $sql_req['user_login'];
$cin ++;
?>

<form action = "" method = "post" id = "form_request<?php echo $user_request; ?>" >
<div style = "overflow: hidden">
<span style = "display:inline-block;font-weight: bold;">Դուք ունեք թիմին միանալու հարցում <?php echo $user_name_request; ?>-ից</span>
<input type = 'submit' id = 'delete_request' name = 'delet_request' value = 'Մերժել հայտը' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a; float:left;margin-left:50px;'>
<input type = 'submit' id = 'update_request' name = 'update_request' value = 'Ընդունել հայտը' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #55f502; float:left;margin-left:12px;'>
<input type = 'hidden' name = 'us_name' value = '<?php echo $user_name_request; ?>' />
<input type = 'hidden' name = 'us_id' value = '<?php echo $user_request; ?>' />
<input type = 'hidden' name = 'team_name' value = '<?php echo $gamer_team; ?>' />
<input type = 'hidden' name = 'req_team_cat' value = '<?php echo $k; ?>' >
<input type = 'hidden' name = 'del_memb' value = '<?php echo $cin; ?>' >
<input type = 'hidden' name = 'up_memb' value = '<?php echo $cin; ?>' >
</div>
</form>
<?php
}
}

 if($data_count==0){
 echo "Դուք չունեք թիմին միանալու հարցում "; }


// mysqli_query($conn,"select * from wp_team_request where captain_name = '$gamer_name' and team_request = '0' team_id = '$team_id'");

}else{
echo "Դուք չունեք թիմ";
}
?>

</ul></li>
</ul>
</div>








</div>
<div class='col-md-12' style = 'margin-top: 50px;'>
<div class='col-md-5'>

<h6>Թիմ՝ <?php echo $gamer_team;?></h6>
<h6>Պաշտոն՝ <?php echo strtoupper($gamer_role);?></h6>
<h4>Իմ թիմի մասնակիցները՝</h4>
<div>
<?php

$a = array('post_type'=>'gamer','exclude'=>array($gamer_id),"tax_query"=>array(array("taxonomy"=>"clubtags","field"=>"slug","terms"=>"$gamer_team")));
$at = get_posts( $a );
if ( $at ) {
foreach ( $at as $post ) {
setup_postdata( $post );

$i = get_the_ID();
$a = get_the_author();
if($cap==$gamer_name){?>
<form action = "" method = "post" style = "display:inline-block;">
<input name = "team_gamers_id" type = "hidden" value = "<?=$i;?>"/>
<input name = "team_gamers_cat" type = "hidden" value = "<?=$k;?>"/>
<input name = "gamer_user_id" type = "hidden" value = "<?=$a;?>"/>
<input name = "theTeam" type = "hidden" value = "<?=$gamer_team;?>"/>
<span style = "float:left;margin-top: 7px;"><?php the_title(); ?></span>
<input name = "del" id = 'delete_member' type = "submit" value = "Հեռացնել թիմից" style = " color: #55f502;background: white !important;float:left;"/> 
<?php }
echo "<br/>";

}
wp_reset_postdata();
}else{
echo "Թիմում դեռ մասնակիցներ չկան";
}
 

?>
</div>
</div>


<div class = 'col-md-7'>
<?php

if(is_user_logged_in())
{ ?>


<?php if($gamer_team!='-'){ echo "<div>".$team_logo."</div>";}?>

<?php


if($gamer_role=="captain"){

?>
<form id="featured_upload" method="post" action="" enctype="multipart/form-data" >

<label for = 'my_team_upload<?=$counter; ?>' style = 'color: white;padding:7px 24px;background-color: #55f502 !important;cursor:pointer;margin-top: 15px;'>Վերբեռնել թիմի լոգոն</label>
<input type="file" class = "upform" name="my_team_upload<?=$counter; ?>" id="my_team_upload<?=$counter; ?>" multiple="false" style = 'display:none;' />
<input type="hidden" name="post_id<?=$counter; ?>" id="post_id<?=$counter; ?>" value="<?php echo $team_id; ?>" />
<?php wp_nonce_field( "my_team_upload".$counter, "my_team_upload_nonce".$counter ); ?>
<!-- <input id="submit_my_team_upload" class = 'log' name="submit_my_team_upload" type="submit" value="Վերբեռնել թիմի լոգոն" style = "padding:5px 10px;margin-top:15px;background:#8080806b;" /> -->
</form>

<?php } ?>

<?php } ?>

</div>




</div>

</div>


</li>

 <?php
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){
$count_not = mysqli_query($conn,"SELECT COUNT(team_request) AS NumberOfProducts FROM wp_team_request where captain_name = '$gamer_name' and team_request = '1' and team_id = '$team_id'");
$data=mysqli_fetch_assoc($count_not);
$data_count = $data['NumberOfProducts'];
if($data_count!=0){
//echo "<i class='fa fa-flag' aria-hidden='true' style = 'position: absolute;right: 10px;bottom: 16px;color:  #81da04;'></i>";
}}

}elseif($k=='81'){

?><li id = 'k<?php echo $k; ?>' style= 'text-align:center;background:#80808040;padding:10px; margin-top:0;border: 3px solid #55f502;cursor: pointer;float:left;width:270px;border: 1px solid rgb(238, 238, 238) !important;font-weight: bold;
background: rgb(249, 249, 249) none repeat scroll 0% 0%;'>DOTA 2 ՄՐՑՈՒՅԹ

<div class = 'row' id = 'c<?php echo $k; ?>' style = 'border:1px solid #80808040;margin-bottom:30px;display:none;margin-left:0px;margin-right:0px;position:absolute;top:100%;left:0;'>

<div class='col-md-12'>
<div class='col-md-5'  style = 'padding: 0;'>
<?php if($testTeam=="-"){?>
<form action = "" method = "post">
<input type = "text" name = "tname" placeholder = "Ձեր թիմի անունը... " style = 'margin-top: 3px;padding: 11px 8px;margin-left: 1px;'/>
<input type = "hidden" name = "gametype" value = "<?php echo $k;?>"/>
<input type = "submit" name = "addteam" value = "Ստեղծել թիմ" style = "color: white;line-height: 39px;"/>
</form>
<?php
} ?>
</div>

<div class='col-md-7'>
<ul id = 'relative' style = 'position:relative;width:100%;margin: 4px 7px 12px 43px;'>
<li class = 'relative_li' style = 'list-style: none;float: left;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;
padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;
width:100%;display:inline-block;'>Փոփոխել տվյալները</span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; border: 1px solid #eee!important; background: #f9f9f9; width: 94%;margin-left:0;
min-height: 240px;
position: absolute;'>


<form action='https://arena.nout.am/my-account-2/' method='post' style='margin-top: 30px;'>

<?php

 


if(($gamer_team!='-') && ($gamer_role=='gamer')){
echo "
<input type = 'submit' class = 'lose_team' name = 'lose_team' data-name = '$gamer_name' data-team = '$gamer_team' data-user = '$user_id' data-gamer = '$gamer_id' data-team = '$team_id' id = 'lose_team' value = 'Հրաժարվել թիմից' style = 'background:#3fd533;cursor:pointer;border:3px solid white;margin-top:30px;'>
<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";


}elseif(($gamer_team!='-') && ($gamer_role=='captain')){
echo "<input type = 'submit' name = 'lose_status' value = 'Հրաժարվել պաշտոնից' id = 'lose_status' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a; float:left;margin-left:12px;margin-top:30px;'>
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";
echo "<input type = 'submit' class = 'lose_team' name = 'lose_team' data-name = '$gamer_name' data-team = '$gamer_team' data-user = '$user_id' data-gamer = '$gamer_id' data-team = '$team_id' id = 'lose_team' value = 'Հրաժարվել թիմից' style = 'display:inline-block;background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a;margin-top:30px;'>

<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";

}elseif(($gamer_team=='-') && ($gamer_role=='gamer')){
echo "<a href='https://arena.nout.am/gamers-and-teams/?g=$k' id = 'add_teams' style='color: white;background-color: #55f502 !important;;padding: 10px;font-weight: bold;border:3px solid white;margin-top:30px;'>Միանալ թիմի</a>";
}
?>
</form>
</ul></li>

<li class = 'relative_li' style = 'list-style: none;float: left; margin-left: 12px;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;width:100%;display:inline-block;'>Մրցույթներ</span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; border: 1px solid #eee!important; background: #f9f9f9; width: 94%;margin-left:0;
min-height: 240px;
position: absolute;'>
<?php 
if($gamer_team!='-'){
//echo "<a href = 'https://arena.nout.am/gamers-and-teams/' style = 'color: white;display:inline-block;background:#3fd533;cursor:pointer;border:3px solid white;margin-top:30px;padding: 9px 45px;font-weight: bold;'>Միանալ թիմի</a>";
echo "<h4>Իմ թիմը: ".$gamer_team."</h4><h4>Իմ թիմի մրցույթները՝</h4>";
$league = get_the_terms($team_id,'clubtags');
$league_title = $league[0]->name;
if($league_title){
echo "<span style = 'display: inline-block;background:#3fd533;color: white;padding: 10px 20px;'>".$league_title."</span>";

}else{
echo "<a href = 'https://arena.nout.am/liga/' style = 'color: white;display:inline-block;background-color: #55f502 !important;cursor:pointer;border:3px solid white;margin-top:30px;font-weight: bold;padding:9px;'>Մասնակցել Մրցույթին</a>";
}

 

} 
else{
// echo "<a href='https://arena.nout.am/gamers-and-teams/' style='color: black;background:#3fd533;padding: 10px;font-weight: bold'>Միանալ թիմի</a>";
} 
?>
</ul></li>


<li class = 'relative_li' style = 'list-style: none;float: left; margin-left: 12px;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;width:100%;display:inline-block;position:relative;'>Հարցումներ<?php
$count_not = mysqli_query($conn,"SELECT COUNT(team_request) AS NumberOfProducts FROM wp_team_request where captain_name = '$gamer_name' and team_request = '1' and team_id = '$team_id'");
$data=mysqli_fetch_assoc($count_not);
$data_count = $data['NumberOfProducts'];
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){
if($data_count!=0){
 echo "<span style = 'position: absolute;top: 0;color:#55f502;right: 13px;font-size: 16px;'>".$data_count."</span>"; } } ?></span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; width: 94%;
min-height: 240px;
background: white;
border:3px solid grey;
position: absolute;margin-left:0;'>

<?php
$cin = 0;
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){ 

$conn = mysqli_connect("localhost","nout_sub_user","TGynUGVLen","nout_sub_arena");
$team_req = mysqli_query($conn,"select * from wp_team_request where captain_name = '$gamer_name' and team_id = '$team_id'");

while($team_requests = mysqli_fetch_assoc($team_req)){
$user_request = $team_requests['user_id'];
$sql = mysqli_query($conn,"SELECT `user_login` FROM `wp_users` WHERE `ID` = '$user_request'");
while($sql_req = mysqli_fetch_assoc($sql)){
$user_name_request = $sql_req['user_login'];
$cin ++;
?>

<form action = "" method = "post" id = "form_request<?php echo $user_request; ?>" >
<div style = "overflow: hidden">
<span style = "display:inline-block;font-weight: bold;">Դուք ունեք թիմին միանալու հարցում <?php echo $user_name_request; ?>-ից</span>
<input type = 'submit' id = 'delete_request' name = 'delet_request' value = 'Մերժել հայտը' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a; float:left;margin-left:50px;'>
<input type = 'submit' id = 'update_request' name = 'update_request' value = 'Ընդունել հայտը' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #55f502; float:left;margin-left:12px;'>
<input type = 'hidden' name = 'us_name' value = '<?php echo $user_name_request; ?>' />
<input type = 'hidden' name = 'us_id' value = '<?php echo $user_request; ?>' />
<input type = 'hidden' name = 'team_name' value = '<?php echo $gamer_team; ?>' />
<input type = 'hidden' name = 'req_team_cat' value = '<?php echo $k; ?>' >
<input type = 'hidden' name = 'del_memb' value = '<?php echo $cin; ?>' >
<input type = 'hidden' name = 'up_memb' value = '<?php echo $cin; ?>' >
</div>
</form>
<?php
}
}

 if($data_count==0){
 echo "Դուք չունեք թիմին միանալու հարցում "; }


// mysqli_query($conn,"select * from wp_team_request where captain_name = '$gamer_name' and team_request = '0' team_id = '$team_id'");

}else{
echo "Դուք չունեք թիմ";
}
?>

</ul></li>
</ul>
</div>













</div>
<div class='col-md-12'  style = 'margin-top: 50px;'>
<div class='col-md-5'>

<h6>Թիմ՝ <?php echo $gamer_team;?></h6>
<h6>Պաշտոն՝ <?php echo strtoupper($gamer_role);?></h6>
<h4>Իմ թիմի մասնակիցները՝</h4>
<div>
<?php

$a = array('post_type'=>'gamer','exclude'=>array($gamer_id),"tax_query"=>array(array("taxonomy"=>"clubtags","field"=>"slug","terms"=>"$gamer_team")));
$at = get_posts( $a );
if ( $at ) {
foreach ( $at as $post ) {
setup_postdata( $post );

$i = get_the_ID();
$a = get_the_author();
if($cap==$gamer_name){?>
<form action = "" method = "post" style = "display:inline-block;">
<input name = "team_gamers_id" type = "hidden" value = "<?=$i;?>"/>
<input name = "team_gamers_cat" type = "hidden" value = "<?=$k;?>"/>
<input name = "gamer_user_id" type = "hidden" value = "<?=$a;?>"/>
<input name = "theTeam" type = "hidden" value = "<?=$gamer_team;?>"/>
<span style = "float:left;margin-top: 7px;"><?php the_title(); ?></span>
<input name = "del" id = 'delete_member' type = "submit" value = "Հեռացնել թիմից" style = " color: #55f502;background: white !important;float:left;"/> 
<?php }
echo "<br/>";

}
wp_reset_postdata();
}else{
echo "Թիմում դեռ մասնակիցներ չկան";
}

?>
</div>
</div>


<div class = 'col-md-7'>
<?php

if(is_user_logged_in())
{ ?>


<?php if($gamer_team!='-'){ echo "<div>".$team_logo."</div>";}?>

<?php


if($gamer_role=="captain"){

?>
<form id="featured_upload" method="post" action="" enctype="multipart/form-data" >

<label for = 'my_team_upload<?=$counter; ?>' style = 'color: white;padding:7px 24px;background-color: #55f502 !important;cursor:pointer;margin-top: 15px;'>Վերբեռնել թիմի լոգոն</label>
<input type="file" class = "upform" name="my_team_upload<?=$counter; ?>" id="my_team_upload<?=$counter; ?>" multiple="false" style = 'display:none;' />
<input type="hidden" name="post_id<?=$counter; ?>" id="post_id<?=$counter; ?>" value="<?php echo $team_id; ?>" />
<?php wp_nonce_field( "my_team_upload".$counter, "my_team_upload_nonce".$counter ); ?>
<!-- <input id="submit_my_team_upload" class = 'log' name="submit_my_team_upload" type="submit" value="Վերբեռնել թիմի լոգոն" style = "padding:5px 10px;margin-top:15px;background:#8080806b;" /> -->
</form>

<?php } ?>

<?php } ?>

</div>



</div>

</div>


</li>
<?php
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){
$count_not = mysqli_query($conn,"SELECT COUNT(team_request) AS NumberOfProducts FROM wp_team_request where captain_name = '$gamer_name' and team_request = '1' and team_id = '$team_id'");
$data=mysqli_fetch_assoc($count_not);
$data_count = $data['NumberOfProducts'];
if($data_count!=0){
//echo "<i class='fa fa-flag' aria-hidden='true' style = 'position: absolute;right: 10px;bottom: 16px;color:  #81da04;'></i>";
}} ?>
<?php
 

}elseif($k=='82'){

?><li id = 'k<?php echo $k; ?>' style= 'text-align:center;background:#80808040;padding:10px; margin-top:0;border: 3px solid #57fe00;cursor: pointer;float:left;width:300px;border: 1px solid rgb(238, 238, 238) !important;font-weight: bold;
background: rgb(249, 249, 249) none repeat scroll 0% 0%;'>LOL ՄՐՑՈՒՅԹ

<div class = 'row' id = 'c<?php echo $k; ?>' style = 'border:1px solid #80808040;margin-bottom:30px;display:none;margin-left:0px;margin-right:0px;position:absolute;top:100%;left:0;'>

<div class='col-md-12'>
<div class='col-md-5'  style = 'padding: 0;'>
<?php if($testTeam=="-"){?>
<form action = "" method = "post">
<input type = "text" name = "tname" placeholder = "Ձեր թիմի անունը... " style = 'margin-top: 3px;padding: 11px 8px;margin-left: 1px;'/>
<input type = "hidden" name = "gametype" value = "<?php echo $k;?>"/>
<input type = "submit" name = "addteam" value = "Ստեղծել թիմ" style = "color: white;line-height: 39px;"/>
</form>
<?php
} ?>
</div>


<div class='col-md-7'>
<ul id = 'relative' style = 'position:relative;width:100%;margin: 4px 7px 12px 43px;'>
<li class = 'relative_li' style = 'list-style: none;float: left;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;
padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;
width:100%;display:inline-block;'>Փոփոխել տվյալները</span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; border: 1px solid #eee!important; background: #f9f9f9; width: 94%;margin-left:0;
min-height: 240px;
position: absolute;'>


<form action='https://arena.nout.am/my-account-2/' method='post' style='margin-top: 30px;'>

<?php

 


if(($gamer_team!='-') && ($gamer_role=='gamer')){
echo "
<input type = 'submit' class = 'lose_team' name = 'lose_team' data-name = '$gamer_name' data-team = '$gamer_team' data-user = '$user_id' data-gamer = '$gamer_id' data-team = '$team_id' id = 'lose_team' value = 'Հրաժարվել թիմից' style = 'background:#3fd533;cursor:pointer;border:3px solid white;margin-top:30px;'>
<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";


}elseif(($gamer_team!='-') && ($gamer_role=='captain')){
echo "<input type = 'submit' name = 'lose_status' value = 'Հրաժարվել պաշտոնից' id = 'lose_status' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a; float:left;margin-left:12px;margin-top:30px;'>
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";
echo "<input type = 'submit' class = 'lose_team' name = 'lose_team' data-name = '$gamer_name' data-team = '$gamer_team' data-user = '$user_id' data-gamer = '$gamer_id' data-team = '$team_id' id = 'lose_team' value = 'Հրաժարվել թիմից' style = 'display:inline-block;background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a;margin-top:30px;'>

<input type = 'hidden' name = 'lose_team_name' value = '$gamer_team' >
<input type = 'hidden' name = 'lose_team_id' value = '$team_id' >
<input type = 'hidden' name = 'lose_team_cat' value = '$k' >
";

}elseif(($gamer_team=='-') && ($gamer_role=='gamer')){
echo "<a href='https://arena.nout.am/gamers-and-teams/?g=$k' id = 'add_teams' style='color: white;background-color: #55f502 !important;;padding: 10px;font-weight: bold;border:3px solid white;margin-top:30px;'>Միանալ թիմի</a>";
}
?>
</form>
</ul></li>

<li class = 'relative_li' style = 'list-style: none;float: left; margin-left: 12px;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;width:100%;display:inline-block;'>Մրցույթներ</span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; border: 1px solid #eee!important; background: #f9f9f9; width: 94%;margin-left:0;
min-height: 240px;
position: absolute;'>
<?php 
if($gamer_team!='-'){
//echo "<a href = 'https://arena.nout.am/gamers-and-teams/' style = 'color: white;display:inline-block;background:#3fd533;cursor:pointer;border:3px solid white;margin-top:30px;padding: 9px 45px;font-weight: bold;'>Միանալ թիմի</a>";
echo "<h4>Իմ թիմը: ".$gamer_team."</h4><h4>Իմ թիմի մրցույթները՝</h4>";
$league = get_the_terms($team_id,'clubtags');
$league_title = $league[0]->name;
if($league_title){
echo "<span style = 'display: inline-block;background:#3fd533;color: white;padding: 10px 20px;'>".$league_title."</span>";

}else{
echo "<a href = 'https://arena.nout.am/liga/' style = 'color: white;display:inline-block;background-color: #55f502 !important;cursor:pointer;border:3px solid white;margin-top:30px;font-weight: bold;padding:9px;'>Մասնակցել Մրցույթին</a>";
}

 

} 
else{
// echo "<a href='https://arena.nout.am/gamers-and-teams/' style='color: black;background:#3fd533;padding: 10px;font-weight: bold'>Միանալ թիմի</a>";
} 
?>
</ul></li>


<li class = 'relative_li' style = 'list-style: none;float: left; margin-left: 12px;text-align:center;'><span class = 'relative_a' style = 'border-radius: 0;padding: 10px 22px;color: #333;
margin-right: 3px;
border: 1px solid #eee!important;
border-bottom: 0!important;
font-size: 13px;
font-weight: 700;
background: #f9f9f9;
line-height: 29px;width:100%;display:inline-block;position:relative;'>Հարցումներ<?php
$count_not = mysqli_query($conn,"SELECT COUNT(team_request) AS NumberOfProducts FROM wp_team_request where captain_name = '$gamer_name' and team_request = '1' and team_id = '$team_id'");
$data=mysqli_fetch_assoc($count_not);
$data_count = $data['NumberOfProducts'];
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){
if($data_count!=0){
 echo "<span style = 'position: absolute;top: 0;color:#55f502;right: 13px;font-size: 16px;'>".$data_count."</span>"; } } ?></span><ul class = 'abs' style = 'z-index:9999;display:none; left:0; width: 94%;
min-height: 240px;
background: white;
border:3px solid grey;
position: absolute;margin-left:0;'>

<?php
$cin = 0;
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){ 

$conn = mysqli_connect("localhost","nout_sub_user","TGynUGVLen","nout_sub_arena");
$team_req = mysqli_query($conn,"select * from wp_team_request where captain_name = '$gamer_name' and team_id = '$team_id'");

while($team_requests = mysqli_fetch_assoc($team_req)){
$user_request = $team_requests['user_id'];
$sql = mysqli_query($conn,"SELECT `user_login` FROM `wp_users` WHERE `ID` = '$user_request'");
while($sql_req = mysqli_fetch_assoc($sql)){
$user_name_request = $sql_req['user_login'];
$cin ++;
?>

<form action = "" method = "post" id = "form_request<?php echo $user_request; ?>" >
<div style = "overflow: hidden">
<span style = "display:inline-block;font-weight: bold;">Դուք ունեք թիմին միանալու հարցում <?php echo $user_name_request; ?>-ից</span>
<input type = 'submit' id = 'delete_request' name = 'delet_request' value = 'Մերժել հայտը' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #f24c0a; float:left;margin-left:50px;'>
<input type = 'submit' id = 'update_request' name = 'update_request' value = 'Ընդունել հայտը' style = 'background: #f9f9f9 !important;cursor:pointer;border: 2px solid #55f502; float:left;margin-left:12px;'>
<input type = 'hidden' name = 'us_name' value = '<?php echo $user_name_request; ?>' />
<input type = 'hidden' name = 'us_id' value = '<?php echo $user_request; ?>' />
<input type = 'hidden' name = 'team_name' value = '<?php echo $gamer_team; ?>' />
<input type = 'hidden' name = 'req_team_cat' value = '<?php echo $k; ?>' >
<input type = 'hidden' name = 'del_memb' value = '<?php echo $cin; ?>' >
<input type = 'hidden' name = 'up_memb' value = '<?php echo $cin; ?>' >
</div>
</form>
<?php
}
}
if($data_count==0){
 echo "Դուք չունեք թիմին միանալու հարցում "; }
 


// mysqli_query($conn,"select * from wp_team_request where captain_name = '$gamer_name' and team_request = '0' team_id = '$team_id'");

}else{
echo "Դուք չունեք թիմ";
}
?>

</ul></li>
</ul>
</div>














</div>
<div class='col-md-12'  style = 'margin-top: 50px;'>
<div class='col-md-5'>

<h6>Թիմ՝ <?php echo $gamer_team;?></h6>
<h6>Պաշտոն՝ <?php echo strtoupper($gamer_role);?></h6>
<h4>Իմ թիմի մասնակիցները՝</h4>
<div>
<?php

$a = array('post_type'=>'gamer','exclude'=>array($gamer_id),"tax_query"=>array(array("taxonomy"=>"clubtags","field"=>"slug","terms"=>"$gamer_team")));
$at = get_posts( $a );
if ( $at ) {
foreach ( $at as $post ) {
setup_postdata( $post );

$i = get_the_ID();
$a = get_the_author();
if($cap==$gamer_name){?>
<form action = "" method = "post" style = "display:inline-block;">
<input name = "team_gamers_id" type = "hidden" value = "<?=$i;?>"/>
<input name = "team_gamers_cat" type = "hidden" value = "<?=$k;?>"/>
<input name = "gamer_user_id" type = "hidden" value = "<?=$a;?>"/>
<input name = "theTeam" type = "hidden" value = "<?=$gamer_team;?>"/>
<span style = "float:left;margin-top: 7px;"><?php the_title(); ?></span>
<input name = "del" id = 'delete_member' type = "submit" value = "Հեռացնել թիմից" style = " color: #55f502;background: white !important;float:left;"/> 
<?php }
echo "<br/>";

}
wp_reset_postdata();
}else{
echo "Թիմում դեռ մասնակիցներ չկան";
}

?>
</div>
</div>


<div class = 'col-md-7'>
<?php

if(is_user_logged_in())
{ ?>


<?php if($gamer_team!='-'){ echo "<div>".$team_logo."</div>";}?>

<?php


if($gamer_role=="captain"){

?>
<form id="featured_upload" method="post" action="" enctype="multipart/form-data" >

<label for = 'my_team_upload<?=$counter; ?>' style = 'color: white;padding:7px 24px;background-color: #55f502 !important;cursor:pointer;margin-top: 15px;'>Վերբեռնել թիմի լոգոն</label>
<input type="file" class = "upform" name="my_team_upload<?=$counter; ?>" id="my_team_upload<?=$counter; ?>" multiple="false" style = 'display:none;' />
<input type="hidden" name="post_id<?=$counter; ?>" id="post_id<?=$counter; ?>" value="<?php echo $team_id; ?>" />
<?php wp_nonce_field( "my_team_upload".$counter, "my_team_upload_nonce".$counter ); ?>
<!-- <input id="submit_my_team_upload" class = 'log' name="submit_my_team_upload" type="submit" value="Վերբեռնել թիմի լոգոն" style = "padding:5px 10px;margin-top:15px;background:#8080806b;" /> -->
</form>

<?php } ?>

<?php } ?>

</div>



</div>

</div>


</li>
<?php
if($gamer_team!='-' && $cap==$gamer_name && $gamer_role=='captain' ){
$count_not = mysqli_query($conn,"SELECT COUNT(team_request) AS NumberOfProducts FROM wp_team_request where captain_name = '$gamer_name' and team_request = '1' and team_id = '$team_id'");
$data=mysqli_fetch_assoc($count_not);
$data_count = $data['NumberOfProducts'];
if($data_count!=0){
//echo "<i class='fa fa-flag' aria-hidden='true' style = 'position: absolute;right: 10px;bottom:16px;color:  #81da04;'></i>";
}}
 }
?>


 

<?php
if ( 
isset( $_POST['my_image_upload_nonce'], $_POST['post_id'] ) 
&& wp_verify_nonce( $_POST['my_image_upload_nonce'], 'my_image_upload' )
) {
// The nonce was valid and the user has the capabilities, it is safe to continue.

// These files need to be included as dependencies when on the front end.
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

// Let WordPress handle the upload.
// Remember, 'my_image_upload' is the name of our file input in our form above.
$attachment_id = media_handle_upload( 'my_image_upload', $_POST['post_id'] );

if ( is_wp_error( $attachment_id ) ) {
// There was an error uploading the image.
} else {
set_post_thumbnail($_POST['post_id'],$attachment_id);
// echo '<meta http-equiv=Refresh content="0;url=index.php?reload=1">';
echo '<meta http-equiv="refresh" content="0; url=https://arena.nout.am/my-account-2/" />';
}

} else {

}


if ( 
isset( $_POST['my_team_upload_nonce'.$counter], $_POST['post_id'.$counter] ) 
&& wp_verify_nonce( $_POST['my_team_upload_nonce'.$counter], 'my_team_upload'.$counter) 
) {
// The nonce was valid and the user has the capabilities, it is safe to continue.

// These files need to be included as dependencies when on the front end.
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

// Let WordPress handle the upload.
// Remember, 'my_image_upload' is the name of our file input in our form above.
$attachment_id = media_handle_upload( 'my_team_upload'.$counter, $_POST['post_id'.$counter] );

if ( is_wp_error( $attachment_id ) ) {
// There was an error uploading the image.
} else {
set_post_thumbnail($_POST['post_id'.$counter],$attachment_id);
// echo '<meta http-equiv=Refresh content="0;url=index.php?reload=1">';
echo '<meta http-equiv="refresh" content="0; url=https://arena.nout.am/my-account-2/" />';
}

} else {

}

$counter++;

 

}}
//isset change name
if(isset($_POST["chName"])){
$change = $_POST["changeName"];
wp_update_post(array("ID"=>$gamer_id,"post_title"=>$change));
foreach($captain_teams as $example){
update_post_meta($example,"captain",$change);
}
}

 


?>
</ul></div>

