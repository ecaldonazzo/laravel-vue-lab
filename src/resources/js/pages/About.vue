<template>
    <div class="sobre-page">

        <!-- Header -->
        <div class="page-header">
            <div class="page-tag">// sobre.mim</div>
            <h1 class="page-title">Esdras<span class="accent">_</span>Caldonazzo</h1>
            <p class="page-subtitle">Fullstack Developer & Systems Architect</p>
        </div>

        <!-- Profile intro -->
        <div class="profile-intro">
            <div class="profile-photo-wrap">
                <div class="profile-photo">
                    <img :src="photos.profile" alt="Esdras" @error="e => e.target.style.display='none'" />
                </div>
                <div class="profile-glow"></div>
            </div>
            <div class="profile-text">
                <p class="profile-bio">
                    Sou desenvolvedor fullstack com mais de <span class="hl">6 anos</span> transformando
                    ideias em sistemas que realmente funcionam. Comecei do zero, com um projeto universitário,
                    e fui construindo — projeto a projeto, empresa a empresa — uma trajetória em
                    integrações, arquitetura de dados e automação de operações complexas.
                </p>
                <div class="profile-stack">
                    <span class="stack-tag" v-for="tech in stack" :key="tech">{{ tech }}</span>
                </div>
            </div>
        </div>

        <!-- Story heading -->
        <div class="story-heading">
            <div class="sh-line"></div>
            <span class="sh-label">// minha história</span>
            <div class="sh-line"></div>
        </div>

        <!-- TIMELINE STORIES -->
        <div class="stories">

            <div
                v-for="(item, i) in timeline"
                :key="item.id"
                class="story-item"
                :class="{ reverse: i % 2 !== 0 }"
            >
                <!-- Photo side -->
                <div class="story-photo-wrap">
                    <div class="story-photo">
                        <img :src="photos[item.id]" :alt="item.title" @error="e => e.target.parentElement.classList.add('no-photo')" />
                        <div class="story-photo-overlay">
                            <span class="spo-year">{{ item.year }}</span>
                        </div>
                    </div>
                    <div class="story-photo-accent" :style="{ background: item.color }"></div>
                </div>

                <!-- Text side -->
                <div class="story-content">
                    <div class="sc-chapter">capítulo {{ String(i + 1).padStart(2, '0') }}</div>
                    <h2 class="sc-title">{{ item.title }}</h2>
                    <div class="sc-where">
                        <span class="sc-dot" :style="{ background: item.color }"></span>
                        {{ item.where }}
                    </div>
                    <p class="sc-text">{{ item.story }}</p>
                    <div class="sc-tags">
                        <span class="tag" v-for="t in item.tags" :key="t">{{ t }}</span>
                    </div>
                    <button v-if="item.project" class="sc-btn" @click="openModal(item.id)">
                        detalhes do projeto <span class="btn-arrow">→</span>
                    </button>
                </div>

                <!-- connector -->
                <div class="story-connector" v-if="i < timeline.length - 1">
                    <div class="connector-line"></div>
                </div>
            </div>

        </div>

        <!-- MODAL -->
        <Teleport to="body">
            <div class="modal-overlay" :class="{ open: modal.open }" @click.self="closeModal">
                <div class="modal-box" v-if="modal.open">
                    <button class="modal-close" @click="closeModal">✕</button>
                    <div class="modal-label">// projeto</div>
                    <h2 class="modal-title">{{ modal.data.title }}</h2>
                    <div class="modal-year">{{ modal.data.year }}</div>
                    <div class="modal-divider"></div>
                    <div class="modal-section">
                        <div class="msl">sobre o projeto</div>
                        <p class="modal-text">{{ modal.data.about }}</p>
                    </div>
                    <div class="modal-section contrib">
                        <div class="msl">// minha contribuição</div>
                        <ul class="modal-list">
                            <li v-for="c in modal.data.contributions" :key="c">{{ c }}</li>
                        </ul>
                    </div>
                    <div class="modal-tags">
                        <span class="tag" v-for="t in modal.data.tags" :key="t">{{ t }}</span>
                    </div>
                </div>
            </div>
        </Teleport>

    </div>
</template>

<script setup>
import { reactive } from 'vue'

