<?php



/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package thim
 */
?>

<?php while (have_posts()) : the_post();

	get_template_part('content', 'page');
endwhile; // end of the loop.  
	
$g = isset($_GET["g"])?$_GET["g"]:80;
?>
<form action = "" method = "get" id = "gametype" >
<input type = "radio" name = "g" value ="80" class = "r" <?php if($g==80){echo "checked";}?>>CS:GO
<input type = "radio" name = "g" value ="81" class = "r" <?php if($g==81){echo "checked";}?>> DOTA 2
<input type = "radio" name = "g" value ="82" class = "r" <?php if($g==82){echo "checked";}?>> LEAGUE OF LEGENDS
</form>

<div class = "col-md-12">
<div class = "col-md-6">
<a href = 'https://arena.nout.am/liga/' style = 'color: white;display:inline-block;background:#55f502;cursor:pointer;border:3px solid white;margin-top:30px;font-weight: bold;padding:9px;'>Մասնակցել Մրցույթին</a>
</div>
<div class = "col-md-6">
<form action="" method="post" style = "margin-top:30px;">  
	<input type="text" name="term" placeholder= "Որոնել մասնակցին..."/>  
	<input type="submit" value="Որոնել" style = "color: white;"/>  
</form> 

<?php
$conn = mysqli_connect("localhost","nout_sub_user","TGynUGVLen","nout_sub_arena");

if (!empty($_POST['term'])) {
$term = mysqli_real_escape_string($conn,$_POST['term']);     
$sql = mysqli_query($conn,"SELECT `ID` FROM `wp_users` WHERE `user_login` = '$term'"); 
$termses = mysqli_fetch_assoc($sql);
	$user = $termses["ID"];
 $teams = mysqli_query($conn,"SELECT * FROM `wp_usermeta` WHERE (`user_id` = $user AND `meta_key` = 'team80') OR (`user_id` = $user AND `meta_key` = 'team81') OR (`user_id` = $user AND `meta_key` = 'team82')"); 
while($row = mysqli_fetch_assoc($teams)){
if($row["meta_key"]=='team80'){
echo '<span style = "color:black;font-weight:bold;">Թիմի անուն: </span>'.$row["meta_value"]."<span style = 'color:black;font-weight:bold;'> ՄՐՑՈՒՅԹ: </span>CSGO <br>";
}elseif($row["meta_key"]=='team81'){
echo '<span style = "color:black;font-weight:bold;">Թիմի անուն: </span>'.$row["meta_value"]."<span style = 'color:black;font-weight:bold;'> ՄՐՑՈՒՅԹ: </span>DOTA 2 <br>";
}elseif($row["meta_key"]=='team82'){
echo '<span style = "color:black;font-weight:bold;">Թիմի անուն: </span>'.$row["meta_value"]."<span style = 'color:black;font-weight:bold;'> ՄՐՑՈՒՅԹ: </span>LEAGUE OF LEGENDS  <br>";
}
}
}
?>

</div>
 </div>


<?php

$args = array('post_type'=>'clubs','posts_per_page'=>100,"cat"=>$g);
$attachments = get_posts( $args );
if ( $attachments ) {
    foreach ( $attachments as $post ) {
        setup_postdata( $post );
		$id = get_the_ID();
//echo $id."<br>";
		$captain = get_post_meta($id,"captain",true); 
		$gamers_count = get_post_meta($id,"gamer_count",true);
		$link = get_permalink();
		$title = get_the_title();
		if ( has_post_thumbnail() ) {
    		$team_logo= get_the_post_thumbnail($id,"custom",array( 'title' => 'Թիմի լոգո' ));
		}
else {
   		$team_logo= '<img  class = "imgs" src="' . get_bloginfo( 'stylesheet_directory' ) 
        . '/images/team-logo.png" title = "Թիմի լոգո" />';	
}
		$html.=$team_logo;	
		
		echo "<div class = 'col-md-12'><div class = 'col-md-3' style = 'margin-top:30px;'><a href = '".$link."' style = 'color:black;'>".$team_logo."</a></div>";
		$html = "<div class = 'col-md-8' style = 'margin-top:50px;' ><div class = 'col-md-12'><a href = '".$link."' style = 'color:black;'><span style = 'color:black;font-weight:bold;'> Թիմի անուն: </span>".$title."</a></div><div class = 'col-md-12'><span style = 'color:black;font-weight:bold;'>Թիմի կապիտան: </span>".$captain."</div><br/></div></div>";	
		
			echo $html;
   
        
    }
   wp_reset_postdata();
 }

//echo "<h4 style='background:orange'>".$captain."</h4>";
?>
 
<script>
	$(".r").css("margin-left",50+"px");
	$(".r").click(function(){
	$("#gametype").submit();
});
</script>