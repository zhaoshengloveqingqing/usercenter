{extends file='base_layout.tpl'}

{block name=head}
{js position='head'}
{css}
{/block}

{block name=body}
	<div class="container">
	{h1}{$title}{/h1}
	{datatable}
	</div>
{/block}

{block name=foot}
{js}
{/block}
