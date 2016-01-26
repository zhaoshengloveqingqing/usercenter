{extends file='base_layout.tpl'}
{block name=head}
{js position='head'}
{css}
{/block}
{block name=body}
<div class="container">
	<div class="row">
		<h1>Hello</h1>
		{form action="#"}
			{field_group field="test.username" layout=false}
				{input_group}
					{label  class="sr-only"}
					{input}
					<div class="input-group-addon">@</div>
				{/input_group}
			{/field_group}
			{field_group field="test.username"}
			{/field_group}
			{field_group field="test.username"}
				{textarea}
			{/field_group}
			{field_group field="test.username"}
				{password}
			{/field_group}
			{field_group field="test.username"}
				{select options=["A", "B", "C"]}
				{/select}
			{/field_group}
		{/form}
	</div>
</div>
{/block}
{block name=foot}
{js}
{/block}
