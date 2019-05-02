@extends('backend.app_backend')

@section('css')
	<!-- page specific plugin styles -->
	<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" />
	<link href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/daterangepicker.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/ui.jqgrid.min.css') }}" />

	<link href="{{ asset('/css/bootstrap-editable.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-multiselect.min.css') }}" rel="stylesheet">

	<link href="{{ asset('/css/chosen.min.css') }}" rel="stylesheet">
	<style>
		.ui-autocomplete { position: absolute; cursor: default; z-index: 1100 !important;}
	</style>
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

					<div align="center">L H P<br />
							<span class="editable" id="psdate"></span>
					</div>
					</br>
					<form id="dompdf" role="form" method="POST" action="{{ url('oprasional/PDFAdmin') }}" target="_blank">
						{!! csrf_field() !!}
						<input name="page" value="" hidden/>
						<input name="file" value="" hidden/>
						<input name="start" value="" hidden/>
						<input name="sidx" value="" hidden/>
					</form>
					<div class="row">
						<div class="col-xs-12 col-sm-3">
							<div class="form-group">
								<label class="control-label col-xs-12 col-sm-3 no-padding-right">List</label>

								<div class="col-xs-12 col-sm-9">
									<select id="ppjk" class="multiselect" multiple="">
										<option value=""></option>
									</select>
								</div>
							</div>
						</div>
					</diV>

					<table id="grid-table"></table>

					<div id="grid-pager"></div>
          <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
      </div><!-- /.row -->
@endsection

@section('js')
	<script src="{{ asset('/js/jquery-ui.min.js') }}"></script>

	<script src="{{ asset('/js/moment.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ asset('/js/daterangepicker.min.js') }}"></script>

	<script src="{{ asset('js/jquery.jqGrid.min.js') }}"></script>
	<script src="{{ asset('js/grid.locale-en.js') }}"></script>

	<script src="{{ asset('js/bootstrap-multiselect.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-editable.min.js') }}"></script>
	<script src="{{ asset('/js/ace-editable.min.js') }}"></script>

	<script src="{{ asset('/js/chosen.jquery.min.js') }}"></script>

<script type="text/javascript">

	jQuery(function($) {
		//editables on first profile page
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="ace-icon fa fa-check"></i></button>'+
                                '<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';

		var setdate = moment().format('D MMMM YYYY');
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
        $(grid_selector).jqGrid('setGridParam',{postData:{bstdo:params.newValue}}).trigger("reloadGrid");

        setdate = params.newValue;
				get_ppjk(setdate);
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
				var target = $(this).find('input[type=radio]');
				var which = parseInt(target.val());
				if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
				else $('#form-field-select-4').removeClass('tag-input-style');
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
				postsave = {datatb:'lstp_ck',id:option.val(),checked:checked,lstp_ck:setdate};
				getparameter("{{url('/api/oprasional/cud')}}",postsave,	function(data){
					$(grid_selector).jqGrid('setGridParam',{postData:{lstp_ck:setdate}}).trigger("reloadGrid");
				},function(data){});
	    }
		});

