<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();
Route::get('/',       'CekController@index');
Route::get('/home',   'CekController@index')->name('home');

/////////////////////////////////////////////////////////////////////////////////////// Master Data //////

Route::get('masterdata',      'Masterdata\MasterDataController@masterdata');                                       //
Route::get('mjabatan',        'Masterdata\MasterDataController@mjabatan');                                         //
Route::get('mdivisi',         'Masterdata\MasterDataController@mdivisi');                                          //
Route::get('mlibur',          'Masterdata\MasterDataController@mlibur');
Route::get('mdiagnosa',       'Masterdata\MasterDataController@mdiagnosa');
Route::get('mmuser',          'Masterdata\MasterDataController@mmuser');
Route::get('mamenu',          'Masterdata\MasterDataController@mamenu');

/////////////////////////////////////////////////////////////////////////////////////// Kepegawaian //////
Route::get('pkaryawa',          'Kepegawaian\KepegawaianController@pkaryawa');				//
Route::get('editkaryawan/{e}',  'Kepegawaian\KepegawaianController@editkaryawan');			//
Route::get('dapeg/{e}',         'Kepegawaian\KepegawaianController@dapeg');					//
Route::get('dakel/{e}',         'Kepegawaian\KepegawaianController@dakel');					//
Route::get('dcuti',							'Kepegawaian\KepegawaianController@dcuti');					//
Route::get('wspd',							'Kepegawaian\KepegawaianController@wspd');
Route::get('mrawatjalan',				'Kepegawaian\KepegawaianController@mrawatjalan');
Route::get('jshiftopr',					'Kepegawaian\KepegawaianController@jshiftopr');
Route::get('jshift',						'Kepegawaian\KepegawaianController@jshift');
Route::get('absen',							'Kepegawaian\KepegawaianController@absen');
Route::match(['get', 'post'],	'PDF_Kepegawaian',		'Kepegawaian\PdfKepegawaianController@PDFMarker');
Route::match(['get', 'post'],	'XLS_Kepegawaian',		'Kepegawaian\XlsKepegawaianController@XLSMarker');

/////////////////////////////////////////////////////////////////////////////////////// Payroll //////////
Route::get('koperasi',						'Payroll\PayrollController@koperasi');
Route::get('pkoperasi',						'Payroll\PayrollController@pkoperasi');
Route::get('upah',								'Payroll\PayrollController@upah');
Route::get('potongan',						'Payroll\PayrollController@potongan');

Route::get('uploaddata',					'Payroll\PayrollController@uploaddata');			//
Route::get('pengaturanpayroll',		'Payroll\PayrollController@pengaturanpayroll');			//
Route::match(['get', 'post'],	'PDF_payroll',		'Payroll\PdfPayrollController@PDFMarker');


Route::prefix('papan')->group(function(){
  Route::get('/',                 'Papan\PapanController@index');
});

Route::prefix('oprasional')->group(function(){
  Route::get('/',             'Oprasional\OprasionalController@upload');
  Route::get('/ppjk',         'Oprasional\OprasionalController@ppjk');
  Route::get('/dl',           'Oprasional\OprasionalController@dl');
  Route::get('/lhp',          'Oprasional\OprasionalController@lhp');
  Route::get('/bstdo',        'Oprasional\OprasionalController@bstdo');
  Route::get('/report',       'Oprasional\OprasionalController@report');
  Route::get('/upload',       'Oprasional\OprasionalController@upload');
  Route::get('/chart',        'Oprasional\OprasionalController@chart');

  Route::get('/masteroper',   'Oprasional\OprasionalController@masteroper');
  Route::get('/mkapal',       'Oprasional\OprasionalController@mkapal');
  Route::get('/magen',        'Oprasional\OprasionalController@magen');
  Route::get('/mpc',          'Oprasional\OprasionalController@mpc');
  Route::get('/mdermaga',     'Oprasional\OprasionalController@mdermaga');
  Route::get('/mmooring',     'Oprasional\OprasionalController@mmooring');

  Route::match(['get', 'post'],   'FileUpload',					'Oprasional\FilesCrudController@save');
  Route::match(['get', 'post'],   'FilesJson',					'Oprasional\FilesCrudController@json');
  Route::match(['get', 'post'],   'FilesSave',		  		'Oprasional\FilesCrudController@save');
  Route::match(['get', 'post'],   'PDFAdmin', 		    	'Oprasional\PdfController@PDFMarker');
  Route::match(['get', 'post'],	  'XLS_Oprasional',     'Oprasional\XlsOprasionalController@XLSMarker');
  Route::match(['get', 'post'],   'Chart',	     	  		'Oprasional\FilesCrudController@chart');

  Route::get('/listinvoice',  'Oprasional\Invoice\InvoiceController@listinvoice');

  Route::match(['get', 'post'],   'PDFInvoice', 		    	'Oprasional\Invoice\PdfController@PDFMarker');
  Route::match(['get', 'post'],   'PDFReport', 		      	'Oprasional\Report\PdfController@PDFMarker');
});

