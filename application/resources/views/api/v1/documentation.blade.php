<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width">

  <title>API v1 Documentation</title>

  <!-- Flatdoc -->
  <script src="{{ '/application/api/v1/jquery.1.9.1.min.js' }}"></script>
  <script src="{{ '/application/api/v1/flatdoc/legacy.js' }}"></script>
  <script src="{{ '/application/api/v1/flatdoc/flatdoc.js' }}"></script>

  <!-- Flatdoc theme -->
  <link  href="{{ '/application/api/v1/flatdoc/theme-white/style.css' }}" rel='stylesheet'>
  <link  href="{{ '/application/api/v1/style.css' }}" rel='stylesheet'>
  <script src="{{ '/application/api/v1/flatdoc/theme-white/script.js' }}"></script>

  <!-- Meta -->
  <meta content="Your Project" property="og:title">
  <meta content="Your Project description goes here." name="description">

  <!-- Initializer -->
  <script>
    Flatdoc.run({
      fetcher: Flatdoc.file("{{ '/application/api/v1/documentation.md' }}")
    });
  </script>
</head>
<body role='flatdoc' class="">

  <div class='content-root'>
    <div class='menubar'>
      <div class='menu section' role='flatdoc-menu'></div>
    </div>
    <div role='flatdoc-content' class='content'></div>
  </div>

</body>
</html>