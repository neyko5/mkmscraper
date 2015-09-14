@extends("admin::layouts.main")

@section("page")
<header class="main-header">
    <a href="/admin" class="logo">
        @if(\Config::get("admin.admin.picture"))
        <img src="{{\Config::get("admin.admin.picture")}}" class="logo-lg" />
        @else
        {{\Config::get("admin.admin.site_title")}}
        @endif
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/admin/logout">
                        <i class="icon-off"></i>
                        {{trans("admin::templates.16")}}
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <section class="sidebar">
        @include("admin::elements.navigation")
    </section>
</aside>
<div class="wrapper row-offcanvas row-offcanvas-left">


    <aside class="right-side">
        <section class="content-header">
            <h1>
                {{$module->label}}
                <small>
                    <i class="icon-double-angle-right"></i>
                    {{$action}}
               </small>
            </h1>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="/admin/">{{trans("admin::templates.18")}}</a>
                </li>
                @if($module->moduleparent)
                <li>
                    <a href="/admin/{{$module->moduleparent->name}}">{{$module->moduleparent->label}}</a>
                </li>
                @endif
                <li class="active">
                    <a href="/admin/{{$module->name}}">{{$module->label}}</a>
                </li>
            </ol>
        </section>
        <section class="content">
            @if(Session::get("message"))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4>	<i class="icon fa fa-check"></i> Success!</h4>
                {!! Session::get("message") !!}
            </div>
            @endif
            @yield("content")
        </section>
    </aside>
</div>
@if(isset($module) && $module->name!="dashboard" && isset($add))
    <a href="/admin/{{$module->name}}/new" class="btn" style="float:right;">
        <i class="icon-plus-sign  bigger-125"></i>
        {{Lang::get("admin::templates.19")}}
    </a>
@endif
@endsection

