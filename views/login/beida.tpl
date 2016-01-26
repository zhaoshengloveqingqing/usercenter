{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
    <div class="container">
        {header}
            <div id="head" class="row">
                {figure action='http://www.pinet.co' path='/responsive/size' class='col-320-4 col-1280-3' src=$logo title=$company}
                {/figure}
                {h1 class='col-320-8 col-1280-9'}<span>{lang}Login{/lang}</span>{lang}You can choose the ways below{/lang}{/h1}
            </div>
        {/header}
        {sect id="sms-form"}
            <div id="login" class="row">
                <div class="col-320-12" id="method">
                        {oauth_wechat class='wechat_button'}
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
{/block}
