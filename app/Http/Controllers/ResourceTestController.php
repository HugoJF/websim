<?php

namespace App\Http\Controllers;

use App\User;
use App\MyLittleTree;
use App\Http\Controllers\Controller;

class ResourceTestController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function execute()
    {
		$livros = MyLittleTree::where('name', '=', 'Livros')->first();
		//$livros->children()->create(['name' => 'e-books']);
		
		$materiais = MyLittleTree::where('name', '=', 'Materiais')->first();
		//$materiais->children()->create(['name' => 'Canetas']);
		
		return '<pre>' . $livros->descendantsAndSelf()->get(array('id')) . '</pre>';
    }
}

