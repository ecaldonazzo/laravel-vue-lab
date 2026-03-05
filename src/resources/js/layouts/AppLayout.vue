<template>
    <div class="app-container" :class="{ 'sidebar-open': sidebarOpen }">

        <div class="overlay" @click="sidebarOpen = false"></div>

        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">// <span>dev</span>.laboratory</div>
                <div class="logo-title">Esdras<span>_</span>Lab</div>
                <div class="status">
                    <div class="status-dot"></div>
                    sistema online
                </div>
            </div>

            <nav class="nav">
                <div class="nav-section">
                    <div class="nav-label">// navegação</div>
                    <router-link class="nav-item" to="/" @click="sidebarOpen = false">
                        <span class="icon">⌂</span> Início
                    </router-link>
                    <router-link class="nav-item" to="/sobre" @click="sidebarOpen = false">
                        <span class="icon">◉</span> Sobre mim
                    </router-link>
                </div>

                <div class="nav-section">
                    <div class="nav-label">// experimentos</div>
                    <router-link class="nav-item" to="/chat" @click="sidebarOpen = false">
                        <span class="icon">◈</span> Chat em tempo real
                    </router-link>
                    <router-link class="nav-item" to="/pokemon" @click="sidebarOpen = false">
                        <span class="icon">⚔</span> Batalha Pokémon
                        <span class="nav-badge">NOVO</span>
                    </router-link>
                </div>

                <!-- Contato dentro da sidebar no mobile -->
                <div class="nav-section nav-contact-mobile">
                    <div class="nav-label">// contato</div>
                    <a class="nav-item" href="http://www.linkedin.com/in/emccastro" target="_blank">
                        <span class="icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                                <rect x="2" y="9" width="4" height="12"/>
                                <circle cx="4" cy="4" r="2"/>
                            </svg>
                        </span>
                        LinkedIn
                    </a>
                    <a class="nav-item" href="mailto:esdrascaldonazzo@gmail.com">
                        <span class="icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        E-mail
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <div class="version">
                    <span>Laravel 12 + Vue 3</span>
                    <span class="accent">v1.0</span>
                </div>
            </div>
        </aside>

        <div class="main">
            <div class="topbar">
                <button class="hamburger" @click="sidebarOpen = !sidebarOpen">
                    <span></span><span></span><span></span>
                </button>

                <div class="breadcrumb">
                    <span>lab</span>
                    <span>/</span>
                    <span class="current">{{ currentPage }}</span>
                </div>

                <div class="topbar-actions">
                    <button class="btn" @click="toggleTheme">{{ isDark ? '☀ claro' : '🌙 escuro' }}</button>
                    <a class="btn btn-primary" href="https://github.com/ecaldonazzo" target="_blank">GitHub ↗</a>

                    <div class="contact-wrap" ref="contactWrap">
                        <button class="btn btn-contact" @click="contactOpen = !contactOpen">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <span class="btn-contact-label">contato</span>
                            <svg class="chevron" :class="{ open: contactOpen }" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </button>

                        <Transition name="panel">
                            <div class="contact-panel" v-if="contactOpen">
                                <div class="cp-header">// contato.esdras</div>
                                <div class="cp-divider"></div>
                                <a class="cp-item" href="http://www.linkedin.com/in/emccastro" target="_blank">
                                    <span class="cp-icon linkedin">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                                            <rect x="2" y="9" width="4" height="12"/>
                                            <circle cx="4" cy="4" r="2"/>
                                        </svg>
                                    </span>
                                    <div class="cp-info">
                                        <span class="cp-label">LinkedIn</span>
                                        <span class="cp-value">in/emccastro</span>
                                    </div>
                                    <svg class="cp-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M7 17L17 7M17 7H7M17 7v10"/>
                                    </svg>
                                </a>
                                <a class="cp-item" href="mailto:esdrascaldonazzo@gmail.com">
                                    <span class="cp-icon email">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                            <polyline points="22,6 12,13 2,6"/>
                                        </svg>
                                    </span>
                                    <div class="cp-info">
                                        <span class="cp-label">E-mail</span>
                                        <span class="cp-value">esdrascaldonazzo@gmail.com</span>
                                    </div>
                                    <svg class="cp-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M7 17L17 7M17 7H7M17 7v10"/>
                                    </svg>
                                </a>
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>

            <div class="content">
                <router-view />
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const isDark = ref(true)
const sidebarOpen = ref(false)
const contactOpen = ref(false)
const contactWrap = ref(null)

