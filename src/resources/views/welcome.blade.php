<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lug'at</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@500;700;900&display=swap');

    :root {
    --ink: #231942;
    --muted: #6d628f;
    --pink: #ff6b9d;
    --yellow: #ffd23f;
    --blue: #4d96ff;
    --green: #2ec4a6;
    --main: #3d6bff;       /* asosiy rang — shu yerdan almashtiring */
    --main-2: #19b3c9;     /* gradientning ikkinchi rangi */
    --main-dark: #2a4fd1;  /* tugma soyasi */
    --font: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    * { box-sizing: border-box; margin: 0; }
    html, body { height: 100%; }

    body {
        display: block;
        min-width: 0;
        font-family: var(--font);
        color: var(--ink);
        background:
            radial-gradient(circle at 12% 18%, rgba(255, 210, 63, .35), transparent 38%),
            radial-gradient(circle at 88% 82%, rgba(46, 196, 166, .30), transparent 40%),
            radial-gradient(circle at 85% 15%, rgba(77, 150, 255, .22), transparent 35%),
            linear-gradient(160deg, #ffe0ee 0%, #e4e6ff 50%, #d6f6ec 100%) fixed;
        -webkit-tap-highlight-color: transparent;
    }

    #app { width: 100%; max-width: none; margin: 0; padding: 0; }

    </style>
</head>
<body>
    <div id="app">
        <welcome></welcome>
    </div>
</body>
</html>
