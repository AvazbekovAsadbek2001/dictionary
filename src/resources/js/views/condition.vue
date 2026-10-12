<script setup>
defineProps({
    topic: { type: Object, required: true },
})
defineEmits(['select', 'back'])

const conditions = [
    { id: 'ru', label: 'ru', hint: "Ruscha so'z ko'rinadi, o'zbekchasini yozasiz" },
    { id: 'uz', label: 'uz', hint: "O'zbekcha so'z ko'rinadi, ruschasini yozasiz" },
    { id: 'mix', label: 'aralash', hint: "Savollar ikki yo'nalishda aralash keladi" },
]
</script>

<template>
    <main class="page">
        <header class="bar">
            <button class="link" @click="$emit('back')">Orqaga</button>
        </header>

        <h2>{{ topic.name }}</h2>
        <span class="rule" aria-hidden="true"></span>

        <ul class="list">
            <li v-for="c in conditions" :key="c.id">
                <button class="tile" @click="$emit('select', c.id)">
                    <span class="tile-name">{{ c.label }}</span>
                    <span class="tile-meta">{{ c.hint }}</span>
                </button>
            </li>
        </ul>
    </main>
</template>

<style scoped>
.page {
    flex: 1;
    width: 100%;
    max-width: 560px;
    margin: 0 auto;
    padding: 20px 24px 48px;
    box-sizing: border-box;
}

.bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }

.link {
    background: none;
    border: 0;
    padding: 8px 0;
    font: 500 15px var(--sans);
    color: var(--tile);
    cursor: pointer;
}
.link:hover { text-decoration: underline; }

h2 {
    margin: 8px 0 0;
    font: 600 clamp(36px, 8vw, 56px)/1.1 var(--serif);
    letter-spacing: -0.01em;
}

.rule { display: block; width: 48px; height: 4px; margin: 16px 0 28px; background: var(--saffron); }

.list { list-style: none; margin: 0; padding: 0; display: grid; gap: 12px; }

.tile {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 6px;
    padding: 18px 20px;
    text-align: left;
    background: var(--card);
    color: var(--ink);
    border: 1px solid var(--line);
    border-left: 6px solid var(--turq);
    border-radius: 4px;
    cursor: pointer;
    transition: border-color 0.15s, transform 0.15s;
}
.tile:hover { border-left-color: var(--saffron); transform: translateX(3px); }
.tile-name { font: 600 22px/1.2 var(--serif); }
.tile-meta { font-size: 14px; opacity: 0.7; }

.link:focus-visible,
.tile:focus-visible { outline: 3px solid var(--saffron); outline-offset: 3px; }

@media (prefers-reduced-motion: reduce) {
    * { transition: none !important; }
}
</style>