const pageNames = {
    '/': 'início',
    '/sobre': 'sobre mim',
    '/chat': 'chat em tempo real',
    '/pokemon': 'batalha pokémon',
}

const currentPage = computed(() => pageNames[route.path] || route.path)

function toggleTheme() {
    isDark.value = !isDark.value
    document.documentElement.setAttribute('data-theme', isDark.value ? 'dark' : 'light')
}

function handleClickOutside(e) {
    if (contactWrap.value && !contactWrap.value.contains(e.target)) {
        contactOpen.value = false
    }
}

onMounted(() => document.addEventListener('mousedown', handleClickOutside))
onUnmounted(() => document.removeEventListener('mousedown', handleClickOutside))
</script>

<style>
.app-container {
    display: flex;
    height: 100vh;
    overflow: hidden;
}

.sidebar {
    width: 260px;
    min-width: 260px;
    background: var(--sidebar);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease;
    z-index: 100;
}

.sidebar::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
}

.sidebar-header {
    padding: 28px 20px 20px;
    border-bottom: 1px solid var(--border);
}

.logo { font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 6px; }
.logo span { color: var(--accent); }
.logo-title { font-size: 20px; font-weight: 700; color: var(--text-bright); letter-spacing: -0.5px; }
.logo-title span { color: var(--accent); }

.status { display: flex; align-items: center; gap: 6px; font-size: 10px; color: var(--text-dim); margin-top: 10px; }
.status-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent); animation: pulse 2s infinite; }

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

.nav { flex: 1; padding: 16px 0; overflow-y: auto; }
.nav-section { margin-bottom: 8px; }
.nav-label { font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-dim); padding: 8px 20px 4px; }

.nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 20px; cursor: pointer; transition: all 0.15s;
    border-left: 2px solid transparent; font-size: 13px;
    color: var(--text); text-decoration: none;
}
.nav-item:hover, .nav-item.router-link-active {
    background: rgba(0,255,136,0.05); color: var(--accent); border-left-color: var(--accent);
}
.icon { font-size: 14px; width: 18px; text-align: center; opacity: 0.7; }
.nav-item.router-link-active .icon { opacity: 1; }

.nav-badge {
    margin-left: auto; background: rgba(0,255,136,0.15);
    color: var(--accent); font-size: 9px; padding: 2px 6px;
    border-radius: 10px; letter-spacing: 1px;
}

/* Contato mobile — só aparece no mobile dentro da sidebar */
.nav-contact-mobile { display: none; }

.sidebar-footer {
    padding: 16px 20px; border-top: 1px solid var(--border);
    font-size: 11px; color: var(--text-dim);
}
.version { display: flex; align-items: center; justify-content: space-between; }
.accent { color: var(--accent); }

.main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

.topbar {
    height: 52px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; padding: 0 28px;
    gap: 12px; font-size: 12px; color: var(--text-dim);
    background: var(--sidebar);
}

.breadcrumb { display: flex; align-items: center; gap: 8px; }
.breadcrumb .current { color: var(--text-bright); }
.topbar-actions { margin-left: auto; display: flex; gap: 8px; align-items: center; }

.btn {
    padding: 6px 14px; border-radius: 4px;
    font-family: 'JetBrains Mono', monospace; font-size: 11px;
    cursor: pointer; border: 1px solid var(--border);
    background: transparent; color: var(--text);
    transition: all 0.15s; letter-spacing: 0.5px; text-decoration: none;
}
.btn:hover { border-color: var(--accent); color: var(--accent); }
.btn-primary { background: var(--accent); color: var(--bg); border-color: var(--accent); font-weight: 600; }
.btn-primary:hover { opacity: 0.85; color: var(--bg); }