// ── Photos ──────────────────────────────────────────
// Coloque as fotos em public/images/about/
// Ex: public/images/about/profile.jpg, unifal.jpg, vader.jpg ...
const photos = {
    profile:          '/images/perfil.png',
    unifal:           '/images/about/inicio.png',
    vader:            '/images/about/studiovv.jpeg',
    'logcomex-entry': '/images/about/contratado.png',
    integracoes:      '/images/about/logesdras.jpg',
    datalake:         '/images/about/datalake.JPEG',
    x9:               '/images/about/squad.JPEG',
    trem:             '/images/about/trem.jpg',
    milestones:       '/images/about/coordenador.jpg',
}

// ── Stack ───────────────────────────────────────────
const stack = ['PHP', 'Laravel', 'Vue.js', 'JavaScript', 'APIs', 'PostgreSQL', 'CI/CD']

// ── Timeline data ────────────────────────────────────
const timeline = [
    {
        id: 'unifal',
        year: '2018',
        title: 'O primeiro código',
        where: 'UNIFAL-MG · Projeto Universitário',
        color: '#00d4aa',
        story: 'Meu primeiro trabalho foi uma intranet educacional desenvolvida para o Programa de Pós-Graduação em História Ibérica da UNIFAL-MG. O sistema apresentava a pesquisa sobre Cristóvão Colombo em formato de notícias interativas, com atividades de fixação — e rodava completamente offline dentro da universidade.',
        tags: ['HTML', 'CSS3', 'JavaScript', 'Bootstrap', 'offline-first'],
        project: true,
    },
    {
        id: 'vader',
        year: '2019',
        title: 'Gerenciando música com código',
        where: 'Studio Vader · Projeto Freelance',
        color: '#a89cff',
        story: 'Desenvolvi um sistema de gestão para estúdio de música onde o produtor organizava projetos, definia faixas e comunicava aos músicos o que e quando gravar. Cada músico sabia exatamente sua hora de entrar no estúdio e quais músicas gravar — tudo centralizado no sistema.',
        tags: ['gestão de projetos', 'agenda', 'músicos', 'gravações'],
        project: true,
    },
    {
        id: 'logcomex-entry',
        year: 'out. 2019',
        title: 'Contratado. Hora de enfrentar desafios',
        where: 'Logcomex · Engenheiro de Software Junior',
        color: '#00ff88',
        story: 'Entrei na Logcomex para refatorar do zero o Configurador de Planos — frontend e backend. Reescrevi a arquitetura frontend com Vue.js e o backend com estrutura mais robusta e segura, preparando o sistema para suportar o crescimento acelerado da empresa.',
        tags: ['Vue.js', 'refatoração', 'frontend', 'escala'],
        project: false,
    },
    {
        id: 'integracoes',
        year: '2021',
        title: 'Conectando os pontos que ninguém conectava',
        where: 'Logcomex · Engenheiro de Software Pleno',
        color: '#ffb347',
        story: 'Era o momento em que a empresa precisava de métricas reais. Assumi a missão de integrar os sistemas — HubSpot, ERP Omie e a estrutura de CRM de vendas — conectando tudo à base de dados para gerar indicadores estratégicos no Looker e consolidar o processo comercial.',
        tags: ['Movidesk', 'HubSpot', 'Looker', 'APIs', 'ETL', 'métricas'],
        project: false,
    },
    {
        id: 'datalake',
        year: '2022',
        title: 'Arquitetando a fonte única da verdade',
        where: 'Logcomex · Engenheiro de Software Senior',
        color: '#ff6b9d',
        story: 'Arquitetei os robôs que capturavam dados de todos os sistemas da empresa. Danilo Damasceno (BI) criava os dashboards no Looker enquanto me ajudava a estruturar a base — juntos entregamos o Health Score, o painel de Growth e os indicadores estratégicos que passaram a guiar as decisões da empresa.',
        tags: ['Data Lake', 'ERP Omie', 'Python', 'crons', 'Health Score', 'Growth'],
        project: false,
    },
    {
        id: 'x9',
        year: '2023',
        title: 'Squad Leader e o Robô que protegia a receita',
        where: 'Logcomex · Squad Leader',
        color: '#ff6b9d',
        story: 'Passei a liderar um time de engenheiros de software e arquitetei o Robô X9 — sistema de auditoria automática que monitorava os CRMs, identificava erros de lançamento e alertava os vendedores antes do faturamento. O resultado foi uma base de dados confiável e fechamentos mensais muito mais ágeis.',
        tags: ['Squad Leader', 'auditoria', 'CRM', 'automação', 'alertas', 'faturamento', 'robô'],
        project: true,
    },
    {
        id: 'trem',
        year: '2024',
        title: 'TREM — a plataforma que transformou a operação',
        where: 'Logcomex · Coordenador de Integrações',
        color: '#00ff88',
        story: 'Com a liderança mais madura e atuação multi-área, construí o TREM — middleware que criei do zero enquanto continuava programando. O sistema criava interfaces onde não existiam, automatizava operações e integrava ferramentas sem API, viabilizando faturamento internacional, transferências de contrato em segundos e fechamentos contábeis acelerados.',
        tags: ['middleware', 'Vue.js', 'Laravel', 'automação', 'enterprise', 'integrações'],
        project: true,
    },
    {
        id: 'milestones',
        year: 'fim de 2025',
        title: 'Mais de 150 iniciativas concluídas',
        where: 'Logcomex · Coordenador de Integrações de Sistemas',
        color: '#00d4aa',
        story: 'Ao final de 2025, olhei para trás e contei: mais de 150 iniciativas entregues. Cada uma delas foi uma solução real — um processo automatizado, um sistema integrado, uma operação que deixou de depender de trabalho manual. Não é um número numa planilha. É a soma de seis anos construindo coisas que importam.',
        tags: ['150+ iniciativas', 'integrações', 'automações', 'engenharia', 'entrega'],
        project: false,
    },
]

