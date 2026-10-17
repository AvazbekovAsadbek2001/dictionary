<template>
  <main class="q-screen">
    <header class="q-bar">
      <button class="q-exit" type="button" @click="goBack()">✕ Chiqish</button>

      <div class="q-stats">
        <span v-if="streak >= 2" class="q-pill fire">🔥 <b :key="streak" class="q-bump">{{ streak }}</b></span>
        <span class="q-pill ok">✓ <b :key="'o' + stats.ok" class="q-bump">{{ stats.ok }}</b></span>
        <span class="q-pill no">✕ <b :key="'n' + stats.no" class="q-bump">{{ stats.no }}</b></span>
      </div>
    </header>

    <p class="q-topic">{{ section.title }} · {{ modeLabel }}</p>

    <!-- so'z — do'stning gap pufakchasida -->
    <section class="q-stage" :class="who">
      <Transition name="q-pop" mode="out-in">
        <div v-if="loading" key="load" class="q-bubble">
          <span class="q-dots"><i></i><i></i><i></i></span>
        </div>

        <div v-else-if="current" :key="round" class="q-bubble" :class="{ 'q-shake': result && !result.correct }">
          <small class="q-lang">{{ who === 'ru' ? 'Ruscha' : "O'zbekcha" }}</small>
          <h2 class="q-word" :class="{ long: current.word.length > 12 }">{{ current.word }}</h2>
        </div>

        <div v-else key="err" class="q-bubble">
          <p class="q-err">{{ error }}</p>
        </div>
      </Transition>

      <div class="q-friendbox">
        <svg class="q-friend" :class="[mood, who]" :viewBox="who === 'ru' ? '30 108 100 126' : '234 106 92 128'" aria-hidden="true">
          <g :transform="who === 'ru' ? '' : 'translate(200 0)'">
            <circle cx="80" cy="186" r="44" :fill="who === 'ru' ? '#ffd9b8' : '#f2c79e'" />
            <circle cx="56" cy="200" r="6" fill="#ff9fb8" opacity=".7" />
            <circle cx="104" cy="200" r="6" fill="#ff9fb8" opacity=".7" />

            <!-- ko'zlar -->
            <g v-if="mood === 'happy'" stroke="#231942" stroke-width="3.5" fill="none" stroke-linecap="round">
              <path d="M60 192 Q66 183 72 192" /><path d="M88 192 Q94 183 100 192" />
            </g>
            <g v-else>
              <circle cx="66" cy="190" r="4.5" fill="#231942" /><circle cx="94" cy="190" r="4.5" fill="#231942" />
              <g v-if="mood === 'sad'" stroke="#231942" stroke-width="3" stroke-linecap="round">
                <path d="M58 182 L73 176" /><path d="M87 176 L102 182" />
              </g>
            </g>

            <!-- og'iz -->
            <path v-if="mood === 'happy'" d="M64 199 Q80 224 96 199 Z" fill="#231942" />
            <path v-else-if="mood === 'sad'" d="M68 212 Q80 200 92 212" stroke="#231942" stroke-width="3" fill="none" stroke-linecap="round" />
            <path v-else-if="mood === 'think'" d="M72 206 L88 206" stroke="#231942" stroke-width="3" stroke-linecap="round" />
            <path v-else d="M68 202 Q80 214 92 202" stroke="#231942" stroke-width="3" fill="none" stroke-linecap="round" />
            <path v-if="mood === 'sad'" d="M104 196 Q108 204 104 208 Q100 204 104 196Z" fill="#8cc4ff" />
          </g>

          <!-- ushanka (rus) -->
          <g v-if="who === 'ru'">
            <rect x="30" y="152" width="14" height="36" rx="7" fill="#ff6b9d" />
            <rect x="116" y="152" width="14" height="36" rx="7" fill="#ff6b9d" />
            <path d="M36 156 Q36 114 80 114 Q124 114 124 156 Z" fill="#ff6b9d" />
            <ellipse cx="80" cy="156" rx="46" ry="9" fill="#fff" />
          </g>
          <!-- do'ppi (o'zbek) -->
          <g v-else>
            <path d="M240 152 L244 120 Q280 106 316 120 L320 152 Q280 162 240 152 Z" fill="#231942" />
            <g fill="#fff">
              <polygon points="0,-6 6,0 0,6 -6,0" transform="translate(258 136)" />
              <polygon points="0,-6 6,0 0,6 -6,0" transform="translate(280 132)" />
              <polygon points="0,-6 6,0 0,6 -6,0" transform="translate(302 136)" />
            </g>
          </g>
        </svg>

        <div v-if="result && result.correct" :key="'b' + burst" class="q-confetti" aria-hidden="true">
          <i v-for="k in 12" :key="k" :style="{ '--a': k * 30 + 'deg', '--c': k % 4 }"></i>
        </div>
      </div>
    </section>

    <form class="q-form" @submit.prevent="submit">
      <input
        ref="input"
        v-model="answer"
        class="q-input"
        :class="[result ? (result.correct ? 'good' : 'bad') : '', { 'q-shake': result && !result.correct }]"
        :placeholder="placeholder"
        :disabled="!current || loading || checking || !!result"
        autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" enterkeyhint="done"
      />

      <div class="q-fbslot">
        <Transition name="q-fb">
          <p v-if="result" :key="'r' + round" class="q-fb" :class="result.correct ? 'good' : 'bad'">
            <template v-if="result.correct">{{ praise }}</template>
            <template v-else>To'g'ri javob: <b>{{ result.answer }}</b></template>
          </p>
          <p v-else-if="error && current" key="e" class="q-fb bad">{{ error }}</p>
        </Transition>
      </div>

      <button ref="btn" class="q-btn" :disabled="busy">
        <span v-if="checking" class="q-dots small"><i></i><i></i><i></i></span>
        <template v-else>{{ label }}</template>
      </button>
    </form>
  </main>
