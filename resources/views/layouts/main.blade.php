<!DOCTYPE html>
<html>
    @include("elements.head")
    <body>
        <div class="container">
            <div class="content">
                @if(\Session::get("message"))
                <div class="alert alert-info" role="alert">{!! \Session::get("message") !!}</div>
                @endif
                @yield("content")
            </div>
        </div>
    </body>
</html>