// ── Modal data ───────────────────────────────────────
const projects = {
    unifal: {
        title: 'Intranet Educacional — UNIFAL-MG',
        year: '2018',
        about: 'Objeto de Aprendizagem desenvolvido para o Programa de Pós-Graduação em História Ibérica da UNIFAL-MG, baseado na dissertação "Cristóvão Colombo Descoberto" do mestrando Mário Caldonazzo de Castro. O sistema rodava offline dentro da universidade e apresentava o conteúdo histórico em formato de notícias interativas, com trechos da dissertação e atividades de fixação. Contou com apoio da CAPES e FAPEMIG.',
        contributions: [
            'Desenvolvi toda a interface e navegação do sistema offline do zero',
            'Criei as atividades interativas de fixação de conteúdo',
            'Estruturei o conteúdo histórico em formato de notícias digitais',
            'Implementei lógica de navegação entre módulos do objeto de aprendizagem',
            'Garanti compatibilidade offline-first sem dependência de servidor externo',
        ],
        tags: ['HTML', 'CSS3', 'JavaScript', 'Bootstrap', 'offline-first', 'educação'],
    },
    x9: {
        title: 'Robô X9 — Auditoria Automática de CRM',
        year: '2023 · Squad Leader',
        about: 'Sistema de auditoria automática para proteger a integridade da base de dados. O Robô X9 monitorava os dados dos CRMs, identificava erros antes do faturamento e alertava os vendedores com tempo para correção. Eliminou erros silenciosos que antes só apareciam no fechamento mensal.',
        contributions: [
            'Concepção e desenvolvimento completo como Squad Leader',
            'Análise das regras de negócio para identificar padrões de erro',
            'Sistema de alertas automáticos para vendedores antes do faturamento',
            'Integração com os CRMs para leitura e validação contínua dos dados',
            'Redução drástica de erros no fechamento mensal',
            'Proteção da receita evitando dados incorretos na base de faturamento',
        ],
        tags: ['auditoria', 'CRM', 'robô', 'alertas', 'Python', 'faturamento', 'Squad Leader'],
    },
    vader: {
        title: 'Sistema de Gestão — Studio Vader',
        year: '2019',
        about: 'Plataforma de gestão desenvolvida para um estúdio de música, cobrindo o ciclo completo de produção: controle de sessões de gravação, agenda de músicos participantes por projeto, acompanhamento de status das produções e gestão de projetos musicais.',
        contributions: [
            'Desenvolvimento fullstack completo do sistema do zero',
            'Modelagem do banco de dados para projetos musicais',
            'Interface de gestão de agenda e escalação de músicos',
            'Sistema de acompanhamento de gravações por projeto',
        ],
        tags: ['gestão', 'agenda', 'estúdio', 'músicos', 'projetos'],
    },
    trem: {
        title: 'TREM — Technology Resource Enterprise Manager',
        year: '2023',
        about: 'Middleware enterprise criado do zero para resolver um problema crítico da Logcomex: integrar sistemas que não possuíam API nativa, criar interfaces customizadas onde os sistemas legados não ofereciam e automatizar tarefas operacionais de alto volume. Tornou-se o núcleo das operações da empresa.',
        contributions: [
            'Arquitetura e desenvolvimento completo da plataforma como Coordenador de Integrações',
            'Habilitou o faturamento internacional da empresa',
            'Transferência de contratos entre sistemas em segundos',
            'Grupo econômico dinâmico — totalmente gerenciável em uma interface',
            'Suspensão de contratos em todos os sistemas via interface única',
            'Automações que eliminaram trabalho operacional repetitivo',
            'Integração de sistemas que só exportavam arquivos sem API',
            'Conciliações financeiras e aceleração de fechamentos mensais',
        ],
        tags: ['middleware', 'Vue.js', 'Laravel', 'automação', 'enterprise', "faturamento int'l"],
    },
}

