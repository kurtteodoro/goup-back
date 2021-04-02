<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \App\Models\Favorite;

class GithubController extends Controller
{
    
    public function buscar(Request $request) {
        $perfis = Http::get('https://api.github.com/search/users',[
            'q' => $request->q,
            'per_page' => 10
        ])->json()['items'];

        $favorites = Favorite::whereIn(
            'user_github_id',
            collect($perfis)->pluck('id')
        )->get()->pluck('user_github_id');

        return response()->json([
            'perfis' => $perfis,
            'favorites' => $favorites
        ]);
    }

    public function addFavorite(Request $request) {
        $favorite = new Favorite();
        $favorite->user_id = auth()->user()->id;
        $favorite->user_github_id = $request->user_github_id;
        if($favorite->save())
            return response()->json([
                'success' => true
            ]);
        return response()->json([
            'error' => true
        ]);
    }
    
    public function removeFavorite(Request $request) {
        
        $deleted = Favorite::
        whereUserId(auth()->user()->id)
        ->where('user_github_id', $request->user_github_id)
        ->delete();
        
        if($deleted)
            return response()->json([
                'success' => true
            ]);
        return response()->json([
            'error' => true
        ]);
    }

    public function searchFavorites(Request $request) {

        $perfis = array();
        $favorites = Favorite::
        where('user_id', auth()->user()->id)
        ->get()
        ->pluck('user_github_id');

        foreach($favorites as $favorite) {
            $perfis[] =  Http::get('https://api.github.com/user/'.$favorite)->json();
        }

        return response()->json([
            'perfis' => $perfis,
            'favorites' => collect($perfis)->pluck('id')
        ]);
    }

}
