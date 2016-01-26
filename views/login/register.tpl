{extends file='base_layout.tpl'}
{block name=head}
{css}
{js position='head'}
{/block}
{block name=body}
	<div class="container">
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
						<div class="">
							<ul class="nav navbar-nav navbar-right">
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
						</div><!-- /.navbar-collapse -->

                   					 <!-- Collect the nav links, forms, and other content for toggling -->
						<!-- <div class="collapse navbar-collapse navbar-collapse-nav">
							<ul class="nav navbar-nav">
								<li class="active"><a href="#">Link</a></li>
								<li><a href="#">Link</a></li>
								<li><a href="#">Link</a></li>
							</ul>
						</div> -->
                				</div>
                				 <!-- @End Container Fluid -->
				</nav>
			</div>
			<!-- @End Nav -->
		</div>
		<!-- @END Header -->

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
					{form class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='account/register'}" method="POST"}
						<div class="panel panel-default">
							<div class="panel-heading">{lang}Register{/lang}</div>
							<div class="panel-body">
								<div class="info"> {lang}Personal Information{/lang}</div>
								{field_group field='name' layout=['label' => 2,'element' => 9, 'mobile-label'=>3, 'mobile-element'=>9]}{/field_group}
								{field_group field='email_address' layout=['label' => 2,'element' => 9, 'mobile-label'=>3, 'mobile-element'=>9]}{/field_group}
								{field_group  field='username' layout=['label' => 2,'element' => 9, 'mobile-label'=>3, 'mobile-element'=>9]}{/field_group}
								<div class="row">
									{field_group  field='password' class='col-320-12 col-1280-6' layout=['label' => 4,'element' => 6, 'mobile-label'=> 3,'mobile-element'=> 9]}
									{password}
									{/field_group}
									{field_group field='password_confirm' class='col-320-12 col-1280-6'  layout=['label' => 4,'element' => 6, 'mobile-label'=> 3,'mobile-element'=> 9]} {password}{/field_group}
								</div>
								{field_group  field='mobile'  layout=['label' => 2,'element' => 9, 'mobile-label'=>3, 'mobile-element'=>9]}{/field_group}
								<div class="row">
									{field_group class="col-320-12 col-1280-6 " field='birthday'  layout=['label' => 4,'element' => 6, 'mobile-label'=> 3,   'mobile-element'=> 9]}{/field_group}
									{field_group class="col-320-12 col-1280-6" field='sex'  layout=['label' => 4,'element' => 6, 'mobile-label'=> 3,   'mobile-element'=> 9]}
									{select options=$sexs noselectboxit=true}
									{/select}                     
									{/field_group}
								</div>
								<br><br><br>
								<div class="info"> {lang}Company Information{/lang}</div>
									{field_group  field='contact_company'  layout=['label' => 2,'element' => 9, 'mobile-label'=>3, 'mobile-element'=>9]}{/field_group}
									{field_group  field='contact_street' layout=['label' => 2,'element' => 9, 'mobile-label'=>3, 'mobile-element'=>9]}{/field_group}

								<div class="row">
									{field_group layout=['label' => 4,'element' => 6, 'mobile-label'=> 3,   'mobile-element'=> 9] field='contact_city' class='col-1280-6 col-320-12'}
									{/field_group}
									{field_group  field='contact_postalcode' class='col-1280-6 col-320-12' layout=['label' => 4,'element' => 6, 'mobile-label'=> 3,   'mobile-element'=> 9]}
									{/field_group}

								</div>
								<div class="row">
										{field_group layout=['label' => 4,'element' => 6, 'mobile-label'=> 3, 'mobile-element'=> 9] field='contact_province' class='col-1280-6 col-320-12'} {/field_group}
										{field_group field='contact_country' class='col-1280-6 col-320-12' layout=['label' => 4,'element' => 6, 'mobile-label'=> 3,   'mobile-element'=> 9]}
										{input}
									{/field_group}
								</div>
								{field_group field='contact_profile' layout=false}
									{label class='col-1280-2 col-320-3'}
									{textarea class='col-1280-9 col-320-9'}
								{/field_group}
								{input field='id' type='hidden'}
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
    if($("select").length > 0) {
    	if($(window)[0].outerWidth > 1280) {
        		$("select").selectBoxIt({
        			"autoWidth": false
        		});
    	}
    }  

    $("#field_birthday").datepicker({
        language: "zh-CN",
        format: "yyyy-mm-dd"
    });

    if($.isFunction($.fn.jqBootstrapValidation)) {
        $("input,textarea").not("[type=image],[type=submit],[type=file]").jqBootstrapValidation();
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
		}else {
			$('#nav').css('position', 'static');	
			 $('#nav').css('background-color', 'transparent');
		} 		
    	}

    	checkTop();
    	$(window).resize(function(){
    		 checkTop(); 		 
    	});
})
</script>
{/block}