const modal = reactive({ open: false, data: {} })

function openModal(key) {
    modal.data = projects[key]
    modal.open = true
    document.body.style.overflow = 'hidden'
}

function closeModal() {
    modal.open = false
    document.body.style.overflow = ''
}
</script>

<style scoped>
.sobre-page { max-width: 1000px; }

/* Header */
.page-header { margin-bottom: 40px; }
.page-tag { font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 8px; }
.page-title { font-size: 36px; font-weight: 700; color: var(--text-bright); letter-spacing: -1px; line-height: 1; margin-bottom: 6px; }
.accent { color: var(--accent); }
.page-subtitle { font-size: 13px; color: var(--text-dim); }

/* Profile intro */
.profile-intro { display: flex; gap: 32px; align-items: center; margin-bottom: 56px; }

.profile-photo-wrap { position: relative; flex-shrink: 0; }

.profile-photo {
    width: 110px; height: 110px;
    border-radius: 10px;
    border: 1px solid var(--border);
    overflow: hidden;
    cursor: pointer;
    position: relative; z-index: 1;
    background: var(--bg);
    transition: border-color 0.2s;
}
.profile-photo:hover { border-color: var(--accent); }
.profile-photo img { width: 100%; height: 100%; object-fit: cover; }

.ph-slot { width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px; color: var(--text-dim); }
.ph-icon { font-size: 22px; }
.ph-text { font-size: 9px; letter-spacing: 1.5px; text-transform: uppercase; }

.profile-glow {
    position: absolute; inset: -8px; border-radius: 16px;
    background: radial-gradient(ellipse, rgba(0,255,136,0.08), transparent 70%);
    z-index: 0;
}

.profile-bio { font-size: 13px; line-height: 1.8; color: var(--text); margin-bottom: 20px; }
.hl { color: var(--accent); font-weight: 600; }

.profile-stack { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.stack-tag {
    background: rgba(0,255,136,0.06);
    border: 1px solid rgba(0,255,136,0.15);
    color: var(--accent);
    font-size: 10px;
    padding: 3px 10px;
    border-radius: 3px;
    font-family: 'JetBrains Mono', monospace;
    letter-spacing: 0.5px;
    transition: all 0.15s;
}
.stack-tag:hover { background: rgba(0,255,136,0.12); border-color: var(--accent); }

/* Story heading */
.story-heading { display: flex; align-items: center; gap: 16px; margin-bottom: 48px; }
.sh-line { flex: 1; height: 1px; background: var(--border); }
.sh-label { font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: var(--accent); white-space: nowrap; }

/* Stories */
.stories { display: flex; flex-direction: column; }

.story-item {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: center;
    padding-bottom: 72px;
    position: relative;
}

.story-item.reverse .story-photo-wrap { order: 2; }
.story-item.reverse .story-content { order: 1; }

.story-connector {
    position: absolute;
    bottom: 0; left: 50%;
    transform: translateX(-50%);
    height: 72px;
    display: flex; align-items: center; justify-content: center;
}
.connector-line { width: 1px; height: 100%; background: linear-gradient(to bottom, var(--border), transparent); }

/* Photo card */
.story-photo-wrap { position: relative; }

.story-photo {
    width: 100%;
    aspect-ratio: 4 / 3;
    border-radius: 10px;
    border: 1px solid var(--border);
    overflow: hidden;
    cursor: pointer;
    position: relative;
    background: var(--bg);
    transition: border-color 0.25s;
}

.story-photo:hover { border-color: var(--accent); }
.story-photo:hover .story-photo-overlay { opacity: 1; }
.story-photo img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
.story-photo:hover img { transform: scale(1.04); }

.story-ph {
    width: 100%; height: 100%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 8px; color: var(--text-dim);
    transition: color 0.2s;
}
.story-photo:hover .story-ph { color: var(--accent); }

.sph-year { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; opacity: 0.4; }
.sph-icon { font-size: 28px; }
.sph-text { font-size: 9px; letter-spacing: 2px; text-transform: uppercase; }

.story-photo-overlay {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 12px 16px;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    opacity: 0; transition: opacity 0.2s;
}
.spo-year { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: white; font-weight: 600; }

.story-photo-accent {
    position: absolute; bottom: -6px; right: -6px;
    width: 60%; height: 4px; border-radius: 2px; opacity: 0.4;
}

/* Story content */
.story-content { display: flex; flex-direction: column; }

.sc-chapter { font-size: 9px; letter-spacing: 3px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 8px; }

.sc-title { font-size: 20px; font-weight: 700; color: var(--text-bright); letter-spacing: -0.4px; line-height: 1.25; margin-bottom: 10px; }

.sc-where { display: flex; align-items: center; gap: 8px; font-size: 11px; color: var(--text-dim); margin-bottom: 16px; }
.sc-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

.sc-text { font-size: 12.5px; line-height: 1.8; color: var(--text); margin-bottom: 18px; }

.sc-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }

