<template>
  <main class="welcome">
    <div class="top">
      <div class="words" aria-hidden="true">
        <div class="w w1"><b>книга</b><small>kitob</small></div>
        <div class="w w2"><b>вода</b><small>suv</small></div>
        <div class="w w3"><b>дом</b><small>uy</small></div>
      </div>

      <div class="head">
        <h1 class="title">Lug'at</h1>
        <p>Rus va o'zbek so'zlarini o'rganing</p>
      </div>
    </div>

    <a href = "/menu" class="btn">Boshlash</a>

    <div class="scene">
      <svg viewBox="0 18 360 308" role="img" aria-label="Ikki do'st salomlashmoqda">
        <circle cx="180" cy="190" r="142" fill="#fff" opacity=".55" />

        <!-- bezaklar -->
        <polygon points="0,-10 3,-3 10,-3 4,2 6,10 0,5 -6,10 -4,2 -10,-3 -3,-3" transform="translate(14 262)" fill="#ffd23f" />
        <polygon points="0,-10 3,-3 10,-3 4,2 6,10 0,5 -6,10 -4,2 -10,-3 -3,-3" transform="translate(330 170) scale(.8)" fill="#ff6b9d" />
        <polygon points="0,-10 3,-3 10,-3 4,2 6,10 0,5 -6,10 -4,2 -10,-3 -3,-3" transform="translate(180 120) scale(.7)" fill="#2ec4a6" />

        <g transform="translate(186 150)"><circle r="17" fill="#4d96ff" /><text y="7" fill="#fff">Ш</text></g>
        <g transform="translate(22 112)"><circle r="17" fill="#ffd23f" /><text y="7" fill="#231942">Я</text></g>
        <g transform="translate(340 126)"><circle r="17" fill="#ff6b9d" /><text y="7" fill="#fff">Oʻ</text></g>

        <!-- yerdagi soyalar -->
        <ellipse cx="80" cy="322" rx="54" ry="6" fill="#231942" opacity=".12" />
        <ellipse cx="280" cy="322" rx="54" ry="6" fill="#231942" opacity=".12" />

        <!-- kitob -->
        <g transform="translate(180 252) scale(.8)" class="book">
          <rect x="-58" y="-28" width="116" height="52" rx="9" fill="#ffd23f" />
          <path d="M-2 -22 Q-28 -30 -52 -22 L-52 14 Q-28 6 -2 14Z" fill="#fff" />
          <path d="M2 -22 Q28 -30 52 -22 L52 14 Q28 6 2 14Z" fill="#fff" />
          <path d="M-44 -10 Q-28 -15 -12 -10 M-44 0 Q-28 -5 -12 0 M12 -10 Q28 -15 44 -10 M12 0 Q28 -5 44 0" stroke="#4d96ff" stroke-width="3" fill="none" stroke-linecap="round" />
        </g>

        <!-- RUS do'st -->
        <g class="bob">
          <ellipse cx="80" cy="271" rx="54" ry="47" fill="#4d96ff" />
          <ellipse cx="62" cy="315" rx="15" ry="8" fill="#231942" /><ellipse cx="98" cy="315" rx="15" ry="8" fill="#231942" />
          <g class="wave" style="transform-origin:118px 262px">
            <path d="M118 262 L140 236" stroke="#4d96ff" stroke-width="16" stroke-linecap="round" />
            <circle cx="142" cy="232" r="11" fill="#ffd9b8" />
          </g>
          <circle cx="80" cy="186" r="44" fill="#ffd9b8" />
          <circle cx="56" cy="200" r="6" fill="#ff9fb8" opacity=".7" />
          <circle cx="104" cy="200" r="6" fill="#ff9fb8" opacity=".7" />
          <circle cx="66" cy="190" r="4.5" fill="#231942" />
          <circle cx="94" cy="190" r="4.5" fill="#231942" />
          <path d="M68 202 Q80 214 92 202" stroke="#231942" stroke-width="3" fill="none" stroke-linecap="round" />
          <rect x="30" y="152" width="14" height="36" rx="7" fill="#ff6b9d" />
          <rect x="116" y="152" width="14" height="36" rx="7" fill="#ff6b9d" />
          <path d="M36 156 Q36 114 80 114 Q124 114 124 156 Z" fill="#ff6b9d" />
          <ellipse cx="80" cy="156" rx="46" ry="9" fill="#fff" />
        </g>

        <!-- O'ZBEK do'st -->
        <g class="bob b2">
          <ellipse cx="280" cy="271" rx="54" ry="47" fill="#2ec4a6" />
          <ellipse cx="262" cy="315" rx="15" ry="8" fill="#231942" /><ellipse cx="298" cy="315" rx="15" ry="8" fill="#231942" />
          <g class="wave" style="transform-origin:242px 262px">
            <path d="M242 262 L220 236" stroke="#2ec4a6" stroke-width="16" stroke-linecap="round" />
            <circle cx="218" cy="232" r="11" fill="#f2c79e" />
          </g>
          <circle cx="280" cy="186" r="44" fill="#f2c79e" />
          <circle cx="256" cy="200" r="6" fill="#ff9fb8" opacity=".7" />
          <circle cx="304" cy="200" r="6" fill="#ff9fb8" opacity=".7" />
          <circle cx="266" cy="190" r="4.5" fill="#231942" />
          <circle cx="294" cy="190" r="4.5" fill="#231942" />
          <path d="M268 202 Q280 214 292 202" stroke="#231942" stroke-width="3" fill="none" stroke-linecap="round" />
          <path d="M240 152 L244 120 Q280 106 316 120 L320 152 Q280 162 240 152 Z" fill="#231942" />
          <g fill="#fff">
            <polygon points="0,-6 6,0 0,6 -6,0" transform="translate(258 136)" />
            <polygon points="0,-6 6,0 0,6 -6,0" transform="translate(280 132)" />
            <polygon points="0,-6 6,0 0,6 -6,0" transform="translate(302 136)" />
          </g>
        </g>

        <!-- gap pufakchalari -->
        <g>
          <rect x="20" y="30" width="120" height="44" rx="16" fill="#ffd23f" />
          <rect x="20" y="26" width="120" height="44" rx="16" fill="#fff" />
          <path d="M70 68 L88 68 L78 88 Z" fill="#fff" />
          <text x="80" y="55" class="say">Привет!</text>
        </g>
        <g>
          <rect x="220" y="50" width="120" height="44" rx="16" fill="#ffd23f" />
          <rect x="220" y="46" width="120" height="44" rx="16" fill="#fff" />
          <path d="M270 88 L288 88 L280 108 Z" fill="#fff" />
          <text x="280" y="75" class="say">Salom!</text>
        </g>
      </svg>
    </div>

  </main>
