<meta name="csrf-token" content="{{ csrf_token() }}"/>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ChatBuddy</span>
    </a>

<!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @foreach($avatar as $img)
                    @if($img == "")
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="img-circle elevation-2"
                             alt="User Image">
                    @elseif(strpos($img, "http") === 0)
                        <img src="{{($img)}}" class="img-circle elevation-2"
                             alt="User Image">
                    @else
                        <img src="{{(url('avatars/'.$img))}}" class="img-circle elevation-2"
                             alt="User Image">
                    @endif
                @endforeach
            </div>
            @if(Auth::user() == true)
                <div class="info">
                    <a href="#" class="d-block">{{Auth::user()->name}}</a>
                </div>
            @endif
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            All User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($OnlineUsers as $user)
                            @if($user->id != Auth::id())
                                <li>
                                    <a href="{{route('chat.user',$user->id)}}"
                                       class="list-group-item list-group-item-action border-0 start_chat" id="chatUser">
                                        <input type="hidden" name="userId" id="userId" value="{{$user->id}}">
                                        <div class="d-flex align-items-start">
                                            @if($user->avatar == "")
                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png"
                                                     class="rounded-circle mr-1" alt="{{$user->name}}" width="40"
                                                     height="40">
                                            @elseif(strpos($user->avatar, "http") === 0)
                                                <img src="{{$user->avatar}}"
                                                     class="rounded-circle mr-1" alt="{{$user->name}}" width="40"
                                                     height="40">
                                            @else
                                                <img src="{{url('/avatars/'.$user->avatar)}}"
                                                     class="rounded-circle mr-1" alt="{{$user->name}}" width="40"
                                                     height="40">
                                            @endif
                                            <div class="flex-grow-1 ml-3">
                                                <div class="small" id="unreadMsg">
                                                    {{$user->name}}

{{--                                                    @if($unseenMessage->count() > 0)--}}
{{--                                                        @if($user->id != Auth::id())--}}
{{--                                                            <span class="label label-success">{{$unseenMessage->count()}}</span>--}}
{{--                                                        @endif--}}
{{--                                                    @else--}}
{{--                                                        <span class="label label-success">0</span>--}}
{{--                                                    @endif--}}
                                                </div>
                                                <div class="small" id="user_details">
                                                    @if(Cache::has('user-is-online-' . $user->id))
                                                        <span class="fas fa-circle chat-online"></span> Online
                                                    @else
                                                        <span class="fas fa-circle chat-offline"></span> Offline
                                                        {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Layout Options
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">6</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/layout/top-nav.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Top Navigation</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
{{--@extends('admin.layouts.master')--}}
{{--@section('scripts')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $.ajaxSetup({--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                }--}}
{{--            });--}}

{{--            $('.chatUser').on('click', function () {--}}
{{--                var id = $(this).data(id);--}}
{{--                var href = $(this).attr("href");--}}
{{--                $.ajax({--}}
{{--                    method: 'GET',--}}
{{--                    url: '{{url('chat-buddy-user')}}',--}}
{{--                    data: {id: id},--}}
{{--                    dataType: 'json',--}}
{{--                    success: function (res) {--}}
{{--                        $("#page-main").html(data);--}}
{{--                    }--}}
{{--                });--}}
{{--                return false;--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}

{{--<script src="https://code.jquery.com/jquery-3.5.0.js"></script>--}}
{{--</script>--}}
{{--<script type="text/javascript">--}}
{{--    $(document).ready(function () {--}}
{{--        setTimeout(function () {--}}
{{--            location.reload(true);--}}
{{--        }, 1000);--}}
{{--    });--}}
{{--</script>--}}

<script type="text/javascript" src="{{asset('/assets/js/jquery-1.9.1.min.js')}}"></script>
<script>

    $(document).ready(function () {
        setTimeout(fetch_user, 2000);
        // setTimeout(fetch_unseen_msg, 2000);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function fetch_user() {
            var to_user_id = $('#userId').val();
            $.ajax({
                url: "/chat-buddy/get/online-status",
                method: "POST",
                data: {to_user_id: to_user_id},
                success: function (data) {
                    $('#user_details').html(data);
                }
            })
        }

    });

</script>
