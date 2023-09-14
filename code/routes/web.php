<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/az', function () {
    // Store data in the cache for 5 minutes
    Cache::put('example_key', 'This is cached data', 5);

    // Retrieve the data from the cache
    $cachedData = Cache::get('example_key');

    if ($cachedData) {
        // Data was found in the cache
        return $cachedData;
    } else {
        // Data was not found in the cache, so store it
        Cache::put('example_key', 'This is cached data', 5);
        return 'Data cached for the first time.';
    }
});
