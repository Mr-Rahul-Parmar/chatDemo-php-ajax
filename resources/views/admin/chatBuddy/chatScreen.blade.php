@extends('admin.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <main class="content">
        <div class="container p-0">
            <div class="card">
                <div class="row g-0">

                    @foreach($chatUser as $chat)
                        <div class="col-12 col-lg-7 col-xl-12">
                            <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                <div class="d-flex align-items-center py-1">

                                    <div class="position-relative">

                                        @if($chat->avatar == "")
                                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png"
                                                 class="rounded-circle mr-1" alt="Sharon Lessman" width="40"
                                                 height="40">
                                        @elseif(strpos($chat->avatar, "http") === 0)
                                            <img src="{{$chat->avatar}}" class="rounded-circle mr-1"
                                                 alt="Sharon Lessman" width="40" height="40">
                                        @else
                                            <img src="{{url('/avatars/'.$chat->avatar)}}" class="rounded-circle mr-1"
                                                 alt="Sharon Lessman" width="40" height="40">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 pl-3" id="typingStatus">
                                        <strong>{{$chat->name}}</strong>
                                        <div class="typingStatus">
                                            <small class="text-muted">
                                                {{$typingStatus}}
                                            </small>
                                        </div>
                                        {{--                                        <div class="text-muted small typingStatus"><em></em></div>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative">
                                <div class="chat-messages p-4">

                                    <div class="chat-message-right pb-4">
                                        @foreach($chatAdmin as $chatAdmin)
                                            <div class="flex-shrink-1 rounded py-2 px-3 mr-3">
                                                {{--                                                <div class="font-weight-bold mb-1">{{$chatAdmin->name}}</div>--}}
                                                <input type="hidden" name="from_name" value="{{$chatAdmin->name}}">
                                                <input type="hidden" id="toId" name="toId" value="{{$chat->id}}">

                                                <ul class="media-list" id="message">
                                                    @foreach($messages as $message )
                                                        <input type="hidden" id="msgId" name="msgId"
                                                               value="{{$message->to_user_id}}">
                                                        @if($message->to_user_id == $chatAdmin->id)
                                                            <li class="media flex-shrink-1 rounded py-2 px-3 ml-3">
                                                                <div class="media-body">
                                                                    <div class="media">
                                                                        @if($chat->avatar == "")
                                                                            <img
                                                                                src="https://bootdey.com/img/Content/avatar/avatar7.png"
                                                                                class="rounded-circle mr-1"
                                                                                alt="{{$chat->name}}" width="40"
                                                                                height="40">
                                                                        @elseif(strpos($chat->avatar, "http") === 0)
                                                                            <img
                                                                                src="{{$message->avatar}}"
                                                                                class="rounded-circle mr-1 adminPic"
                                                                                alt="{{$chat->name}}" width="40"
                                                                                height="40">
                                                                        @else
                                                                            <img
                                                                                src="{{url('/avatars/'.$message->avatar)}}"
                                                                                class="rounded-circle mr-1 adminPic"
                                                                                alt="{{$chat->name}}" width="40"
                                                                                height="40">
                                                                        @endif
                                                                        <div class="media-body">
                                                                            {{$message->chat_message}}
                                                                            <br/>
                                                                            <bold><small
                                                                                    class="text-muted">{{$message->name}}
                                                                                    | {{$message->created_at}}
                                                                                </small></bold>
                                                                            <hr>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @else
                                                            <li class="media flex-shrink-1 rounded py-2 px-3 ml-3 adminLi ">
                                                                <div class="media-body">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            {{$message->chat_message}}
                                                                            <br/>
                                                                            <bold><small
                                                                                    class="text-muted">{{$message->name}}
                                                                                    | {{$message->created_at}}
                                                                                </small></bold>
                                                                            <hr>
                                                                        </div>
                                                                        @if($chatAdmin->avatar == "")
                                                                            <img
                                                                                src="https://bootdey.com/img/Content/avatar/avatar7.png"
                                                                                class="rounded-circle mr-1"
                                                                                alt="Chris Wood" width="40"
                                                                                height="40">
                                                                        @elseif(strpos($chatAdmin->avatar, "http") === 0)
                                                                            <img
                                                                                src="{{$chatAdmin->avatar}}"
                                                                                class="rounded-circle mr-1 adminPic"
                                                                                alt="Chris Wood" width="40"
                                                                                height="40">
                                                                        @else
                                                                            <img
                                                                                src="{{url('/avatars/'.$chatAdmin->avatar)}}"
                                                                                class="rounded-circle mr-1 adminPic"
                                                                                alt="Chris Wood" width="40"
                                                                                height="40">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endif
                                                        <div id="user_details"></div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>


                                    {{--                                    <div class="section-content">--}}
                                    {{--                                        <?php foreach($messages as $row){?>--}}
                                    {{--                                        <div class="row chat">--}}
                                    {{--                                            <div class="col-md-6">--}}
                                    {{--                                                <div class="bubble1 me" style="color:black"><p><?php echo $row->chat_message;?></p>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <div class="row chat">--}}
                                    {{--                                            <div class="bubble you" style="color:white"><p><?php echo $row->chat_message;?></p></div>--}}
                                    {{--                                        </div><?php }?>--}}
                                    {{--                                    </div>--}}



                                    {{--                                                                        <div class="chat-message-left pb-4">--}}
                                    {{--                                                                            <div>--}}
                                    {{--                                                                                @if($chat->avatar == "")--}}
                                    {{--                                                                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png"--}}
                                    {{--                                                                                         class="rounded-circle mr-1" alt="Sharon Lessman" width="40"--}}
                                    {{--                                                                                         height="40">--}}
                                    {{--                                                                                @else--}}
                                    {{--                                                                                    <img src="{{url('/avatars/'.$chat->avatar)}}"--}}
                                    {{--                                                                                         class="rounded-circle mr-1" alt="Sharon Lessman" width="40"--}}
                                    {{--                                                                                         height="40">--}}
                                    {{--                                                                                @endif--}}

                                    {{--                                                                                <div class="text-muted small text-nowrap mt-2">2:34 am</div>--}}
                                    {{--                                                                            </div>--}}
                                    {{--                                                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">--}}
                                    {{--                                                                                <div class="font-weight-bold mb-1">{{$chat->name}}</div>--}}
                                    {{--                                                                                <ul class="media-list" id="message">--}}
                                    {{--                                                                                    @foreach($messages as $message )--}}
                                    {{--                                                                                        @if($message->from_user_id == $chat->id)--}}
                                    {{--                                                                                            <li class="media">--}}
                                    {{--                                                                                                <div class="media-body">--}}
                                    {{--                                                                                                    <div class="media">--}}
                                    {{--                                                                                                        <div class="media-body">--}}
                                    {{--                                                                                                            {{$message->chat_message}}--}}
                                    {{--                                                                                                            <br/>--}}
                                    {{--                                                                                                            <bold><small--}}
                                    {{--                                                                                                                    class="text-muted">{{$message->name}}--}}
                                    {{--                                                                                                                </small></bold>--}}
                                    {{--                                                                                                            <hr>--}}
                                    {{--                                                                                                        </div>--}}
                                    {{--                                                                                                    </div>--}}
                                    {{--                                                                                                </div>--}}
                                    {{--                                                                                            </li>--}}
                                    {{--                                                                                        @endif--}}
                                    {{--                                                                                    @endforeach--}}
                                    {{--                                                                                </ul>--}}
                                    {{--                                                                            </div>--}}
                                    {{--                                                                        </div>--}}
                                    {{--                                </div>--}}
                                </div>
                                <div class="flex-grow-0 py-3 px-4 border-top">
                                    <div class="input-group">
                                        <input type="text" class="form-control chat_message" name="message"
                                               id="messageBox"
                                               placeholder="Type your message">
                                        {{--                                        <button class="btn btn-primary" id="send">Send</button>--}}
                                        <a class="btn btn-primary" id="send"><i class="fa fa-paper-plane"></i> Send</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('/assets/js/jquery-1.9.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/js/moment.js')}}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            setTimeout(realTime, 2000);
        });

        // $(document).ready(function () {
        //     setTimeout(fetch_unseen_msg, 2000);
        // });
        //
        // function fetch_unseen_msg() {
        //     var to_user_id = $('#userId').val();
        //     $.ajax({
        //         url: "/chat-buddy/get/unread-msg",
        //         method: "POST",
        //         data: {to_user_id: to_user_id},
        //         success: function (data) {
        //             $('#unreadMsg').html(data);
        //         }
        //     })
        // }

        function realTime() {
            var id = $('#msgId').val();
            var to_user_id = $('#toId').val();

            $.ajax({
                type: 'POST',
                url: '/chat-buddy/get',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: id, to_user_id: to_user_id},
                success: function (data) {
                    const message = data[0].messages;
                    const today = new Date();
                    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate() + ' ' + today.getHours() + ':' + today.getMinutes();

                    $.each(message, function () {
                        var msgKey = Object.keys(this)[0];
                        var message = this[msgKey];
                        var statusKey = Object.keys(this)[5];
                        var status = this[statusKey];
                        var timeKey = Object.keys(this)[4];
                        var time = this[timeKey];
                        const e = moment.utc(time).toDate();
                        var db_date = e.getFullYear() + '-' + (e.getMonth() + 1) + '-' + e.getDate() + ' ' + e.getHours() + ':' + e.getMinutes();
                        var nameKey = Object.keys(this)[3];
                        var name = this[nameKey];

                        if (status == 0) {
                            $('#message').append('  <li class="media"><div class="media-body"><div class="media"><div class="media-body">' + message + '<br/><small class="text-muted">' + name + '|' + time + '</small><hr/></div></div></div></li>');
                            // for (var i = 0; i < data.length; i++) {
                            //
                            // }
                        }
                    });


                    // //  $('#message').replaceWith(' <ul class="media-list" id="message"></ul>');
                    //   //$('#message').replaceWith(' <div class="media-list" id="message"></div>');
                    //   for (var i = 0; i < data.length; i++) {
                    //       $('#message').append('  <li class="media"><div class="media-body"><div class="media"><div class="media-body">' + data.messages + '<br/><small class="text-muted">' + data[0].from_name + '|' + data[0].created_at + '</small><hr/></div></div></div></li>');
                    //
                    //       // $('#message').append(' <div class="media"><div class="media-body"><div class="media"><div class="media-body">' + data[i].message + '<br/><small class="text-muted">' + data[i].from_name + '|' + data[i].created_at + '</small><hr/></div></div></div></div>')
                    //   }
                },
            });
            setTimeout(realTime, 2000);
        }

        // $('#send').submit(function (event) {
        //     event.preventDefault();
        //     $.ajax({
        //         type: 'post',
        //         url: '/chat-buddy/send',
        //         data: {
        //             'from_name': $('input[name=from_name]').val(),
        //             'to_id': $('#toId').val(),
        //             'message': $('input[name=message]').val(),
        //         },
        //         success: function (data) {
        //             $('#message').append('  <li class="media"><div class="media-body"><div class="media"><div class="media-body">' + data[1].chat_message + '<br/><small class="text-muted">' + data[0] + '|' + data[1].created_at + '</small><hr/></div></div></div></li>');
        //             // $('#message').append('  <div class="media"><div class="media-body"><div class="media"><div class="media-body">' + data.message + '<br/><small class="text-muted">' + data.from_name + '|' + data.created_at + '</small><hr/></div></div></div></div>');
        //         }
        //     })
        //     return false;  // stop browser from submit/refresh
        //
        // })

        $("#send").click(function () {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/chat-buddy/send',
                data: {
                    'from_name': $('input[name=from_name]').val(),
                    'to_id': $('#toId').val(),
                    'message': $('input[name=message]').val(),
                },
                success: function (data) {
                    // $('#message').append('  <li class="media"><div class="media-body"><div class="media"><div class="media-body">' + data[1].chat_message + '<br/><small class="text-muted">' + data[0] + '|' + data[1].created_at + '</small><hr/></div></div></div></li>');
                    // $('#message').append('  <div class="media"><div class="media-body"><div class="media"><div class="media-body">' + data.message + '<br/><small class="text-muted">' + data.from_name + '|' + data.created_at + '</small><hr/></div></div></div></div>');
                }
            })
            $('input[name=message]').val('');
            return false;
        });

        // $(document).ready(function () {
        //     $("#send").click(function () {
        //         event.preventDefault();
        //         $.ajax({
        //             type: "POST",
        //             url: "/chat-buddy/send",
        //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //             data: {
        //                 'from_name': $('input[name=from_name]').val(),
        //                 'to_id': $('#toId').val(),
        //                 'message': $('input[name=message]').val(),
        //             },
        //             success: function (data) {
        //                 // $('#message').append('  <li class="media"><div class="media-body"><div class="media"><div class="media-body">' + message + '<br/><small class="text-muted">' + name + '</small><hr/></div></div></div></li>');
        //             },
        //         });
        //         $('input[name=message]').val('')
        //         return false;
        //     });
        // });


        {{--$(document).on('focus', '.chat_message', function () {--}}
        {{--    var is_type = '1';--}}
        {{--    var to_user_id = $('#toId').val();--}}
        {{--    $.ajax({--}}
        {{--        url: "{{url('update_is_type_status')}}",--}}
        {{--        method: "POST",--}}
        {{--        data: {is_type: is_type, to_user_id: to_user_id},--}}
        {{--        success: function (data) {--}}
        {{--            var output = data['0'].output;--}}
        {{--            $.each(output, function () {--}}
        {{--                var status = Object.keys(this)[0];--}}
        {{--                if (status == 1) {--}}
        {{--                    $('#typingStatus').append('<div class="typingStatus"><em>Typing...</em></div>');--}}
        {{--                }--}}

        {{--            });--}}


        {{--        }--}}
        {{--    })--}}
        {{--});--}}

        {{--$(document).on('blur', '.chat_message', function () {--}}
        {{--    var is_type = '0';--}}
        {{--    var to_user_id = $('#toId').val();--}}
        {{--    $.ajax({--}}
        {{--        url: "{{url('update_is_type_status')}}",--}}
        {{--        method: "POST",--}}
        {{--        data: {is_type: is_type, to_user_id: to_user_id},--}}
        {{--        success: function (res) {--}}
        {{--            var output = res['0'].output;--}}
        {{--            $.each(output, function () {--}}
        {{--                var status = Object.keys(this)[0];--}}
        {{--                console.log(status)--}}
        {{--                if (status == 0) {--}}
        {{--                    $('#typingStatus').append('<div class="typingStatus"><em></em></div>');--}}
        {{--                }--}}
        {{--            });--}}
        {{--        }--}}
        {{--    })--}}
        {{--});--}}

        $(document).on('focus', '.chat_message', function () {
            var is_type = 'yes';
            var to_user_id = $('#toId').val();
            $.ajax({
                url: "{{url('update_is_type_status')}}",
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {is_type: is_type, to_user_id: to_user_id},
                success: function () {

                }
            })
        });

        $(document).on('blur', '.chat_message', function () {
            var is_type = 'no';
            var to_user_id = $('#toId').val();
            $.ajax({
                url: "{{url('update_is_type_status')}}",
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {is_type: is_type, to_user_id: to_user_id},
                success: function () {

                }
            })
        });
    </script>
@endsection
