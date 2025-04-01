<?php

namespace App\Http\Controllers;

use App\Models\UserViewer;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $userViewer = UserViewer::findOrFail($id);

        if (!hash_equals(sha1($userViewer->email), $hash)) {
            return redirect('/')->with('error', 'Invalid verification link.');
        }

        if (!$userViewer->hasVerifiedEmail()) {
            $userViewer->markEmailAsVerified();
        }

        return redirect('/')->with('success', 'Your email has been verified!');
    }
}
