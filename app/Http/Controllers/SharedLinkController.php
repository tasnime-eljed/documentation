<?php

namespace App\Http\Controllers;

use App\Models\SharedLink;
use Illuminate\Http\Request;

class SharedLinkController extends Controller
{
    public function accederViaLienPartage($token)
    {
        $sharedLink = SharedLink::where('token', $token)->firstOrFail();
        $documentation = $sharedLink->documentation;

        $documentation->incrementerVues();

        return view('documentations.shared', compact('documentation', 'sharedLink'));
    }

    public function show($token)
    {
        return $this->accederViaLienPartage($token);
    }
}
