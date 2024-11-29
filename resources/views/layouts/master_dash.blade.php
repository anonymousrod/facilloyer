<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
@include('layouts.layouts_dash.head')

<body>
    @include('layouts.layouts_dash.header')
    @include('layouts.layouts_dash.sidebar')

    <div class="page-wrapper">
        <div class="page-content">

            @yield('content')

            @include('layouts.layouts_dash.footer')
        </div>
    </div>
    @include('layouts.layouts_dash.script')

</body>

</html>
