<script setup>
import { ref, computed, nextTick } from 'vue'
import Menu from './menu.vue'
import Condition from './condition.vue'

/* ---------- FAKE MA'LUMOTLAR (keyin API bilan almashtiriladi) ---------- */
const topics = ref([
    {
        id: 1,
        name: 'Oila',
        words: [
            { ru: 'мама', uz: 'ona' },
            { ru: 'папа', uz: 'ota' },
            { ru: 'брат', uz: 'aka' },
            { ru: 'сестра', uz: 'opa' },
            { ru: 'бабушка', uz: 'buvi' },
            { ru: 'дедушка', uz: 'bobo' },
            { ru: 'сын', uz: "o'g'il" },
            { ru: 'дочь', uz: 'qiz' },
        ],
    },
    {
        id: 2,
        name: 'Ovqat',
        words: [
            { ru: 'хлеб', uz: 'non' },
            { ru: 'вода', uz: 'suv' },
            { ru: 'мясо', uz: "go'sht" },
            { ru: 'яблоко', uz: 'olma' },
            { ru: 'молоко', uz: 'sut' },
            { ru: 'рис', uz: 'guruch' },
            { ru: 'чай', uz: 'choy' },
            { ru: 'сыр', uz: 'pishloq' },
        ],
    },
    {
        id: 3,
        name: 'Hayvonlar',
        words: [
            { ru: 'собака', uz: 'it' },
            { ru: 'кошка', uz: 'mushuk' },
            { ru: 'лошадь', uz: 'ot' },
            { ru: 'корова', uz: 'sigir' },
            { ru: 'птица', uz: 'qush' },
            { ru: 'рыба', uz: 'baliq' },
            { ru: 'волк', uz: "bo'ri" },
            { ru: 'овца', uz: "qo'y" },
        ],
    },
    {
        id: 4,
        name: 'Ranglar',
        words: [
            { ru: 'красный', uz: 'qizil' },
            { ru: 'синий', uz: "ko'k" },
            { ru: 'зелёный', uz: 'yashil' },
            { ru: 'жёлтый', uz: 'sariq' },
            { ru: 'чёрный', uz: 'qora' },
            { ru: 'белый', uz: 'oq' },
        ],
    },
])

/* ---------- HOLAT ---------- */
const screen = ref('welcome') // welcome | topics | modes | quiz | result
const topic = ref(null)
const mode = ref(null)
const queue = ref([])
const index = ref(0)
const score = ref(0)
const answer = ref('')
const status = ref('idle') // idle | right | wrong
const inputEl = ref(null)

const current = computed(() => queue.value[index.value])
const langLabel = (l) => (l === 'ru' ? 'Rus tilida' : "O'zbek tilida")
const answerLang = computed(() => (current.value?.show === 'ru' ? 'uz' : 'ru'))
const progress = computed(() => (queue.value.length ? (index.value / queue.value.length) * 100 : 0))

/* ---------- YORDAMCHILAR ---------- */
function shuffle(arr) {
    const a = [...arr]
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1))
        ;[a[i], a[j]] = [a[j], a[i]]
    }
    return a
}

