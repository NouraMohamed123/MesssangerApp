<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class messengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $user = Auth::user();
        $friends = User::where('id', '<>', $user->id)
            ->orderBy('name')
            ->paginate();
        $chats = $user
            ->conversations()
            ->with([
                'partisipants' => function ($builder) use ($user) {
                    $builder->where('id', '<>', $user->id);
                },
            ])
            ->get();

        return $chats;
        $messages = [];
        if ($id) {
            //advantage collection can make condition
            $chat = $chats->where('id', $id)->first();
            $messages = $chat
                ->messages()
                ->with('user')
                ->paginate();
        }

        return view('messenger', [
            'friends' => $friends,
            'chats' => $chats,
            'messages' => $messages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}