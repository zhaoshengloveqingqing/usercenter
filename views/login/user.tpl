{extends file='base_layout.tpl'}
{block name=head}
	{div class="header"}
		{div class="navbar"}
			<img src="{site_url url="application/static/img/logo.png"}">
			<img class="phone" src="{site_url url="application/static/img/phone.png"}">
		{/div}
	{/div}
	{css}
{/block}
{block name=body}
    {*<div id="Absolute-Center">*}
        {*<div class="logo col-320-4 col-1280-5">*}
            {*<div class="info">*}
                {*<img src="{site_url url="application/static/img/logo.png"}">*}
                {*<h3>{lang}Welcome{/lang}</h3>*}
                {*<p>{lang}It's cold outside,enter!{/lang}</p>*}
                {*<div>*}
                    {*<ul>*}
                        {*<li>{lang}Create you account{/lang}</li>*}
                        {*<li>{lang} Add content for each days{/lang}</li>*}
                        {*<li>{lang}Share it to the world{/lang}</li>*}
                    {*</ul>*}
                {*</div>*}
            {*</div>*}
        {*</div>*}
        {*<div class="login col-320-8 col-1280-7">*}
            {*<div class="login_info">*}
                 {*<h3>{lang}Login{/lang}</h3>*}
                {*{form class='form-horizontal' attr=['novalidate'=>'']}*}
                    {*{field_group field='mobile'  layout=false}*}
                        {*<div class="input-group mobile-phone">*}
                            {*<span class="input-group-addon">*}
                              {*<img src="{site_url url="application/static/img/phone-number-icon.png"}">*}
                            {*</span>*}
                            {*{input}*}
                        {*</div>*}
                    {*{/field_group}*}
                    {*{field_group field='validation_code' layout=false}*}
                        {*<div class="input-group code">*}
                            {*<span class="input-group-addon">*}
                                {*<img src="{site_url url="application/static/img/verify-code-icon.png"}">*}
                            {*</span>*}
                            {*{input}*}
                        {*</div>*}
                        {*<div id="send" class="btn">*}
                            {*{lang}Click to get{/lang}*}
                        {*</div>*}
                    {*{/field_group}*}
                    {*<input type="hidden" name="callback" value="{site_url url='api/login_success'}">*}
                    {*<input id="appid" name="appid" type="hidden" value="-1"/>*}
                    {*<p>*}
                        {*<input id="submit" type="submit" disabled="disabled" class="btn pinet-btn-cyan submit-button" type="button" value="{lang}Submit{/lang}"/>*}
                        {*<span>{lang}or login with{/lang}</span>*}
                        {*{oauth_weibo  class='weibo_button'}*}
                        {*{oauth_qq class='qq_button'}*}
                    {*</p>*}
                {*{/form}*}
            {*</div>*}
        {*</div>*}
    {*</div>*}
	{div class="content"}
		{div class="promotion-banner"}
			<img class="phone" src="{site_url url="application/static/img/login_bg.png"}">
		{/div}
		{div class="promotion-login"}
			{form class='form-horizontal' attr=['novalidate'=>'']}
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							{*<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>*}
							<h4 class="modal-title" id="myModalLabel">{lang}用户登录{/lang}</h4>
						</div>
						<div class="modal-body">
							<div class="control-group form-group" >
								<div class="input-group mobile-phone">
			                            <span class="input-group-addon">
		                                    <img src="{site_url url='application/static/img/phone-number-icon.png'}">
			                            </span>
									<input type="text" name="mobile" value="" class=" form-control" id="field_mobile" placeholder="手机账号登录"  />
								</div>
							</div>
							<div class="control-group form-group" >
								<div class="input-group code">
			                            <span class="input-group-addon">
			                                <img src="{site_url url='application/static/img/verify-code-icon.png'}">
			                            </span>
									<input type="text" name="validation_code" value="" class=" form-control" id="field_validation_code" placeholder="验证码"  />
								</div>
								<div id="send" class="btn">
									获取验证码
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<p>
								<input id="submit" type="submit" disabled="disabled" class="btn pinet-btn-cyan submit-button" type="button" value="{lang}Submit{/lang}"/>
								{*<input type="submit" value="登录" id="submit" class="btn pinet-btn-cyan submit-button" disabled>*}
								<a href="http://user.pinet.co/oauth/session/qq/4000" class="qq_button">QQ登录</a>
								<a href="http://user.pinet.co/oauth/session/weibo/4000" class="weibo_button">微博登录</a>
							</p>
							<input type="hidden" name="callback" value="http://user.pinet.co/api/login_success">
							<input id="appid" name="appid" type="hidden" value="-1"/>
						</div>
					</div>
				</div>
			{/form}
		{/div}
	{/div}
{/block}
{block name=foot append}
	{div class="copyright"}
		©Copyright Pinet Technology Solutions 2014
	{/div}
    {js}
    {init_js}
    <script type="text/javascript">
        function initialise () {
            hideAlertTip();
            $("#alert").hide();

            var counter = 60;
            var handle = null;
            var timeout = null;

	        function onMobileValid() {
		        alert('激活码发送成功，60秒内未收到请重新获取');
	        }

	        function onNotMobileValid() {
		        alert('请输入正确的手机号');
	        }

            function showTip(tip) {
                clearTimeout(timeout);
                $("#alert").text(tip);
                $("#alert").show();
            }

            function showAlertTip(tip) {
                clearTimeout(timeout);
                $("#alert").text(tip);
                $("#alert").show();
                timeout = setTimeout(function(){
                    $("#alert").text('').hide();
                }, 2000);
            }

            function hideAlertTip() {
                clearTimeout(timeout);
                $("#alert").text('').hide();
            }

            function count_down() {
                clearTimeout(handle);
                if(counter-- == 1) {
                    $("#alert").hide();
                    $("#send").removeAttr("disabled").text("重新发送");
                    counter = 60;
                    return;
                }

                $("#send").text("倒计时 " + counter);
                handle = setTimeout(count_down, 1000);
            }

            function isMobileValid(mobile) {
                if(mobile.length==0) {
                    return false;
                }
                if(mobile.length!=11) {
                    return false;
                }
                return !!mobile.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{literal}{8}{/literal}$/);
            }

            function isVerificationCode(code) {
                return !!String(code).match(/^\d{literal}{6}{/literal}$/);
            }

            $("#send").click(function(){
                var mobile = $(".mobile-phone input").val();
                if(isMobileValid(mobile)) {
                    showAlertTip('激活码发送成功，60秒内未收到请重新获取');
                    count_down();
                    $.ajax({
                        type: "POST",
                        url: "{site_url url='api/send_code'}",
                        data: { mobile: $('#field_mobile').val() },
                        dataType: "json",
                        success : function(data){
                            if(data.success){
                                $("#field_validation_code").data('code', data.msg);
                            }else{
                                showTip(data.msg);
                                $("#send").removeAttr("disabled").text("重新发送");
                                clearTimeout(handle);
                            }
                            $("#send").attr("disabled", "disabled");
                        }
                    });
                }
                else {
                    showAlertTip('请输入正确的手机号');
                }
            });

            $("#field_mobile").focus(function(){
                hideAlertTip();
            });

            $("#field_validation_code").focus(function(){
                hideAlertTip();
            });

            $("#field_mobile").keyup(function(){
                var mobile = $("#field_mobile").val();
                if(isMobileValid(mobile)) {
                    $("#alert").hide();
                }
            });

            function checkCode(show) {
                var codeVal = $("#code").val();
                var mobileVal = $("#mobile").val();
                if(isMobileValid(mobileVal)) {
                    if (isVerificationCode(codeVal)) {
                        $("#alert").hide();
                        $("#submit").removeAttr("disabled");
                    }else{
                        $("#submit").attr("disabled", "disabled");
                        if (show) {
                            showAlertTip('验证码格式不正确, 验证码是6位有效数字');
                        };
                    }
                }
            }

            $("#field_validation_code").on('keyup', function() {
                var val = $(this).val();
                if($("#field_validation_code").data('code')) {
                    if(val != $("#field_validation_code").data('code')) {
                        $("#submit").attr("disabled", "disabled");
                    }else {
                        $("#submit").removeAttr('disabled');
                    }
                }
            });
        }




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
	{*<script type="text/javascript">*}
		{*var counter = 60;*}
		{*var handle = null;*}
		{*var timeout = null;*}

		{*function onMobileValid() {*}
			{*alert('激活码发送成功，60秒内未收到请重新获取');*}
		{*}*}

		{*function onNotMobileValid() {*}
			{*alert('请输入正确的手机号');*}
		{*}*}
{*//*}
{*//		function onCodeFailed() {*}
{*//			alert('验证码输入错误');*}
{*//		}*}

		{*$("#send").click(function(){*}
			{*var mobile = $(".mobile-phone input").val();*}
			{*function isMobileValid(mobile) {*}
				{*if(mobile.length==0) {*}
					{*return false;*}
				{*}*}
				{*if(mobile.length!=11) {*}
					{*return false;*}
				{*}*}
				{*return !!mobile.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{literal}{8}{/literal}$/);*}
			{*}*}

			{*function count_down() {*}
				{*clearTimeout(handle);*}
				{*if(counter-- == 1) {*}
{*//					$("#alert").hide();*}
					{*$("#send").removeAttr("disabled").text("重新发送");*}
					{*counter = 60;*}
					{*return;*}
				{*}*}

				{*$("#send").text("倒计时 " + counter);*}
				{*handle = setTimeout(count_down, 1000);*}
			{*}*}


			{*if(isMobileValid(mobile)) {*}
				{*onMobileValid();*}
				{*count_down();*}
				{*$.ajax({*}
					{*type: "POST",*}
					{*url: "{site_url url='api/send_code'}",*}
					{*data: { mobile: $('#field_mobile').val() },*}
					{*dataType: "json",*}
					{*success : function(data){*}
						{*if(data.success){*}
							{*$("#field_validation_code").data('code', data.msg);*}
						{*}else{*}
							{*onCodeFailed();*}
							{*$("#send").removeAttr("disabled").text("重新发送");*}
							{*clearTimeout(handle);*}
						{*}*}
						{*$("#send").attr("disabled", "disabled");*}
					{*}*}
				{*});*}
			{*}*}
			{*else {*}
{*//				showAlertTip('请输入正确的手机号');*}
				{*onNotMobileValid();*}
			{*}*}
		{*});*}






		{*$('[placeholder]').focus(function() {*}
			{*var input = $(this);*}
			{*if (input.val() == input.attr('placeholder')) {*}
				{*input.val('');*}
				{*input.removeClass('placeholder');*}
			{*}*}
		{*}).blur(function() {*}
			{*var input = $(this);*}
			{*if (input.val() == '' || input.val() == input.attr('placeholder')) {*}
				{*input.addClass('placeholder');*}
				{*input.val(input.attr('placeholder'));*}
			{*}*}
		{*}).blur();*}




		{*$('[placeholder]').parents('form').submit(function() {*}
			{*$(this).find('[placeholder]').each(function() {*}
				{*var input = $(this);*}
				{*if (input.val() == input.attr('placeholder')) {*}
					{*input.val('');*}
				{*}*}
			{*})*}
		{*});*}


	{*</script>*}
{/block}