Route::prefix('surat')->group(function(){
  Route::get('/',             'Surat\SuratController@surat');
  Route::get('/smasuk',       'Surat\SuratController@smasuk');

});

Route::prefix('inventaris')->group(function(){
  Route::get('/',             'Inventaris\InventarisController@index');
});



//Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/', 'HomeController@index');
// Route::get('/home', 'HomeController@index');
//
// Route::get('top-menu',          'HomeController@topmenu');
// Route::get('two-menu-1',        'HomeController@twomenu1');
// Route::get('two-menu-2',        'HomeController@twomenu2');
// Route::get('mobile-menu-1',     'HomeController@mobilemenu1');
// Route::get('mobile-menu-2',     'HomeController@mobilemenu2');
// Route::get('mobile-menu-3',     'HomeController@mobilemenu3');
// Route::get('typography',        'HomeController@typography');
// Route::get('elements',          'HomeController@elements');
// Route::get('buttons',           'HomeController@buttons');
// Route::get('content-slider',    'HomeController@contentslider');
// Route::get('treeview',          'HomeController@treeview');
// Route::get('jquery-ui',         'HomeController@jqueryui');
// Route::get('nestable-list',     'HomeController@nestablelist');
//
// Route::get('tables',            'HomeController@tables');
// Route::get('jqgrid',            'HomeController@jqgrid');
//
// Route::get('form-elements',     'HomeController@formelements');
// Route::get('form-elements-2',   'HomeController@formelements2');
// Route::get('form-wizard',       'HomeController@formwizard');
// Route::get('wysiwyg',           'HomeController@wysiwyg');
// Route::get('dropzone',          'HomeController@dropzone');
//
// Route::get('widgets',           'HomeController@widgets');
//
// Route::get('calendar',          'HomeController@calendar');
// Route::get('gallery',           'HomeController@gallery');
//
// Route::get('profile',           'HomeController@profile');
// Route::get('inbox',             'HomeController@inbox');
// Route::get('pricing',           'HomeController@pricing');
// Route::get('invoice',           'HomeController@invoice');
// Route::get('timeline',          'HomeController@timeline');
// Route::get('search',            'HomeController@search');
// Route::get('email',             'HomeController@email');
// Route::get('email-confirmation','HomeController@emailconfirmation');
// Route::get('email-navbar',      'HomeController@emailnavbar');
// Route::get('email-newsletter',  'HomeController@emailnewsletter');
// Route::get('email-contrast',    'HomeController@emailcontrast');
//
// Route::get('faq',               'HomeController@faq');
// Route::get('error-404',         'HomeController@error404');
// Route::get('error-500',         'HomeController@error500');
// Route::get('grid',              'HomeController@grid');
// Route::get('blank',             'HomeController@blank');
//
// Route::get('dompdf',            'HomeController@dompdf');
// Route::get('webcamera',         'HomeController@webcamera');
// Route::get('qr',                'HomeController@qr');
// Route::get('excel',             'HomeController@excel');
// Route::get('pos',               'POS\PosController@pos');
//
// Route::match(['get', 'post'], 'PDFAdmin', 			'PdfController@PDFMarker');
// Route::match(['get', 'post'], 'ExcelExport',		'ExcelController@excelexport');
// Route::match(['get', 'post'], 'ExcelImport',		'ExcelController@excelimport');
//
// Route::get('multiauth',           'MultiAuthController@multiauth');
//
//
// Route::post('/web/logout', 'Auth\LoginController@weblogout')->name('web.logout');
//
// Route::prefix('member')->group(function(){
//   Route::get('/login', 'Auth\MemberLoginController@showLoginForm')->name('member.login');
//   Route::post('/login', 'Auth\MemberLoginController@login')->name('member.login.submit');
//   Route::post('/logout', 'Auth\MemberLoginController@web2logout')->name('member.logout');
//   Route::get('/', 'MemberController@index')->name('member.dasboard');
// });
//
// Route::prefix('bank')->group(function(){
//   Route::get('/trxharian', 'Bank\BankController@trxharian');
//   Route::get('/', 'Bank\BankController@index');
// });
