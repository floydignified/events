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
    Route::group([
        "prefix" => "events",
        "namespace" => "Events",
    ], function () {

        Route::get("/", "EventController@fetch");
        Route::post("/create", "EventController@define");
    });
});
