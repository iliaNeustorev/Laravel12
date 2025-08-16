<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function Test()
    {
        $guzzle = new Client();
    }
}
