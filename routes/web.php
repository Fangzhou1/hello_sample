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

// Route::get('/', function () {
//     return view('welcome');
// });
//静态页
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');
Route::get('signup', 'UsersController@create')->name('signup');
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');


Route::post('/users/rolestouser/{user}', 'UsersController@rolestouser')->name('users.rolestouser');
Route::get('/users/rolestouserpage/{user}', 'UsersController@rolestouserpage')->name('users.rolestouserpage');
Route::get('/users/usersactionindex', 'UsersController@usersactionindex')->name('users.usersactionindex');
Route::resource('users', 'UsersController');

//注册
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');


//结算审计路由
Route::get('settlements/importpage', 'SettlementController@importpage')->name('settlements.importpage');
Route::post('settlements/import', 'SettlementController@import')->name('settlements.import');
Route::get('settlements/export', 'SettlementController@export')->name('settlements.export');
Route::get('settlements/exportbytype', 'SettlementController@exportbytype')->name('settlements.exportbytype');
Route::post('settlements/rowupdate/{settlement}', 'SettlementController@rowupdate')->name('settlements.rowupdate');
Route::get('settlements/smsmail', 'SettlementController@smsmail')->name('settlements.smsmail');
Route::get('settlements/smsmaildetail', 'SettlementController@smsmaildetail')->name('settlements.smsmaildetail');
Route::get('settlements/sendemail/', 'SettlementController@sendEmailReminderTo')->name('settlements.sendemail');
Route::get('settlements/statistics', 'SettlementController@statistics')->name('settlements.statistics');
Route::resource('settlements', 'SettlementController',['except' => ['show', 'edit', 'update']]);

//决算审计路由
Route::get('rreturns/importpage', 'RreturnsController@importpage')->name('rreturns.importpage');
Route::post('rreturns/import', 'RreturnsController@import')->name('rreturns.import');
Route::get('rreturns/export', 'RreturnsController@export')->name('rreturns.export');
Route::get('rreturns/exportbytype', 'RreturnsController@exportbytype')->name('rreturns.exportbytype');
Route::post('/rreturns/rowupdate/{rreturn}', 'RreturnsController@rowupdate')->name('rreturns.rowupdate');
Route::get('rreturns/smsmail', 'RreturnsController@smsmail')->name('rreturns.smsmail');
Route::get('rreturns/smsmaildetail', 'RreturnsController@smsmaildetail')->name('rreturns.smsmaildetail');
Route::get('rreturns/sendemail/', 'RreturnsController@sendEmailReminderTo')->name('rreturns.sendemail');
Route::get('rreturns/statistics', 'RreturnsController@statistics')->name('rreturns.statistics');
Route::resource('rreturns', 'RreturnsController',['except' => ['show', 'edit', 'update']]);

//权限管理
Route::post('/permissions/rowupdate/{permission}', 'PermissionsController@rowupdate')->name('permissions.rowupdate');
Route::resource('permissions', 'PermissionsController',['except' => ['show', 'edit', 'update']]);
Route::get('/roles/permissionstorolepage/{role}', 'RolesController@permissionstorolepage')->name('roles.permissionstorolepage');
Route::post('/roles/permissionstorole/{role}', 'RolesController@permissionstorole')->name('roles.permissionstorole');
Route::post('/roles/rowupdate/{role}', 'RolesController@rowupdate')->name('roles.rowupdate');
Route::resource('roles', 'RolesController',['except' => ['show', 'edit', 'update']]);


// Route::get('/users', 'UsersController@index')->name('users.index');
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');//
// Route::get('/users/create', 'UsersController@create')->name('users.create');
// Route::post('/users', 'UsersController@store')->name('users.store');
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');//
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update');//
// Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');










Route::get('test', function () {
  $data= App\Models\Settlement::where('audit_progress','已出报告')->select(DB::raw('count(*) as finished_ordernum'))->first()->toArray();
  $data2=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as ordernum,audit_progress,project_number'))->groupBy('project_number','audit_progress')->get();

  foreach ($data2 as $value) {
    $newdata_tem[$value->project_number][$value->audit_progress]=$value->ordernum;
  }
  $newdata3=['finished_projectnum'=>0];
  foreach ($newdata_tem as $value) {
    if(!(isset($value['审计中'])||isset($value['未送审'])||isset($value['被退回'])))
      $newdata3['finished_projectnum']+=1;

  }
$data=array_merge($data,$newdata3);

  App\Models\Settlementtime::create($data);
});
