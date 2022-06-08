<!doctype html>
<html lang="en" class="h-100">

@include('frontend.layouts.partials._head')

<body>
        @include('frontend.layouts.partials._nav')
        <section class="@if($errors->any()) content-size2 @else content-size @endif section-name  padding-y-sm">
            <div class="container">
                @yield('content')
            </div>
         </section>

        @include('frontend.layouts.partials._footer')

    @include('frontend.layouts.partials._scripts')
</body>
</html>
