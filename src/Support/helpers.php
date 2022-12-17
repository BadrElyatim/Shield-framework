<?php

use Shield\Application;
use Shield\View\View;

function env($key, $default = null) {
    return $_ENV[$key] ?? value($default);
}

function value($value) {
    return ($value instanceof Closure) ? $value() : $value;
}

function base_path() {
    return dirname(__DIR__) . '/../';
}

function view_path() {
    return base_path() . 'views/';
}

function view($view, $params = []) {
    View::make($view, $params);
}

function app() {
    static $appInstance = null;

    if (!$appInstance) {
        $appInstance = new Application;
    }

    return $appInstance;
}