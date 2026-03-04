<template>
    <div class="chat-page">

        <div class="hero-tag">// websocket.experiment</div>
        <h1 class="page-title">Chat <span class="accent">Lab</span></h1>
        <p class="page-subtitle">Envie uma mensagem — ela chega em tempo real</p>

        <div class="chat-center">
            <div class="chat-wrap">
                <div class="chat-messages" ref="messagesEl">
                    <div class="chat-empty" v-if="messages.length === 0">
                        <span class="empty-icon">◈</span>
                        <span>aguardando mensagens...</span>
                    </div>
                    <div v-for="(msg, i) in messages" :key="i" class="msg" :class="{ own: msg.own }">
                        <div class="msg-meta">
                            <span class="msg-name">{{ msg.name }}</span>
                            <span class="msg-time">{{ msg.time }}</span>
                        </div>
                        <div class="msg-bubble">{{ msg.message }}</div>
                    </div>
                </div>
                <div class="chat-form">
                    <div class="form-row" v-if="!nameSaved">
                        <input v-model="nameInput" class="chat-input" placeholder="seu nome..." @keyup.enter="saveName" maxlength="50" />
                        <button class="chat-btn" @click="saveName">ok</button>
                    </div>
                    <div class="form-row" v-else>
                        <span class="name-tag">
                            <span class="nt-dot"></span>
                            {{ name }}
                            <button class="nt-change" @click="nameSaved = false">✕</button>
                        </span>
                        <input v-model="messageInput" class="chat-input flex-1" placeholder="mensagem..." @keyup.enter="sendMessage" maxlength="500" :disabled="sending" ref="msgInput" />
                        <button class="chat-btn" @click="sendMessage" :disabled="sending">
                            <span v-if="!sending">enviar</span>
                            <span v-else class="sending-dots">...</span>
                        </button>
                    </div>
                    <div class="form-hint">pressione Enter para enviar</div>
                </div>
            </div>
            <div class="ws-status" :class="wsState">
                <span class="ws-dot"></span>
                {{ wsLabel }}
            </div>
        </div>

        <div class="explanation">
            <div class="exp-header">
                <div class="sh-line"></div>
                <span class="sh-label">// implementação</span>
                <div class="sh-line"></div>
            </div>
            <div class="exp-grid">
                <div class="exp-card">
                    <div class="exp-icon">◈</div>
                    <div class="exp-title">Sobre o experimento</div>
                    <p class="exp-text">
                        Este experimento demonstra comunicação em tempo real via WebSocket usando
                        <span class="hl">Laravel Reverb</span> como servidor WebSocket nativo do Laravel
                        e <span class="hl">Laravel Echo</span> no frontend para escutar os eventos.
                        Qualquer mensagem enviada aqui é recebida instantaneamente no painel do administrador,
                        sem polling e sem reload — conexão persistente bidirecional.
                    </p>
                </div>
                <div class="exp-card">
                    <div class="exp-icon">⬢</div>
                    <div class="exp-title">Como foi construído</div>
                    <p class="exp-text">
                        O frontend envia a mensagem via <span class="hl">POST /api/chat/send</span>.
                        O Controller dispara o evento <span class="hl">MessageSent</span> que implementa
                        <span class="hl">ShouldBroadcast</span>. O Reverb publica no canal público
                        <span class="hl">chat</span> via protocolo Pusher sobre WebSocket.
                        O Echo escuta o evento <span class="hl">.message.sent</span> e atualiza
                        a UI reativamente via Vue.js.
                    </p>
                </div>
                <div class="exp-card">
                    <div class="exp-icon">⬡</div>
                    <div class="exp-title">Stack</div>
                    <div class="exp-tags">
                        <span class="exp-tag">Laravel Reverb</span>
                        <span class="exp-tag">WebSocket</span>
                        <span class="exp-tag">Laravel Echo</span>
                        <span class="exp-tag">Vue.js 3</span>
                        <span class="exp-tag">Broadcasting</span>
                        <span class="exp-tag">Events</span>
                        <span class="exp-tag">Channels</span>
                        <span class="exp-tag">Pusher Protocol</span>
                    </div>
                </div>
            </div>
            <div class="exp-flow">
                <div class="flow-step">
                    <span class="fs-label">Vue.js</span>
                    <span class="fs-sub">Laravel Echo</span>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step">
                    <span class="fs-label">POST /api</span>
                    <span class="fs-sub">Controller</span>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step">
                    <span class="fs-label">broadcast()</span>
                    <span class="fs-sub">MessageSent</span>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step">
                    <span class="fs-label">Reverb</span>
                    <span class="fs-sub">WS Server</span>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step highlight">
                    <span class="fs-label">canal chat</span>
                    <span class="fs-sub">todos os clientes ⚡</span>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, nextTick, onUnmounted } from 'vue'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

