<footer id="colophon" class="<?php thim_footer_class();?>">
	<?php if ( is_active_sidebar( 'footer' ) ) : ?>
		<div class="footer">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php do_action('thim_copyright_area'); ?>

</footer><!-- #colophon -->
</div><!--end main-content-->

<?php do_action( 'thim_end_content_pusher' ); ?>

</div><!-- end content-pusher-->

<?php do_action( 'thim_end_wrapper_container' ); ?>


</div><!-- end wrapper-container -->

<?php wp_footer(); ?>
<script>
		$('#my_image_upload').click(function(){
	$('#avat').animate({background:"green"});
});
$('#my_team_upload').click(function(){
	$('#log').animate({background:"green"});
});

	$(".custom_field_user_role").change(function(){
		var v  = $(".custom_field_user_role").val();
        

          if(v=="captain"){
          //  $("#teams_select").fadeOut();
            // $("#span_teams").fadeOut();
$("#span_team").fadeIn();
$(".game").fadeIn();
			var team = $("<input type = 'text' name = 'team' id = 'team' placeholder = 'Team name...' style = '    margin-left: 39px;'>");
			$(".team_name").append(team);
            
			
		}else{
//$("#teams_select").css("margin-left", "14px");
           // $("#teams_select").fadeIn();
            
         //   $("#span_teams").fadeIn();
$(".game").fadeOut();
            $("#span_team").fadeOut();
           $("#team").fadeOut(500,function(){$("#team").remove();});
		}

      
	});
	$('#tab-happening').append("<div class = 'our_teams'>Հարգելի խմբի մասնակիցներ, գալիք մրցույթին մասնակցելու են առաջին 16 գրանցված թիմերը, շատ ցանկալի է որ բոլոր ժամանակին ներկայացնեն իրենց թիմերի կազմերը և ժամանակին կազմեն թիմերը. պատրաստվեք գալիք մրցույթին, պատրաստվեք միասին որպեսզի բարձրորակ մրցակցություն ցուցաբերեք և հետաքրքիր խաղ տեսնենք բոլորով, NOUT ARENA, բոլոր հարցերով խնդրում ենք դիմել <a href='mailto:gaming@nout.am' target='_blank' rel='noopener'>gaming@nout.am</a> հասցեով:<br><a href=' https://arena.nout.am/gamers-and-teams/' target='_blank' rel='noopener'>Մեր գրանցվաց թիմերը</a></div>");


$('#tab-upcoming').append("<div class = 'our_events'><span id = 'soon'>ՇՈՒՏՈՎ</span></div>");
var a = document.getElementById("wppb_register_pre_form_message");
	var last_click;
	if(a!=null){
		document.getElementById("wppb_register_pre_form_message").innerHTML = "Կարող եք գրանցել նոր TEAM կամ գրանցվել որպես GAMER";
	}
	$(".relative_li").hover(function(){
	
	$(this).children().eq(1).stop().slideToggle(400);
});
	$('.team_names').hover(function(){
    $(this).children().eq(0).stop().slideToggle(400);
});
	
$('#text-11').css({"float": "right", "margin-right": "27px"});

$(".profile").css("display","none");

$(".upform").change(function(){
	$(this).parent().submit();
});
//$("#wp-admin-bar-my-account").children().html("barev");
//$("#wp-admin-bar-edit-profile").children().html("popoxel tvyalner@");


$(".lp-form-field-wrap li:last-child").css("display","none");
var a = $('#team_lead');
$('#app').prepend(a);





 $('#c80').css({"display":"block"});

$('#k80').click(function(){
	 $('#c81').css({"display":"none"});
	 $('#k81').css({"border":"1px solid rgb(238, 238, 238)"});
	 $('#c82').css({"display":"none"});
	 $('#k82').css({"border":"1px solid rgb(238, 238, 238)"});
     $('#c80').css("display","block");
	 $('#k80').css({"border-left":"1px solid rgb(238, 238, 238)","border-right":"1px solid rgb(238, 238, 238)","border-bottom":"1px solid rgb(238, 238, 238)","border-top":"3px solid #55f502"});

})


$('#k81').click(function(){
	 $('#c80').css({"display":"none"});
	 $('#k80').css({"border":"1px solid rgb(238, 238, 238)"});
	 $('#c82').css({"display":"none"});
	 $('#k82').css({"border":"1px solid rgb(238, 238, 238)"});
	 $('#c81').css({"display":"block"});
	 $('#k81').css({"border-left":"1px solid rgb(238, 238, 238)","border-right":"1px solid rgb(238, 238, 238)","border-bottom":"1px solid rgb(238, 238, 238)","border-top":"3px solid #55f502"});
})

$('#k82').click(function(){
     $('#c80').css({"display":"none"});
	 $('#k80').css({"border":"1px solid rgb(238, 238, 238)"});
	 $('#c81').css({"display":"none"});
	 $('#k81').css({"border":"1px solid rgb(238, 238, 238)"});
     $('#c82').css("display","block");
     $('#k82').css({"border-left":"1px solid rgb(238, 238, 238)","border-right":"1px solid rgb(238, 238, 238)","border-bottom":"1px solid rgb(238, 238, 238)","border-top":"3px solid #55f502"});
})







</script>
</body>
</html>