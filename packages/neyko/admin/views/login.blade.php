@extends("admin::layouts.main")
@section("page")
<div class="login-box" id="login-box">
    <div class="login-box">
        <div class="login-logo">
            <h2>{{env("ADMIN_TITLE")}}</h2>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
        {!! \Form::open(array("url"=>"/admin/login","method"=>"post")) !!}
            @if(Session::get('message'))
                <div style="color:red; text-align:center;">{{Session::get('message')}}</div>
            @endif
            <p class="login-box-msg">Sign in to administrator panel</p>
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" placeholder="{{Lang::get('admin::templates.54')}}"/>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="{{Lang::get('admin::templates.55')}}"/>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember_me"/> {{trans('admin::templates.56')}}
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        {!! \Form::close() !!}
        </div>
    </div>
</div>
<div class="form-box" id="forgot-box" style="display:none;">
	<div class="header">{{trans('admin::templates.57')}}</div>
	<form action="/admin/forgotpassword" id="forgot-pass" method="post">
		<div class="body bg-gray">
			<p>{{trans('admin::templates.60')}}	</p>
			<div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="{{Lang::get('admin::templates.54')}}"/>
            </div>
        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">{{trans('admin::templates.61')}}</button>  
            <p><a href="#">{{trans('admin::templates.62')}}</a></p>
        </div>
	</form>
</div>
@endsection
