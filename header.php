<?php

/**

* The Header for our theme.

*

* Displays all of the <head> section and everything up till <div id="content">

*

* @package thim

*/
$conn = mysqli_connect("localhost","nout_sub_user","TGynUGVLen","nout_sub_arena");

if(is_user_logged_in())
{
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$find = mysqli_query($conn,"select meta_value from wp_usermeta where meta_key ='team80' and user_id = '$user_id'");
$disp = !mysqli_num_rows($find);
$username_query = mysqli_query($conn,"select user_login from wp_users where ID = '$user_id'");
$userRes = mysqli_fetch_assoc($username_query);
if(isset($_POST["add"])){
if(isset($_POST["team"])){
$team = strtoupper($_POST["team"]);
$roles = $_POST["roles"];
$game = $_POST["game"];
//echo $game;
$name = $userRes['user_login'];

$find_team = mysqli_query($conn,"select * from wp_usermeta where meta_value ='$team'");
if(!mysqli_num_rows($find_team)){


$post_gamer_settings = array(
'post_content'=>"Team:".$team."\nStatus:".$roles,
'post_title'=>$name,
'post_category'=>array($game),
'post_status' => 'publish',
'post_type'=>'gamer');
$post_gamer = wp_insert_post( $post_gamer_settings );
add_post_meta($post_gamer,"status","captain",false);
wp_set_object_terms($post_gamer,$team,'clubtags');
$post_team_settings = array(
'post_title'=>$team,
'post_category'=>array($game),
'post_status' => 'publish',
'post_type'=>'clubs');
$post_t =wp_insert_post( $post_team_settings );
add_post_meta($post_t,"captain",$name,false);
$game_array = array(80,81,82); 
if (($key = array_search($game, $game_array)) !== false) 
{ array_splice($game_array,$key,1); }
add_user_meta($user_id,"role".$game,$roles,false);
add_user_meta($user_id,"team".$game,$team,false);
add_user_meta($user_id,"role".$game_array[0],"gamer",false);
add_user_meta($user_id,"team".$game_array[0],"-",false);
add_user_meta($user_id,"role".$game_array[1],"gamer",false);
add_user_meta($user_id,"team".$game_array[1],"-",false);
header("Location:https://arena.nout.am/my-account-2/");

}else{
echo "Տվյալ թիմը արդեն գոյություն ունի";
//header("Location:https://arena.nout.am/my-account-2/");
}
}else{
//$teams = strtolower($_POST["teams"]);

$roles = $_POST["roles"];
//$game = $_POST["game"];
$post_gamer_settings = array(
'post_title'=>$userRes['user_login'],
'post_status' => 'publish',
'post_type'=>'gamer',
'meta_input' => array(
'status' => 'gamer',
)
);
$post_gamer = wp_insert_post( $post_gamer_settings );
//wp_set_object_terms($post_gamer,$teams,'clubtags');
//$game_array = array(80,81,82); 
//if (($key = array_search($game, $game_array)) !== false) 
//{ array_splice($game_array,$key,1); }
add_user_meta($user_id,"role80",$roles,false);
add_user_meta($user_id,"team80","-",false);
add_user_meta($user_id,"role81","gamer",false);
add_user_meta($user_id,"team81","-",false);
add_user_meta($user_id,"role82","gamer",false);
add_user_meta($user_id,"team82","-",false);
header("Location:https://arena.nout.am/my-account-2/");


}
}
}


?><!DOCTYPE html>

<html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" ></script>

<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>">
<style>
#sidebar{
float: right !important;
}
#delete_request:hover{
background:#f24c0a !important;
transition:all 0.5s ease;
}
#update_request:hover{
background:#55f502 !important;
transition:all 0.5s ease;
}
footer#colophon.has-footer-bottom{
margin-top:200px;
}
#k80, #k81{
width:290px !important;
}
#k81, #k82{
margin-left: 10px ;

}
.events{
margin:0;
}






#c80, #c81, #c82{
padding-top: 30px !important;
min-height:400px;
}
.fixed{
position:fixed !important; 
background: #00000080;
z-index:9999;
display:none;
height:100%;
} 
#form_team{
min-height:500px;
border: 6px solid oldlace;
padding: 30px;
background: white;
margin-top: 200px;
}
.thim-color{
color:#55f502 !important;
}
.title::before{
background-color:#55f502 !important;
}

