{extends file='base_layout.tpl'}
{block name=head}
{css}
{js position='head'}
<style>

</style>
{/block}
{block name=body}
	<div class="container">
		<div class="container-mask"></div>
	<!-- Button trigger modal -->
		<!-- Modal -->
		<div id="login-modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">{lang}Sign in{/lang}</h4>
						<p id="error_msg" class="pull-left prompt-message hidden"></p>
					</div>
					<div class="modal-body">
						<div class="col-1280-8 pinet-form-input">
							<input type="text" name="username" id="username" class="form-control" placeholder="{lang}User Name{/lang}">
							<div class="help-block"></div>
						</div>
						<div class="col-1280-8 pinet-form-input">
							<input type="password" name="password" id="password" class="form-control" placeholder="{lang}Password{/lang}">
							<div class="help-block"></div>
						</div>
						<p class="pull-right"><a class="forget-password-link" href="{site_url url='welcome/forget_password'}">{lang}I forget my password{/lang}</a></p>
					</div>
					<div class="modal-footer">
						<input id="ok-btn" type="button" class="btn btn-cyan ok" value="{lang}OK{/lang}" >
						<button type="reset" class="btn btn-grey cancel">{lang}Cancel{/lang}</button>
					</div>
				</div>
			</div>
		</div>




	</div>
{/block}
{block name=foot}
{js}
{init_js}
<script type="text/javascript">
	function initialise() {
		if($(window)[0].outerWidth > 1280) {
			$("#the_process .nav-content").on('mouseenter','li',function(e){
				var self = $(this);
				self.find('.content').show();
			});

			$("#the_process .nav-content").on('mouseleave','li',function(e){
				var self = $(this);
				self.find('.content').hide();
			});
		}

        var login_modal = $("#login-modal");
        login_modal.on('click', '.cancel', function(e){
        	e.preventDefault();
        	login_modal.modal('hide');
        });

        $("#menu-collapse").on('show.bs.collapse', function(e){
        	$('.container-mask').fadeIn();
        });

        $("#menu-collapse").on('hidden.bs.collapse', function(e){
        	$('.container-mask').fadeOut();
        });

        if($(window)[0].outerWidth < 1280) {
	        $(".navbar-mobile-menu-toggle").on('click', function(e){
	        	if($('.navbar-mobile-menu').is(':hidden')) {
	        		$('.container-mask').show();
	        		$('.navbar-mobile-menu').fadeIn();
	        	}else {
	        		$('.container-mask').hide();
	        		$('.navbar-mobile-menu').fadeOut();
	        	}
	        	return false;
	        });

	        $('.navbar-mobile-menu').on('click', 'li', function(){
	        	$('#nav').css('background-color', 'rgba(0, 0, 0, 0.6)');
	    		$('.container-mask').hide();
	    		$('.navbar-mobile-menu').fadeOut();
	        });
        }
        else {
        	$('#nav').css('position', 'static');
        }

    	function checkTop() {
		if ($(window)[0].outerWidth < 1280) {
			var time = null;
			var showBgTop = 0;

			$('#nav').css('position', 'fixed');
			$('#nav').css('top', 0);
			$(document).scroll(function(e){
				var docScrollTop = parseInt($(document).scrollTop());
				if(docScrollTop > showBgTop) {
					$('#nav').css('background-color', 'rgba(0, 0, 0, 0.6)');
				}
				else {
					$('#nav').css('background-color', 'transparent');
				}
			        	if($('.navbar-mobile-menu').is(':hidden')) {
			        	}else {
			        		clearTimeout(time);
			        		var time = setTimeout(function(){
				        		$('#nav').css('background-color', 'rgba(0, 0, 0, 0.6)');
				        		$('.container-mask').hide();
				        		$('.navbar-mobile-menu').fadeOut();
			        		}, 2000);
			        	}
			});
		}
		else {
			$('#nav').css('position', 'static');
			 $('#nav').css('background-color', 'transparent');
			 $(document).off('scroll');
		}
	    	if ($(window)[0].outerWidth < 1280) {
			if ($(document).scrollTop() > 0) {
				$('#nav').css('position', 'fixed');
				$('#nav').css('top', 0);
				$('#nav').css('background-color', 'rgba(0, 0, 0, 0.6)');
			}
		}
    	}

    	checkTop();
    	$(window).resize(function(){
    		 checkTop();
    	});

        // $("#password").on('keydown', function(e){
        // 	if (true) {
        // 		e.returnValue=false;
        // 		e.cancel = true;
        // 		$("#ok-btn").trigger('click');
        // 	};
        // });
	}

	$(function(){
		// vartop = 0;

    		function checkStickUp() {
				if($(window)[0].outerWidth > 1280) {
					// ?(document ready)
					$(document).ready(function(){
						$('.navbar-wrapper').stickUp({
							parts: {
								0: 'pinet_business',
								1: 'what_is_good_for',
								2: 'how_it_works',
								3: 'case_studies',
								4: 'get_it_now',
								5: 'contact_us',
								6: 'wordpress',
								7: 'contact'
							},
							itemClass: 'menu-item',
							itemHover: 'active'
						});
					});
	    		}
    		}

    		checkStickUp();

    		function checkScrollDir() {

    		}

			$(window).on('resize', function(){
				$(document).off('srcoll').on('scroll', function(){
					var scrollTop = parseInt($(document).scrollTop());
					var firstMenuScrollTop = $('#pinet_business').offset().top;
					var navigationMenuHeight = parseInt($('.stuckMenu').height());
					// if (scrollTop < firstMenuScrollTop) {
					// $('.stuckMenu').css("position","relative");
					// $('#pinet_business').css('margin-top', 0);
					// }
					// else {
					// 	console.log(scrollTop);
					// 	$('.stuckMenu').css("position","fixed");
					// 	$('.stuckMenu').css("top", 0);
					// }
					var navigationMenuScrollTop = firstMenuScrollTop - navigationMenuHeight;
					if (scrollTop < navigationMenuScrollTop) {
						$('.stuckMenu').css("position","relative");
						$('#pinet_business').css('margin-top', 0);
					}
					// else {
					// 	$('.stuckMenu').css("position","fixed");
					// 	$('.stuckMenu').css("top", 0);
					// }
				});
			});


		$('#ok-btn').on('click', function(e){
			$.ajax({
				type: "POST",
				url: "{site_url url='welcome/login'}",
				dataType: "json",
				data: { password: $('#password').val(), username: $('#username').val() },
				success : function(data){
					if(data.success){
						window.location = data.msg;
					}else{
						$('#error_msg').html(data.msg);
						$('#error_msg').removeClass('hidden');
					}
				}
			});
		})
	})
</script>
{/block}