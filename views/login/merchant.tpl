{extends file='base_layout.tpl'}
{block name=head}
    {js position='head'}
    {css}
{/block}
{block name=body}
	<div id="header">
	</div>
    <div id="Absolute-Center">
	    <div class="context">
		    <div class="logo">
			    <img src="{site_url url="application/static/img/admin_login_logo.png"}">
		    </div>
		    <div class="login">
			    <div class="login_info">
				    {form action="{uri}/api/login{/uri}"}
					    <input type="hidden" name="callback" value="{uri}/api/login_success{/uri}">
					    <input type="hidden" name="appid" value="-1">
					    <div class="control-group form-group" >
						    <div class="input-group mobile-phone">
	                            <span class="input-group-addon">
	                                <img src="{site_url url='application/static/img/account.png'}">
	                            </span>
							    <input type="text" name="mobile" value="" class=" form-control" id="field_mobile" placeholder="请输入账号"  />
						    </div>
					    </div>
					    <div class="control-group form-group" >
						    <div class="input-group code">
							    <span class="input-group-addon">
							       <img src="{site_url url='application/static/img/password.png'}">
							    </span>
							    <input type="password" name="mobile" value="" class=" form-control" id="password" placeholder="请输入密码"  />
						    </div>
					    </div>
					    <div class="checkbox">
						    <label>
							    <input type="checkbox"> 下次自动登录
						    </label>
						    <a>忘记账号或密码</a>
					    </div>
					    <input type="submit" value="登录" id="submit" class="btn btn-block pinet-btn-cyan submit-button">
				    {/form}
			    </div>
		    </div>
	    </div>
    </div>
	<div id="footer">
		<div class="lanmu">
			<div class="content">
				<div class="foot_left">
					<ul>
						<li>
							<img src="{site_url url='application/static/img/phone1.png'}">
							{*<resimg data-image="phone1.png">*}
						</li>
					</ul>
				</div>
				<div class="foot_right">
					<ul>
						<li>
							<a>4000-123-456</a>
							<a>4000-123-456</a>
						</li>
							<li>
							<a>4000-123-456</a>
							<a>4000-123-456</a>
						</li>
						<li>
							<a>4000-123-456</a>
							<a>4000-123-456</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="copyright">©Copyright Pinet Technology Solutions 2014</div>
	</div>
{/block}
{block name=foot}
    {js}
	{init_js}

	<script type="text/javascript">

		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
		}).blur(function() {
			var input = $(this);
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
		}).blur();




		$('[placeholder]').parents('form').submit(function() {
			$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
				}
			})
		});


	</script>
{/block}