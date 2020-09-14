<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Guest House | @yield('title', 'Dashboard')</title>
   @include('frontOffice.template.components.style')
</head>
<body>
   @include('frontOffice.template.components.navbar')
   @include('frontOffice.template.components.sidebar')
   @include('frontOffice.template.components.contentWrapper')
   @include('frontOffice.template.components.footer')
   @include('frontOffice.template.components.script')
</body>
</html>