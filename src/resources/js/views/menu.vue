<template>
  <main class="screen">
    <header class="bar">
      <button class="back" @click="goBack">←</button>

      <div class="ttl">
        <h1 class="h">Menu</h1>
      </div>

      <div class="friends" aria-hidden="true">
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
      <li v-for="(it, i) in menu" :key="it.id" :style="{ '--i': i }">
        <button class="card" :class="'c' + (i % 4)" @click="openBlock(it.id)">
          <span class="ico">{{ it.title.charAt(0) }}</span>
          <span class="txt"><b>{{ it.title }}</b></span>
          <span class="go">›</span>
        </button>
      </li>
    </ul>
  </main>
</template>

<script>
    export default {
    name: 'MenuPage',
    props: {
        menu: {
            type: Array,
            default: () => [],
        },
    },
    methods: {
        goBack() {
            window.location.href = '/'
            },
        openBlock(id) {
            window.location.href = `/menu/${id}/sections`
        },
    },
}
</script>
