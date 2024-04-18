<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComponentTestController extends Controller
{
    public function showComponent1(){
        return view("tests.component-test1");
    }
    public function showComponent2(){
        return view("tests.component-test2");
    }
}