</template>

<script>

// Backend manzili. O'zingizning api manzilingizga almashtiring.
const BASE = '/back'

// Har qanday so'rovni yuboradigan umumiy funksiya.
// path    — manzilning davomi (masalan '/words/next')
// options — qo'shimcha sozlamalar (method, body ...)
async function http(path, options = {}) {
  const res = await fetch(BASE + path, {
    headers: { 'Content-Type': 'application/json' },
    ...options,
  })
  // Server 400, 404, 500 kabi xato qaytarsa — xatoga aylantiramiz,
  // shunda pastdagi try/catch uni ushlab oladi.
  if (!res.ok) throw new Error('HTTP ' + res.status)
  return res.json()
}

// Sinov oynasi ishlatadigan ikkita so'rov.
const api = {
  // Yangi so'z olish.
  // GET /words/next?section_id=21&mode=ru
  // Kutiladigan javob: { id: 5, word: 'книга', from: 'ru' }
  //   id   — so'zning raqami (tekshirishda kerak bo'ladi)
  //   word — ekranda ko'rsatiladigan so'z
  //   from — so'z qaysi tilda berilgan: 'ru' yoki 'uz'
  getWord: (sectionId, mode) => http(`/word?section_id=${sectionId}&type=${mode}`),

  // Javobni tekshirish.
  // POST /words/check  { word_id, answer, from }
  // Kutiladigan javob: { correct: true, answer: 'kitob' }
  //   correct — javob to'g'rimi
  //   answer  — to'g'ri javob (xato bo'lganda ekranda ko'rsatiladi)
  checkWord: (payload) => http('/check', { method: 'POST', body: JSON.stringify(payload) }),
}

// To'g'ri javobdan keyin tasodifiy chiqadigan maqtov so'zlari.
const PRAISE = ["Barakalla!", "Ofarin!", "Zo'r!", 'Молодец!', 'Mukammal!', 'Ajoyib!', 'Отлично!']

/* =====================================================================
   2) KOMPONENT
   ===================================================================== */
