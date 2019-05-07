<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::group(['middleware'=>['api']],function(){
  Route::prefix('bank')->group(function(){
    Route::post('jqgrid', 'Bank\BankApiController@jqgrid');
    Route::post('json', 'Bank\BankApiController@json');
    Route::post('save', 'Bank\BankApiController@save');
  });
//});

//
Route::prefix('masterdata')->group(function(){
  Route::post('jqgrid', 'Masterdata\MasterDataApiController@jqgrid');
  Route::post('json',   'Masterdata\MasterDataApiController@json');
  Route::post('cud',   'Masterdata\MasterDataApiController@cud');
});

Route::prefix('kepegawaian')->group(function(){
  Route::post('jqgrid', 'Kepegawaian\KepegawaianApiController@jqgrid');
  Route::post('json',   'Kepegawaian\KepegawaianApiController@json');
  Route::post('cud',   'Kepegawaian\KepegawaianApiController@cud');
});

Route::prefix('payroll')->group(function(){
  Route::post('jqgrid', 'Payroll\PayrollApiController@jqgrid');
  Route::post('json',   'Payroll\PayrollApiController@json');
  Route::post('cud',   'Payroll\PayrollApiController@cud');
});

Route::prefix('papan')->group(function(){
  Route::post('/',           'Papan\PapanApiController@index');
});

Route::prefix('surat')->group(function(){
  Route::post('/jqgrid',           'Surat\SuratApiController@jqgrid');
  Route::post('/autoc',            'Surat\SuratApiController@autoc');
  Route::post('/json',             'Surat\SuratApiController@json');
  Route::post('/cud',              'Surat\SuratApiController@cud');
});

Route::prefix('oprasional')->group(function(){
  Route::post('/jqgrid',           'Oprasional\oprasionalApiController@jqgrid');
  Route::match(['get', 'post'],	'autoc','Oprasional\oprasionalApiController@autoc');
  Route::post('/json',             'Oprasional\oprasionalApiController@json');
  Route::post('/cud',              'Oprasional\oprasionalApiController@cud');
});

Route::prefix('Inventaris')->group(function(){
  Route::post('/search',              'Inventaris\InventarisApiController@search');
});
