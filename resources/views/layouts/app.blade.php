<!DOCTYPE html>
<html lang="fr" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="AgriConnect : Plateforme de mise en relation directe entre producteurs agricoles et acheteurs au Bénin.">
    <title>{{ $title ?? 'AgriConnect' }}</title>
    
    <!-- Police Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        :root {
            --g: #1A6B3C; --gd: #124d2b; --gl: #eef5f1;
            --o: #C17F3B; --ol: #fdf6ed;
            --bg: #F9FAFB; --t: #1F2937; --tl: #6B7280; --w: #FFFFFF;
            --sh: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            --r: 16px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        body { background: var(--bg); color: var(--t); line-height: 1.6; overflow-x: hidden; }

        .header { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); padding: 1rem 0; position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .c { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        @include('layouts.nav')
    </header>

    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('layouts.footer')

</body>
</html>
