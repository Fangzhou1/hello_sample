<?php
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;



//登陆、退出
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');



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
Route::post('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');
Route::get('signup', 'UsersController@create')->name('signup');
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');









Route::prefix('audit_navigation')->group(function () {


//密码重设
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


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
Route::get('settlements/search', 'SettlementController@search')->name('settlements.search');
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


//物资退库管理
Route::get('refunds', 'RefundsController@index')->name('refunds.index');
Route::get('refunds/importpage', 'RefundsController@importpage')->name('refunds.importpage');
Route::post('refunds/importrefunds', 'RefundsController@importrefunds')->name('refunds.importrefunds');
Route::post('refunds/importrefunddetails', 'RefundsController@importrefunddetails')->name('refunds.importrefunddetails');
Route::get('refunds/export', 'RefundsController@export')->name('refunds.export');
Route::get('refunds/exportdetails', 'RefundsController@exportdetails')->name('refunds.exportdetails');
Route::post('refunds/rowupdate/{refund}', 'RefundsController@rowupdate')->name('refunds.rowupdate');
Route::get('refunds/refundsdetail/{refund}', 'RefundsController@refundsdetail')->name('refunds.refundsdetail');
Route::get('refunds/smsmail', 'RefundsController@smsmail')->name('refunds.smsmail');
Route::get('refunds/smsmaildetail', 'RefundsController@smsmaildetail')->name('refunds.smsmaildetail');
Route::get('refunds/exportbytype', 'RefundsController@exportbytype')->name('refunds.exportbytype');
Route::get('refunds/sendemail/', 'RefundsController@sendEmailReminderTo')->name('refunds.sendemail');
Route::get('refunds/statistics', 'RefundsController@statistics')->name('refunds.statistics');
Route::resource('refunds', 'RefundsController',['except' => ['show', 'edit', 'update']]);


//物资详情退库管理
Route::post('refunddetails/importrefunddetailsbymanager', 'RefunddetailsController@importrefunddetailsbymanager')->name('refunddetails.importrefunddetailsbymanager');
Route::resource('refunddetails','RefunddetailsController',['except' => ['index','show']]);
// Route::get('/users', 'UsersController@index')->name('users.index');
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');//
// Route::get('/users/create', 'UsersController@create')->name('users.create');
// Route::post('/users', 'UsersController@store')->name('users.store');
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');//
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update');//
// Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');

Route::post('/users/rolestouser/{user}', 'UsersController@rolestouser')->name('users.rolestouser');
Route::get('/users/rolestouserpage/{user}', 'UsersController@rolestouserpage')->name('users.rolestouserpage');
Route::get('/users/usersactionindex', 'UsersController@usersactionindex')->name('users.usersactionindex');

});
Route::resource('users', 'UsersController');






//微信处理
Route::any('weixin','WeixinController@index')->name('weixin.index');
Route::get('weixin/sendweixin/{type}','WeixinController@sendweixin')->name('weixin.sendweixin');
//Route::get('weixin/createmenu','WeixinController@createmenu')->name('weixin.createmenu');
Route::get('weixin/receiveAuditInfo','WeixinController@receiveAuditInfo')->name('weixin.receiveAuditInfo');



Route::group(['middleware' => ['wechat.oauth:snsapi_userinfo']], function () {
  Route::any('weixinlogin','WeixinController@weixinlogin')->name('weixin.weixinlogin');
});





Route::prefix('baseinformation_navigation')->group(function () {
//基本信息
Route::get('baseinformation/loginaction', 'BaseinformationController@loginaction')->name('baseinformation.loginaction');
});




// Route::get('test2', function () {
//   DB::table('roles')->insert([['name'=>'游客',"guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],['name'=>'项目经理',"guard_name"=>"web","created_ti  me"=>Carbon::now(),"updated_at"=>Carbon::now()],['name'=>'高级管理员',"guard_name"=>"web","created_at"=>Carbon::now(),'updated_at'=>Carbon::now()],['name'=>'站长',"guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]]);
//
// });