#wp-submit, #magic-line, .course-readmore{
background:#55f502 !important;
}
.link-bottom a{
color:#55f502 !important;
}
.course-title a:hover{
color:#55f502 !important;
}
.search-toggle:hover{
color:#55f502 !important;

}
.attachment-custom{
height:100px !important;
width:100px !important;
border-radius: 50px;
}
.imgs{
height:100px !important;
width:100px !important;
}
#back-to-top:hover{
background:#55f502 !important;
}
#breadcrumbs li a:hover{
color:#55f502 !important;
}
.thim-list-event .item-event .title a:hover{
color:#55f502 !important;
}
::selection{
background-color:#55f502 !important;
}
::-moz-selection{
background-color:#55f502 !important;
}
input[type=submit]{
background-color:#55f502 !important;
}
.filter-controls li a:hover, .filter-controls li a.active{
border-color: #55f502 !important;
}
.thim-list-event .item-event .time-from{
color: #55f502 !important;
}
.thim-login form#loginform input[type="email"], .thim-login form#loginform input[type="password"], .thim-login form#loginform input[type="text"], .thim-login form#registerform input[type="email"], .thim-login form#registerform input[type="password"], .thim-login form#registerform input[type="text"], .thim-login form#resetpassform input[type="email"], .thim-login form#resetpassform input[type="password"], .thim-login form#resetpassform input[type="text"]{
border: 1px solid #e5e5e5 !important;
}

