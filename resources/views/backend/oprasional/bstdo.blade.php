@extends('backend.app_backend')

@section('css')
	<!-- page specific plugin styles -->
	<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/ui.jqgrid.min.css') }}" />

	<link rel="stylesheet" href="{{ asset('/css/bootstrap-editable.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('/css/typeahead.js-bootstrap.css') }}" />

	<link rel="stylesheet" href="{{ asset('/css/chosen.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.min.css') }}" />
@endsection

@section('breadcrumb')
	<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
      <li>
        <i class="ace-icon fa fa-home home-icon"></i>
        <a href="{{url('')}}">Home</a>
      </li>

      @foreach(array_reverse($aktif_menu) as $row)
      <li>
        {!!$row['nama']!!}
      </li>
      @endforeach
    </ul><!-- /.breadcrumb -->
    <div class="nav-search" id="nav-search">
      <form class="form-search">
        <span class="input-icon">
          <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
          <i class="ace-icon fa fa-search nav-search-icon"></i>
        </span>
      </form>
    </div><!-- /.nav-search -->
  </div>
@endsection

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <!-- PAGE CONTENT BEGINS -->

					<form id="dompdf" role="form" method="POST" action="{{ url('oprasional/PDFAdmin') }}" target="_blank">
						{!! csrf_field() !!}
						<input name="page" value="" hidden/>
						<input name="file" value="" hidden/>
						<input name="start" value="" hidden/>
						<input name="bstdo" value="" hidden/>
						<input name="sidx" value="" hidden/>
					</form>

					<div align="center">BSTDO<br />
						<span class="editable" id="psdate"></span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-5">
							<div class="profile-user-info profile-user-info-striped ">
									<div class="profile-info-row">
										<div class="profile-info-name"> No BSTDO </div>

										<div class="profile-info-value">
											<span id="NoBSTDO" data-pk="1" data-placement="right" data-title="No BSTDO"></span>
										</div>
									</div>
									<div class="profile-info-row">
										<div class="profile-info-name"> LIST PPJK </div>

										<div class="profile-info-value">
											<select id="ppjk" class="multiselect" multiple="">
												<option value=""></option>
											</select>
										</div>
									</div>
							</div>
						</div>
					</div>

					<table id="grid-table"></table>
					<div id="grid-pager"></div>
          <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
      </div><!-- /.row -->
@endsection

