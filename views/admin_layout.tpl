{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body append}
	<div class="container">
    <div class="response-row">
      {if $has_head}
        <div id="nav" class="col-1440-3">
          <nav class='navigations'>
              {block name=navigations}{/block}
              <a class="divide">
                . . .
              </a>
              <a class="language" href="" data-toggle="tooltip" data-placement="right" title="Tooltip on right">
                {picture path='/responsive/size' alt='$title' src='language.png'}
              </a>
              <a class="logoout" href="{site_url url='welcome/logout'}" data-toggle="tooltip" data-placement="right" title="Tooltip on right">
                {picture path='/responsive/size' alt='$title' src='logout.png'}
              </a>              
          </nav>
        </div>
      {/if}
      <div id="main" class="col-1440-9">
        {if $has_head}
          <div class="response-row statebar">
            {block name=statebar}{/block}
          </div> 
        {/if}
        <div class="response-row content">     
          <div class="col-1440-9 workbench">        
            {block name=workbench}{/block}
          </div>
          {if $has_head}
            <div class="col-1440-3 side">
              {block name=aside}{/block}
            </div>
          {/if}
        </div>     
      </div>
    </div>
  </div>
{/block}
{block name=foot}
{js}
<script type="text/javascript">
function datatable_init(options) {
  var defaults = {
    search_selector: "#search-input",
    btn_selector: "#search-btn"
  }

  var op = $.extend(true, defaults, options);

  if ($("#datatable").length > 0) {
    var datatable = $('#datatable').DataTable(); 
    var settings = datatable.settings();

    var search_input_value = "";
    if (settings[0] && settings[0].oPreviousSearch) {
      search_input_value = settings[0].oPreviousSearch.sSearch;
    };

    if ($(op.search_selector).length > 0) {
      var search_input = $(op.search_selector);
      search_input.val(search_input_value);
    };

    datatable.on('draw.dt', function(){
      $('#datatable tbody td').emit();
    });

    $(op.btn_selector).on('click',function(){
      datatable.search(search_input.val()).draw();
    });
  };
}

function resize_scrollcontent_height(context) {
  if (context.find("#main").children('.content').children('.workbench').length > 0) {
      var workbench = context.find("#main").children('.content').children('.workbench');

      var toolbar_height = parseInt(workbench.children('.toolbar').outerHeight(true)) || 0;
      if(toolbar_height == 0) {
        if(workbench.children('.toolbar').find('.faq').length > 0) {
          toolbar_height = parseInt(workbench.children('.toolbar').find('.faq').height());
        }
      }

      var messagebar_height = parseInt(workbench.children('.messagesbar').outerHeight(true)) || 0;
      var scrollcontent_height = parseInt(workbench.children('.scrollcontent').height()) || 0;
      setTimeout(function(){
        workbench.children('.scrollcontent').height(scrollcontent_height - toolbar_height - messagebar_height);
      }, 300);
  };
}

$(function(){
//  $("input").not("[type=submit]").jqBootstrapValidation(); 
  $('#datatable tbody td').emit();
  $('nav.navigations').children('a').tooltip();

  $('nav.navigations').on('click', 'a', function(e){
    e.preventDefault();
    var self = $(e.currentTarget);
    var href = self.attr('href');

    if($("#datatable").length > 0) {
      var datatable = $('#datatable').DataTable(); 
      datatable.search("");
      datatable.state.save();
    }

    setTimeout(function(){
      window.location.href = href;
    }, 300);
  });
  
  $('.faq').tooltip({
    viewport: {
      selector: '.workbench',
      padding: 0
    }
  });
  $('nav.navigations').on('mouseenter','a',function(){
      var self = $(this);
      var picture = $(this).find('picture');
      if(picture.length > 0){
        var img = picture.find('img');
        var imageName = picture.attr('src').replace('.png','');
        var imagePath = img.attr('src').replace(imageName, imageName + '-hover');
        if(!self.hasClass('active')) {
          img.attr('src', imagePath);
        } 
      }       
  }); 
  $('nav.navigations').on('mouseleave','a',function(){
      var self = $(this);
      var picture = $(this).find('picture');
      if(picture.length > 0){
        var img = picture.find('img');        
        var imagePath = img.attr('src').replace('-hover', '');
        if(!self.hasClass('active')) {
          img.attr('src', imagePath);
        }
      }
  }); 
  $(".statebar .info .content").tooltip({
  });
  $(document).ready(function(){
    resize_scrollcontent_height($('body'));
  });

  $(window).resize(function(){
    var workbench = $("#main").children('.content').children('.workbench');
    workbench.children('.scrollcontent').height('100%');
    resize_scrollcontent_height($('body'));
  });

})
</script>
{/block}