.lp-course-progress .lp-progress-bar .lp-progress-value, #your-profile ul.learn-press-subtabs li.current:before, .quiz-buttons button:hover, .woocommerce .product_thumb .onsale, .learn-press-question-options > li.answer-option > label input[type="checkbox"]:checked:before, .learn-press-question-options > li.answer-option > label input[type="radio"]:checked:before, .footer-bottom .thim-widget-icon-box:before, .wrapper-lists-our-team .our-team-item .our-team-image:before, .thim-bg-overlay-color-half:before, .thim-bg-overlay-color:before, .thim-testimonial-slider ul.scrollable li:before, .product-grid .product__title a.added_to_cart, .pagination li .page-numbers:hover, .pagination li .page-numbers.current, .loop-pagination li .page-numbers:hover, .loop-pagination li .page-numbers.current, .thim-widget-carousel-categories .content-wrapper, body .vc_tta.vc_tta-spacing-1 .vc_tta-tab .vc_active:before, .lp_pmpro_courses_by_level .level-wrap header .lp_pmpro_title_level:before, .lp_pmpro_courses_by_level .level-wrap footer a, .pmpro-has-access input.pmpro_btn, .pmpro-has-access a.pmpro_btn, #learn-press-form-login input[type=submit], .widget-area.sidebar-events .book-title, .widget-area.sidebar-events .widget_book-event .event_register_foot .event_register_submit, .thim-buy-now-desc:before, #thim-popup-login .thim-login-container .close-popup, .thim-owl-carousel-post.thim-list-posts .info, .thim-timetable-link, .woocommerce-MyAccount-navigation li.is-active:before, .thim-search-light-style .thim-widget-courses-searching .courses-searching button, .thim-button-checkout, .thim-text-title:before, body .vc_tta.vc_general .vc_active .vc_tta-panel-title > a:before, body .vc_tta.vc_general .vc_tta-panel-title:hover > a:before, .thim-widget-courses .view-all-courses.position-bottom, .woocommerce .add_to_cart_button.ajax_add_to_cart, .cssload-loader-inner-style-2, .widget_shopping_cart .minicart_hover .cart-items-number span.wrapper-items-number, .widget_shopping_cart .widget_shopping_cart_content .buttons a:hover, .thim-course-grid .course-item .thim-course-content .course-meta:before, .thim-course-grid .course-item .course-thumbnail > a.course-readmore, #tab-course-review .add-review form button[type=submit], #tab-course-review .review-load-more #course-review-load-more, #tab-course-review .course-rating .detailed-rating .stars > div.bar .full_bar > div, .thim-widget-tab .nav-tabs li.active:before, .wrapper-lists-our-team a.join-our-team, .site-main .widget_text .widget-title:before, .rev_slider_wrapper .tp-bullet.selected, .become-teacher-form button[type=submit], .thim-about-us-quote hr, .thim-login form#loginform input[type=submit], .thim-login form#registerform input[type=submit], .thim-login form#lostpasswordform input[type=submit], .thim-login form#resetpassform input[type=submit], .thim-list-content li:before, .tp-event-archive .entry-content .tp_event_view-detail, .list-tab-event .nav-tabs li.active:before, .profile-tabs .nav-tabs li.active:before, .single-quiz button.check_answer:hover, .single-quiz button.next-question:hover, .single-quiz button.prev-question:hover, .single-quiz button.button-finish-quiz:hover, .single-quiz button.button-start-quiz:hover, .bbpress #bbpress-forums li.bbp-header, .bbpress #bbpress-forums button:hover, .thim-what-it-about-desc .button .thim-button, a.widget-button, .menu-right .thim-link-login a, .thim-join-the-elite-group:before, .thim-join-the-elite-group .thim-widget-button .widget-button.normal, .thim-welcome-university .thim-register-now-form .wpcf7-form .wpcf7-submit, .thim-course-megamenu .course-readmore, #buddypress div.item-list-tabs ul li.selected:before, #buddypress div.item-list-tabs ul li.current:before, #buddypress .bp-avatar-nav ul.avatar-nav-items li.selected:before, #buddypress .bp-avatar-nav ul.avatar-nav-items li.current:before, #buddypress input[type=submit], #buddypress a.button:hover, #buddypress div#item-header div.generic-button > a:hover, li form.ac-form .ac-reply-content .ac-reply-cancel:hover, li form.ac-form .ac-reply-content input[type=submit], .rev-btn.thim-slider-button, form.lp-cart .checkout-button, #learn-press-checkout-user-form #learn-press-checkout-user-register .form-content a, #learn-press-checkout-user-form #learn-press-checkout-user-login ul.form-fields li button, .learn-press .view-cart-button:hover, #learn-press-payment .place-order-action input.button, #learn-press-payment .place-order-action input.button, #learn-press-payment .place-order-action input.button:hover, #learn-press-finish-course, #learn-press-checkout-user-form #learn-press-checkout-user-login ul.form-fields li button, #learn-press-checkout-user-form #learn-press-checkout-user-register .form-content a, .overlay-black .thim-widget-courses-searching .courses-searching button, .event_button_disable, .owl-controls .owl-pagination .owl-page:hover, .owl-controls .owl-pagination .owl-page.active, .thim-widget-icon-box .line-heading, .widget-area aside.WOOF_Widget .woof_container .woof_container_inner:before, .thim-course-landing-button .woocommerce-message a.button, .course-payment .woocommerce-message a.button, form.pmpro_form .lp-pmpro-name, .loop-pagination .page-number, .loop-pagination a:hover .page-number, .blog-switch-layout.blog-grid article .entry-grid-meta:before, .woocommerce-product-search:after, .learn-press-pmpro-buy-membership a.button:hover, .lp-course-progress .lp-progress-bar .lp-progress-value, .grid-horizontal .item-post:nth-child(2n) .article-wrapper, .cssload-loader-style-3 .sk-cube:before, #learn-press-course-curriculum ul.curriculum-sections .section-content .course-lesson.current:after, #learn-press-course-curriculum ul.curriculum-sections .section-content .course-lesson.item-current:after, #learn-press-course-curriculum ul.curriculum-sections .section-content .course-lesson .lesson-preview:hover, #learn-press-course-curriculum ul.curriculum-sections .section-content .course-quiz.current:after, #learn-press-course-curriculum ul.curriculum-sections .section-content .course-quiz.item-current:after, #learn-press-course-curriculum ul.curriculum-sections .section-content .course-quiz .lesson-preview:hover, #your-profile input[type=submit], #course-curriculum-popup #popup-header, #popup_container #popup_title, #popup_panel #popup_ok, #popup_panel #popup_ok:hover, #popup_panel #popup_cancel:hover, #popup_title, .course-content .popup-title, .mfp-content .popup-title, .quiz-buttons .button-hint:hover, .quiz-buttons .button-next-question:hover, .quiz-buttons .button-check-answer:hover, .quiz-buttons .button-prev-question:hover, .lp-pmpro-membership-list .header-item.position-2:before, .cssload-loading i, .learn-press #learn_press_payment_form .learn_press_payment_close .learn_press_payment_checkout:hover, .learn-press .thim-enroll-course-button, .learn-press .course-tabs .nav-tabs li.active:before, .learn-press #finish-course, .learn-press .course-meta > div .value.lp-progress-bar .lp-progress-value, #learn-press-course-curriculum .section-content .course-lesson a.lesson-preview:hover, #learn-press-course-curriculum .section-content .course-quiz a.lesson-preview:hover, .course-content .complete-lesson-button, .thim-course-menu-landing .thim-course-landing-tab li.active:before, .thim-course-list .course-item .thim-course-content .course-readmore a, .woocommerce div.product .woocommerce-tabs .tabs.wc-tabs li.active:before, .woocommerce div.product .woocommerce-tabs .entry-content #reviews #review_form_wrapper .comment-form .form-submit .submit, .woocommerce-page .button:hover, .woocommerce div.product form.cart .button, .woocommerce div.product .onsale, .product_thumb .onsale, .quickview .product-info .right .cart button.button, .product-grid .product__title .title a.button.add_to_cart_button, .product-grid .product__title .title a.added_to_cart, .widget-area aside:before, article .readmore a, .thim-widget-accordion .panel-title a:not(.collapsed):before, .thim-register-now-form .wpcf7-form .wpcf7-submit:hover{
background-color:#55f502 !important;
}
#h1_paragraph{
margin-top: 25px;
background: #55f502;
border: 6px solid white !important;
padding: 15px !important;
text-align: center;
color: white;
border: 3px solid white;
font-size: 30px;
}
#add{
padding: 4px 31px;
color: white;
background: #55f502;
}
.all{
overflow: hidden;
margin-top: 70px;
border: 6px solid white;
}
.game select{
padding: 7px 2px;
}
.custom_field_user_role{
padding: 7px 50px;
}
.teams_select{
margin-top: 15px;
}
.teams_select select{
padding: 7px 39px;
}
.team_name{
margin-top: 15px;
}
.submit{
margin-top: 15px;
}
#team{
padding:5px 6px;
}
#lose_status:hover{
opacity:0.6;
transition:all 0.5s ease;
}
#lose_team:hover{
opacity:0.6;
transition:all 0.5s ease;
}
#add_teams:hover{
opacity:0.6;
transition:all 0.5s ease;
}
.sub-menu{
min-width:200px !important;
background:rgba(0,0,0,.6) !important;
transition:all 0.5s ease;
}
.sub-menu:hover{
background:black !important;
transition:all 0.5s ease;
}
.tc-megamenu-title{
padding-left:26px !important;
color:white !important;
}
.tc-megamenu-title:hover{
font-size:16px;
}
.our_events{
text-align:center;
font-size:80px;
font-weight:bold;
}
#menu-item-7117{
display:none;
}
#menu-item-7089, .page-title-wrapper, #wp-admin-bar-course_profile{
display:none;
}
aside#text-11 textwidget p a{
display:none !important;
}
</style>