@section('js')
	<script src="{{ asset('/js/jquery-ui.min.js') }}"></script>

	<script src="{{ asset('/js/moment.min.js') }}"></script>
	<script src="{{ asset('js/jquery.jqGrid.min.js') }}"></script>
	<script src="{{ asset('js/grid.locale-en.js') }}"></script>

	<script src="{{ asset('/js/bootstrap-editable.min.js') }}"></script>
	<script src="{{ asset('/js/ace-editable.min.js') }}"></script>

	<script src="{{ asset('/js/typeahead.js') }}"></script>
	<script src="{{ asset('/js/typeaheadjs.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>

	<script src="{{ asset('/js/chosen.jquery.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-multiselect.min.js') }}"></script>
	<script type="text/javascript">

	jQuery(function($) {
		//editables on first profile page
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="ace-icon fa fa-check"></i></button>'+
                                '<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';

		$('#psdate').html(moment().format('D MMMM YYYY'));
		$('#psdate').editable({
				type: 'adate',
				date: {
						//datepicker plugin options
								format: 'dd MM yyyy',
						viewformat: 'dd MM yyyy',
						 weekStart: 1

						//,nativeUI: true//if true and browser support input[type=date], native browser control will be used
						//,format: 'yyyy-mm-dd',
						//viewformat: 'yyyy-mm-dd'
				}
		}).on('save', function(e, params) {
				// $(grid_selector).jqGrid('setGridParam',{postData:{start:params.newValue}}).trigger("reloadGrid");
				// // $('input[name="start"]').val(params.newValue);
				setdate = params.newValue;
		});
		var setdate = moment().format('D MMMM YYYY');

		var nobstdo = '';
		var posdata= {'datatb':'ppjk', _token:'{{ csrf_token() }}'};
		$.ajax({
			type: "POST",
		  url: "{{url('/api/oprasional/json')}}",
			data: posdata,
		  async: false,
		  success: function(data) {
				var No = new Array();
				$.each(data, function (idx, obj) {
					No.push(data[idx].bstdo);
				});
				No.sort();
				$('#NoBSTDO')
					// .editable('setValue',No[0])
					.val(No[0])
					.html(No[0]);
				nobstdo = $('#NoBSTDO').html();
				get_ppjk(No[0]);
		  }
		});

		$('#NoBSTDO').editable({
			type:'typeaheadjs',
			success: function(response, newValue) {
        // if(response.status == 'error') return response.msg; //msg will be shown in editable form
				get_ppjk(newValue);
				$(grid_selector).jqGrid('setGridParam',{postData:{bstdo:newValue}}).trigger("reloadGrid");
			},
			typeahead: {
				name: 'bsto',
				remote: {
			    wildcard: '%QUERY',
			    url: "{{url('/api/oprasional/autoc')}}?datatb=bstdo&cari=%QUERY",
			  }
			}
		});


		if(!ace.vars['touch']) {
			$('.chosen-select').chosen({
				allow_single_deselect:true,
			});
			//resize the chosen on window resize

			$(window)
			.off('resize.chosen')
			.on('resize.chosen', function() {
				$('.chosen-select').each(function() {
					var $this = $(this);
						$this.next().css({'width': '100%'});
					})
			}).trigger('resize.chosen');
			//resize chosen on sidebar collapse/expand
			$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
				if(event_name != 'sidebar_collapsed') return;
				$('.chosen-select').each(function() {
					var $this = $(this);
					$this.next().css({'width': '100%'});
				})
			});

			$('#chosen-multiple-style .btn').on('click', function(e){
				// var target = $(this).find('input[type=radio]');
				// var which = parseInt(target.val());
				// if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
				// else $('#form-field-select-4').removeClass('tag-input-style');
			});
		};

		$('.multiselect').multiselect({
			enableFiltering: true,
			enableHTML: true,
			buttonClass: 'btn btn-white btn-primary',
			templates: {
				button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> &nbsp;<b class="fa fa-caret-down"></b></button>',
				ul: '<ul class="multiselect-container dropdown-menu"></ul>',
				filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
				li: '<li><a tabindex="0"><label></label></a></li>',
				divider: '<li class="multiselect-item divider"></li>',
				liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
			},
			onChange: function(option, checked, select) {
				postsave = {datatb:'bstdo',id:option.val(),checked:checked,bstdo:$('#NoBSTDO').html()};
				getparameter("{{url('/api/oprasional/cud')}}",postsave,	function(data){
					$(grid_selector).jqGrid('setGridParam',{postData:{bstdo:$('#NoBSTDO').html()}}).trigger("reloadGrid");
				},function(data){});
	    }
		});

		function get_ppjk(setbstdo){
			var posdata= {'datatb':'ppjk', _token:'{{ csrf_token() }}'};
			var $select_elem = $("#ppjk");
			// $select_elem.empty();
			$select_elem.html('');
			getparameter("{{url('/api/oprasional/json')}}",posdata,function(data){
				var No = new Array();
				$.each(data, function (idx, obj) {
					if (data[idx].bstdo == setbstdo){
						$select_elem.append('<option value="'+data[idx].id+'" selected>'+data[idx].ppjk+'</option>');
					} else if (data[idx].bstdo === null && data[idx].lhp !== null){
						$select_elem.append('<option value="'+data[idx].id+'">'+data[idx].ppjk+'</option>');
					}
				});
				$select_elem.multiselect('rebuild');
			},function(data){});
		}
