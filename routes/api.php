<?php
/**
 * API routes
 */
Route::group([
    "prefix" => "v1",
], function () {

    /**
     * Events module
     */
    Route::group(["prefix" => "events"], function () {

        Route::get('/', function () {
            return response()->json(["events" => true]);
        });
        Route::get('/create', function () {
            return response()->json(["events" => true, "create" => true]);
        });
    });
});
