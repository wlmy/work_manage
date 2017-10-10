<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{wiki_config('SITE_NAME','SmartWiki')}}</title>

    <!-- Bootstrap -->
    <link href="{{asset('static/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/styles/styles.css')}}" rel="stylesheet">
    <link href="{{asset('static/log/write.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('static/bootstrap/js/html5shiv.min.js')}}"></script>
    <script src="{{asset('static/bootstrap/js/respond.min.js')}}"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('static/scripts/jquery.min.js')}}"></script>

    <link href="{{asset('static/webuploader/webuploader.css')}}" rel="stylesheet">
    <link href="{{asset('static/cropper/cropper.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('/static/cropper/cropper.js')}}"></script>
    <script type="text/javascript" src="{{asset('/static/webuploader/webuploader.js')}}"></script>
    @yield('styles')
</head>
<body>
<div class="manual-reader">
    <header class="navbar navbar-static-top smart-nav navbar-fixed-top" role="banner" style="background-color: #5cb85c">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="navbar-brand" style="color: white">海风教育应用</a>
                <a href="#" class="navbar-brand" style="margin-left: 0px;color: white"><i class="fa fa-th-large"></i></a>
            </div>
            <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background-color: #5cb85c;color: white">
                            {{$member->account}}
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" style="min-width: 100px">
                            <li><a href="{{route('account.logout')}}" title="退出登录">退出登录&nbsp;<i class="fa fa-sign-out"></i>
                                </a></li>
                        </ul>

                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container-fluid smart-container member">
        <div class="row">
            <div class="page-left">
                <ul class="menu">
                    <li{!! (isset($member_users) ? ' class="active"' : '') !!}><a href="{{route('workLog.add')}}" class="item"  ><i class="fa fa-clipboard"></i> 写日报</a> </li>
                    <li{!! (isset($member_users) ? ' class="active"' : '') !!}><a href="{{route('workLog.other')}}" class="item"  ><i class="fa fa-clipboard"></i> 查看日报</a> </li>
                    <li{!! (isset($member_users) ? ' class="active"' : '') !!}><a href="{{route('workLog.index')}}" class="item"  ><i class="fa fa-th-list"></i> 日报统计</a> </li>
                    {{-- <li{!! (isset($member_index) ? ' class="active"' : '') !!}><a href="{{route('member.index')}}" class="item"><i class="fa fa-user"></i> 个人资料</a> </li>
                     <li{!! (isset($member_account) ? ' class="active"' : '') !!}><a href="{{route('member.account')}}" class="item"><i class="fa fa-lock"></i> 修改密码</a> </li>
                     <li{!! (isset($member_projects) ? ' class="active"' : '') !!}><a href="{{route('member.projects')}}" class="item"><i class="fa fa-sitemap"></i> 项目列表</a> </li>
                     @if(isset($member->group_level) and $member->group_level === 0)
                         <li{!! (isset($member_setting) ? ' class="active"' : '') !!}><a href="{{route('member.setting')}}" class="item"><i class="fa fa-gear"></i> 网站常量</a> </li>
                         <li{!! (isset($setting_site) ? ' class="active"' : '') !!}><a href="{{route('setting.site')}}" class="item"><i class="fa fa-cogs"></i> 网站设置</a> </li>
                         <li{!! (isset($member_users) ? ' class="active"' : '') !!}><a href="{{route('member.users')}}" class="item"><i class="fa fa-group"></i> 用户管理</a> </li>
                         <li{!! (isset($member_users) ? ' class="active"' : '') !!}><a href="{{route('workLog.add')}}" class="item"><i class="fa fa-group"></i> 写日志</a> </li>
                         <li{!! (isset($member_users) ? ' class="active"' : '') !!}><a href="{{route('workLog.index')}}" class="item"><i class="fa fa-group"></i> 看日志</a> </li>
                     @endif--}}
                </ul>
            </div>
            <div class="page-right">
                @yield('content')
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

</div>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('static/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('static/scripts/jquery.form.js')}}"></script>
<script type="text/javascript" src="{{asset('static/layer/layer.js')}}"></script>
<script src="{{asset('static/scripts/scripts.js')}}" type="text/javascript"></script>
@yield('scripts')
</body>
</html>