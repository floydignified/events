<?php

/**
 * Default route (events page view)
 */
Route::get("/", function () {
    return view('app');
})->name("default");

/**
 * Redirect any other route to default
 */
Route::fallback(function () {
    return redirect()->route('default');
});