export default {
  name: 'Condition',

  // Tashqaridan (App.vue dan) keladigan ma'lumotlar
  props: {
    section: { type: Object, required: true },   // tanlangan bo'lim: { id, title }
    mode: { type: String, required: true },      // sinov turi: 'ru' | 'uz' | 'mix'
  },

  // Komponent tashqariga yuboradigan voqea:
  // "Chiqish" bosilganda 'exit' chiqadi va ichida { ok, no } bo'ladi.
  emits: ['exit'],

  // ---------------------------------------------------------------
  // Holat — ekrandagi hamma narsa shu o'zgaruvchilarga qarab chiziladi
  // ---------------------------------------------------------------
  data() {
    return {
      current: null,           // hozirgi so'z: { id, word, from }
      answer: '',              // inputga yozilgan javob
      result: null,            // tekshiruv natijasi: { correct, answer } (tekshirilmagan bo'lsa null)

      loading: true,           // yangi so'z yuklanyaptimi
      checking: false,         // javob tekshirilyaptimi
      error: '',               // xato matni (bo'sh bo'lsa xato yo'q)

      stats: { ok: 0, no: 0 }, // to'g'ri va noto'g'ri javoblar soni
      streak: 0,               // ketma-ket to'g'ri javoblar (🔥)

      mood: 'idle',            // do'st kayfiyati: 'idle' | 'think' | 'happy' | 'sad'
      burst: 0,                // konfetti hisoblagich (har to'g'ri javobda +1, animatsiyani qayta o'ynatadi)
      round: 0,                // so'z hisoblagich (har yangi so'zda +1, animatsiya uchun)
      praise: '',              // hozirgi maqtov matni
    }
  },

  // ---------------------------------------------------------------
  // Hisoblangan qiymatlar — boshqa o'zgaruvchilardan o'zi hisoblanadi
  // ---------------------------------------------------------------
  computed: {
    // Hozir kim gapirmoqda: ruscha so'z bo'lsa rus do'st, o'zbekcha bo'lsa o'zbek do'st.
    who() { return this.current ? this.current.from : 'ru' },

    // Tepada ko'rinadigan sinov turi nomi.
    modeLabel() { return { ru: 'Ruscha', uz: "O'zbekcha", mix: 'Aralash' }[this.mode] },

    // Input ichidagi yo'riqnoma: ruscha so'zga o'zbekcha tarjima yoziladi va aksincha.
    placeholder() { return this.who === 'ru' ? "O'zbekcha tarjimasi" : 'Ruscha tarjimasi' },

    // Tugma o'chiq turadigan paytlar:
    //  - so'z yuklanyapti yoki javob tekshirilyapti
    //  - so'z bor, hali tekshirilmagan va input bo'sh
    busy() {
      return this.loading || this.checking || (!!this.current && !this.result && !this.answer.trim())
    },

    // Tugma yozuvi: so'z yuklanmagan bo'lsa "Qayta urinish",
    // tekshirilgan bo'lsa "Keyingisi", aks holda "Tekshirish".
    label() { return !this.current ? 'Qayta urinish' : this.result ? 'Keyingisi' : 'Tekshirish' },
  },

  // Sahifa ochilishi bilan birinchi so'zni olamiz.
    mounted() {
        this.load();
    },

  methods: {
    // ---------------------------------------------------------------
    // Apidan yangi so'z olish
    // ---------------------------------------------------------------
    async load() {

      // Oldingi so'zdan qolgan hamma narsani tozalaymiz
      this.loading = true
      this.error = ''
      this.result = null
      this.answer = ''
      this.mood = 'idle'

      try {
        this.current = await api.getWord(this.section.id, this.mode)
        this.round++            // yangi so'z — pufak animatsiyasi qayta o'ynaydi
      } catch {
        this.current = null     // so'z kelmadi — "Qayta urinish" tugmasi chiqadi
        this.error = "So'zni yuklab bo'lmadi"
      } finally {
        this.loading = false
        // Ekran yangilanishini kutamiz, keyin inputga kursorni qo'yamiz
        await this.$nextTick()
        this.$refs.input && this.$refs.input.focus()
      }
    },

    // ---------------------------------------------------------------
    // Tugma bosilganda yoki Enter bosilganda ishlaydi
    // ---------------------------------------------------------------
    async submit() {
      if (this.loading || this.checking) return   // band bo'lsa hech narsa qilmaymiz
      if (!this.current) return this.load()       // so'z yo'q edi — qayta yuklaymiz
      if (this.result) return this.load()         // allaqachon tekshirilgan — keyingi so'zga o'tamiz
      if (!this.answer.trim()) return             // input bo'sh — tekshirmaymiz

      this.checking = true
      this.error = ''
      this.mood = 'think'                         // do'st o'ylanib turadi

      try {
        // Javobni apiga yuboramiz
        const r = await api.checkWord({
          word_id: this.current.id,
          answer: this.answer.trim(),
          from: this.current.from,
        })
        this.result = r

        if (r.correct) {
          // To'g'ri: hisob, streak, quvonch va konfetti
          this.stats.ok++
          this.streak++
          this.mood = 'happy'
          this.burst++
          this.praise = PRAISE[Math.floor(Math.random() * PRAISE.length)]
        } else {
          this.stats.no++
          this.streak = 0
          this.mood = 'sad'
        }

        // Fokusni tugmaga o'tkazamiz — shunda Enter bosib keyingi so'zga o'tish mumkin
        await this.$nextTick()
        this.$refs.btn && this.$refs.btn.focus()
      } catch {
        // Tarmoq yoki server xatosi — foydalanuvchi qayta bosib ko'radi
        this.error = "Javobni tekshirib bo'lmadi"
        this.mood = 'idle'
      } finally {
        this.checking = false
      }
    },

    // Bir sahifa orqaga qaytish (brauzer tarixi bo'yicha).
    // Eslatma: hozirgi shablonda "Chiqish" tugmasi buni emas, 'exit' voqeasini ishlatadi.
    goBack() {
      window.history.back()
    },
  },
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@500;700;900&display=swap');

:root {
  --ink: #231942;
  --muted: #6d628f;
  --pink: #ff6b9d;
  --yellow: #ffd23f;
  --blue: #4d96ff;
  --green: #2ec4a6;
  --main: #3d6bff;
  --main-2: #19b3c9;
  --main-dark: #2a4fd1;
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

/* ---------- quiz ----------  (hamma o'lcham em da: .q-screen font-size ni o'zgartirsangiz hammasi o'zgaradi) */
.q-screen {
  font-size: clamp(16px, 2.4vmin, 28px);
  width: 100%;
  max-width: 30em;
  height: 100dvh;
  margin: 0 auto;
  padding: max(1.2em, env(safe-area-inset-top)) 1.2em max(1.2em, env(safe-area-inset-bottom));
  display: flex;
  flex-direction: column;
}

.q-bar { display: flex; align-items: center; justify-content: space-between; gap: .8em; }
.q-exit {
  border: 0; border-radius: 1em; padding: .7em 1.1em;
  background: #fff; color: var(--ink);
  font: inherit; font-weight: 900; cursor: pointer;
  box-shadow: 0 .25em 0 rgba(35, 25, 66, .14);
  transition: transform .08s, box-shadow .08s;
}
.q-exit:active { transform: translateY(.2em); box-shadow: 0 .05em 0 rgba(35, 25, 66, .14); }

.q-stats { display: flex; gap: .5em; }
.q-pill { padding: .45em .85em; border-radius: 1em; background: #fff; font-weight: 900; box-shadow: 0 .2em 0 rgba(35, 25, 66, .1); }
.q-pill.ok { color: #12806a; }
.q-pill.no { color: #b8325f; }
.q-pill.fire { color: #c25b00; }
.q-bump { display: inline-block; animation: q-bump .4s cubic-bezier(.3, 1.8, .5, 1); }
@keyframes q-bump { from { transform: scale(.4); } }

.q-topic { text-align: center; margin: .9em 0 0; color: var(--muted); font-weight: 800; }

/* sahna */
.q-stage {
  --bg: #4d96ff; --sh: #2a6fd6; --soft: #dce9ff;
  flex: 1; min-height: 0;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: 1.3em; padding: 1em 0;
}
.q-stage.uz { --bg: #2ec4a6; --sh: #1a9a80; --soft: #d5f5ee; }

.q-bubble {
  position: relative;
  width: 100%; max-width: 22em; min-height: 6.5em;
  padding: 1em 1.2em 1.1em;
  display: grid; place-content: center; gap: .15em; text-align: center;
  border-radius: 1.6em; background: #fff;
  box-shadow: 0 .3em 0 var(--sh);
}
.q-bubble::after {
  content: ''; position: absolute; left: 50%; bottom: -.85em; transform: translateX(-50%);
  border: 1em solid transparent; border-top-color: #fff; border-bottom: 0;
}
.q-lang { justify-self: center; padding: .15em .8em; border-radius: .8em; background: var(--soft); color: var(--ink); font-weight: 900; font-size: .8em; }
.q-word { font-size: 2.8em; font-weight: 900; line-height: 1.15; color: var(--sh); overflow-wrap: anywhere; }
.q-word.long { font-size: 1.9em; }
.q-err { color: var(--muted); font-weight: 800; }

.q-dots { display: inline-flex; gap: .4em; }
.q-dots i { width: .7em; height: .7em; border-radius: 50%; background: var(--sh, var(--main)); animation: q-dot 1s infinite ease-in-out; }
.q-dots i:nth-child(2) { animation-delay: .15s; }
.q-dots i:nth-child(3) { animation-delay: .3s; }
.q-dots.small i { background: #fff; width: .5em; height: .5em; }
@keyframes q-dot { 0%, 80%, 100% { transform: scale(.5); opacity: .5; } 40% { transform: scale(1); opacity: 1; } }

.q-pop-enter-active { transition: transform .4s cubic-bezier(.3, 1.6, .5, 1), opacity .2s; }
.q-pop-leave-active { transition: transform .15s, opacity .15s; }
.q-pop-enter-from { transform: scale(.7) translateY(.6em); opacity: 0; }
.q-pop-leave-to { transform: translateY(-.5em) scale(.95); opacity: 0; }

/* do'st */
.q-friendbox { position: relative; display: grid; place-items: center; margin-top: .6em; }
.q-friend { height: clamp(4em, 17dvh, 7em); width: auto; animation: q-nod 3s ease-in-out infinite; transform-origin: 50% 100%; }
.q-friend.happy { animation: q-hop .7s cubic-bezier(.3, 1.4, .5, 1); }
.q-friend.sad { animation: q-droop .6s ease-out forwards; }
.q-friend.think { animation: q-wobble .6s ease-in-out infinite; }
@keyframes q-nod { 50% { transform: translateY(-.3em); } }
@keyframes q-hop { 0%, 100% { transform: translateY(0) scale(1); } 35% { transform: translateY(-1.2em) scale(1.08, .95); } 60% { transform: translateY(0) scale(.95, 1.06); } }
@keyframes q-droop { from { transform: translateY(0) rotate(0); } to { transform: translateY(.3em) rotate(-5deg); } }
@keyframes q-wobble { 50% { transform: rotate(4deg); } }

.q-confetti { position: absolute; inset: 0; pointer-events: none; }
.q-confetti i {
  position: absolute; left: 50%; top: 40%; width: .55em; height: .55em; border-radius: .15em;
  background: var(--pink);
  animation: q-burst .9s ease-out forwards;
}
.q-confetti i:nth-child(4n + 1) { background: var(--yellow); }
.q-confetti i:nth-child(4n + 2) { background: var(--blue); }
.q-confetti i:nth-child(4n + 3) { background: var(--green); }
@keyframes q-burst {
  from { transform: rotate(var(--a)) translateY(0) scale(1); opacity: 1; }
  to { transform: rotate(var(--a)) translateY(-5.5em) scale(.4); opacity: 0; }
}

/* forma */
.q-form { display: grid; gap: .8em; }
.q-input {
  width: 100%; padding: .85em 1em;
  border: .13em solid transparent; border-radius: 1.2em;
  background: #fff; color: var(--ink);
  font: inherit; font-size: 1.3em; font-weight: 800; text-align: center;
  box-shadow: 0 .2em 0 rgba(35, 25, 66, .12);
  transition: border-color .15s, background .15s;
}
.q-input::placeholder { color: #a79fc4; font-weight: 700; }
.q-input:focus { outline: none; border-color: var(--main); }
.q-input.good { border-color: var(--green); background: #effcf8; }
.q-input.bad { border-color: var(--pink); background: #fff3f8; }

.q-fbslot { position: relative; min-height: 2.9em; }
.q-fb { text-align: center; font-weight: 800; padding: .6em 1em; border-radius: 1em; }
.q-fb.good { background: #d5f5ee; color: #12806a; }
.q-fb.bad { background: #ffe3ee; color: #b8325f; }
.q-fb-enter-active { transition: transform .3s cubic-bezier(.3, 1.5, .5, 1), opacity .2s; }
.q-fb-leave-active { transition: opacity .1s; position: absolute; left: 0; right: 0; }
.q-fb-enter-from { transform: translateY(-.5em) scale(.95); opacity: 0; }
.q-fb-leave-to { opacity: 0; }

.q-btn {
  width: 100%; min-height: 3.4em; padding: .9em 1em;
  border: 0; border-radius: 1.2em;
  background: linear-gradient(90deg, var(--main), var(--main-2));
  color: #fff; font: inherit; font-size: 1.15em; font-weight: 900; cursor: pointer;
  box-shadow: 0 .3em 0 var(--main-dark);
  transition: transform .08s, box-shadow .08s, opacity .15s;
}
.q-btn:active:not(:disabled) { transform: translateY(.2em); box-shadow: 0 .1em 0 var(--main-dark); }
.q-btn:disabled { opacity: .5; cursor: default; }

.q-shake { animation: q-shake .45s; }
@keyframes q-shake { 20%, 60% { transform: translateX(-.4em); } 40%, 80% { transform: translateX(.4em); } }

:focus-visible { outline: 3px solid var(--main); outline-offset: 3px; }
@media (prefers-reduced-motion: reduce) {
  .q-friend, .q-confetti i, .q-bump, .q-shake, .q-dots i { animation: none !important; }
  .q-pop-enter-active, .q-fb-enter-active { transition: none; }
}
</style>
