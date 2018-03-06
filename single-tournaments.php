<?php
/**
 * The template for displaying all single posts.
 *
 * @package thim
 */
?>


<div class="page-content">
<?php 

    while ( have_posts() ){ the_post();
		$tournament_title = get_the_title();
		$tournament_id = get_the_id();
		$b = get_the_category();
		$cat_id = $b[0]->cat_ID;
		the_post_thumbnail();
		the_content();//tournament discription
       
    }

$html = "";
global $wpdb;
?><div class = "col-md-12">
<?php
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_name =$current_user->user_login;
$user_team = get_user_meta($user_id,"team".$cat_id,true);
$user_status= get_user_meta($user_id,"role".$cat_id,true);
//get members of league ids
$sql = "
	select team_name,team_id
	from wp_league_request
	where request_status=1 && league_id = $tournament_id
";
$requests = $wpdb->get_results($sql,ARRAY_N);
$request_team_id = array();
for($i=0;$i<count($requests);$i++){
	$request_team_id[] = $requests[$i][1];
}
if(count($request_team_id)>0){
$a = array("include"=>$request_team_id,"post_type"=>"clubs");
$at = get_posts( $a );
$count = 0;

if ( $at ) {
$html.="<ul>";
    foreach ( $at as $post ) {
        setup_postdata( $post );
        $team_name =get_the_title();
		 $team_id=get_the_ID();

     		if ( has_post_thumbnail() ) {
    		$team_logo= get_the_post_thumbnail($team_id,"medium");
		}
else {
   		$team_logo= '<img src="' . get_bloginfo( 'stylesheet_directory' ) 
        . '/images/team-logo.png" />';	
}
 		$captain=get_post_meta($team_id,"captain",true);
		$html.="<li>".$team_logo.'Team name: '.$team_name."</li>";
		
		$count++;
    }
$html.="</ul>";
   wp_reset_postdata();
 }
echo $html;
//echo "Team captain: ".$captain;
}
?>
</div>

</div><?php
$current_team_settings = array("post_type"=>"clubs","title"=>$user_team);
		$current_team_post = get_posts($current_team_settings);
		if($current_team_post){
			foreach($current_team_post as $post){
				setup_postdata($post);
				$current_team_post_id = get_the_ID();
                $current_team_post_name = get_the_title();
			}
		
		wp_reset_postdata();
		}


?>		
<form method = "post" action = "">
<?php 
$con_league = $wpdb->query("select team_id from wp_league_request where request_status=1 and team_id = '$current_team_post_id'");
$con_this_league = $wpdb->query("select team_id from wp_league_request where  team_id =$current_team_post_id && league_id=$tournament_id");

		if($count<16 && $user_status=="captain" && $con_league==0 && $con_this_league==0){
			echo "<input type='submit' name='joinleague' value ='Միանալ մրցույթին'><br/>";
		}
	
?>
</form>	<?php
if(isset($_POST["joinleague"])){
		//wp_set_post_terms($current_team_post_id,$tournament_title,"clubtags");
	$wpdb->insert("wp_league_request",array("team_id"=>$current_team_post_id,"league_id"=>$tournament_id,"league_name"=>$tournament_title,"team_name"=>$current_team_post_name));
?>
<script>
$("#main").empty();
$("#main").html("Ձեր հայտը հաջողությամբ ուղարկված է,24 ժամվա ընթացքում ադմինիստրատորը կընդունի կամ կմերժի ձեր հայտը:");

</script>
<?php
}
?>