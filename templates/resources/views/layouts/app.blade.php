<!doctype html>
<html @php(language_attributes())>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php(do_action('get_header'))
  @php(wp_head())
  <style>
    .otgs-development-site-front-end {
      display: none;
    }
  </style>
</head>

<body @php(body_class())>
@php(wp_body_open())

@yield('header')

<main>
  @yield('content')
</main>

@yield('footer')

@php(do_action('get_footer'))
@php(wp_footer())
</body>

</html>
