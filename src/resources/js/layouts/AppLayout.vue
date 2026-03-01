<template>
  <div class="app-container">
    
    <!-- Sidebar -->
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
          <router-link class="nav-item" to="/">
            <span class="icon">⌂</span> Início
          </router-link>
          <router-link class="nav-item" to="/sobre">
            <span class="icon">◉</span> Sobre mim
          </router-link>
        </div>

        <div class="nav-section">
          <div class="nav-label">// experimentos</div>
          <router-link class="nav-item" to="/chat">
            <span class="icon">◈</span> Chat em tempo real
            <span class="nav-badge">NOVO</span>
          </router-link>
        </div>
      </nav>

      <div class="sidebar-footer">
        <div class="version">
          <span>Laravel 12 + Vue 3</span>
          <span class="accent">v1.0</span>
        </div>
      </div>
    </aside>

    <!-- Main -->
    <div class="main">
      <div class="topbar">
        <div class="breadcrumb">
          <span>lab</span>
          <span>/</span>
          <span class="current">{{ currentPage }}</span>
        </div>
        <div class="topbar-actions">
          <button class="btn" @click="toggleTheme">{{ isDark ? '☀ claro' : '🌙 escuro' }}</button>
          <a class="btn btn-primary" href="https://github.com/ecaldonazzo" target="_blank">GitHub ↗</a>
        </div>
      </div>

      <div class="content">
        <router-view />
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const isDark = ref(true)

const pageNames = {
  '/': 'início',
  '/sobre': 'sobre mim',
  '/chat': 'chat em tempo real',
}

const currentPage = computed(() => pageNames[route.path] || route.path)

function toggleTheme() {
  isDark.value = !isDark.value
  document.documentElement.setAttribute('data-theme', isDark.value ? 'dark' : 'light')
}
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

.logo {
  font-size: 11px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--text-dim);
  margin-bottom: 6px;
}

.logo span { color: var(--accent); }

.logo-title {
  font-size: 20px;
  font-weight: 700;
  color: var(--text-bright);
  letter-spacing: -0.5px;
}

.logo-title span { color: var(--accent); }

.status {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 10px;
  color: var(--text-dim);
  margin-top: 10px;
}

.status-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: var(--accent);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.3; }
}

.nav { flex: 1; padding: 16px 0; overflow-y: auto; }
.nav-section { margin-bottom: 8px; }

.nav-label {
  font-size: 9px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--text-dim);
  padding: 8px 20px 4px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 20px;
  cursor: pointer;
  transition: all 0.15s;
  border-left: 2px solid transparent;
  font-size: 13px;
  color: var(--text);
  text-decoration: none;
}

.nav-item:hover,
.nav-item.router-link-active {
  background: rgba(0,255,136,0.05);
  color: var(--accent);
  border-left-color: var(--accent);
}

.icon { font-size: 14px; width: 18px; text-align: center; opacity: 0.7; }
.nav-item.router-link-active .icon { opacity: 1; }

.nav-badge {
  margin-left: auto;
  background: rgba(0,255,136,0.15);
  color: var(--accent);
  font-size: 9px;
  padding: 2px 6px;
  border-radius: 10px;
  letter-spacing: 1px;
}

.sidebar-footer {
  padding: 16px 20px;
  border-top: 1px solid var(--border);
  font-size: 11px;
  color: var(--text-dim);
}

.version { display: flex; align-items: center; justify-content: space-between; }
.accent { color: var(--accent); }

.main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

.topbar {
  height: 52px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  padding: 0 28px;
  gap: 12px;
  font-size: 12px;
  color: var(--text-dim);
  background: var(--sidebar);
}

.breadcrumb { display: flex; align-items: center; gap: 8px; }
.breadcrumb .current { color: var(--text-bright); }

.topbar-actions { margin-left: auto; display: flex; gap: 8px; }

.btn {
  padding: 6px 14px;
  border-radius: 4px;
  font-family: 'JetBrains Mono', monospace;
  font-size: 11px;
  cursor: pointer;
  border: 1px solid var(--border);
  background: transparent;
  color: var(--text);
  transition: all 0.15s;
  letter-spacing: 0.5px;
  text-decoration: none;
}

.btn:hover { border-color: var(--accent); color: var(--accent); }

.btn-primary {
  background: var(--accent);
  color: var(--bg);
  border-color: var(--accent);
  font-weight: 600;
}

.btn-primary:hover { opacity: 0.85; color: var(--bg); }

.content { 
  flex: 1; 
  overflow-y: auto; 
  padding: 40px 56px; 
}

</style>