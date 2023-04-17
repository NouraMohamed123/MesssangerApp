<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = Auth::user();
        $conversations = $user->conversations()->findOrFail($id);
        return $conversations->messages()->paginate();
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
        // $request->validate([
        //     'conversation_id' => [
        //         Rule::requiredIf(function () use ($request) {
        //             return !$request->input('user_id');
        //         }),
        //         'int',
        //         'exists:conversations,id',
        //     ],
        //     'user_id' => [
        //         Rule::requiredIf(function () use ($request) {
        //             return !$request->input('conversation_id');
        //         }),
        //         'int',
        //         'exists:users,id',
        //     ],
        // ]);

        //  $user = Auth::user();
        DB::beginTransaction();
        try {
            $user = User::find(1);
            $conversations_id = $request->post('conversation_id');
            $user_id = $request->post('user_id', 2);
            $message = $request->post('message');

            if ($conversations_id) {
                $conversation = $user
                    ->conversations()
                    ->findOrFail($conversations_id);
            } else {
                $conversation = Conversation::where('type', '=', 'peer')
                    ->whereHas('partisipants', function ($builder) use (
                        $user_id,
                        $user
                    ) {
                        $builder
                            ->join(
                                'participants as participants2',
                                'participants2.conversation_id',
                                '=',
                                'participants.conversation_id'
                            )
                            ->where('participants.user_id', '=', $user_id)
                            ->where('participants2.user_id', '=', $user->id);
                    })
                    ->first();

                if (!$conversation) {
                    $conversation = Conversation::create([
                        'user_id' => $user->id,
                        'type' => 'peer',
                        'label' => '7ob',
                    ]);
                    $conversation
                        ->partisipants()
                        ->attach([$user->id, $user_id]);
                }
            }
            $message = $conversation->messages()->create([
                'user_id' => $user->id,
                'type' => 'text',
                'body' => $message,
            ]);

            DB::statement(
                '
          INSERT INTO recipients (user_id,message_id)
           SELECT user_id,? from participants WHERE conversation_id = ?
            ',
                [$message->id, $conversation->id]
            );
            // Conversation::update([
            //     'last_message_id' => $message->id,
            // ]);
            event(new MessageCreated($message));
            DB::commit();
            return $message;
        } catch (throwable $e) {
            DB::rollback();
        }
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