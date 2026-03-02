<template>
  <div class="home">

    <!-- Apresentação -->
    <div class="profile">
      <div class="profile-img">
       <img :src="'/images/perfil.png'" alt="Esdras" />
      </div>
      <div class="profile-info">
        <div class="hero-tag">// olá, eu sou</div>
        <h1>Esdras<span>_</span></h1>
        <p>Desenvolvedor Full Stack apaixonado por arquiteturas de software, soluções criativas e código que funciona de verdade. Aqui você encontra meus projetos interativos — não só teoria, mas coisas que você pode testar.</p>
        <router-link to="/sobre" class="btn-link">Ver minha trajetória →</router-link>
      </div>
    </div>

    <!-- Hero -->
    <div class="hero">
      <div class="hero-tag">// laboratório pessoal</div>
      <h1>Experimentos em <span>tempo real</span></h1>
      <p>Um espaço para explorar arquiteturas, padrões e tecnologias. Cada experimento é interativo — veja funcionando, não só leia sobre.</p>
    </div>

    <!-- Experimentos -->
    <div class="section-title">// experimentos disponíveis</div>
    <div class="experiments">

      <div class="exp-card" @click="$router.push('/chat')">
        <div class="exp-tag">// eventos</div>
        <div class="exp-title">Chat em Tempo Real</div>
        <div class="exp-desc">Demonstração de Arquitetura Orientada a Eventos usando WebSockets. Duas pessoas conversando sem reload de página.</div>
        <div class="exp-footer">
          <div class="exp-tech">
            <span class="tech-tag">REVERB</span>
            <span class="tech-tag">VUE</span>
          </div>
          <span class="exp-status pending">● em andamento</span>
        </div>
      </div>

        <div class="exp-card" @click="$router.push('/pokemon')">
            <div class="exp-tag">// batalha</div>
            <div class="exp-title">Batalha Pokémon</div>
            <div class="exp-desc">Dois Pokémons aleatórios da Gen I se enfrentam em batalha automática. Sistema de dano com críticos e animações.</div>
            <div class="exp-footer">
                <div class="exp-tech">
                    <span class="tech-tag">LARAVEL</span>
                    <span class="tech-tag">VUE</span>
                    <span class="tech-tag">POKEAPI</span>
                </div>
                <span class="exp-status">● ativo</span>
            </div>
        </div>

      <div class="exp-card disabled">
        <div class="exp-tag">// em breve</div>
        <div class="exp-title">Próximo experimento</div>
        <div class="exp-desc">Novo experimento chegando em breve...</div>
        <div class="exp-footer">
          <div class="exp-tech">
            <span class="tech-tag">???</span>
          </div>
          <span class="exp-status pending">● pendente</span>
        </div>
      </div>

    </div>

    <div class="terminal-line">
      cd /lab/experimentos/chat <span class="cursor"></span>
    </div>

  </div>
</template>

<script setup>
</script>

<style>
.home {}

/* ── Perfil ── */
.profile {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 40px;
  margin-bottom: 56px;
  padding-bottom: 48px;
  border-bottom: 1px solid var(--border);
  flex-wrap: wrap;
}

.profile-img { flex-shrink: 0; }

.profile-img img {
  width: 160px;
  height: 160px;
  border-radius: 50%;
  object-fit: cover;
  object-position: center top;
  border: 2px solid var(--accent);
  filter: grayscale(20%);
  display: block;
}

.profile-info h1 {
  font-size: 42px;
  font-weight: 700;
  color: var(--text-bright);
  letter-spacing: -1.5px;
  margin-bottom: 12px;
}

.profile-info h1 span {
  color: var(--accent);
  animation: blink 1s infinite;
}

.profile-info p {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 15px;
  color: var(--text);
  line-height: 1.75;
  max-width: 480px;
  margin-bottom: 20px;
}

.btn-link {
  font-size: 13px;
  color: var(--accent);
  text-decoration: none;
  border: 1px solid var(--accent);
  padding: 8px 16px;
  border-radius: 4px;
  transition: all 0.2s;
  display: inline-block;
}

.btn-link:hover {
  background: var(--accent);
  color: var(--bg);
}

@media (max-width: 600px) {
  .profile {
    flex-direction: column;
    align-items: center;
  }

  .profile-img img {
    width: 120px;
    height: 120px;
  }
}

/* ── Hero ── */
.hero {
  margin-bottom: 48px;
  text-align: center;
}

.hero-tag {
  font-size: 11px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 16px;
}

.hero h1 {
  font-size: 48px;
  font-weight: 700;
  color: var(--text-bright);
  line-height: 1.15;
  letter-spacing: -1.5px;
  margin-bottom: 16px;
}

.hero h1 span { color: var(--accent); }

.hero p {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 17px;
  color: var(--text);
  max-width: 560px;
  line-height: 1.75;
  margin: 0 auto;
}

/* ── Experimentos ── */
.section-title {
  font-size: 11px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--text-dim);
  margin-bottom: 20px;
  text-align: center;
}

.experiments {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 16px;
  margin-bottom: 48px;
}

.exp-card {
  width: 300px;
  flex-shrink: 0;
  background: var(--sidebar);
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 24px;
  cursor: pointer;
  transition: all 0.2s;
  position: relative;
  overflow: hidden;
}

.exp-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, var(--accent), transparent);
  opacity: 0;
  transition: opacity 0.2s;
}

.exp-card:hover {
  border-color: rgba(0,255,136,0.3);
  transform: translateY(-3px);
  box-shadow: 0 8px 32px rgba(0,255,136,0.08);
}

.exp-card:hover::before { opacity: 1; }

.exp-card.disabled {
  opacity: 0.4;
  cursor: default;
  pointer-events: none;
}

.exp-tag {
  font-size: 10px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 12px;
}

.exp-title {
  font-size: 18px;
  font-weight: 600;
  color: var(--text-bright);
  margin-bottom: 10px;
  letter-spacing: -0.3px;
}

.exp-desc {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 14px;
  color: var(--text-dim);
  line-height: 1.65;
  margin-bottom: 20px;
}

.exp-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.exp-tech { display: flex; gap: 6px; }

.tech-tag {
  background: rgba(0,255,136,0.08);
  color: var(--accent);
  font-size: 10px;
  padding: 3px 8px;
  border-radius: 4px;
  letter-spacing: 1px;
  border: 1px solid rgba(0,255,136,0.15);
}

.exp-status { font-size: 11px; color: var(--accent); }
.exp-status.pending { color: var(--text-dim); }

/* ── Terminal ── */
.terminal-line {
  font-size: 13px;
  color: var(--text-dim);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.terminal-line::before {
  content: '$';
  color: var(--accent);
}

.cursor {
  display: inline-block;
  width: 8px;
  height: 15px;
  background: var(--accent);
  animation: blink 1s infinite;
  vertical-align: middle;
}

@keyframes blink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0; }
}
</style>
