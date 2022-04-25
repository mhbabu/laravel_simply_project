<?php
use Illuminate\Support\Facades\Route;

  Route::group(['prefix' => 'admin','module' => 'Dashboard', 'middleware' => ['web','auth'], 'namespace' => 'App\Modules\Dashboard\Controllers'], function() {
    Route::get('dashboard','DashboardController@index')->name('admin.dashboard.index');
});
