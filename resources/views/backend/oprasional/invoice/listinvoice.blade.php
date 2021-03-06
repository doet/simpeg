@extends('backend.app_backend')

@section('css')
	<!-- page specific plugin styles -->
	<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/ui.jqgrid.min.css') }}" />

	<link rel="stylesheet" href="{{ asset('/css/bootstrap-editable.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('/css/daterangepicker.min.css') }}">
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
<div id="modal" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- 01 Header -->
				<form id="form">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="smaller lighter blue no-margin">Form Laporan </h3>
					</div>
					<!-- 01 end heder -->
					<!-- 02 body -->
					<div class="modal-body">
						{{ csrf_field() }}
						<!-- <input type="hidden" name="datatb" value="keluarga" />
						<input type="hidden" id='oper-1' name="oper" value="add" />
						<input type="hidden" id='id-1' name="id" value="id" /> -->
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="row">
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">Tgl Doc</label>
										<div class="col-xs-12 col-sm-9">
											<div class="clearfix"><input class="input-sm col-sm-4 tgl" type="text" id="tglinv" name="tglinv" readonly></div>
										</div>
									</div>
								</div>
								<div class="space-2"></div>

								<div class="row">
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">Kurs</label>
										<div class="col-xs-12 col-sm-9">
											<div class="clearfix">
												<input class="input-sm col-sm-4 tgl" type="text" id="dkurs" name="dkurs" readonly>
												<input class="input-sm col-sm-5" type="text" id="kurs" name="kurs">
											</div>
										</div>
									</div>
								</div>
								<div class="space-2"></div>

								<div class="row">
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">Selisih</label>
										<div class="col-xs-12 col-sm-9">
											<div class="clearfix"><input class="input-sm col-sm-9" type="text" id="selisih" name="selisih"></div>
										</div>
									</div>
								</div>
								<div class="space-2"></div>

							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="row">
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">No Faktur</label>
										<div class="col-xs-12 col-sm-9">
											<div class="clearfix"><input class="input-sm col-sm-9" type="text" id="pajak" name="pajak"></div>
										</div>
									</div>
								</div>
								<div class="space-2"></div>

								<div class="row">
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">No Invoice</label>
										<div class="col-xs-12 col-sm-9">
											<div class="clearfix"><input class="input-sm" type="text" id="noinv" name="noinv"></div>
										</div>
									</div>
								</div>
								<div class="space-2"></div>

								<div class="row">
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">Ref.No</label>
										<div class="col-xs-12 col-sm-9">
											<div class="clearfix"><input class="input-sm col-sm-9" type="text" id="refno" name="refno"></div>
										</div>
									</div>
								</div>
								<div class="space-2"></div>


							</div>
						</div>

					</div>
					<!-- 02 end body -->

					<!-- 03 footer -->
					<div class="modal-footer">
						<button class="btn btn-sm btn-danger pull-right" id='save'>
								<i class="ace-icon fa fa-floppy-o"></i>Save
						</button>
						<button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
								<i class="ace-icon fa fa-times"></i>Close
						</button>
					</div>
					<!-- 03 end footer Form -->
				</form>
			</div>
		</div>