</template>

<style scoped>

    /*          ---------- welcome ----------
    Hamma o'lcham "em" da: .welcome ning font-size qiymatini o'zgartirsangiz
    butun sahifa birdan kattalashadi yoki kichrayadi. */
    .welcome {
        font-size: clamp(16px, 2.4vmin, 28px);   /* kompyuter (keng ekran) */
        width: 100%;
        max-width: 30em;
        height: 100dvh;
        margin: 0 auto;
        padding: max(1.2em, env(safe-area-inset-top)) 1.2em 0;
        display: grid;
        grid-template-rows: 1fr auto 1fr;   /* tepa | tugma (aynan o'rtada) | pastki */
        justify-items: center;
        overflow: hidden;
    }

    .title {
        font-size: 4em;
        font-weight: 900;
        letter-spacing: -0.03em;
        line-height: 1.1;
        background: linear-gradient(90deg, var(--main), var(--main-2));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .btn {
        min-width: 11em;
        padding: .9em 3em;
        border: 0;
        border-radius: 1.1em;
        text-decoration: none;
        background: linear-gradient(90deg, var(--main), var(--main-2));
        color: #fff;
        font: inherit;
        font-size: 1.15em;
        font-weight: 900;
        cursor: pointer;
        box-shadow: 0 .3em 0 var(--main-dark);
        transition: transform .08s, box-shadow .08s;
    }
    .btn:active { transform: translateY(.2em); box-shadow: 0 .1em 0 var(--main-dark); }

    .top {
        align-self: stretch;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;   /* tugmaga yaqin turadi */
        align-items: center;
        gap: 1.5em;
        padding-bottom: 2em;
    }

    .words { display: flex; gap: .6em; justify-content: center; }
    .w { padding: .75em 1.1em; border-radius: 1.1em; text-align: center; line-height: 1.2; color: var(--ink); }
    .w b { display: block; font-size: 1.3em; font-weight: 900; }
    .w small { font-size: .85em; font-weight: 700; opacity: .7; }
    .w1 { background: var(--pink);   box-shadow: 0 .3em 0 #d9457b; transform: rotate(-5deg); }
    .w2 { background: var(--yellow); box-shadow: 0 .3em 0 #d9a900; transform: translateY(-.5em) rotate(3deg); }
    .w3 { background: var(--green);  box-shadow: 0 .3em 0 #1a9a80; transform: rotate(-3deg); }

    .head { text-align: center; }
    .head p { color: var(--muted); font-weight: 700; margin-top: .25em; }

    .scene { min-height: 0; width: 100%; padding-top: 2em; display: flex; justify-content: center; align-items: flex-start; }
    .scene svg { height: 100%; width: auto; max-width: 100%; max-height: 18em; overflow: visible; }
    .scene text { font-family: var(--font); font-weight: 900; font-size: 20px; text-anchor: middle; }
    .scene .say { font-size: 22px; fill: var(--ink); }

    /* ---------- telefon (tik ekran): cho'zinchoq, butun balandlikka yoyiladi ---------- */
    @media (max-aspect-ratio: 1/1) {
    .welcome { font-size: clamp(16px, 4.6vw, 26px); }
    .top { justify-content: space-evenly; gap: 0; padding-bottom: 0; }
    .scene { padding-top: 0; align-items: center; }
    .scene svg { height: auto; width: 100%; max-width: 22em; max-height: 100%; }
    }

    .bob { animation: bob 3s ease-in-out infinite; }
    .b2 { animation-delay: -1.5s; }
    .wave { animation: wave 1.6s ease-in-out infinite; }
    @keyframes bob { 50% { transform: translateY(-7px); } }
    @keyframes wave { 50% { transform: rotate(-14deg); } }

    :focus-visible { outline: 3px solid var(--main); outline-offset: 3px; }
    @media (prefers-reduced-motion: reduce) {
    .bob, .wave { animation: none; }
    .btn { transition: none; }
    }
</style>
