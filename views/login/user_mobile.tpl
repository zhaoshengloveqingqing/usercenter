{extends file="base-layout.tpl"}
	{block name="head"}
		{div id="header_mobile"}
			{div class="top_navbar"}
				{span}您好，欢迎来到翼百网！{/span}
				{span}{a uri="home/index"}返回首页{/a}{/span}
			{/div}
			{div class="top_logo"}
				{div class="navbar"}
					{div class="navbar__brand"}
						{resimg data-image="common-mobile/logo.png"}
					{/div}
					{div class="navbar__section navbar__action"}
						{resimg data-image="common-mobile/phone.png"}
					{/div}
				{/div}
			{/div}
		{/div}
	{/block}
	{block name="main"}
		{form id="login" role="form" novalidate="" accept-charset="utf-8" method="post" action="http://user.pinet.co/api/login"}
			{div class="control-group form-group"}
				{div class="input-group mobile-phone"}
					{label}手机号：{/label}
					{input type="text" name="mobile" value="" class="form-control" id="mobile" placeholder="电话号码"}
				{/div}
			{/div}
			{div class="control-group form-group"}
				{div class="input-group code"}
					{label}验证码：{/label}
					{input type="text" name="validation_code" value="" class=" form-control" id="field_validation_code" placeholder="输入验证码"}
				{/div}
			{/div}
			{div class="otjr"}{div class="register"}{/div}{div id="send" class="get-code" sendsmsurl="{$url}"}获取验证码{/div}{/div}
			{div class="action"}
				<input type="hidden" name="callback" value="http://user.pinet.co/api/login_success">
				<input id="appid" name="appid" type="hidden" value="-1"/>
				{input id="submit" type="submit" disabled="disabled" class="btn login_block_btn pinet-btn-cyan submit-button" value="登录"}
				{a uri="home/index"}{input type="button"  class="back_block_btn" value="返回"}{/a}
			{/div}
			{div class="other_way"}
				{ul id="navlist"}
					{li class="list1"}{/li}
					{li class="list2"}{a href=""}{span}其它方式登录{/span}{/a}{/li}
				{/ul}
				{div class="other_way_login"}
					{a href="http://user.pinet.co/oauth/session/qq/4000"}{resimg data-image="common-mobile/qq.png"}{/a}
					{a href="http://user.pinet.co/oauth/session/weibo/4000"}{resimg data-image="common-mobile/weibo.png"}{/a}
				{/div}
			{/div}
		{/form}
	{/block}