function normalize(s) {
    return s
        .toLowerCase()
        .trim()
        .replace(/[ʻʼ’‘`´]/g, "'")
        .replace(/ё/g, 'е')
        .replace(/\s+/g, ' ')
}

/* ---------- HARAKATLAR ---------- */
function openTopic(t) {
    topic.value = t
    screen.value = 'modes'
}

function startQuiz(m) {
    mode.value = m
    queue.value = shuffle(topic.value.words).map((w) => ({
        ...w,
        show: m === 'ru' ? 'ru' : m === 'uz' ? 'uz' : Math.random() < 0.5 ? 'ru' : 'uz',
    }))
    index.value = 0
    score.value = 0
    answer.value = ''
    status.value = 'idle'
    screen.value = 'quiz'
    nextTick(() => inputEl.value?.focus())
}

function check() {
    if (status.value !== 'idle' || !answer.value.trim()) return
    const target = current.value[answerLang.value]
    const ok = normalize(answer.value) === normalize(target)
    status.value = ok ? 'right' : 'wrong'
    if (ok) score.value++
}

function next() {
    if (index.value + 1 >= queue.value.length) {
        screen.value = 'result'
        return
    }
    index.value++
    answer.value = ''
    status.value = 'idle'
    nextTick(() => inputEl.value?.focus())
}

function onEnter() {
    status.value === 'idle' ? check() : next()
}

function back() {
    if (screen.value === 'modes') screen.value = 'topics'
    else if (screen.value === 'quiz' || screen.value === 'result') screen.value = 'modes'
    else if (screen.value === 'topics') screen.value = 'welcome'
}
</script>

<template>
    <div class="welcome">
        <div class="band" aria-hidden="true"></div>

        <!-- 1. Boshlash -->
        <main v-if="screen === 'welcome'" class="center">
            <h1>Lug'at</h1>
            <span class="rule" aria-hidden="true"></span>
            <button class="btn primary start" @click="screen = 'topics'">Boshlash</button>
        </main>

        <!-- 2. Mavzular -->
        <Menu v-else-if="screen === 'topics'" :topics="topics" @select="openTopic" @back="back" />

        <!-- 3. Shart (ru / uz / aralash) -->
        <Condition v-else-if="screen === 'modes'" :topic="topic" @select="startQuiz" @back="back" />

        <!-- 4. Mashq -->
        <main v-else-if="screen === 'quiz'" class="page quiz">
            <header class="bar">
                <button class="link" @click="back">Chiqish</button>
                <span class="count">{{ index + 1 }} / {{ queue.length }}</span>
            </header>
            <div class="track" aria-hidden="true"><div class="fill" :style="{ width: progress + '%' }"></div></div>

            <p class="prompt-lang">{{ langLabel(current.show) }}</p>
            <div class="word" :lang="current.show">{{ current[current.show] }}</div>

            <input
                ref="inputEl"
                v-model="answer"
                class="field"
                :class="status"
                :disabled="status !== 'idle'"
                :placeholder="answerLang === 'uz' ? 'O\'zbekchasini yozing' : 'Ruschasini yozing'"
                :lang="answerLang"
                autocomplete="off"
                autocapitalize="off"
                spellcheck="false"
                @keydown.enter="onEnter"
            />

            <p v-if="status === 'right'" class="msg right">To'g'ri</p>
            <p v-else-if="status === 'wrong'" class="msg wrong">
                Noto'g'ri. To'g'ri javob: <strong>{{ current[answerLang] }}</strong>
            </p>
            <p v-else class="msg">&nbsp;</p>

            <button v-if="status === 'idle'" class="btn primary" :disabled="!answer.trim()" @click="check">
                Tekshirish
            </button>
            <button v-else class="btn primary" @click="next">
                {{ index + 1 >= queue.length ? 'Natijani ko\'rish' : 'Keyingisi' }}
            </button>
        </main>

        <!-- 5. Natija -->
        <main v-else-if="screen === 'result'" class="page result">
            <h2>{{ topic.name }}</h2>
            <span class="rule small" aria-hidden="true"></span>
            <div class="score">{{ score }}<span class="of"> / {{ queue.length }}</span></div>
            <p class="msg">to'g'ri javob</p>
            <div class="actions">
                <button class="btn primary" @click="startQuiz(mode)">Qayta boshlash</button>
                <button class="btn" @click="screen = 'modes'">Rejimni o'zgartirish</button>
                <button class="btn" @click="screen = 'topics'">Mavzularga qaytish</button>
            </div>
        </main>
    </div>
</template>

<style scoped>
:global(body) { margin: 0; }

.welcome {
    --paper: #f4f7fb;
    --ink: #0e2a47;
    --tile: #1d4e89;
    --turq: #0f8b8d;
    --saffron: #f2b134;
    --card: #ffffff;
    --line: #d5dfeb;
    --ok: #0f8b5d;
    --bad: #c2392f;
    --serif: Charter, "Iowan Old Style", "Palatino Linotype", Georgia, serif;
    --sans: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;

    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: var(--paper);
    color: var(--ink);
    font-family: var(--sans);
}

@media (prefers-color-scheme: dark) {
    .welcome {
        --paper: #0b1626;
        --ink: #e7eef8;
        --tile: #6fa3e6;
        --turq: #3cc0c2;
        --card: #12233a;
        --line: #24395a;
        --ok: #4cd1a0;
        --bad: #ff8077;
    }
}

/* Sopol/plitka hoshiyasini eslatuvchi yo'l-yo'l tasma */
.band {
    height: 10px;
    background: repeating-linear-gradient(
        135deg,
        var(--tile) 0 8px,
        var(--turq) 8px 16px,
        var(--saffron) 16px 20px,
        var(--turq) 20px 28px
    );
}

.center {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 24px;
}

h1 {
    margin: 0;
    font: 600 clamp(64px, 16vw, 144px)/1 var(--serif);
    letter-spacing: -0.02em;
}

h2 {
    margin: 8px 0 0;
    font: 600 clamp(36px, 8vw, 56px)/1.1 var(--serif);
    letter-spacing: -0.01em;
}

.rule {
    width: 72px;
    height: 4px;
    margin-top: 20px;
    background: var(--saffron);
}
.rule.small { width: 48px; margin: 16px 0 28px; }

/* ---------- Tugmalar ---------- */
.btn {
    font: 600 16px/1 var(--sans);
    padding: 15px 28px;
    border-radius: 6px;
    border: 2px solid var(--tile);
    background: transparent;
    color: var(--tile);
    cursor: pointer;
    transition: background 0.15s, color 0.15s, transform 0.1s;
}
.btn:hover:not(:disabled) { background: var(--tile); color: var(--paper); }
.btn:active:not(:disabled) { transform: translateY(1px); }
.btn.primary { background: var(--tile); color: var(--paper); }
.btn.primary:hover:not(:disabled) { background: var(--ink); border-color: var(--ink); color: var(--paper); }
.btn:disabled { opacity: 0.45; cursor: not-allowed; }
.btn:focus-visible,
.link:focus-visible,
.field:focus-visible { outline: 3px solid var(--saffron); outline-offset: 3px; }

.start { margin-top: 48px; padding: 18px 48px; font-size: 18px; }

.link {
    background: none;
    border: 0;
    padding: 8px 0;
    font: 500 15px var(--sans);
    color: var(--tile);
    cursor: pointer;
}
.link:hover { text-decoration: underline; }

/* ---------- Sahifalar ---------- */
.page {
    flex: 1;
    width: 100%;
    max-width: 560px;
    margin: 0 auto;
    padding: 20px 24px 48px;
    box-sizing: border-box;
}

.bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.count { font-size: 14px; color: var(--tile); font-variant-numeric: tabular-nums; }

/* ---------- Mashq ---------- */
.track { height: 4px; background: var(--line); border-radius: 2px; overflow: hidden; }
.fill { height: 100%; background: var(--turq); transition: width 0.25s; }

.prompt-lang { margin: 40px 0 8px; font-size: 14px; opacity: 0.7; }

.word {
    font: 600 clamp(44px, 12vw, 72px)/1.1 var(--serif);
    letter-spacing: -0.01em;
    word-break: break-word;
    margin-bottom: 32px;
}

.field {
    width: 100%;
    box-sizing: border-box;
    padding: 16px 18px;
    font: 500 20px var(--sans);
    color: var(--ink);
    background: var(--card);
    border: 2px solid var(--line);
    border-radius: 6px;
}
.field.right { border-color: var(--ok); }
.field.wrong { border-color: var(--bad); }

.msg { min-height: 24px; margin: 14px 0 22px; font-size: 16px; }
.msg.right { color: var(--ok); font-weight: 600; }
.msg.wrong { color: var(--bad); }
.msg strong { color: var(--ink); }

/* ---------- Natija ---------- */
.result { text-align: left; }
.score { font: 600 clamp(72px, 20vw, 120px)/1 var(--serif); }
.score .of { font-size: 0.4em; opacity: 0.55; }
.actions { display: grid; gap: 12px; margin-top: 12px; }

@media (prefers-reduced-motion: reduce) {
    * { transition: none !important; }
}
</style>
