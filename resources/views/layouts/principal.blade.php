<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard · 2026 Redesign Preview</title>

        <script>!function () { try { var t = localStorage.getItem("dash26-theme"), e = window.matchMedia("(prefers-color-scheme: dark)").matches; document.documentElement.setAttribute("data-theme", t || (e ? "dark" : "light")) } catch (t) { document.documentElement.setAttribute("data-theme", "light") } }()</script>

        @vite([
            'resources/css/style.css',
            'resources/css/app.css',
            'resources/js/runtime.js',
            'resources/js/vendor-fullcalendar.js',
            'resources/js/vendor-chartjs.js',
            'resources/js/vendors.js',
            'resources/js/2026.js',
            'resources/js/app.js',
            'resources/js/jquery4.js',
            'resources/js/sweetalert2.all.min.js'
        ])

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body data-active="dashboard" data-crumbs="Workspace | Dashboard">
        <div class="shell">
            @include('layouts.sidebar')


            <div class="main">
                @include('layouts.navbar')


                <main class="content">
                    <section class="hero">
                        <div class="hero-text"><span class="eyebrow" id="heroDate">Thursday · April 23 · 2026</span>
                            <h1 class="hero-title">Welcome back, <span class="accent">IVAN</span></h1>
                            <p class="hero-sub">Total visits are <strong>+10%</strong> week over week, unique visitors
                                steady, and bounce rate holding at 33%. Two new regions came online overnight.</p>
                        </div>
                    </section>
                    
                </main>
                <main class="content">
                    @yield('content')
                </main>
                <div data-shell-footer></div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>