.tag {
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border);
    color: var(--text-dim);
    font-size: 10px; padding: 3px 8px;
    border-radius: 3px;
    font-family: 'JetBrains Mono', monospace;
}

.sc-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: transparent;
    border: 1px solid rgba(0,255,136,0.2);
    color: var(--accent);
    font-size: 11px; padding: 7px 14px;
    border-radius: 4px; cursor: pointer;
    transition: all 0.15s;
    font-family: 'JetBrains Mono', monospace;
    letter-spacing: 0.5px; width: fit-content;
}
.sc-btn:hover { background: rgba(0,255,136,0.07); border-color: var(--accent); }
.btn-arrow { transition: transform 0.2s; }
.sc-btn:hover .btn-arrow { transform: translateX(4px); }

/* Modal */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.8); backdrop-filter: blur(8px);
    z-index: 500; display: flex;
    align-items: center; justify-content: center;
    padding: 2rem; opacity: 0; pointer-events: none; transition: opacity 0.2s;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }

.modal-box {
    background: var(--sidebar); border: 1px solid var(--border);
    border-radius: 8px; padding: 28px;
    max-width: 620px; width: 100%; max-height: 80vh;
    overflow-y: auto; position: relative;
}
.modal-box::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, var(--accent), #00d4aa);
    border-radius: 8px 8px 0 0;
}
.modal-close {
    position: absolute; top: 14px; right: 14px;
    background: var(--border); border: none; color: var(--text-dim);
    width: 28px; height: 28px; border-radius: 4px;
    cursor: pointer; font-size: 11px; transition: all 0.15s;
}
.modal-close:hover { background: rgba(255,100,100,0.15); color: #ff6b6b; }

.modal-label { font-size: 9px; letter-spacing: 3px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 6px; }
.modal-title { font-size: 20px; font-weight: 700; color: var(--text-bright); letter-spacing: -0.5px; margin-bottom: 4px; }
.modal-year { font-size: 11px; color: var(--accent); }
.modal-divider { width: 100%; height: 1px; background: var(--border); margin: 18px 0; }
.modal-section { margin-bottom: 18px; }
.modal-section.contrib { background: rgba(0,255,136,0.03); border: 1px solid rgba(0,255,136,0.1); border-radius: 6px; padding: 16px; }
.msl { font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-dim); margin-bottom: 10px; }
.contrib .msl { color: var(--accent); }
.modal-text { font-size: 12px; line-height: 1.75; color: var(--text); }
.modal-list { list-style: none; display: flex; flex-direction: column; gap: 7px; }
.modal-list li { font-size: 12px; color: var(--text); padding-left: 16px; position: relative; line-height: 1.5; }
.modal-list li::before { content: '▸'; position: absolute; left: 0; color: var(--accent); font-size: 10px; }
.modal-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 18px; padding-top: 16px; border-top: 1px solid var(--border); }

/* Responsive */
@media (max-width: 700px) {
    .story-item, .story-item.reverse { grid-template-columns: 1fr; gap: 20px; }
    .story-item .story-photo-wrap, .story-item.reverse .story-photo-wrap { order: 0; }
    .story-item .story-content, .story-item.reverse .story-content { order: 1; }
    .profile-intro { flex-direction: column; text-align: center; }
    .profile-stats { justify-content: center; }
}
</style>
