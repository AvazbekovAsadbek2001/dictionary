<template>
  <main class="screen">
    <header class="bar">
      <button class="back" @click="goBack" aria-label="Orqaga">←</button>

      <div class="ttl">
        <h1 class="h">Sinov turi</h1>
        <p class="sub">{{ section.title }}</p>
      </div>

      <div class="friends" aria-hidden="true">
        <svg class="friend" viewBox="30 108 100 126">
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
        </svg>
        <svg class="friend f2" viewBox="234 106 92 128">
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
        </svg>
      </div>
    </header>

    <ul class="list">
      <li v-for="(it, i) in types" :key="it.mode" :style="{ '--i': i }">
        <button class="card" :class="'c' + it.c" @click="openBlock(it.mode)">
          <span class="ico">{{ it.icon }}</span>
          <span class="txt">
            <b>{{ it.title }}</b>
            <small>{{ it.hint }}</small>
            <span class="chip">{{ it.sample }}</span>
          </span>
          <span class="go">›</span>
        </button>
      </li>
    </ul>
  </main>
</template>

<script>
// 3 ta doimiy sinov turi
const TYPES = [
  { mode: 'ru', c: 2, icon: 'Я', title: 'Ruscha', hint: "Ruscha so'z beriladi, o'zbekchasini yozasiz", sample: 'книга → ?' },
  { mode: 'uz', c: 3, icon: 'Oʻ', title: "O'zbekcha", hint: "O'zbekcha so'z beriladi, ruschasini yozasiz", sample: 'kitob → ?' },
  { mode: 'mix', c: 0, icon: '⇄', title: 'Aralash', hint: "Ikkala yo'nalish navbatma-navbat", sample: 'книга ⇄ kitob' },
]

export default {
    name: 'TestTypePage',
    props: {
        section: {
            type: Object,
            default: () => [],
        },
        menuId : {
            type: Number,
            default: 0
        }
    },
    methods: {
        goBack() {
            window.history.back();
        },
        openBlock(type) {
            window.location.href = window.location.pathname + '/'+ type;
        },
    },
  data() {
    return { types: TYPES }
  },
}
</script>
