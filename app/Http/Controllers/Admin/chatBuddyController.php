<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\chatMessageBuddy;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDO;

class chatBuddyController extends Controller
{
    public function chatBuddy(Request $request)
    {
        return view('admin.chatBuddy.chatDashboard');
    }

    public function chatUserList()
    {
        $param['uList'] = User::all();
        return view('admin.layouts.partials.left-sidebar', $param);
    }

    public function chatBuddyUserChat(Request $request)
    {

        $param['chatAdmin'] = User::where('id', '=', Auth::id())->get();
        $param['chatUser'] = User::where('id', '=', $request->id)->get();
        $param['users'] = User::all();
        $param['OnlineUsers'] = User::select("*")
            ->whereNotNull('last_seen')
            ->orderBy('last_seen', 'DESC')
            ->paginate(10);
        $senderid = Auth::id();
        $receivermsgid = $request->id;
        $param['messages'] = DB::table('chat_message_buddies')
            ->join('users', 'chat_message_buddies.from_user_id', '=', 'users.id')
            ->where('from_user_id', $senderid)->where('to_user_id', $receivermsgid)
            ->orwhere('from_user_id', $receivermsgid)->where('to_user_id', $senderid)
            ->select('chat_message_buddies.chat_message', 'chat_message_buddies.from_user_id', 'chat_message_buddies.to_user_id', 'chat_message_buddies.created_at as created_at', 'users.name as name', 'users.avatar as avatar')
            ->orderby('chat_message_buddies.created_at', 'asc')
            ->get();
        $connect = new PDO("mysql:host=localhost;dbname=ChatBuddy", "root", "3rd@123");
        $param['typingStatus'] = fetch_is_type_status($receivermsgid,$connect);
        return ($request->ajax() ? view('partial') : view('admin.chatBuddy.chatScreen', $param));

    }

    public function sendMessage(Request $request)
    {
        $id = Auth::id();
        $message = new chatMessageBuddy();
        $message->from_user_id = $id;
        $message->to_user_id = $request->to_id;
        $message->chat_message = $request->message;
        $message->save();
        $fromName = $request->from_name;
        return response()->json(array($fromName, $message));
    }

    public function getMessage(Request $request)
    {

        $senderid = Auth::id();
        $receivermsgid = $request->to_user_id;
        $param['chatAdmin'] = User::where('id', '=', $senderid)->get();
        $param['chatUser'] = User::where('id', '=', $request->id)->get();
        $param['messages'] = DB::table('chat_message_buddies')->where('status', '==', 0)
            ->join('users', 'chat_message_buddies.from_user_id', '=', 'users.id')
            ->where('from_user_id', $senderid)->where('to_user_id', $receivermsgid)
            ->orwhere('from_user_id', $receivermsgid)->where('to_user_id', $senderid)
            ->where('to_user_id', '=', $senderid)->where('from_user_id', '=', $receivermsgid)
            ->select('chat_message_buddies.chat_message', 'chat_message_buddies.from_user_id', 'chat_message_buddies.to_user_id', 'users.name as name', 'chat_message_buddies.created_at as created_at', 'chat_message_buddies.status as status', 'users.avatar as avatar')
            ->orderby('chat_message_buddies.created_at', 'asc')
            ->get();

//        $param['messages'] = chatMessageBuddy::where('status', '==', 0)->orwhere('to_user_id', '=', $senderid)->join('users', 'chat_message_buddies.from_user_id', '=', 'users.id')->select('chat_message_buddies.chat_message', 'chat_message_buddies.from_user_id', 'chat_message_buddies.to_user_id', 'users.name as name', 'chat_message_buddies.created_at as created_at', 'chat_message_buddies.status as status', 'users.avatar as avatar')->get();

        chatMessageBuddy::where('from_user_id', $senderid)->update(['status' => 1]);

        return response()->json(array($param));
    }

    public function getOnlineStatus(Request $request)
    {

        $param['OnlineUsers'] = chatMessageBuddy::select("*")
            ->whereNotNull('status')
            ->orderBy('status', 'DESC')
            ->paginate(10);
        $senderid = Auth::id();
        $receivermsgid = $request->to_user_id;

//        $connect = new PDO("mysql:host=localhost;dbname=ChatBuddy", "root", "3rd@123");
//        $param['typingStatus'] = fetch_is_type_status($receivermsgid,$connect);
//        $param['unseenMessage'] = $statement->count();
//        return response()->json($OnlineUsers);
        return view('admin.layouts.partials.left-sidebar', $param);

    }

//    public function getUnseenMessage(Request $request)
//    {
//
//        $param['unseenMessage'] = DB::table("chat_message_buddies")->where("from_user_id", "=", Auth::id())->where("to_user_id", "=", $request->to_user_id)->where("status", "=", 0)->get();
////        $param['unseenMessage'] = DB::table('chat_message_buddies')->where("read_msg_status", "=", 1)->get();
//        return view('admin.layouts.partials.left-sidebar', $param);
//    }

    public function chatStatus(Request $request)
    {
//        $senderid = Auth::id();
//        $user_id = $request->to_user_id;
//        $param['output'] = DB::table("chat_message_buddies")->select("is_type")->where("from_user_id", "=",$senderid)->limit(1)->orderBy("status","desc")->get();
////        $param['output'] = DB::table('chat_message_buddies')->where('status', '==', 0)
////            ->join('users', 'chat_message_buddies.from_user_id', '=', 'users.id')
////            ->where('from_user_id', $senderid)->where('to_user_id', $user_id)
////            ->orwhere('from_user_id', $user_id)->where('to_user_id', $senderid)
////            ->where('to_user_id', '=', $senderid)->where('from_user_id', '=', $user_id)
////            ->select('chat_message_buddies.read_msg_status')
////            ->orderby('chat_message_buddies.created_at', 'asc')
////            ->get();
//        $param['chatUser'] = User::where('id', '=', $request->id)->get();
//        chatMessageBuddy::where('from_user_id', $senderid)->where('to_user_id', $user_id)->update(['read_msg_status' => 1]);
////        return view('admin.chatBuddy.chatScreen', $param);
//        return response()->json(array($param));
        return view('admin.chatBuddy.update_is_type_status');

    }

    public function fetch_is_type_status(Request $request)
    {
        $senderid = Auth::id();
        $user_id = $request->to_user_id;
        $param['chatUser'] = User::where('id', '=', $request->id)->get();

        $connect = new PDO("mysql:host=localhost;dbname=ChatBuddy", "root", "3rd@123");
        $param['typingStatus'] = fetch_is_type_status($user_id,$connect);
        dd($param['typingStatus']);
//        return view('admin.chatBuddy.chatScreen', $param);
                return response()->json($param);

    }

}

