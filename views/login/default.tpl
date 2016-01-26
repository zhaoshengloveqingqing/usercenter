{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
    <div id="tip">
        <div class="col-1280-12">
            <div id="alert" class="alert" role="alert">
            </div>
        </div>
    </div>
    <div class="container">
        {header}
            <div id="head" class="row">
                {figure action='http://www.pinet.co' path='/responsive/size' class='col-320-4 col-1280-3' src=$logo title=$company}
                {/figure}
                {h1 class='col-320-8 col-1280-9'}<span>{lang}Login{/lang}</span>{lang}You can choose the ways below{/lang}{/h1}
            </div>
        {/header}
        {sect id="sms-form"}
            <div class="row">
                <div class="col-320-12">
                    {form class='form-horizontal' attr=['novalidate'=>'']}
                    {field_group field='mobile'  layout=false}
                        <div class="input-group mobile-phone">
                                <span class="input-group-addon">
                                    <img src="{site_url url="application/static/img/phone-number-icon.png"}">
                                </span>
                            {input}
                        </div>
                    {/field_group}
                    {field_group field='validation_code' layout=false}
                        <div class="input-group code">
                                <span class="input-group-addon">
                                    <img src="{site_url url="application/static/img/verify-code-icon.png"}">
                                </span>
                            {input}
                        </div>
                        <div id="send" class="btn">
                            {lang}Click to get{/lang}
                        </div>
                    {/field_group}
                        <input type="hidden" name="callback" value="{site_url url='api/login_success'}">
                        <input id="appid" name="appid" type="hidden" value="-1"/>
                        <input id="submit" type="submit" disabled="disabled" class="btn pinet-btn-cyan submit-button" type="button" value="{lang}Submit{/lang}"/>
                    {/form}
                </div>
            </div>
            <div id="login" class="row">
                <div class="col-320-12 mobile-head">
                    <p>
                        {lang}You can also choose the ways below{/lang}
                    </p>
                </div>
                <div class="col-320-12" id="method">
                        {oauth_weibo  class='weibo_button'}
                        {oauth_qq class='qq_button'}
                        {oauth_wechat class='wechat_button'}
                        {oauth_yixin class='yixin_button'}
                </div>
            </div>
        {/sect}
    </div>
    {footer}
        <div id="foot">
            <div id="legal" class="row">
                {lang}Provide to you by{/lang}{link uri='http://www.pinet.co'}{figure src='pinet_footer_logo.png'
                media320='32' media480='48' media640='64'  media720='72' title='Pinet'}{/figure}{/link}{lang}Suzhou Pinet Network Technology Co., Ltd.{/lang}
            </div>
        </div>
    {/footer}

{/block}
{block name=foot append}
    {js}
    {init_js}
    <script type="text/javascript">
        function initialise () {
            hideAlertTip();
            $('#sms-btn').on('click', function(e){
                $.ajax({
                    type: "POST",
                    url: "{site_url url='signin/send_code'}",
                    dataType: "json",
                    success : function(data){
                        if(data.success){
                            alert(data.msg);
                        }
                    }
                });
            })
            $("#alert").hide();

            var counter = 60;
            var handle = null;
            var timeout = null;

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
            } );
        }
    </script>
{/block}
