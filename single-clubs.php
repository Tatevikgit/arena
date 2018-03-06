<?php
$conn = mysqli_connect("localhost","nout_sub_user","TGynUGVLen","nout_sub_arena");
//mysqli_query($conn,"delete from wp_team_request");

//mysqli_query($conn, "CREATE TABLE wp_team_request (
//id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
//team_id INT(6),
//captain_name VARCHAR(30),
//user_id INT(6),
//team_request BOOLEAN 	DEFAULT '0' NOT NULL
//)");
/**
 * The template for displaying all single posts.
 *
 * @package thim
 */
?>


<div class="page-content">
<?php 

    while(have_posts()){ the_post();
		$team = get_the_title();
		$id = get_the_ID();
//echo $id.",";
		$b = get_the_category();
		$cat_id = $b[0]->cat_ID;
		$captain = get_post_meta($id,'captain',true); 
		if(has_post_thumbnail()){
    		$team_logo= get_the_post_thumbnail($id,"custom",array( 'title' => 'Թիմի լոգո' ));
		}else{
   		$team_logo= '<img src="' . get_bloginfo( 'stylesheet_directory' ) 
        . '/images/team-logo.png" class = "imgs" title = "Թիմի լոգո"/>';	
        }
    }

$html = "";
echo "<div class = 'row' ><div class = 'col-md-3'style = 'width:200px;height:200px !important;overflow:hidden;margin-top: 11px;'>".$team_logo."</div><div class = 'col-md-8'><h3 style = 'font-size:39px;'>".$team."</h3></div></div>";
?>

<div class = 'col-md-12' id = 'app'>
<?php

$current_user = wp_get_current_user();
$user_id = $current_user->ID;




//echo $user_id;
$t = false;
$user_name =$current_user->user_login;
$count = 0;
$user_team = get_user_meta($user_id,"team".$cat_id,true);
$user_status= get_user_meta($user_id,"role".$cat_id,true);
$a = array('post_type'=>'gamer',"tax_query"=>array(array("taxonomy"=>"clubtags","field"=>"slug","terms"=>$team)));
$at = get_posts( $a );
if ( $at ) {
$html.="<div class = 'row'>";
    foreach ( $at as $post ) {
        setup_postdata( $post );
        $gamer_name =get_the_title();
		$team_gamer_id = get_the_ID();
		$author = get_the_author_ID();
		$gamer_role = get_user_meta($author,"role".$cat_id,true);
		
		//if($author==$user_id){$t=true;}
		
		if ( has_post_thumbnail() ) {
    		$user_avatar= get_the_post_thumbnail($team_gamer_id,"custom",array( 'title' => 'Ավատար' ));

		}
else
	if($gamer_role=="gamer"){
   		$user_avatar= '<img src="' . get_bloginfo( 'stylesheet_directory' ) 
        . '/images/avatar.png" class = "imgs"  title = "Ավատար" />';
	}else{
		$user_avatar='<img src="' . get_bloginfo( 'stylesheet_directory' ) 
        . '/images/captain.png" class = "imgs"  title = "Ավատար" />';
	}

if($captain==$gamer_name){echo "<div class = 'col-md-12' id = 'team_lead'><ul><li style = 'list-style:none;margin-top:50px;'><div class = 'col-md-2'>".$user_avatar."</div><div class = 'col-md-8' style = 'margin-top:15px;'><h3 style = '30px;'>".$gamer_name."-CAPTAIN</h3></div></li></ul></div>";

}else{
echo "<div class = 'col-md-12'><ul><li style = 'list-style:none;margin-top:50px;'><div class = 'col-md-2'>".$user_avatar."</div><div class = 'col-md-8' style = 'margin-top:15px;'><h3 style = '30px;'>".$gamer_name."</h3></div></li></ul></div>";

}

		$count++;
		
    }
$html.="</div>";
    wp_reset_postdata();
 }
echo $html;
//echo $captain;


?>


<div class='col-md-12'>
<form method = 'post' action = ''>
<?php 



	if ($captain == '-' && $user_status == 'gamer' && ($user_team == $team || $user_team == '-')){
	echo "<input type='submit' name='becaptain' value ='Դառնալ կապիտան' style = 'color: white;'>";
   
    }


$select_team_request = mysqli_query($conn,"select * from wp_team_request where user_id = '$user_id'");
$abcd = !mysqli_num_rows($select_team_request);

if($count<5 && $user_team=='-' && $abcd){
	echo "<input type='submit' name='jointeam' id = 'join_team' value ='Միանալ թիմին'  style = 'color: white;margin-left: 15px;'>";
    
}

?>
</form>
</div>



<?php


		$current_user_settings = array("post_type"=>"gamer","title"=>$user_name);
		$current_user_post = get_posts($current_user_settings);
		if($current_user_post){
			foreach($current_user_post as $post){
				setup_postdata($post);
				$current_user_post_id = get_the_ID();
			}


		wp_reset_postdata();
		}
		

	


if(isset($_POST["jointeam"])){
$args = array('post_type'=>'clubs', 'title'=>$team);
$attachments = get_posts( $args );
if ( $attachments ) {
    foreach ( $attachments as $post ) {
        setup_postdata( $post );
		$id = get_the_ID();
		$captain = get_post_meta($id,"captain",true); 
		$select_team_request = mysqli_query($conn,"select * from wp_team_request where user_id = '$user_id'");
if(!mysqli_num_rows($select_team_request)){

$my_insert = mysqli_query($conn,"insert into wp_team_request (team_id,captain_name,user_id) VALUES ('$id','$captain','$user_id')");
if($my_insert){
echo "<script>alert('Ձեր ԹԻՄԻՆ միանալու հարցումը հաջողությամբ ուղարկված է,խնդրում ենք սպասել ԿԱՊԻՏԱՆԻ պատասխանին');</script>";
mysqli_query($conn,"update wp_team_request set team_request = '1' where user_id = '$user_id'");
echo "<style>#join_team{display:none;}</style>";
}else{
echo mysqli_error($conn);
}}
//}else{
//echo "dzer harcum@ der ditvac che";
//echo "<style>#join_team{display:none;}</style>";
//}
		//$link = get_permalink();
		//update_user_meta($user_id,"team".$cat_id,$team,"-");
		//wp_set_post_terms($current_user_post_id,$team,"clubtags",true);
		//echo '<meta http-equiv=Refresh content="0;url=index.php?reload=1">';
//echo '<meta http-equiv="refresh" content="0; url='.$link.'" />';
}}}

if(isset($_POST["becaptain"])){
$args = array('post_type'=>'clubs', 'title'=>$team);
$attachments = get_posts( $args );
if ( $attachments ) {
    foreach ( $attachments as $post ) {
        setup_postdata( $post );
		$link = get_permalink();

 update_post_meta($id,"captain",$user_name,"-");
		//global $wpdb;
		 //$wpdb->query("update wp_postmeta set meta_value = '$user_name' where meta_key='captain' and post_id = '9165' ");
		update_user_meta($user_id,"role".$cat_id,"captain","gamer");
   		update_user_meta($user_id,"team".$cat_id,$team,"-");
		wp_set_post_terms($current_user_post_id,$team,"clubtags",true);

//echo '<meta http-equiv=Refresh content="0;url=index.php?reload=1">';
echo '<meta http-equiv="refresh" content="0; url='.$link.'" />';

//var_dump($c);
	}	}}

?>