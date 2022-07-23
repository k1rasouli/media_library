<?php

namespace App\Http\Controllers;

use App\libs\Universal;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Loading index view or redirecting to admin page if used is logged in
     */
    public function index()
    {
        if(!auth()->check())
            return view('index');
        return redirect(route('AdminIndex'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * login post method
     */
    public function login(Request $request)
    {
        $instance = Universal::internalApiCall(route('ApiAuthLogin'), 'POST', [
            'email' => $request->email,
            'password' => $request->password,
            'remember' => isset($request->remember),
        ]);

        if($instance->status == Response::HTTP_OK)
            return redirect(route('AdminIndex'));
        return redirect()->back()
            ->with('message', __('credential_error'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Log user out
     */
    public function logout()
    {
        auth()->logout();
        return redirect(route('HomeIndex'));
    }
}
