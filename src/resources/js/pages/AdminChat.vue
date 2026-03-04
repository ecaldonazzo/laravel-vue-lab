<template>
    <div class="admin-chat">

        <div class="page-header">
            <div class="page-tag">// admin.chat</div>
            <h1 class="page-title">Inbox<span class="accent">_</span>Live</h1>
            <p class="page-subtitle">Mensagens recebidas em tempo real</p>
        </div>

        <!-- Stats bar -->
        <div class="stats-bar">
            <div class="stat-pill">
                <span class="sp-dot"></span>
                <span>{{ messages.length }} mensagens</span>
            </div>
            <button class="clear-btn" @click="messages = []" v-if="messages.length > 0">
                limpar
            </button>
        </div>

        <!-- Messages feed -->
        <div class="feed" ref="feedEl">
            <div class="feed-empty" v-if="messages.length === 0">
                <span class="fe-icon">◈</span>
                <span>aguardando mensagens dos visitantes...</span>
            </div>

            <TransitionGroup name="msg-in">
                <div class="feed-msg" v-for="(msg, i) in [...messages].reverse()" :key="msg.id">
                    <div class="fm-header">
                        <div class="fm-avatar">{{ msg.name.charAt(0).toUpperCase() }}</div>
                        <div class="fm-meta">
                            <span class="fm-name">{{ msg.name }}</span>
                            <span class="fm-time">{{ msg.time }}</span>
                        </div>
                        <span class="fm-new" v-if="i === 0">novo</span>
                    </div>
                    <div class="fm-body">{{ msg.message }}</div>
                </div>
            </TransitionGroup>
        </div>

        <!-- WS Status -->
        <div class="ws-status" :class="wsState">
            <span class="ws-dot"></span>
            {{ wsLabel }}
        </div>

        <!-- Sound toggle -->
        <div class="sound-toggle" @click="soundOn = !soundOn">
            <span>{{ soundOn ? '🔔' : '🔕' }}</span>
            <span class="st-label">{{ soundOn ? 'som ativo' : 'sem som' }}</span>
        </div>

    </div>
</template>

<script setup>
import { ref, onUnmounted } from 'vue'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

const messages = ref([])
const wsState  = ref('connecting')
const wsLabel  = ref('conectando...')
const soundOn  = ref(true)
let   msgId    = 0

// ── Notification sound ───────────────────────────────
function playSound() {
    if (!soundOn.value) return
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)()
        const osc = ctx.createOscillator()
        const gain = ctx.createGain()
        osc.connect(gain)
        gain.connect(ctx.destination)
        osc.frequency.value = 880
        osc.type = 'sine'
        gain.gain.setValueAtTime(0.3, ctx.currentTime)
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3)
        osc.start(ctx.currentTime)
        osc.stop(ctx.currentTime + 0.3)
    } catch {}
}

// ── Echo / Reverb ────────────────────────────────────
window.Pusher = Pusher

const echo = new Echo({
    broadcaster:  'reverb',
    key:          import.meta.env.VITE_REVERB_APP_KEY,
    wsHost:       import.meta.env.VITE_REVERB_HOST,
    wsPort:       import.meta.env.VITE_REVERB_PORT    ?? 8080,
    wssPort:      import.meta.env.VITE_REVERB_PORT    ?? 443,
    forceTLS:     (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
})

echo.connector.pusher.connection.bind('connected',    () => { wsState.value = 'connected';    wsLabel.value = 'ouvindo mensagens' })
echo.connector.pusher.connection.bind('disconnected', () => { wsState.value = 'disconnected'; wsLabel.value = 'desconectado' })
echo.connector.pusher.connection.bind('error',        () => { wsState.value = 'error';        wsLabel.value = 'erro de conexão' })

echo.channel('chat').listen('.message.sent', (e) => {
    messages.value.push({ ...e, id: ++msgId })
    playSound()

    // Notificação do browser
    if (Notification.permission === 'granted') {
        new Notification(`💬 ${e.name}`, { body: e.message, icon: '/images/perfil.png' })
    }
})

onUnmounted(() => echo.leaveChannel('chat'))

// Pedir permissão de notificação
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission()
}
</script>

<style scoped>
.admin-chat { max-width: 700px; }

.page-header { margin-bottom: 24px; }
.page-tag { font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 8px; }
.page-title { font-size: 36px; font-weight: 700; color: var(--text-bright); letter-spacing: -1px; line-height: 1; margin-bottom: 6px; }
.accent { color: var(--accent); }
.page-subtitle { font-size: 13px; color: var(--text-dim); }

.stats-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.stat-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 10px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--text-dim);
}

.sp-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--accent);
    animation: pulse 2s infinite;
}

.clear-btn {
    background: transparent;
    border: 1px solid var(--border);
    color: var(--text-dim);
    font-size: 10px;
    padding: 4px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-family: 'JetBrains Mono', monospace;
    letter-spacing: 1px;
    transition: all 0.15s;
}
.clear-btn:hover { border-color: #ff6b6b; color: #ff6b6b; }

/* Feed */
.feed {
    display: flex;
    flex-direction: column;
    gap: 10px;
    min-height: 200px;
}

.feed-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
    gap: 10px;
    color: var(--text-dim);
    font-size: 12px;
    letter-spacing: 1px;
    border: 1px dashed var(--border);
    border-radius: 8px;
}

.fe-icon { font-size: 24px; opacity: 0.3; }

.feed-msg {
    background: var(--sidebar);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 16px;
    position: relative;
    transition: border-color 0.2s;
}

.feed-msg:hover { border-color: rgba(0,255,136,0.2); }

.fm-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.fm-avatar {
    width: 32px; height: 32px;
    border-radius: 6px;
    background: rgba(0,255,136,0.1);
    border: 1px solid rgba(0,255,136,0.2);
    color: var(--accent);
    font-size: 13px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-family: 'JetBrains Mono', monospace;
}

.fm-meta { display: flex; flex-direction: column; gap: 1px; flex: 1; }
.fm-name { font-size: 12px; font-weight: 600; color: var(--text-bright); }
.fm-time { font-size: 10px; color: var(--text-dim); font-family: 'JetBrains Mono', monospace; }

.fm-new {
    background: rgba(0,255,136,0.1);
    border: 1px solid rgba(0,255,136,0.2);
    color: var(--accent);
    font-size: 8px;
    padding: 2px 7px;
    border-radius: 10px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    animation: pulse 2s infinite;
}

.fm-body {
    font-size: 13px;
    line-height: 1.65;
    color: var(--text);
    padding-left: 42px;
}

/* Transitions */
.msg-in-enter-active { transition: all 0.3s ease; }
.msg-in-enter-from { opacity: 0; transform: translateY(-10px); }

/* WS Status */
.ws-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 9px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-top: 16px;
    color: var(--text-dim);
}

.ws-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--text-dim); }
.ws-status.connected { color: var(--accent); }
.ws-status.connected .ws-dot { background: var(--accent); animation: pulse 2s infinite; }
.ws-status.disconnected { color: #ff6b6b; }
.ws-status.disconnected .ws-dot { background: #ff6b6b; }
.ws-status.error { color: #ffb347; }
.ws-status.error .ws-dot { background: #ffb347; }

/* Sound toggle */
.sound-toggle {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
    margin-left: 16px;
    cursor: pointer;
    font-size: 11px;
    color: var(--text-dim);
    transition: color 0.15s;
    user-select: none;
}
.sound-toggle:hover { color: var(--text); }
.st-label { font-family: 'JetBrains Mono', monospace; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; }

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}
</style>
