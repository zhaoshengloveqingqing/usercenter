{extends file='base_layout.tpl'}
{block name=head}
{js position='head'}
{css}
{/block}
{block name=body}
<div class="container">
	<div class="row">
		{link href='http://www.baidu.com'}
			{banner strategy='bottom' class=['test', 'again'] src='http://www.baidu.com/img/bd_logo1.png'}
		{/link}
	</div>
	<div class="row">
		<h1>Hello</h1>
		{sample}
	</div>
	<div class="row">
		{button_group}
			{button}
			<span class="red">Hello</span>
			{/button}
			{button show='danger'}
			<span class="red">World</span>
			{/button}
			{dropbutton label='Test' items=$items}
			{/dropbutton}
			{dropbutton label='Test' items=$actions}
			{/dropbutton}
			{dropbutton label='Test'}
				<ul class="dropdown-menu" role="menu">
					<li>
						<a href="#">Action</a>
					</li>
					<li>
						<a href="#">Another action</a>
					</li>
					<li>
						<a href="#">Something else here</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">Separated link</a>
					</li>
				</ul>
			{/dropbutton}
		{/button_group}
		<div class="btn-group">
			<button type="button"
			class="btn btn-primary dropdown-toggle"
			data-toggle="dropdown" aria-expanded="false">Action 
			<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu">
				<li>
					<a href="#">Action</a>
				</li>
				<li>
					<a href="#">Another action</a>
				</li>
				<li>
					<a href="#">Something else here</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">Separated link</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-default dropdown-toggle"
			data-toggle="dropdown" aria-expanded="false">Dropdown 
			<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu">
				<li>
					<a href="#">Dropdown link</a>
				</li>
				<li>
					<a href="#">Dropdown link</a>
				</li>
			</ul>
		</div>
	</div>
</div>
{/block}
{block name=foot}
{js}
{/block}
