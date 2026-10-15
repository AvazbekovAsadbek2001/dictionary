<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Section;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function menus()
    {
        $menus = Menu::select('id', 'name_uz as title')->get();
        return view('menus', compact('menus'));
    }

    public function sections(Request $request)
    {
        $menu = Menu::select('id', 'name_uz as title')->where('id', $request->id)->first();

        $sections = Section::select('id', 'name_uz as title')
            ->where('menu_id', $request->id)
            ->get();

        return view('sections',compact('sections','menu'));
    }

    public function types(Request $req){
        return view();
    }
}