const nameInput    = ref('')
const messageInput = ref('')
const name         = ref('')
const nameSaved    = ref(false)
const sending      = ref(false)
const messages     = ref([])
const messagesEl   = ref(null)
const msgInput     = ref(null)
const wsState      = ref('connecting')
const wsLabel      = ref('conectando...')

window.Pusher = Pusher
const echo = new Echo({
    broadcaster:       'reverb',
    key:               import.meta.env.VITE_REVERB_APP_KEY,
    wsHost:            import.meta.env.VITE_REVERB_HOST,
    wsPort:            import.meta.env.VITE_REVERB_PORT    ?? 8080,
    wssPort:           import.meta.env.VITE_REVERB_PORT    ?? 443,
    forceTLS:          (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
})

echo.connector.pusher.connection.bind('connected',    () => { wsState.value = 'connected';    wsLabel.value = 'conectado' })
echo.connector.pusher.connection.bind('disconnected', () => { wsState.value = 'disconnected'; wsLabel.value = 'desconectado' })
echo.connector.pusher.connection.bind('error',        () => { wsState.value = 'error';        wsLabel.value = 'erro de conexão' })

echo.channel('chat').listen('.message.sent', (e) => {
    messages.value.push({ ...e, own: false })
    scrollDown()
})
onUnmounted(() => echo.leaveChannel('chat'))

function saveName() {
    if (!nameInput.value.trim()) return
    name.value      = nameInput.value.trim()
    nameSaved.value = true
    nextTick(() => msgInput.value?.focus())
}

async function sendMessage() {
    if (!messageInput.value.trim() || sending.value) return
    sending.value = true
    const payload = { name: name.value, message: messageInput.value.trim() }
    try {
        const res  = await fetch('/api/chat/send', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body:    JSON.stringify(payload),
        })
        const data = await res.json()
        messages.value.push({ ...payload, time: data.time, own: true })
        messageInput.value = ''
        scrollDown()
    } catch (e) { console.error(e) }
    finally {
        sending.value = false
        nextTick(() => msgInput.value?.focus())
    }
}

function scrollDown() {
    nextTick(() => {
        if (messagesEl.value) messagesEl.value.scrollTop = messagesEl.value.scrollHeight
    })
}
</script>

<style scoped>
.chat-page { max-width: 900px; }

/* Header — igual ao Pokemon */
.hero-tag { font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: var(--accent); margin-bottom: 8px; }
.page-title { font-size: 42px; font-weight: 700; color: var(--text-bright); letter-spacing: -1.5px; margin-bottom: 12px; }
.page-title .accent { color: var(--accent); }
.accent { color: var(--accent); }
.page-subtitle { font-family: 'Space Grotesk', sans-serif; font-size: 15px; color: var(--text); margin-bottom: 40px; }

/* Chat centralizado */
.chat-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 48px;
}

.chat-wrap {
    width: 100%;
    max-width: 620px;
    background: var(--sidebar);
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}
.chat-wrap::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--accent), #00d4aa);
}

.chat-messages {
    height: 380px;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.chat-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; gap: 8px; color: var(--text-dim); font-size: 12px; letter-spacing: 1px; }
.empty-icon { font-size: 24px; opacity: 0.3; }
.msg { display: flex; flex-direction: column; gap: 4px; max-width: 75%; }
.msg.own { align-self: flex-end; }
.msg-meta { display: flex; align-items: center; gap: 8px; }
.msg.own .msg-meta { flex-direction: row-reverse; }
.msg-name { font-size: 10px; letter-spacing: 1px; text-transform: uppercase; color: var(--accent); font-weight: 600; }
.msg-time { font-size: 9px; color: var(--text-dim); font-family: 'JetBrains Mono', monospace; }
.msg-bubble { background: var(--bg); border: 1px solid var(--border); border-radius: 6px; padding: 10px 14px; font-size: 13px; line-height: 1.6; color: var(--text); word-break: break-word; }
.msg.own .msg-bubble { background: rgba(0,255,136,0.06); border-color: rgba(0,255,136,0.15); color: var(--text-bright); }

