{extends file='base_layout.tpl'}
{block name=head}
{css}
{js position='head'}
<style>

</style>
{/block}
{block name=body}
	<div class="container">
	<!-- Button trigger modal -->
		<!-- Modal -->
      		 <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

		<!-- @START Header -->
		<div id="header">
			<!-- @START Nav -->
			<div id="nav">
				<nav class="navbar" role="navigation">
				 <!-- @START Container Fluid -->
				  	<div class="container-fluid">
				   	 <!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse-nav">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#">
								{picture path='/responsive/size' src='logo.png'}
							</a>
						</div>

	                  				<!-- Collect the nav links, forms, and other content for toggling -->
	                  				<!-- @START Navbar Collapse --> 
				                     	 <div class="">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="#" data-toggle="modal" data-target="#login-modal">&nbsp;{lang}Login{/lang}</a></li>
								<li id="language-select-box" class="dropdown language-select-box">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										{lang}Language{/lang}
										<span class="caret"></span>
									</a>
									<ul class="dropdown-menu" role="menu" aria-labelledby="language-select-box">
										<li>
											<form name="setLangChinese" action="{site_url url='welcome/switch_lang'}" method="POST">
												<input type="hidden" name="language" value="chinese" />
												<input class="btn btn-link" type="submit" value="中文">
											</form>
										</li>

										<li>
											<form name="setLangEnglish" action="{site_url url='welcome/switch_lang'}" method="POST">
												<input type="hidden" name="language" value="english" />
												<input class="btn btn-link" type="submit" value="ENGLISH">
											</form>
										</li>
									</ul>
								</li>
							</ul>
				                     	 </div> 	 
						 <!-- @END Navbar Collapse --> 	  
			             		</div>
			             		<!-- @END Container Fluid -->
				</nav>
			</div>
			<!-- @END Nav -->
		</div>

		<!-- @START Send Mail -->

		<div class="center-row" id="send_mail">
			<ul class="nav navbar-nav nav-head">
				<li>
					<div class="response_row messagesbar">
					{alert}
					</div>  
				</li>
			</ul>
			<ul class="nav navbar-nav nav-body">
				<li>
					{form class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='welcome/forget_password'}" method="POST"}
						<div class="panel panel-default">
							<div class="panel-heading">{lang}Forget Password{/lang}</div>
							<div class="panel-body">
								<div class="info"> 
									{lang}Put your email here and will send you a reset password email.{/lang}
								</div>
								{field_group class="email" field='email_address' layout=['label' => 3,'element' => 9, 'mobile-label'=>3, 'mobile-element'=>9]}{/field_group}
								<input class="btn btn-blue" type="submit" value="{lang}Submit{/lang}">
							</div>
						</div>
					{/form}
				</li>
			</ul>
		</div>
		<!-- @END Send Mail -->

		<!-- @START Contact Us -->
		<div id="contact_us" class="center-row">
			<ul class="nav navbar-nav nav-text">
				<li>
					<p>{lang}FIND US{/lang}</p>
				</li>
			</ul>
			<ul id="nav-address" class="nav navbar-nav nav-content">
				<li>
					<p class="info">{lang}Suzhou Office, Creative Industrial Park, 328 Xinghu Street, Industrial District, Suzhou, Jiangsu Province{/lang}</p>
				</li>
				<li>
					<p class="info">{lang}Hefei Office, 241 Anqing Road, Luyang District, Hefei, Anhui Province{/lang}</p>
				</li>
				<li>
					<p class="info">{lang}Wuhan Office, Guizi Garden, Hongshan Distrcit, Wuhan, Hubei Province{/lang}</p>
				</li>
			</ul>
			<ul  id="copyright" class="nav navbar-nav nav-text">
				<li>
					<p class="logo">{picture path='/responsive/size' src='logo_grey.png'}</p>
					<p class="info">©{lang}Copyright Pinet Technology Solutions 2014{/lang}</p>
					<p class="email"><a target="_top" href="mailto:info@pinet.co">info@pinet.co</a></p>
				</li>
			</ul>
			<ul id="sns-link" class="nav navbar-nav nav-content">
				<li>
					<p>{picture path='/responsive/size' src='wechat_login_icon.png'}</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' src='weibo_login_icon.png'}</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' src='qq_login_icon.png'}</p>
				</li>
			</ul>
		</div>
		<!-- @END Contact Us -->
	</div>
{/block}
{block name=foot}
{js}
<script type="text/javascript">
    $(function(){
        var login_modal = $("#login-modal");
        login_modal.on('click', '.cancel', function(e){
            e.preventDefault();
            login_modal.modal('hide');
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


        if($.isFunction($.fn.jqBootstrapValidation)) {
            $("input,select,textarea").not("[type=image],[type=submit],[type=file]").jqBootstrapValidation();
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

    })
</script>
{/block}