/////////////////////////////////////////////////
////////////////////////// combobox select
		function get_ppjk(setdate){
			var posdata= {'datatb':'ppjk', _token:'{{ csrf_token() }}',lhp_date:setdate};
			var $select_elem = $("#ppjk");
			// $select_elem.empty();
			$select_elem.html('');
			getparameter("{{url('/api/oprasional/json')}}",posdata,function(data){
				// console.log(data);
				$.each(data, function (idx, obj) {
					if (data[idx].lstp_ck === null){
						var selected = '';
					} else {
						selected = 'selected';
					}

					if ((moment(setdate, "D MMMM YYYY") == data[idx].lstp_ck+'000') || (data[idx].lstp_ck === null) && (data[idx].bstdo !== null)){
						$select_elem.append('<option value="'+data[idx].id+'" '+selected+'>'+data[idx].ppjk+'</option>');
					}
				});

				$select_elem.multiselect('rebuild');
			},function(data){});
		}

		get_ppjk(setdate);
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
			caption: "Input LSTP",
      datatype: "json",            //supported formats XML, JSON or Arrray
      mtype : "post",
      postData: {datatb:'dl',lstp_ck:setdate,_token:'{{ csrf_token() }}'},
			url:"{{url('/api/oprasional/jqgrid')}}",
			editurl: "{{url('/api/oprasional/cud')}}",//nothing is saved
			sortname:'ppjk',
			sortorder: 'desc',
			height: 'auto',
			colNames:[' ', 'PPJK','AGEN','Date','Kapal','GRT','LOA','Bendera','Dermaga','OPS','PC','Tunda','ON','OFF','DD','Ket','Kurs','LSTP','Moring','ppjks_id'],
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
		      return { datatb:'dl', _token:'<?php echo csrf_token();?>'};
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
					$('#dompdf input[name=start]').val(setdate);
					$('#dompdf input[name=sidx]').val('ppjk');

					// console.log(setdate);

					$('#dompdf').submit();
				}
		})
		// .jqGrid('navButtonAdd',pager_selector,{
		// 		keys: true,
		// 		caption:"DL",
		// 		buttonicon:"ace-icon fa fa-file-pdf-o orange",
		// 		position:"last",
		// 		onClickButton:function(){
		// 			// var data = $(this).jqGrid('getRowData'); Get all data
		//
		// 			$('#dompdf input[name=page]').val('dl-dompdf');
		// 			$('#dompdf input[name=start]').val(setdate);
		// 			// console.log(setdate);
		//
		// 			$('#dompdf').submit();
		// 		}
		// }).jqGrid('navButtonAdd',pager_selector,{
		// 		keys: true,
		// 		caption:"",
		// 		buttonicon:"ace-icon fa fa-pencil blue",
		// 		position:"first",
		// 		onClickButton:function(){
		// 			$('#form').trigger("reset");
		// 			$('#tunda').multiselect('deselectAll', false).multiselect('refresh');
		//
		// 			var gsr = $(this).jqGrid('getGridParam','selrow');
		// 			if(gsr){
		// 				var posdata= {'datatb':'loadlaporan','iddata':gsr};
		// 				getparameter("{{url('/api/oprasional/json')}}",posdata,function(data){
		// 					$('#ppjk').val(data.ppjk);
		//
		// 					$( "#agen" ).val(data.agen);
		//
		// 					$('#date').data("DateTimePicker").date(data.date);
		//
		// 					$('#pcdate').daterangepicker({
		// 						'applyClass' : 'btn-sm btn-success',
		// 						'cancelClass' : 'btn-sm btn-default',
		// 						"opens": "center",
		// 						timePicker: true,
		// 						timePicker24Hour: true,
		// 						startDate: data.pcon,
		// 						endDate: data.pcoff,
		// 						locale: {
		// 								applyLabel: 'Apply',
		// 								cancelLabel: 'Cancel',
		// 								format: 'DD/MM/YY HH:mm'
		// 						}
		// 					})
		// 					.prev().on(ace.click_event, function(){
		// 							$(this).next().focus();
		// 					});
		//
		// 					$('#tundadate').daterangepicker({
		// 						'applyClass' : 'btn-sm btn-success',
		// 						'cancelClass' : 'btn-sm btn-default',
		// 						"opens": "center",
		// 						timePicker: true,
		// 						timePicker24Hour: true,
		// 						startDate: data.tundaon,
		// 						endDate: data.tundaoff,
		// 						locale: {
		// 								applyLabel: 'Apply',
		// 								cancelLabel: 'Cancel',
		// 								format: 'DD/MM/YY HH:mm'
		// 						}
		// 					})
		// 					.prev().on(ace.click_event, function(){
		// 							$(this).next().focus();
		// 					});
		//
		// 					// console.log();
		// 					$( "#kapal" ).val(data.kapal);
		//
		// 					$('#dermaga').val(data.dermaga).trigger("chosen:updated");
		// 					$('#ops').val(data.ops).trigger("chosen:updated");
		//
		// 					$('#bapp').val(data.bapp);
		// 					$('#pc').val(data.pc);
		//
		// 					if (data.tunda != null) {
		// 						data.tunda.forEach(function(element) {
		// 							$('option[value="'+element+'"]', $('#tunda')).prop('selected', true);
		// 						});
		// 						$('#tunda').multiselect('refresh');
		// 					// console.log(data.tunda);
		// 					}
		// 					$('#dd').val(data.dd);
		// 					$('#ket').val(data.ket);
		// 					$('#kurs').val(data.kurs);
		//
		// 					postsave ='';
		// 					postsave += 'oper=edit&id='+gsr+'&';
		// 				},function(data){ });
		//
		// 				$('#modal').modal('show');
		// 			} else {
		// 				alert("pilih tabel")
		// 			}
		// 		}
		// }).jqGrid('navButtonAdd',pager_selector,{
		// 	keys: true,
		// 	caption:"",
		// 	buttonicon:"ace-icon fa fa-plus-circle purple",
		// 	position:"first",
		// 	onClickButton:function(){
		// 		$('#form').trigger("reset");
		// 		$('#date').data("DateTimePicker").date(new Date(setdate));
		//
		// 		$('#pcdate, #tundadate').daterangepicker({
		// 			'applyClass' : 'btn-sm btn-success',
		// 			'cancelClass' : 'btn-sm btn-default',
		// 			"opens": "center",
		// 			timePicker: true,
		// 			timePicker24Hour: true,
		// 			startDate: moment().startOf('minute'),
		// 			endDate: moment().startOf('minute').add(1, 'minute'),
		// 			locale: {
		// 					applyLabel: 'Apply',
		// 					cancelLabel: 'Cancel',
		// 					format: 'DD/MM/YY HH:mm'
		// 			}
		// 		})
		// 		.prev().on(ace.click_event, function(){
		// 				$(this).next().focus();
		// 		});
		// 		// console.log(moment().startOf('minute'));
		// 		$('#dermaga, #ops').val('').trigger("chosen:updated");
		// 		$('#tunda').multiselect('deselectAll', false).multiselect('refresh');
		// 		postsave ='';
		// 		postsave += 'oper=add&';
		// 		$('#modal').modal('show');
		// 	}
		// })



		//var selr = jQuery(grid_selector).jqGrid('getGridParam','selrow');

		$(document).one('ajaxloadstart.page', function(e) {
			$.jgrid.gridDestroy(grid_selector);
			$('.ui-jqdialog').remove();
		});
	});
</script>

@endsection