<?php wp_head(); ?>

 

<script>

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 

ga('create', 'UA-27933248-1', 'auto');

ga('send', 'pageview');


</script>

 
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-114078858-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-114078858-1');
</script>

 

</head>

<?php 

if(is_user_logged_in()){ ?>
<style>
#toolbar #link-2 .title a, #pg-7085-3{
display: none;
}
#text-11{
display:block;
}
</style>

<?php

} ?>

<body <?php body_class(); ?> id="thim-body">


<div class = "fixed col-md-12" <?php if($disp) echo "style= 'display:block;'" ?> >
<div class = "container">
<form action = "https://arena.nout.am/my-account-2/" method = 'POST' id = "form_team">
<div class = "paragraph col-md-12">
<h1 id = "h1_paragraph">Կարող եք գրանցել նոր TEAM կամ գրանցվել որպես GAMER արդեն գործող TEAM-երում</h1>
</div>
<div class = "all col-md-12">
<div class = "container">
<!-- status and game -->
<div class = "col-md-12">
<div class = "user_role col-md-6" style = " padding-left: 110px;">
<span style = 'font-weight:bold;'>Պաշտոոն: </span>
<select name = "roles" class = "custom_field_user_role">
<option value = "captain">Captain</option>
<option value = "gamer">Gamer</option>
</select>
</div>
<div class = "game col-md-6" style = "padding-left: 110px;">
<span style = 'font-weight:bold;'>Խաղատեսակ: </span>
<select name = "game">
<option value = "80">CS:GO</option>
<option value = "81">DOTA 2</option>
<option value = "82">LEAGUE OF LEGENDS</option>
</select>
</div>
</div>

<!-- team names -->
<div class = "col-md-12">
<div class = "team_name col-md-6" style = " padding-left: 110px;">
<span id = 'span_team' style = 'font-weight:bold;'>Թիմ: </span>
<input type = 'text' name = 'team' id = 'team' placeholder='Թիմի անուն...' style = 'margin-left: 38px;'>
</div>

</div>

<!-- add -->
<div class = "col-md-12">
<div class = "col-md-9"></div>
<div class = "submit col-md-3">
<input type = "submit" name = "add" value = "Գրանցվել" id = "add">
</div>
</div>
</div>
</div>
</form>
</div>
</div>
<?php do_action( 'thim_before_body' ); ?>

 

<div id="wrapper-container" class="wrapper-container">

<div class="content-pusher">

<header id="masthead" class="site-header affix-top<?php thim_header_class(); ?>">

<?php

//Toolbar

if ( get_theme_mod( 'thim_toolbar_show', true ) ) {

get_template_part( 'inc/header/toolbar' );

}

 

//Header style

if ( get_theme_mod( 'thim_header_style', 'header_v1' ) ) {

get_template_part( 'inc/header/' . get_theme_mod( 'thim_header_style', 'header_v1' ) );

}

 

?>

</header>

<!-- Mobile Menu-->

<nav class="mobile-menu-container mobile-effect">

<?php get_template_part( 'inc/header/menu-mobile' ); ?>

</nav>
<div id="main-content">
<div><?php echo $row["meta_value"]."<br>"; ?></div>