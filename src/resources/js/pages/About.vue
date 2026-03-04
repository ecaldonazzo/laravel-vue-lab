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

                    <!-- Layout lado a lado: só UNIFAL -->
                    <div v-if="modal.data.sideImage" class="modal-layout">
                        <div class="modal-image-side">
                            <img :src="modal.data.image" :alt="modal.data.title" @error="e => e.target.parentElement.style.display='none'" />
                        </div>
                        <div class="modal-text-side">
                            <div class="modal-label">// projeto</div>
                            <h2 class="modal-title">{{ modal.data.title }}</h2>
                            <div class="modal-year">{{ modal.data.year }}</div>
                            <div class="modal-divider"></div>
                            <div class="modal-section">
                                <div class="msl">// descrição</div>
                                <p class="modal-text">{{ modal.data.objective }}</p>
                            </div>
                            <div class="modal-section modal-gains">
                                <div class="msl">// ganhos</div>
                                <p class="modal-text">{{ modal.data.gains }}</p>
                            </div>
                            <div class="modal-section contrib">
                                <div class="msl">// minhas contribuições</div>
                                <ul class="modal-list">
                                    <li v-for="c in modal.data.contributions" :key="c">{{ c }}</li>
                                </ul>
                            </div>
                            <div class="modal-tags">
                                <span class="tag" v-for="t in modal.data.tags" :key="t">{{ t }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Layout padrão: foto em cima -->
                    <div v-else>
                        <div class="modal-project-image" v-if="modal.data.image">
                            <img :src="modal.data.image" :alt="modal.data.title" @error="e => e.target.parentElement.style.display='none'" />
                        </div>
                        <div class="modal-label">// projeto</div>
                        <h2 class="modal-title">{{ modal.data.title }}</h2>
                        <div class="modal-year">{{ modal.data.year }}</div>
                        <div class="modal-divider"></div>
                        <div class="modal-section">
                            <div class="msl">// descrição</div>
                            <p class="modal-text">{{ modal.data.objective }}</p>
                        </div>
                        <div class="modal-section modal-gains">
                            <div class="msl">// ganhos</div>
                            <p class="modal-text">{{ modal.data.gains }}</p>
                        </div>
                        <div class="modal-section contrib">
                            <div class="msl">// minhas contribuições</div>
                            <ul class="modal-list">
                                <li v-for="c in modal.data.contributions" :key="c">{{ c }}</li>
                            </ul>
                        </div>
                        <div class="modal-tags">
                            <span class="tag" v-for="t in modal.data.tags" :key="t">{{ t }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>

        <div class="terminal-line">cd /lab/about <span class="cursor"></span></div>

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
    integracoes:      '/images/about/squad.JPEG',
    datalake:         '/images/about/datalake.JPEG',
    x9:               '/images/about/logesdras.jpg',
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
        story: 'Meu primeiro projeto: uma intranet educacional offline para o Programa de Pós-Graduação em História Ibérica da UNIFAL-MG. Apresentava pesquisa sobre Cristóvão Colombo em notícias interativas com atividades de fixação.',
        tags: ['HTML', 'CSS3', 'JavaScript', 'Bootstrap', 'offline-first'],
        project: true,
    },
    {
        id: 'vader',
        year: '2019',
        title: 'Gerenciando musica com tecnologia',
        where: 'Studio Vader · Projeto Freelance',
        color: '#a89cff',
        story: 'Sistema de gestão para estúdio de música: o produtor organizava projetos, definia faixas e comunicava aos músicos o que e quando gravar — tudo centralizado em uma plataforma.',
        tags: ['gestão de projetos', 'agenda', 'músicos', 'gravações'],
        project: true,
    },
    {
        id: 'logcomex-entry',
        year: 'out. 2019',
        title: 'Contratado. Um novo desafio.',
        where: 'Logcomex · Engenheiro de Software Junior',
        color: '#00ff88',
        story: 'Refatorei do zero o Configurador de Planos — frontend com Vue.js e backend com arquitetura mais robusta e segura, preparando o sistema para o crescimento acelerado da empresa.',
        tags: ['Vue.js', 'refatoração', 'frontend', 'escala'],
        project: false,
    },
    {
        id: 'integracoes',
        year: '2021',
        title: 'Conectando os pontos que ninguém conectava',
        where: 'Logcomex · Engenheiro de Software Pleno',
        color: '#ffb347',
        story: 'Integrei os sistemas da empresa — HubSpot, ERP Omie e CRM de vendas — gerando indicadores estratégicos no Looker e consolidando o processo comercial.',
        tags: ['Movidesk', 'HubSpot', 'Looker', 'APIs', 'ETL', 'métricas'],
        project: false,
    },
    {
        id: 'datalake',
        year: '2022',
        title: 'Arquitetando a fonte única da verdade',
        where: 'Logcomex · Engenheiro de Software Senior',
        color: '#ff6b9d',
        story: 'Construí os robôs que capturavam dados de todos os sistemas da empresa — HubSpot, ERP Omie e mais — centralizando tudo no Data Lake como fonte única da verdade para os indicadores estratégicos.',
        tags: ['Data Lake', 'ERP Omie', 'Python', 'crons', 'Health Score', 'Growth'],
        project: false,
    },
    {
        id: 'x9',
        year: '2023',
        title: 'Squad Leader e o Robô que protegia o financeiro',
        where: 'Logcomex · Squad Leader',
        color: '#ff6b9d',
        story: 'Assumi a liderança de um time de engenheiros e arquitetei o Robô X9 — auditoria automática que monitorava os CRMs, identificava erros e alertava os vendedores antes do faturamento.',
        tags: ['Squad Leader', 'auditoria', 'CRM', 'automação', 'alertas', 'faturamento', 'robô'],
        project: true,
    },
    {
        id: 'trem',
        year: '2024',
        title: 'TREM — a plataforma que transformou a operação',
        where: 'Logcomex · Coordenador de Integrações',
        color: '#00ff88',
        story: 'Liderei, idealizei e desenvolvi junto ao time de engenheiros a Plataforma TREM — middleware que potencializou o ERP da empresa e possibilitou fazer aquilo que os outros sistemas não conseguiam, unindo liderança e código do início ao fim.',
        tags: ['middleware', 'Vue.js', 'Laravel', 'automação', 'enterprise', 'integrações'],
        project: true,
    },
    {
        id: 'milestones',
        year: 'fim de 2025',
        title: 'Mais de 150 iniciativas concluídas',
        where: 'Logcomex · Coordenador de Integrações de Sistemas',
        color: '#00d4aa',
        story: 'Mais de 150 iniciativas entregues — processos automatizados, sistemas integrados, operações que deixaram de depender de trabalho manual. Não é um número numa planilha. É a soma de seis anos construindo coisas que importam.',
        tags: ['150+ iniciativas', 'integrações', 'automações', 'engenharia', 'entrega'],
        project: false,
    },
]

