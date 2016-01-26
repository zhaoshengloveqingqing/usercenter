function getIframeState() {
	var key = 'datatable_iframe_states_';
	key += window.location.pathname;
	return JSON.parse(localStorage.getItem(key));
}

function saveIframeState(state) {
	var key = 'datatable_iframe_states_';
	key += window.location.pathname;
	localStorage.setItem(key, JSON.stringify(state));
}

var iframe_containers = [];
iframe_containers.state = {};
if(getIframeState()){
	iframe_containers.state = getIframeState();
}

function datatable_action_column(data, type, row, meta) {
	var actionUrl = datatable_conf.columns[meta.col].action;
	var refer = datatable_conf.columns[meta.col].refer;
	if(refer) {
		if(actionUrl)
			return "<a data-id='" + row[refer] + "' href='"+ actionUrl + "/" + row[refer] +"'>"+ data +"</a>"
		else
			return "<a class='no_text_decoration' data-id='" + row[refer] + "'>"+ data +"</a>"
	}
	return "<a href='"+ actionUrl + "/" + data +"'>"+ data +"</a>"
}

function datatable_toggle_column(data, type, row, meta) {
	var actionUrl = datatable_conf.columns[meta.col].action;
	var refer = datatable_conf.columns[meta.col].refer;
	if(refer) {
		return "<a class='btn btn-default datatable-toggle' data-id='"+data+"' href='"+ actionUrl + "/" + row[refer] +"?nohead=true'>"+ data +"</a>"
	}
	else
		return "<a class='btn btn-default datatable-toggle' data-id='"+data+"' href='"+ actionUrl + "/" + data +"?nohead=true'><i class='glyphicon glyphicon-chevron-down'></i></a>"
}

// Begin the Datatable initialise script
$('#datatable').on('click', '.datatable-toggle', function(e){
	e.preventDefault();

	var tr = $(this).parentsUntil('tr').parent();
	var td_length = tr.children('td').length;
	var tbody = tr.parent();
	var index = $(this).attr('data-id');
	var iframe;
	var iframe_td;
	var iframe_container;

	iframe_container = iframe_containers[index];
	if(iframe_container) {
		iframe = iframe_container.iframe;				
	}

	if($(this).hasClass('datatable-toggled')) {
		$(this).html("<i class='glyphicon glyphicon-chevron-down'></i>");
		$(this).removeClass('datatable-toggled');
		var state = new Object();
		state.opened = false;
		iframe_containers.state["iframe"+index] = state; 
		saveIframeState(iframe_containers.state);
		iframe.animate({
			"height":"0px",
			"display":"none"
		}, 1000);
	}
	else {
		$(this).html("<i class='glyphicon glyphicon-chevron-up'></i>");
		$(this).addClass('datatable-toggled');

		var is_iframe_initialised = tbody.find('tr#datatable-iframe-container-'+index).length;
		if(!is_iframe_initialised) {
			iframe_container = $('<tr></tr>');
			iframe_container.attr('id','datatable-iframe-container-'+index);
			iframe_container.attr('class','datatable-iframe-container');		
			iframe_td = $('<td></td>')
			iframe_td.attr('colspan',td_length);
			iframe = $('<iframe/>').attr('src', $(this).attr('href')).addClass('datatable-toggle-frame');
			iframe_div = $('<div/>');

			iframe_td.append(iframe);	
			iframe_container.append(iframe_td);
			tr.after(iframe_container);
			// iframe_container.hide();
			iframe.on('load', function(){
				iframe_container.show();
				var doc = iframe.contents();
				doc.find('body').attr('trid', 'datatable-iframe-container-'+index);
				doc.find('body').addClass('iframe');

				$(this).trigger('iframe.ready', [iframe, doc]);

				iframe.animate({
					"height":"450px",
					"display":"block"
				}, 1000);
			});

			iframe_container.iframe = iframe;
			iframe_containers[index] = iframe_container;
		}else {
			iframe.animate({
				"height":"450px",
				"display":"block"
			}, 1000);				
		}				
		var state = new Object();
		state.opened = true;
		iframe_containers.state["iframe"+index] = state; 
		saveIframeState(iframe_containers.state);				
	}
	return false;
});
$('#datatable').on('click', 'tr', function(){
	$(this).addClass('ui-selected').siblings().removeClass('ui-selected');
});


// $('#datatable').ready(function(){
// 	$('#datatable').find('.datatable-toggle').eq(0).trigger('click');
// });
// End Make datatable selectable
// End the datatable initialse script
