<?php

namespace App\Http\Middleware;

use App\Models\posts;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikKomik
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) : Response
    {

        $id_author = posts::FindOrFail($request->id);
        $user = Auth::user();

        if($id_author->author != $user->id ){
            return response()->json('Kamu Bukan Pemilik Komik');
        }

        return $next($request);
    }
}
