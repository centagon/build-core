<?php

Route::get('/', 'DashboardController@index')
    ->name('admin.dashboard');

Route::get('/dashboard/create', 'DashboardController@create')
    ->name('admin.dashboard.create');

Route::post('/dashboard/create', 'DashboardController@store')
    ->name('admin.dashboard.store');

Route::post('/dashboard/update-nodes', 'DashboardController@updateNodes')
    ->name('admin.dashboard.update-nodes');

Route::get('/dashboard/{block}', 'DashboardController@edit')
    ->name('admin.dashboard.edit');

Route::put('/dashboard/{block}', 'DashboardController@update')
    ->name('admin.dashboard.update');

Route::get('/dashboard/remove/{block}', 'DashboardController@remove')
    ->name('admin.dashboard.remove');
