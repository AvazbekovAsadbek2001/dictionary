<template>
  <main class="screen">
    <header class="bar">
      <button class="back" @click="goBack" aria-label="Orqaga">←</button>

      <div class="ttl">
        <h1 class="h">Bo'limlar</h1>
        <p class="sub">{{ menu.title }}</p>
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
      </div>
    </header>

    <ul class="list">
      <li v-for="(it, i) in sections" :key="it.id" :style="{ '--i': i }">
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
  name: 'SectionsPage',
  props: {
        sections: {
            type: Array,
            default: () => [],
        },
        menu : {
            type: Object,
            default: "no menu"
        }
    },
  methods: {
        goBack() {
            window.location.href = '/'
        },
        openBlock(id) {
            window.location.href = `/menu/${this.menu.id}/sections/${id}`
        },
    },
}
</script>
