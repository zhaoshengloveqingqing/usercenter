<?php defined('BASEPATH') or exit('No direct script access allowed');

function smarty_function_login_form($params, $template) {
    if(!check_need_to_show()){
        return '';
    }
	$text = <<<TEXT
	{form action="{uri}/api/login{/uri}"}
		<input type="hidden" name="callback" value="{uri}/api/login_success{/uri}">
		<input type="hidden" name="appid" value="-1">
		{field_group field="username"}
		{/field_group}
		{field_group field="password"}
			{password}
		{/field_group}
		<div class="action">
			{button type="submit" show="primary"}{lang}Submit{/lang}{/button}
			{button type="reset"}{lang}Cancel{/lang}{/button}
		</div>
	{/form}
TEXT;
	return $template->fetch('string:'.$text);
}
