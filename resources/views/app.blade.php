<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-stone-800">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="canonical" href="https://isevdb.net">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#fd5183">
        <meta name="apple-mobile-web-app-title" content="非公式いせぶいDB">
        <meta name="application-name" content="非公式いせぶいDB">
        <meta name="msapplication-TileColor" content="#fd5183">
        <meta name="theme-color" content="#ffffff">
        <meta name="og:image" content="https://isevdb.net/images/isevdb_ogp.png">

        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="非公式いせぶいデータベース">
        <meta name="twitter:description" content="いせぶいメンバーの切り抜き・好きな声・好きな場面・エピソード・ファンアートなどをまとめ、貯蓄し気軽に見返せる非公式データベース">
        <meta name="twitter:image" content="https://isevdb.net/images/isevdb_ogp.png">
        
        @if( Request::routeIs('TopPage'))
        <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
        @else
        <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
        @endif
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </head>
    <body class="font-body antialiased">
        @inertia

        @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv
    </body>
</html>