/* Contact button */
.contact-wrap { position: relative; }
.btn-contact {
    display: flex; align-items: center; gap: 6px; padding: 6px 12px;
    border-radius: 4px; font-family: 'JetBrains Mono', monospace; font-size: 11px;
    cursor: pointer; border: 1px solid rgba(0,255,136,0.25);
    background: rgba(0,255,136,0.05); color: var(--accent);
    transition: all 0.15s; letter-spacing: 0.5px;
}
.btn-contact:hover { background: rgba(0,255,136,0.1); border-color: var(--accent); }
.chevron { transition: transform 0.2s; }
.chevron.open { transform: rotate(180deg); }

/* Contact panel */
.contact-panel {
    position: absolute; top: calc(100% + 10px); right: 0;
    width: 280px; background: var(--sidebar);
    border: 1px solid var(--border); border-radius: 8px;
    padding: 14px; z-index: 200;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
}
.contact-panel::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, var(--accent), #00d4aa); border-radius: 8px 8px 0 0;
}
.cp-header { font-size: 9px; letter-spacing: 3px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 10px; }
.cp-divider { width: 100%; height: 1px; background: var(--border); margin-bottom: 10px; }
.cp-item {
    display: flex; align-items: center; gap: 12px; padding: 10px;
    border-radius: 6px; text-decoration: none; color: var(--text); transition: all 0.15s;
}
.cp-item:hover { background: rgba(0,255,136,0.05); color: var(--accent); }
.cp-item:hover .cp-arrow { opacity: 1; transform: translate(2px, -2px); }
.cp-item:hover .cp-icon.linkedin { background: rgba(10,102,194,0.2); color: #0a66c2; }
.cp-item:hover .cp-icon.email { background: rgba(0,255,136,0.15); color: var(--accent); }
.cp-icon {
    width: 32px; height: 32px; border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: all 0.15s;
}
.cp-icon.linkedin { background: rgba(10,102,194,0.1); color: #0a66c2; }
.cp-icon.email { background: rgba(0,255,136,0.08); color: var(--accent); }
.cp-info { display: flex; flex-direction: column; gap: 1px; flex: 1; }
.cp-label { font-size: 12px; font-weight: 600; color: var(--text-bright); line-height: 1; }
.cp-value { font-size: 10px; color: var(--text-dim); font-family: 'JetBrains Mono', monospace; letter-spacing: 0.3px; }
.cp-arrow { opacity: 0; transition: all 0.15s; color: var(--accent); flex-shrink: 0; }

.panel-enter-active, .panel-leave-active { transition: all 0.2s ease; }
.panel-enter-from, .panel-leave-to { opacity: 0; transform: translateY(-8px) scale(0.97); }

.content { flex: 1; overflow-y: auto; padding: 40px 56px; }

/* Hamburguer */
.hamburger { display: none; flex-direction: column; gap: 5px; background: transparent; border: none; cursor: pointer; padding: 4px; }
.hamburger span { display: block; width: 22px; height: 2px; background: var(--text); transition: all 0.3s; }

.overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99; }

/* MOBILE */
@media (max-width: 768px) {
    .hamburger { display: flex; }

    .sidebar { position: fixed; top: 0; left: 0; height: 100vh; transform: translateX(-100%); }
    .sidebar-open .sidebar { transform: translateX(0); }
    .sidebar-open .overlay { display: block; }

    /* Mostra contato na sidebar no mobile */
    .nav-contact-mobile { display: block; }

    /* Esconde botão contato da topbar no mobile */
    .contact-wrap { display: none; }

    /* Esconde tema e github no mobile, deixa só o essencial */
    .topbar-actions .btn { display: none; }
    .topbar-actions .btn-primary { display: none; }

    .topbar { padding: 0 16px; }
    .content { padding: 24px 20px; }
    .btn-contact-label { display: none; }
}
</style>
