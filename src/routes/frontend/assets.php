<?php

$parameters = [
    'namespace' => Assets::class,
    'prefix' => 'media'
];

Route::group($parameters, function () {
    
    Route::get('{uuid}/format/{format}', [
            'as' => 'assets.frontend.formatted',
            'uses' => 'FrontendController@formatMedia'
        ])
        ->where('format', '(.*)');
    
});
