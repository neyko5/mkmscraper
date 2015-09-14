<!DOCTYPE html>
<html lang="en">
    <head>
        @include("admin::elements.head")
    </head>
    <body class="@if(\Session::get("admin")) sidebar-mini skin-blue-light @else  login-page  @endif">
     	@yield("page")
        @include("admin::elements.footer")
    </body>
</html>