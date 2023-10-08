<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class ApiController extends Controller
{
    public function index(){
        return Book::all();
    }
    public function show($data){
        return Book::find($data);
    }
}