.chat-form { border-top: 1px solid var(--border); padding: 14px 16px 10px; background: var(--bg); }
.form-row { display: flex; gap: 8px; align-items: center; margin-bottom: 6px; }
.flex-1 { flex: 1; }
.chat-input { background: var(--sidebar); border: 1px solid var(--border); border-radius: 4px; padding: 8px 12px; font-size: 12px; color: var(--text); font-family: 'JetBrains Mono', monospace; outline: none; transition: border-color 0.15s; width: 180px; }
.chat-input.flex-1 { width: auto; }
.chat-input:focus { border-color: var(--accent); }
.chat-input:disabled { opacity: 0.5; }
.chat-input::placeholder { color: var(--text-dim); }
.chat-btn { background: var(--accent); border: none; color: var(--bg); padding: 8px 16px; border-radius: 4px; font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700; cursor: pointer; letter-spacing: 0.5px; transition: opacity 0.15s; white-space: nowrap; }
.chat-btn:hover { opacity: 0.85; }
.chat-btn:disabled { opacity: 0.4; cursor: not-allowed; }
.name-tag { display: flex; align-items: center; gap: 6px; background: rgba(0,255,136,0.08); border: 1px solid rgba(0,255,136,0.2); color: var(--accent); font-size: 10px; padding: 4px 10px; border-radius: 4px; font-family: 'JetBrains Mono', monospace; white-space: nowrap; letter-spacing: 0.5px; }
.nt-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--accent); }
.nt-change { background: none; border: none; color: var(--text-dim); cursor: pointer; font-size: 10px; padding: 0; transition: color 0.15s; }
.nt-change:hover { color: #ff6b6b; }
.sending-dots { letter-spacing: 2px; }
.form-hint { font-size: 9px; color: var(--text-dim); letter-spacing: 1px; text-align: right; }

/* WS status — centralizado abaixo do chat */
.ws-status { display: inline-flex; align-items: center; gap: 6px; font-size: 9px; letter-spacing: 1.5px; text-transform: uppercase; margin-top: 10px; color: var(--text-dim); }
.ws-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--text-dim); }
.ws-status.connected { color: var(--accent); }
.ws-status.connected .ws-dot { background: var(--accent); animation: pulse 2s infinite; }
.ws-status.disconnected { color: #ff6b6b; }
.ws-status.disconnected .ws-dot { background: #ff6b6b; }
.ws-status.error { color: #ffb347; }
.ws-status.error .ws-dot { background: #ffb347; }

/* Explanation — cards largos */
.exp-header { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
.sh-line { flex: 1; height: 1px; background: var(--border); }
.sh-label { font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: var(--accent); white-space: nowrap; }

.exp-grid { display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px; }

.exp-card {
    background: var(--sidebar);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 22px 32px;
    width: 100%;
    box-sizing: border-box;
    transition: border-color 0.15s;
}
.exp-card:hover { border-color: rgba(0,255,136,0.2); }
.exp-icon { font-size: 18px; color: var(--accent); opacity: 0.6; margin-bottom: 10px; }
.exp-title { font-size: 15px; font-weight: 700; color: var(--text-bright); margin-bottom: 10px; letter-spacing: -0.3px; }
.exp-text { font-size: 12px; line-height: 1.8; color: var(--text); }
.hl { color: var(--accent); font-family: 'JetBrains Mono', monospace; font-size: 10.5px; }
.exp-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.exp-tag { background: rgba(0,255,136,0.06); border: 1px solid rgba(0,255,136,0.15); color: var(--accent); font-size: 9px; padding: 3px 8px; border-radius: 3px; font-family: 'JetBrains Mono', monospace; letter-spacing: 0.5px; }

/* Flow */
.exp-flow { display: flex; align-items: center; justify-content: space-between; gap: 8px; background: var(--sidebar); border: 1px solid var(--border); border-radius: 8px; padding: 20px 32px; overflow-x: auto; }
.flow-step { display: flex; flex-direction: column; align-items: center; gap: 4px; flex-shrink: 0; }
.fs-label { font-size: 12px; font-weight: 700; color: var(--text-bright); font-family: 'JetBrains Mono', monospace; }
.fs-sub { font-size: 9px; color: var(--text-dim); letter-spacing: 0.3px; text-align: center; }
.flow-step.highlight .fs-label { color: var(--accent); }
.flow-step.highlight .fs-sub { color: var(--accent); opacity: 0.7; }
.flow-arrow { color: var(--text-dim); font-size: 16px; flex-shrink: 0; padding-bottom: 14px; }

@media (max-width: 600px) {
    .chat-wrap { max-width: 100%; }
    .exp-flow { justify-content: flex-start; padding: 12px 16px; }
    .fs-label { font-size: 9px; }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}
</style>
