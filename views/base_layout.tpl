<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>{$title}</title>
{block name=head}{/block}
</head>
<body>
	{if $has_head}
	{block name=header}{/block}
	{block name=sidebar}{/block}
	{/if}
	{block name=body}{/block}
	{if $has_head}
	{block name=footer}{/block}
	{/if}
</body>
{if isset($use_less_js)}
<script type='text/javascript'>
  less = {
    globalVars: {
      site_base: '"{uri}{/uri}"'
    }
  };
</script>
{/if}
	{block name=foot}{/block}
<script type="text/javascript">
	$(function(){
		if(typeof($.fn.picture) === 'function') { // If added the jquery picture, then picture all the figure
			$('figure, picture').ready(function(){
				$('figure, picture').picture();
			});
		}

		$('.iframe-lazy').each(function(){
			$(this).attr('src', $(this).attr('data-src'));
		});

		if((jQuery.browser && jQuery.browser.mobile) || $('body').width() < 1280) {
			$('body').addClass('mobile');
		}
		else {
			$('body').addClass('pc');
		}
	});
</script>
</html>
