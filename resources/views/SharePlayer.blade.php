<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-stone-800">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
        
        <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
        
            <meta name="description" content="個人Vtuberグループいせぶい非公式データベースいせぶい所属{{ $currentMember -> display }}DBに登録されたデータのシェアページ">
            <meta property="og:title" content="非公式{{ $currentMember -> display }}DB | SharePage" />
            <meta property="og:type" content="article" />
            <meta property="og:url" content="https://isevdb.sakura.ne.jp/{{ $currentMember->name }}/share/{{ $id }}" />
            <meta property="og:image" content="https://i.ytimg.com/vi/{{ $player-> VideoID }}/hqdefault.jpg" />
            <meta property="og:site_name" content="非公式{{ $currentMember -> display }}DB">
            <meta property="og:description" content="非公式{{ $currentMember -> display }}DB No.{{ $player -> id }}「{{ $player -> title }}」シェアページ">
            <meta property="og:locale" content="ja_JP" />

            <meta name="twitter:card" content="player">
            <meta name="twitter:title" content="非公式{{ $currentMember -> display }}DB">
            <meta name="twitter:description" content="非公式{{ $currentMember -> display }}DB No.{{ $player -> id }}「{{ $player -> title }}」シェアページ">
            <meta name="twitter:image" content="https://i.ytimg.com/vi/{{ $player-> VideoID }}/hqdefault.jpg">
            <meta name="twitter:player" content="https://www.youtube.com/embed/{{ $player->VideoID }}?rel=0&start={{ $player->start }}&end={{ $player->end }}&amp;controls=0&amp;showinfo=0">

            <meta name="twitter:player:width" content="640" />
            <meta name="twitter:player:height" content="360" />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
    </head>
    <body class="font-body antialiased">
        <div id="app">
            <share-page :id="{{ $id }}" :current-member="{{ $currentMember }}" :player="{{ $player }}" :related="{{ $related }}"></share-page>
        </div>
        <script src="{{ mix('js/ogp.js') }}" defer></script>
    </body>
</html>
