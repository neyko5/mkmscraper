@extends("admin::elements.main")

@section("content")
<div class="box">
    <div class="box-header">
        <h3 class="box-title">
            {{Lang::get('admin::templates.3')}}
        </h3>
    </div>

    <div class="box-body table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th><i class="icon-user"></i>{{Lang::get('admin::templates.4')}}</th>
                    <th><i class="icon-edit"></i>{{Lang::get('admin::templates.5')}}</th>
                    <th><i class="icon-time"></i>{{Lang::get('admin::templates.6')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr><td>{{$log->username}}</td><td>{!! $log->message !!}</td><td>{{$log->created_at}}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-3">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{Lang::get('admin::templates.7')}}</h3>
            </div>

            @if(Session::get("message.adminmessage"))
            <div class="alert alert-info" style="margin-bottom:0px;">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                {{Session::get("message.adminmessage")}}
                <br>
            </div>
            @endif
            {!! \Form::open(array("method"=>"post","name"=>"createadmin","url"=>"/admin/createadmin")) !!}
                <div class="box-body">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="{{Lang::get('admin::templates.8')}}" />
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon">@</span>
                        <input type="text" name="email" class="form-control" placeholder="Email" />
                    </div><br> 
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="{{Lang::get('admin::templates.9')}}" />
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-retweet"></i></span>
                        <input type="password" class="form-control" name="passwordrepeat" placeholder="{{Lang::get('admin::templates.10')}}" />
                    </div><br>
                </div>
                <div class="box-footer">
                    <button type="submit" name="new_admin" class="btn btn-primary">{{Lang::get('admin::templates.14')}}</button>
                </div>
            {!! \Form::close() !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-3">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{Lang::get('admin::templates.11')}}</h3>
            </div>

            @if(Session::get("message.passwordmessage"))
            <div class="alert alert-info" style="margin-bottom:0px;">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                {{Session::get("message.passwordmessage")}}
                <br>
            </div>
            @endif
            {!! \Form::open(array("method"=>"post","name"=>"createadmin","url"=>"/admin/changepassword")) !!}
                <div class="box-body">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" name="oldpassword" placeholder="{{Lang::get('admin::templates.12')}}" />
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" name="newpassword" placeholder="{{Lang::get('admin::templates.13')}}" />
                    </div><br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-retweet"></i></span>
                         <input type="password" class="form-control" name="passwordrepeat" placeholder="{{Lang::get('admin::templates.10')}}" />
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="new_admin" class="btn btn-primary">{{Lang::get('admin::templates.15')}}</button>
                </div>
             {!! \Form::close() !!}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var oTable1 = $('table.table').dataTable({
            "order": [[ 2, "DESC" ]]
        });
    });
</script>
@endsection