</div><!-- /.modal-dialog -->

      <div class="row">
        <div class="col-xs-12">
          <!-- PAGE CONTENT BEGINS -->
					<form id="dompdf" role="form" method="POST" action="{{ url('oprasional/PDFInvoice') }}" target="_blank">
						{!! csrf_field() !!}
						<input name="page" value="" hidden/>
						<input name="file" value="" hidden/>
						<input name="start" value="" hidden/>
						<input name="bstdo" value="" hidden/>
						<input name="sidx" value="" hidden/>
					</form>

					<div align="center">Daftar Invoice<br />
						<span class="editable" id="psdate"></span>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-5">
							<div class="profile-user-info profile-user-info-striped ">

									<div class="profile-info-row">
										<div class="profile-info-name"> Display </div>

										<div class="profile-info-value">
											<select id="ppjk" class="multiselect" multiple="" disabled>
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
	<script src="{{ asset('/js/daterangepicker.min.js') }}"></script>

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

		$('.tgl').datepicker({
			format:'dd-mm-yyyy',
			autoclose:true,
		});

		$('#dkurs').on('changeDate', function (ev) {
			kurs($(this).val());
		});
		function kurs(dkurs){
			var posdata= {'datatb':'kurs','search':dkurs};
			// console.log(tglinv);
			getparameter("{{url('/api/oprasional/invoice/json')}}",posdata,function(data){
				if (data[1] !== null) {
					var a = new Date(data[1].date*1000);
					$('#dkurs').datepicker("update", a.getDate() +'-'+(a.getMonth()+1)+'-'+a.getFullYear());
					$('#kurs').val(Numbers(data[1].nilai));
				} else {
					// $('#dkurs').datepicker("update", tglinv);
					// $('#dkurs').val('');
					$('#kurs').val('');
				}
			});
		}

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
				// postsave = {datatb:'bstdo',id:option.val(),checked:checked,bstdo:$('#NoBSTDO').html()};
				// getparameter("{{url('/api/oprasional/cud')}}",postsave,	function(data){
				// 	$(grid_selector).jqGrid('setGridParam',{postData:{bstdo:$('#NoBSTDO').html()}}).trigger("reloadGrid");
				// },function(data){});
	    }
		});

		var postsave={};
		postsave.url = "{{url('/api/oprasional/invoice/cud')}}";
		postsave.grid = '#grid-table';
		postsave.modal = '#modal';
		$('#save').click(function(e) {
			e.preventDefault();
			postsave.post += $("#form").serialize()+'&datatb=inv';
			saveGrid(postsave);
		});
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
			caption: "Daftar Invoice",
      datatype: "json",            //supported formats XML, JSON or Arrray
      mtype : "post",
      postData: {datatb:'invoice', _token:'{{ csrf_token() }}'},
			url:"{{url('/api/oprasional/invoice/jqgrid')}}",
			editurl: "{{url('/api/oprasional/invoice/cud')}}",//nothing is saved
			sortname:'bstdo',
			sortorder: 'desc',
			height: 'auto',
			colNames:[' ', 'BSTDO','PPJK','Agen','Kapal','Jalur','Tanggal Doc','Faktur Pajak','Nomor Invoice','Ref No','Selisih','Status','dkurs'],
			colModel:[
				{name:'myac',index:'', width:50, fixed:true, sortable:false, resize:false, align: 'center'},
				{name:'bstdo',index:'bstdo', width:40,editable: false},
				{name:'ppjk',index:'ppjk', width:60, sorttype:"int", editable: false},
				{name:'agen',index:'agen',width:40, editable:false, align: 'center'},
				{name:'kapal',index:'kapal', width:60, editable: false},
				{name:'rute',index:'rute', width:60, editable: false},
				{name:'tglinv',index:'tglinv', width:60, editable: false, align: 'center'},
				{name:'pajak',index:'pajak', width:60, editable: false},
				{name:'noinv',index:'noinv', width:60, editable: false},
				{name:'refno',index:'refno', width:60, editable: false},
				{name:'selisih',index:'selisih', width:60, editable: false},
				{name:'status',index:'status', width:60, editable: false, formatter:status},
				{name:'dkurs',index:'dkurs', width:60, editable: false}
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

		function status( cellvalue, options, cell ) {
			// setTimeout(function(){
			// 	$(cell) .find('input[type=checkbox]')
			// 		.addClass('ace ace-switch ace-switch-5')
			// 		.after('<span class="lbl"></span>');
			// }, 0);
			// console.log(cellvalue);
			var url="{{ url('oprasional/PDFInvoice') }}?page=invoice-dompdf&id="+cellvalue;
			var url2="{{ url('oprasional/PDFInvoice') }}?page=invoice-dompdf2&id="+cellvalue;
			return '<div><a class="fa fa-file-pdf-o orange" method="POST" href='+url+' target="_blank"></a> - <a class="fa fa-file-pdf-o orange" method="POST" href='+url2+' target="_blank"></a> - <a class="fa fa-credit-card orange"></a></div>';
		}

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

var i=0;
		//navButtons
		jQuery(grid_selector).jqGrid('navGrid',pager_selector,
			{ 	//navbar options
				edit: false,
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
					// var gsr = $(this).jqGrid('getGridParam','selrow');
					// var ppjks_id = $(this).jqGrid('getCell',gsr,'ppjks_id');
					//
		      // return { datatb:'lstp', ppjks_id:ppjks_id,dls_id:gsr,_token:'<?php echo csrf_token();?>'};
					alert(1);
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
		)
		.jqGrid('navButtonAdd',pager_selector,{
				keys: true,
				caption:"",
				buttonicon:"ace-icon fa fa-pencil blue",
				position:"first",
				onClickButton:function(){

					$('#form').trigger("reset");
					$('.tgl').datepicker('update', '');
					var gsr = $(this).jqGrid('getGridParam','selrow');
					if(gsr){
						tglinv = $(this).jqGrid('getCell',gsr,'tglinv');
						pajak = $(this).jqGrid('getCell',gsr,'pajak');
						noinv = $(this).jqGrid('getCell',gsr,'noinv');
						refno = $(this).jqGrid('getCell',gsr,'refno');
						dkurs = $(this).jqGrid('getCell',gsr,'dkurs');
						rute = $(this).jqGrid('getCell',gsr,'rute');
						selisih = $(this).jqGrid('getCell',gsr,'selisih');

						$('#pajak').val(pajak);
						$('#noinv').val(noinv);
						$('#refno').val(refno);
						$('#selisih').val(selisih);

						//
						$('#tglinv').datepicker("setDate",tglinv);
						if (rute==='Domestic'){
							$('#dkurs').prop('disabled', true);
							$('#kurs').prop('disabled', true);
						} else {
							$('#dkurs').datepicker("setDate",dkurs);
							$('#dkurs').prop('disabled', false);
							$('#kurs').prop('disabled', false);
						}

						// console.log($('#dkurs').val());
						// var oldDate = $('#dkurs').val();
						// $('#dkurs').on('changeDate', function (ev) {
						// 	console.log(i);
						// 	console.log($(this).val());
						//
						//
						//   // if (oldDate !== $(this).val()){
						// 	// 	// kurs($(this).val());
						// 	// 	console.log(oldDate +'!=='+ $(this).val());
						// 	//
						// 	// }
						// 	// oldDate = $(this).val();
						// });i++;
						//
						// var oldDate = $('#dkurs').val();
						// $('#dkurs').datepicker("setDate",dkurs).on('change', function (ev) {
						// 	alert(oldDate+'-'+$(this).val());
						// 	oldDate = $(this).val();
						// });
						// $('#dkurs').datepicker().on('changeDate', function (ev) {
						//   if (oldDate !== $(this).val()){
						// 		// kurs($(this).val());
						// 		// console.log(oldDate +'!=='+ $(this).val());
						//
						// 	}
						// 	oldDate = $(this).val();
						// });
						// if (tglinv!==''){
						// 	// console.log(dkurs);
						// 	$('#tglinv').datepicker("setDate",tglinv).on("change", function(e) {
						// 		// kurs(dkurs);
						// 		// console.log(dkurs);
						// 	})
						// 	// kurs(dkurs);
						// }

						postsave.post = '';
						postsave.post += 'oper=edit&id='+gsr+'&';
						$('#modal').modal('show');
					} else {
						alert("pilih tabel")
					}
				}
		});


		$(document).one('ajaxloadstart.page', function(e) {
			$.jgrid.gridDestroy(grid_selector);
			$('.ui-jqdialog').remove();
		});
	});
</script>

@endsection