// ── Modal data ───────────────────────────────────────
const projects = {
    unifal: {
        image: '/images/projects/castela3.jpg',
        sideImage: true,
        title: 'Intranet Educacional — UNIFAL-MG',
        year: '2018',
        objective: 'Objeto de Aprendizagem idealizado pelo mestrando Mário Caldonazzo de Castro para o Programa de Pós-Graduação em História Ibérica da UNIFAL-MG, baseado na dissertação "Cristóvão Colombo Descoberto". O sistema apresentava informações sobre Colombo e a Descoberta da América em notícias sucintas, com trechos da dissertação e atividades interativas de fixação — rodando completamente offline. Apoiado pela CAPES e FAPEMIG.',
        challenge: 'Criar algo simples de instalar em qualquer computador e compartilhar em rede, já que seria reproduzido para crianças em escolas públicas — e meu conhecimento ainda era limitado, estava iniciando os estudos.',
        gains: 'O projeto foi apresentado no mestrado com grande repercussão e a UNIFAL o aplicou em escolas públicas da região — levando o ensino de história de forma interativa e acessível às crianças.',
        architecture: 'Arquitetura monolítica 100% frontend — sem servidor, sem backend. Apenas HTML5, CSS3, JavaScript puro e Bootstrap, rodando offline diretamente no navegador.',
        contributions: [
            'Desenvolvi toda a interface e navegação do sistema offline do zero',
            'Estruturei o conteúdo histórico em formato de notícias digitais interativas',
            'Criei as atividades de fixação de conteúdo com JavaScript puro',
            'Garanti compatibilidade offline-first para redes escolares públicas',
            'Implementei instalação simples sem dependência de servidor externo',
        ],
        tags: ['HTML5', 'CSS3', 'JavaScript', 'Bootstrap', 'offline-first'],
    },
    vader: {
        image: '/images/projects/vader.png',
        title: 'Sistema de Gestão — Studio Vader',
        year: '2019',
        objective: 'Gerenciador de projetos musicais onde músicos chegavam ao estúdio já sabendo o roteiro completo de gravação — faixas, demos para ouvir e preparação de instrumentos — enquanto o produtor trabalhava na cabine com outros músicos.',
        challenge: 'Criar uma solução responsiva e testável num ambiente complexo, onde os usuários reais (músicos e produtores) tinham rotinas dinâmicas e difícil disponibilidade para testes.',
        gains: 'Maior agilidade para direcionar músicos na gravação, menor tempo para organizar roteiros, redução de ruídos de comunicação dentro do estúdio, repositório centralizado de álbuns e contatos de músicos freelancers.',
        architecture: 'Arquitetura monolítica com backend em PHP orientado a objetos (responsabilidades separadas por classe), frontend em HTML5, CSS3 e Bootstrap, banco de dados MySQL.',
        contributions: [
            'Desenvolvimento fullstack completo do zero',
            'Modelagem do banco de dados para projetos musicais',
            'Interface de roteiro e agenda para músicos e produtores',
            'Repositório de faixas demo e álbuns de gravações',
            'Cadastro e gestão de contatos de músicos freelancers',
        ],
        tags: ['PHP', 'MySQL', 'HTML5', 'CSS3', 'Bootstrap', 'OOP'],
    },
    x9: {
        image: '/images/projects/robox.png',
        title: 'Robô X9 — Auditoria Automática de CRM',
        year: '2023 · Squad Leader',
        objective: 'Robô de monitoramento contínuo que auditava os dados do HubSpot antes de entrarem no ERP e na base de dados, alertando os vendedores diretamente no Slack e por e-mail para corrigir erros antes do faturamento.',
        challenge: 'No fechamento mensal, contratos chegavam ao ERP com informações incompletas ou incorretas vindas do HubSpot, sobrecarregando o financeiro com retrabalho e comprometendo as métricas da empresa.',
        gains: 'Redução do fechamento mensal de mais de 2 dias para 2 horas. Assertividade nas métricas, governança de dados e redução significativa da sobrecarga operacional do time financeiro.',
        architecture: 'Cron periódico em Laravel que consultava o HubSpot via API, validava regras de negócio, barrava registros inconsistentes e disparava alertas via Slack API e e-mail. Arquitetura em camadas: Service, Repository e Integration.',
        contributions: [
            'Idealização e desenvolvimento completo do robô como Squad Leader',
            'Mapeamento das regras de negócio para identificar padrões de erro',
            'Integração com HubSpot API para leitura e validação contínua',
            'Sistema de alertas automáticos via Slack e e-mail por vendedor',
            'Bloqueio de registros incorretos antes de entrar no ERP e na base',
        ],
        tags: ['Laravel', 'PHP', 'HubSpot API', 'Slack API', 'Cron', 'Squad Leader'],
    },
    trem: {
        image: '/images/projects/trem1.jpg',
        title: 'TREM — Technology Resource Enterprise Manager',
        year: '2024',
        objective: 'Middleware enterprise que centralizava o controle de todos os sistemas internos via API, permitindo construir qualquer funcionalidade que os sistemas isolados não conseguiam — incluindo grupo econômico dinâmico, faturamento internacional e automações operacionais.',
        challenge: 'A empresa tinha produtos distintos e clientes com estruturas complexas (grupos, parentes com CNPJs diferentes rateando contratos). Os sistemas internos não supriam essas necessidades e não havia uma camada de integração unificada.',
        gains: 'Redução significativa do trabalho operacional, faturamento internacional construído do zero, métricas 100% assertivas e ajustadas automaticamente, suspensão e transferência de contratos em local único, redução de um dos maiores custos operacionais da empresa.',
        architecture: 'Middleware com backend Laravel separado do frontend Vue.js. Autenticação Google com 2 fatores. Camadas: Controller, Service, DTO, Repository e Integration. Frontend com Vuex para gerenciamento de estado.',
        contributions: [
            'Idealização, liderança e desenvolvimento da plataforma do zero',
            'Arquitetura do middleware com separação total de responsabilidades',
            'Construção do módulo de grupo econômico dinâmico',
            'Integração de sistemas via API e arquivos exportados sem API',
            'Implementação do faturamento internacional',
            'Automações que eliminaram trabalho operacional repetitivo',
        ],
        tags: ['Laravel', 'Vue.js', 'Vuex', 'Google Auth', '2FA', 'REST API', 'DTO', 'middleware'],
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
    max-width: 960px; width: 100%; max-height: 90vh;
    overflow-y: auto; position: relative;
}
.modal-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 28px;
    align-items: start;
}
.modal-image-side {
    position: sticky;
    top: 0;
    border-radius: 6px;
    overflow: hidden;
    border: 1px solid var(--border);
    background: var(--bg);
}
.modal-image-side img {
    width: 100%;
    height: auto;
    display: block;
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


.modal-project-image {
    width: 100%;
    aspect-ratio: 16 / 9;
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 20px;
    border: 1px solid var(--border);
    background: var(--bg);
}
.modal-project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.modal-challenge { background: rgba(255,107,107,0.03); border: 1px solid rgba(255,107,107,0.1); border-radius: 6px; padding: 14px; }
.modal-challenge .msl { color: #ff6b6b; }
.modal-gains { background: rgba(0,212,170,0.03); border: 1px solid rgba(0,212,170,0.1); border-radius: 6px; padding: 14px; }
.modal-gains .msl { color: #00d4aa; }
.modal-arch { background: rgba(168,156,255,0.03); border: 1px solid rgba(168,156,255,0.1); border-radius: 6px; padding: 14px; }
.modal-arch .msl { color: #a89cff; }
.modal-arch-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.arch-tag {
    background: rgba(168,156,255,0.08);
    border: 1px solid rgba(168,156,255,0.2);
    color: #a89cff;
    font-size: 10px;
    padding: 3px 10px;
    border-radius: 3px;
    font-family: 'JetBrains Mono', monospace;
    letter-spacing: 0.5px;
}
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
    .modal-layout { grid-template-columns: 1fr; }
    .modal-image-side { position: static; }
}

.terminal-line {
    margin-top: 48px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 12px;
    color: var(--text-dim);
    letter-spacing: 0.5px;
}

.cursor {
    display: inline-block;
    width: 8px;
    height: 13px;
    background: var(--accent);
    vertical-align: middle;
    margin-left: 2px;
    animation: blink 1s step-end infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0; }
}
</style>
