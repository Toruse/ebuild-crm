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

Route::get('/access-closed', 'Setting\PricedController@accessClosed')->name('index')->middleware('auth');

Route::get('/', 'IndexController@index')->name('index')->middleware('auth', 'priced:isAdmin');

Auth::routes();

Route::get('/home', 'IndexController@index')->name('index')->middleware('auth', 'priced:isAdmin');

Route::group(['prefix' => '/notify', 'middleware' => ['auth', 'priced:isAdmin']], function() {
    Route::get('/mark-all-viewed', 'Notify\NotificationController@markAllViewed')->name('notify.mark-all-viewed');
    Route::get('/mark-viewed/{notification}', 'Notify\NotificationController@markViewed')->name('notify.mark-viewed');
    Route::get('/news', 'Notify\NotificationController@news')->name('notify.news');
});

Route::group(['prefix' => '/cabinet', 'as' => 'cabinet.', 'middleware' => ['auth', 'priced:isAdmin']], function() {
    Route::get('/client', 'Cabinet\ClientController@calendarUpdateEvents')
        ->middleware('can:isCustomer')
        ->name('client');

    Route::group(['prefix' => '/contractor', 'middleware' => ['can:isContractor']], function() {
        Route::get('/', 'Cabinet\ContractorController@calendarUpdateEvents')->name('contractor');
        Route::get('/tasks-completed-today', 'Cabinet\ContractorController@tasksCompletedToday')->name('contractor.tasks-completed-today');
    });
});

Route::group(['prefix' => '/users', 'middleware' => ['auth', 'priced:isAdmin', 'role.access:isAdmin,isProjectManager']], function() {
    Route::resource('admins', 'User\AdminController')->middleware('can:isAdmin');
    Route::resource('contractors', 'User\ContractorController');
    Route::resource('customers', 'User\CustomerController');
    Route::get('/get-info-user-project/{user}', 'User\CustomerController@getInfoUserProject')->name('get-info-user-project');
    Route::resource('project-managers', 'User\ProjectManagerController');
    Route::resource('vendors', 'User\VendorController');
    Route::resource('contacts', 'User\ContactController')->only([
        'create',
        'store'
    ]);
    Route::get('/send-new-accesses/{user}', 'User\UserController@sendNewAccesses')->name('users.send-new-accesses');
    Route::resource('sales-associates', 'User\SalesAssociateController');
    Route::resource('user-setting', 'User\SettingsController')->only([
        'edit',
        'update'
    ])->middleware('can:isAdmin');

    Route::resource('users', 'User\UserController')->only([
        'index',
        'destroy'
    ])->middleware('can:isAdmin');
});

Route::group(['prefix' => '/projects', 'middleware' => ['auth', 'priced:isAdmin', 'role.access:isAdmin,isProjectManager'], 'as' => 'projects'], function() {
    Route::get('/', 'Project\ProjectController@index');
    Route::get('/create', ['as' => '.create', 'uses' => 'Project\ProjectController@create']);
    Route::post('/store', ['as' => '.store', 'uses' => 'Project\ProjectController@store']);
    Route::get('/edit/{project}', ['as' => '.edit', 'uses' => 'Project\ProjectController@edit']);
    Route::get('/edit-json/{project}', ['as' => '.edit-json', 'uses' => 'Project\ProjectController@editJson']);
    Route::put('/update/{project}', ['as' => '.update', 'uses' => 'Project\ProjectController@update']);
    Route::delete('/{project}', ['as' => '.destroy', 'uses' => 'Project\ProjectController@destroy']);
    Route::post('/event-drop/{project}', ['as' => '.event-drop', 'uses' => 'Project\ProjectController@eventDrop']);
    Route::post('/event-resize/{project}', ['as' => '.event-resize', 'uses' => 'Project\ProjectController@eventResize']);
    Route::get('/get-list', ['as' => '.get-list', 'uses' => 'Project\ProjectController@getList']);
    Route::post('/publish/{project}', ['as' => '.publish', 'uses' => 'Project\ProjectController@publish']);
});

Route::group(['prefix' => '/tasks', 'middleware' => ['auth', 'priced:isAdmin', 'role.access:isAdmin,isProjectManager'], 'as' => 'tasks'], function() {
    Route::post('/change/{task?}', ['as' => '.change', 'uses' => 'Project\TaskController@change']);
    Route::get('/{task}', ['as' => '.edit', 'uses' => 'Project\TaskController@edit']);
    Route::delete('/{task}', ['as' => '.destroy', 'uses' => 'Project\TaskController@destroy']);
    Route::post('/event-drop/{task}', ['as' => '.event-drop', 'uses' => 'Project\TaskController@eventDrop']);
    Route::post('/event-resize/{task}', ['as' => '.event-resize', 'uses' => 'Project\TaskController@eventResize']);
});

Route::group(['prefix' => '/schedules', 'middleware' => ['auth', 'priced:isAdmin', 'role.access:isAdmin,isProjectManager'], 'as' => 'schedules'], function() {
    Route::post('/select', ['as' => '.select', 'uses' => 'Project\ScheduleController@select']);
    Route::get('/close', ['as' => '.close', 'uses' => 'Project\ScheduleController@close']);
});

Route::resource('schedules', 'Project\ScheduleController')->middleware('auth', 'priced:isAdmin', 'role.access:isAdmin,isProjectManager');

Route::group(['prefix' => '/schedule-tasks', 'middleware' => ['auth', 'priced:isAdmin', 'role.access:isAdmin,isProjectManager'], 'as' => 'schedule-tasks'], function() {
    Route::post('/change/{scheduleTask?}', ['as' => '.change', 'uses' => 'Project\ScheduleTaskController@change']);
    Route::get('/{scheduleTask}', ['as' => '.edit', 'uses' => 'Project\ScheduleTaskController@edit']);
    Route::delete('/{scheduleTask}', ['as' => '.destroy', 'uses' => 'Project\ScheduleTaskController@destroy']);
    Route::post('/event-drop/{scheduleTask}', ['as' => '.event-drop', 'uses' => 'Project\ScheduleTaskController@eventDrop']);
    Route::post('/event-resize/{scheduleTask}', ['as' => '.event-resize', 'uses' => 'Project\ScheduleTaskController@eventResize']);
});

Route::group(['prefix' => '/settings', 'middleware' => ['auth', 'priced:isAdmin', 'role.access:isAdmin,isProjectManager']], function() {
    Route::post('/sources/add-quick', 'Setting\SourceController@addQuick')->name('sources.addquick');

    Route::post('/project-types/add-quick', 'Setting\ProjectTypeController@addQuick')->name('project-types.addquick');

    Route::post('/task-types/add-quick', 'Setting\TaskTypeController@addQuick')->name('task-types.addquick');

    Route::post('/skill-specialtys/add-quick', 'Setting\SkillSpecialtyController@addQuick')->name('skill-specialtys.addquick');
});

Route::group(['prefix' => '/settings', 'middleware' => ['auth', 'priced:isAdmin', 'can:isAdmin']], function() {
    Route::get('/index', 'Setting\SettingController@index')->name('settings');

    Route::resource('sources', 'Setting\SourceController');

    Route::resource('project-types', 'Setting\ProjectTypeController');

    Route::resource('material-services', 'Setting\MaterialServiceController');

    Route::resource('skill-specialtys', 'Setting\SkillSpecialtyController');

    Route::resource('task-types', 'Setting\TaskTypeController');

    Route::resource('priceds', 'Setting\PricedController');
});