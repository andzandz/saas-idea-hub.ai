<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerateIdeaSubmitController extends Controller
{
    public function __invoke( Request $request )
    {
        // TODO
        sleep( 3 );
        dd( $request->all() );

        return redirect()->route( 'your-ideas' );
    }
}
