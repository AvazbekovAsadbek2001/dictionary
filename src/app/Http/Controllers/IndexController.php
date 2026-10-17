<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Section;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

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

    public function types(Request $request){
        $menuId = $request->menuId;
        $section = Section::select('id', 'name_uz as title')->where('id', $request->id)->first();
        return view('types', compact('menuId', 'section'));
    }

    public function condition(Request $request)
    {
        $section = Section::select('id', 'name_uz as title')->where('id', $request->id)->first();
        $type = $request->type;
        return view('condition', compact('section', 'type'));
    }

    public function getword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:sections,id',
            'type' => 'required|in:ru,uz,mix',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $column = ($data['type'] !== "mix") ?
            "name_".$data['type'] : "name_" . Arr::random(['ru','uz']);

        $word = Word::select("id", $column." as title")
            ->where('section_id', $data['section_id'])
            ->inRandomOrder()
            ->first();

        return response()->json([
            'id' => $word->id,
            'word' => $word->title,
            'from' => ($column == 'name_uz') ? 'uz' : 'ru',
        ]);
    }

    public function checkword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'word_id' => 'required|exists:words,id',
            'answer'  => 'required|string',
            'from'    => 'required|in:ru,uz,mix',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $column = $data['from'] === 'ru' ? 'name_uz' : 'name_ru';

        $correctText = (string) Word::whereKey($data['word_id'])->value($column);

        $variants = array_map([$this, 'normalize'], explode('/', $correctText));

        $isCorrect = in_array($this->normalize($data['answer']), $variants, true);

        return response()->json([
            'correct' => $isCorrect,
            'answer'  => $correctText,          // xato bo'lganda frontend shuni ko'rsatadi
        ]);
    }

    private function normalize(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');                       // katta-kichik harf farqi yo'q
        $text = str_replace('ё', 'е', $text);                        // ё = е
        $text = str_replace(['ʻ', 'ʼ', '’', '‘', '`', '´'], "'", $text); // o', g' belgilarining hamma turi bir xil
        $text = preg_replace('/\s+/u', ' ', $text);                  // ortiqcha bo'shliqlar
        return trim($text);
    }
}