// Route::get('test3', function () {
//
//   DB::table('permissions')->insert([
//   // ['name'=>"结算审计更新","route"=>"settlements.rowupdate","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算审计分类页面","route"=>"settlements.smsmail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算审计详情","route"=>"settlements.smsmaildetail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算审计发邮件","route"=>"settlements.sendemail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算审计统计","route"=>"settlements.statistics","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算审计主页","route"=>"settlements.index","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算审计新增页","route"=>"settlements.create","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算审计新增","route"=>"settlements.store","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算审计删除","route"=>"settlements.destroy","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计更新","route"=>"rreturns.rowupdate","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计分类页面","route"=>"rreturns.smsmail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计详情","route"=>"rreturns.smsmaildetail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计发邮件","route"=>"rreturns.sendemail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计统计","route"=>"rreturns.statistics","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计主页","route"=>"rreturns.index","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计新增页","route"=>"rreturns.create","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计新增","route"=>"rreturns.store","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算审计删除","route"=>"rreturns.destroy","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算批量导入页","route"=>"settlements.importpage","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"结算批量导入","route"=>"settlements.import","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算批量导入页","route"=>"rreturns.importpage","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"决算批量导入","route"=>"rreturns.import","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"权限主页","route"=>"permissions.index","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"新增权限页","route"=>"permissions.create","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"新增权限","route"=>"permissions.store","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"删除权限","route"=>"permissions.destroy","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"更新权限","route"=>"permissions.rowupdate","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"角色主页","route"=>"roles.index","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"新增角色页","route"=>"roles.create","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"新增角色","route"=>"roles.store","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"删除角色","route"=>"roles.destroy","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"给角色赋予权限","route"=>"roles.permissionstorole","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"更新角色","route"=>"roles.rowupdate","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"用户列表页","route"=>"users.index","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"用户展示页","route"=>"users.show","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"用户更新页","route"=>"users.edit","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"更新用户","route"=>"users.update","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"删除用户","route"=>"users.destroy","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"用户处置列表页","route"=>"users.usersactionindex","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"给用户赋予角色页","route"=>"users.rolestouserpage","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"给用户赋予角色","route"=>"users.rolestouser","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"给角色赋予权限页","route"=>"roles.permissionstorolepage","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"导出结算总表","route"=>"settlements.export","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"导出决算总表","route"=>"rreturns.export","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"按分类导出结算分表","route"=>"settlements.exportbytype","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   // ['name'=>"按分类导出决算分表","route"=>"rreturns.exportbytype","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//
//   ['name'=>"物资主页","route"=>"refunds.index","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资批量导入页","route"=>"refunds.importpage","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资批量导入","route"=>"refunds.importrefunds","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资详情批量导入","route"=>"refunds.importrefunddetails","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资导出","route"=>"refunds.export","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资更新","route"=>"refunds.rowupdate","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资详情主页","route"=>"refunds.refundsdetail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资邮件短信页","route"=>"refunds.smsmail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资邮件短信详情页","route"=>"RefundsController@smsmaildetail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资分类导出","route"=>"refunds.exportbytype","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资发送邮件通知","route"=>"refunds.sendemail","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资统计页","route"=>"refunds.statistics","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资新增页","route"=>"refunds.create","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资新增","route"=>"refunds.store","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资删除","route"=>"refunds.destroy","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//
//   ['name'=>"物资详情新增页","route"=>"refunddetails.create","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资详情新增","route"=>"refunddetails.store","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资详情编辑页","route"=>"refunddetails.edit","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资详情编辑","route"=>"refunddetails.update","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//   ['name'=>"物资详情删除","route"=>"refunddetails.destroy","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//
//
//   ['name'=>"发送微信通知","route"=>"weixin.sendweixin","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//
//
//   ['name'=>"基础信息页","route"=>"baseinformation.loginaction","guard_name"=>"web","created_at"=>Carbon::now(),"updated_at"=>Carbon::now()],
//
//
//
//
//
//
// ]);
//
// });








// Route::get('/users/create', 'UsersController@create')->name('users.create');
// Route::post('/users', 'UsersController@store')->name('users.store');
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');//
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update');//
// Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');

























// Route::get('test4', function () {
//   $role=Role::where('name','站长')->first();
//   //dd($role);
//     $role->givePermissionTo(["结算审计更新","结算审计分类页面","结算审计详情","结算审计发邮件","结算审计统计","结算审计主页","结算审计新增页","结算审计新增","结算审计删除","决算审计更新","决算审计分类页面","决算审计详情","决算审计发邮件","决算审计统计","决算审计主页","决算审计新增页","决算审计新增","决算审计删除","结算批量导入页","结算批量导入","决算批量导入页","决算批量导入","权限主页","新增权限页","新增权限","删除权限","更新权限",
//     "角色主页","新增角色页","新增角色","删除角色","给角色赋予权限","更新角色","用户列表页","用户展示页","用户更新页","更新用户","删除用户","用户处置列表页","给用户赋予角色页","给用户赋予角色","给角色赋予权限页","导出结算总表","导出决算总表","按分类导出结算分表","按分类导出决算分表"]);
//
// });



// Route::get('test', function () {
//   $data= App\Models\Settlement::where('audit_progress','已出报告')->select(DB::raw('count(*) as finished_ordernum'))->first()->toArray();
//   $data2=DB::table('settlements')->where('order_number','<>','订单编号')->select(DB::raw('count(*) as ordernum,audit_progress,project_number'))->groupBy('project_number','audit_progress')->get();
//
//   foreach ($data2 as $value) {
//     $newdata_tem[$value->project_number][$value->audit_progress]=$value->ordernum;
//   }
//   $newdata3=['finished_projectnum'=>0];
//   foreach ($newdata_tem as $value) {
//     if(!(isset($value['审计中'])||isset($value['未送审'])||isset($value['被退回'])))
//       $newdata3['finished_projectnum']+=1;
//
//   }
// $data=array_merge($data,$newdata3);
//
//   App\Models\Settlementtime::create($data);
// });

// Route::get('test', function () {
//
//   $data=DB::table('rreturns')->where('project_number','<>','项目编号')->select(DB::raw('count(*) as projectnum,audit_progress,is_canaudit'))->groupBy('is_canaudit','audit_progress')->get();
// //dd($data);
//   foreach ($data as $value) {
//     if($value->audit_progress=='未送审'&&$value->is_canaudit=='否')
//       $newdata3['不具备决算送审条件']=$value->projectnum;
//     elseif($value->audit_progress=='未送审'&&$value->is_canaudit=='是')
//       $newdata3['具备送审条件未送审']=$value->projectnum;
//     elseif($value->audit_progress=='审计中')
//       $newdata3['审计中']=$value->projectnum;
//     elseif($value->audit_progress=='被退回')
//       $newdata3['被退回']=$value->projectnum;
//     elseif($value->audit_progress=='已出报告')
//       $newdata3['已出报告']=$value->projectnum;
//
//   }
//
//   App\Models\Rreturntime::create($newdata3);
// });

Route::get('/download/jesmb', function () {
  return response()
        ->download(storage_path('app/jesmb.xlsx'));
})->name('download.jesmb');

Route::get('/download/jusmb', function () {
  return response()
        ->download(storage_path('app/jusmb.xlsx'));
})->name('download.jusmb');

Route::get('/download/refunddetailmb', function () {
  return response()
        ->download(storage_path('app/refunddetailmb.xlsx'));
})->name('download.refunddetailmb');
