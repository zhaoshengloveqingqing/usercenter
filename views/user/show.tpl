{extends file='base_layout.tpl'}

{block name=head}
{js position='head'}
{css}
{/block}

{block name=body}
	<div class="container">
	{h1}{$title}{/h1}
	{form}
		{input field='id' type='hidden'}
		{field_group field='id'}
		{/field_group}
		{field_group field='status'}
		{/field_group}
		{field_group field='create_date'}
		{/field_group}
		<div class="active">
			{button type='submit' show='primary'}Submit{/button}
			{link uri='/user' class='btn btn-default'}Cancel{/link}
		</div>
	{/form}
	</div>
{/block}

{block name=foot}
{js}
{/block}
