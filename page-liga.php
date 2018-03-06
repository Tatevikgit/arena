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

<?php

$args = array('post_type'=>'tournaments','posts_per_page'=>100,"cat"=>$g);
$attachments = get_posts( $args );
if ( $attachments ) {
    foreach ( $attachments as $post ) {
        setup_postdata( $post );
		$id = get_the_ID();
		$link = get_permalink();
		$title = get_the_title();
		$excerpt=get_the_excerpt();
		if ( has_post_thumbnail() ) {
    		$tournament_logo= get_the_post_thumbnail($id,"medium");
		}
else {
   		$tournament_logo= '<img class = "imgs" src="' . get_bloginfo( 'stylesheet_directory' ) 
        . '/images/team-logo.png"/>';	
}
	
		
		echo "<div class = 'col-md-12'><div class = 'col-md-4' style = 'margin-top:30px;'><a href = '".$link."' >".$tournament_logo."</a></div>";
		$html = "<div class = 'col-md-8' style = 'margin-top:50px;' ><div class = 'col-md-12'><a href = '".$link."'><span style = 'color:black;font-weight:bold;'> Մրցույթի անուն: </span>".$title."</a></div><div class = 'col-md-12'>".$excerpt."</div><br/></div></div>";	
		
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