//////////////////////////////////////////////

		var grid_selector = "#grid-table";
		var pager_selector = "#grid-pager";

		var parent_column = $(grid_selector).closest('[class*="col-"]');
		//resize to fit page size
		$(window).on('resize.jqGrid', function () {
			$(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
			})

		//resize on sidebar collapse/expand
		$(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
			if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
				//setTimeout is for webkit only to give time for DOM changes and then redraw!!!
				setTimeout(function() {
					$(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
				}, 20);
			}
			})

		//if your grid is inside another element, for example a tab pane, you should use its parent's width:
		/**
		$(window).on('resize.jqGrid', function () {
			var parent_width = $(grid_selector).closest('.tab-pane').width();
			$(grid_selector).jqGrid( 'setGridWidth', parent_width );
		})
		//and also set width when tab pane becomes visible
		$('#myTab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			if($(e.target).attr('href') == '#mygrid') {
			var parent_width = $(grid_selector).closest('.tab-pane').width();
			$(grid_selector).jqGrid( 'setGridWidth', parent_width );
			}
		})
		*/

		jQuery(grid_selector).jqGrid({
			caption: "Input BSTDO",
      datatype: "json",            //supported formats XML, JSON or Arrray
      mtype : "post",
      postData: {datatb:'dl', bstdo:nobstdo,_token:'{{ csrf_token() }}'},
			url:"{{url('/api/oprasional/jqgrid')}}",
			editurl: "{{url('/api/oprasional/cud')}}",//nothing is saved
			sortname:'ppjk',
			sortorder: 'desc',
			height: 'auto',
			colNames:[' ', 'PPJK','AGEN','Date','Kapal','GRT','LOA','Bendera','Dermaga','OPS','bapp','PC','Tunda','ON','OFF','DD','Ket','Kurs','LSTP','Moring','ppjks_id'],
			colModel:[
				{name:'myac',index:'', width:50, fixed:true, sortable:false, resize:false, align: 'center'},
				{name:'ppjk',index:'ppjk', width:55, sorttype:"int", editable: false},
				{name:'agen',index:'agen',width:45, editable:false, align: 'center'},
				{name:'date',index:'date', width:120,editable: false},
				{name:'kapal',index:'kapal', width:150, editable: false},
				{name:'grt',index:'grt', width:50, editable: false, align: 'right',hidden:true},
				{name:'loa',index:'loa', width:50, sortable:false, align: 'right',hidden:true},
				{name:'bendera',index:'bendera', width:80, editable: false,hidden:true},
				{name:'dermaga',index:'dermaga', width:100, editable: false},
				{name:'ops',index: 'ops', width: 60,editable: false, align: 'center'},
				{name:'bapp',index:'bapp',width:100, editable: false,hidden:true},
				{name:'pc',index: 'pc', width: 40, editable: false, align: 'center'},
				{name:'tunda',index:'tunda',width:100, editable: false},
				{name:'on',index:'on',width:40, editable: false},
				{name:'off',index:'off',width:40, editable: false},
				{name:'dd',index:'dd',width:40, editable: false},
				{name:'ket',index:'ket',width:100, editable: false},
				{name:'kurs',index:'kurs',width:50, editable: false, align: 'center'},
				{name:'lstp',index:'lstp',width:50, editable: true, align: 'center'},
				{name:'moring',index:'moring',width:180, editable: true, align: 'center'},
				{name:'ppjks_id',index:'ppjks_id',width:180, editable: false, hidden:true, align: 'center'}
			],

			viewrecords : true,
			rowNum:10,
			rowList:[10,20,30],
			pager : pager_selector,
			altRows: true,
      multiboxonly: true,

			loadComplete : function() {

				var table = this;
				setTimeout(function(){
					styleCheckbox(table);

					updateActionIcons(table);
					updatePagerIcons(table);
					enableTooltips(table);
				}, 0);
			},

			//,autowidth: true,


			/**
			,
			grouping:true,
			groupingView : {
				 groupField : ['name'],
				 groupDataSorted : true,
				 plusicon : 'fa fa-chevron-down bigger-110',
				 minusicon : 'fa fa-chevron-up bigger-110'
			},
			caption: "Grouping"
			*/

		});
		$(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size



		//enable search/filter toolbar
		//jQuery(grid_selector).jqGrid('filterToolbar',{defaultSearch:true,stringResult:true})
		//jQuery(grid_selector).filterToolbar({});


		//switch element when editing inline
		function aceSwitch( cellvalue, options, cell ) {
			setTimeout(function(){
				$(cell) .find('input[type=checkbox]')
					.addClass('ace ace-switch ace-switch-5')
					.after('<span class="lbl"></span>');
			}, 0);
		}
		//enable datepicker
		function pickDate( cellvalue, options, cell ) {
			setTimeout(function(){
				$(cell) .find('input[type=text]')
					.datepicker({format:'yyyy-mm-dd' , autoclose:true});
			}, 0);
		}


		//navButtons
		jQuery(grid_selector).jqGrid('navGrid',pager_selector,
			{ 	//navbar options
				edit: true,
				editicon : 'ace-icon fa fa-pencil blue',
				add: false,
				addicon : 'ace-icon fa fa-plus-circle purple',
				del: false,
				delicon : 'ace-icon fa fa-trash-o red',
				search: false,
				searchicon : 'ace-icon fa fa-search orange',
				refresh: true,
				refreshicon : 'ace-icon fa fa-refresh green',
				view: false,
				viewicon : 'ace-icon fa fa-search-plus grey',
			},
			{
				//edit record form
				//closeAfterEdit: true,
				//width: 700,
				recreateForm: true,
				beforeShowForm : function(e) {
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_edit_form(form);
				},
				onclickSubmit: function () {
					var gsr = $(this).jqGrid('getGridParam','selrow');
					var ppjks_id = $(this).jqGrid('getCell',gsr,'ppjks_id');

		      return { datatb:'lstp', id:ppjks_id, _token:'<?php echo csrf_token();?>'};
		    }
			},
			{
				//new record form
				//width: 700,
				closeAfterAdd: true,
				recreateForm: true,
				viewPagerButtons: false,
				beforeShowForm : function(e) {
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar')
					.wrapInner('<div class="widget-header" />')
					style_edit_form(form);
				}
			},
			{
				//delete record form
				recreateForm: true,
				beforeShowForm : function(e) {
					var form = $(e[0]);
					if(form.data('styled')) return false;

					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_delete_form(form);

					form.data('styled', true);
				},
				onClick : function(e) {
					//alert(1);
				},
				onclickSubmit: function () {
		      return { datatb:'dl',_token:'<?php echo csrf_token();?>'};
		    }
			},
			{
				//search form
				recreateForm: true,
				afterShowSearch: function(e){
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
					style_search_form(form);
				},
				afterRedraw: function(){
					style_search_filters($(this));
				}
				,
				multipleSearch: true,
				/**
				multipleGroup:true,
				showQuery: true
				*/
			},
			{
				//view record form
				recreateForm: true,
				beforeShowForm: function(e){
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
				}
			}
		).jqGrid('navButtonAdd',pager_selector,{
				keys: true,
				caption:"bstdo",
				buttonicon:"ace-icon fa fa-file-pdf-o orange",
				position:"last",
				onClickButton:function(){
					// var data = $(this).jqGrid('getRowData'); Get all data

					$('#dompdf input[name=page]').val('bstdo-dompdf');
					$('#dompdf input[name=bstdo]').val($('#NoBSTDO').html());
					$('#dompdf input[name=start]').val(setdate);
					$('#dompdf input[name=sidx]').val('ppjk');

					// console.log(setdate);

					$('#dompdf').submit();
				}
		})


		$(document).one('ajaxloadstart.page', function(e) {
			$.jgrid.gridDestroy(grid_selector);
			$('.ui-jqdialog').remove();
		});
	});
</script>

@endsection
