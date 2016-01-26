{extends file='base_layout.tpl'}

{block name=head}
{css}
{/block}

{block name=foot}
{js}
{/block}

{block name=body}
	<div class="container">
		<div class="row">
			{field_group field='province'}
				{select}{/select}
			{/field_group}
			{field_group field='city'}
				{select}{/select}
			{/field_group}
		</div>
	</div>
{/block}
