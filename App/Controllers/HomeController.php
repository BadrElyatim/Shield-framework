<?php

namespace App\Controllers;

use Shield\View\View;

class HomeController {
    
    public function index() {
        return view('posts.index', [
            'name' => 'badr',
            'age' => 20
        ]);
    }
}