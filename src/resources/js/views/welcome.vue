<template>
    <div class="welcome">
        <div class="band" aria-hidden="true"></div>

        <main class="center">
            <h1>Lug'at</h1>
            <span class="rule" aria-hidden="true"></span>
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
    --serif: Charter, "Iowan Old Style", "Palatino Linotype", Georgia, serif;

    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: var(--paper);
    color: var(--ink);
}

@media (prefers-color-scheme: dark) {
    .welcome {
        --paper: #0b1626;
        --ink: #e7eef8;
        --tile: #6fa3e6;
        --turq: #3cc0c2;
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

.rule {
    width: 72px;
    height: 4px;
    margin-top: 20px;
    background: var(--saffron);
}
</style>
