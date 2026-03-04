<template>
    <div class="pokemon">
        <div class="hero-tag">// experimento · batalha pokémon</div>
        <h1>Batalha <span>Pokémon</span></h1>
        <p class="subtitle">Dois Pokémons aleatórios da Gen I se enfrentam. Quem será o vencedor?</p>

        <div v-if="phase === 'idle'" class="battle-setup">
            <button class="btn-action" @click="loadPokemons" :disabled="loading">
                <span v-if="loading">// carregando...</span>
                <span v-else>⚔ Gerar Batalha</span>
            </button>
        </div>

        <div v-if="phase === 'vs'" class="vs-screen">
            <div class="pokemon-card">
                <div class="poke-tag">// jogador</div>
                <img :src="player.imagePokemon" :alt="player.name" class="poke-sprite" />
                <div class="poke-name">{{ player.name }}</div>
                <div class="poke-types">
                    <span v-for="t in player.types" :key="t" :class="`type-tag type-${t}`">{{ t }}</span>
                </div>
                <div class="poke-stats">
                    <div class="stat"><span class="stat-label">HP</span><div class="stat-bar"><div class="stat-fill hp" :style="{ width: barWidth(player.hp, 255) }"></div></div><span class="stat-val">{{ player.hp }}</span></div>
                    <div class="stat"><span class="stat-label">ATK</span><div class="stat-bar"><div class="stat-fill atk" :style="{ width: barWidth(player.attack, 190) }"></div></div><span class="stat-val">{{ player.attack }}</span></div>
                    <div class="stat"><span class="stat-label">DEF</span><div class="stat-bar"><div class="stat-fill def" :style="{ width: barWidth(player.defense, 230) }"></div></div><span class="stat-val">{{ player.defense }}</span></div>
                    <div class="stat"><span class="stat-label">SPD</span><div class="stat-bar"><div class="stat-fill spd" :style="{ width: barWidth(player.speed, 180) }"></div></div><span class="stat-val">{{ player.speed }}</span></div>
                </div>
            </div>

            <div class="vs-center">
                <div class="vs-text">VS</div>
                <button class="btn-action battle-btn" @click="startBattle">⚡ Batalhar</button>
                <button class="btn-outline" @click="loadPokemons" :disabled="loading">↺ Novos Pokémons</button>
            </div>

            <div class="pokemon-card">
                <div class="poke-tag">// oponente</div>
                <img :src="enemy.imagePokemon" :alt="enemy.name" class="poke-sprite" />
                <div class="poke-name">{{ enemy.name }}</div>
                <div class="poke-types">
                    <span v-for="t in enemy.types" :key="t" :class="`type-tag type-${t}`">{{ t }}</span>
                </div>
                <div class="poke-stats">
                    <div class="stat"><span class="stat-label">HP</span><div class="stat-bar"><div class="stat-fill hp" :style="{ width: barWidth(enemy.hp, 255) }"></div></div><span class="stat-val">{{ enemy.hp }}</span></div>
                    <div class="stat"><span class="stat-label">ATK</span><div class="stat-bar"><div class="stat-fill atk" :style="{ width: barWidth(enemy.attack, 190) }"></div></div><span class="stat-val">{{ enemy.attack }}</span></div>
                    <div class="stat"><span class="stat-label">DEF</span><div class="stat-bar"><div class="stat-fill def" :style="{ width: barWidth(enemy.defense, 230) }"></div></div><span class="stat-val">{{ enemy.defense }}</span></div>
                    <div class="stat"><span class="stat-label">SPD</span><div class="stat-bar"><div class="stat-fill spd" :style="{ width: barWidth(enemy.speed, 180) }"></div></div><span class="stat-val">{{ enemy.speed }}</span></div>
                </div>
            </div>
        </div>

        <div v-if="phase === 'battle'" class="battle-screen">
            <div class="battle-field">
                <div class="fighter" :class="{ shake: playerShaking, faint: playerFainted }">
                    <img :src="player.imagePokemon" :alt="player.name" class="fighter-sprite" />
                    <div class="fighter-name">{{ player.name }}</div>
                    <div class="fighter-hp-wrap">
                        <div class="fighter-hp-bar"><div class="fighter-hp-fill" :style="{ width: hpPercent(playerHp, player.hp) + '%' }" :class="hpClass(playerHp, player.hp)"></div></div>
                        <span class="fighter-hp-num">{{ playerHp }}/{{ player.hp }}</span>
                    </div>
                </div>
                <div class="battle-vs">⚡</div>
                <div class="fighter enemy" :class="{ shake: enemyShaking, faint: enemyFainted }">
                    <img :src="enemy.imagePokemon" :alt="enemy.name" class="fighter-sprite" />
                    <div class="fighter-name">{{ enemy.name }}</div>
                    <div class="fighter-hp-wrap">
                        <div class="fighter-hp-bar"><div class="fighter-hp-fill" :style="{ width: hpPercent(enemyHp, enemy.hp) + '%' }" :class="hpClass(enemyHp, enemy.hp)"></div></div>
                        <span class="fighter-hp-num">{{ enemyHp }}/{{ enemy.hp }}</span>
                    </div>
                </div>
            </div>
            <div class="battle-log">
                <div class="log-line" v-for="(log, i) in battleLog" :key="i" :class="log.type">
                    <span class="log-prefix">$</span> {{ log.text }}
                </div>
            </div>
        </div>

        <div v-if="phase === 'end'" class="result-screen">
            <div class="result-tag">// resultado</div>
            <div class="result-winner">
                <img :src="winner.imagePokemon" :alt="winner.name" class="result-sprite" />
                <div class="result-title">{{ winner.name }} <span>venceu!</span></div>
                <p class="result-desc">{{ winner.name }} dominou a batalha!</p>
            </div>
            <div class="result-actions">
                <button class="btn-action" @click="loadPokemons">⚔ Nova Batalha</button>
            </div>
        </div>

        <div class="terminal-line">cd /lab/experimentos/pokemon <span class="cursor"></span></div>

        <!-- Implementação -->
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
                        Experimento que consome a <span class="hl">PokéAPI</span> para buscar Pokémons aleatórios da
                        Geração I e simula uma batalha automática baseada nos atributos reais de cada Pokémon —
                        HP, Ataque, Defesa e Velocidade. O resultado é determinístico com lógica de dano e chance
                        de acerto crítico, simulando o sistema de batalha dos jogos originais.
                    </p>
                </div>

                <div class="exp-card">
                    <div class="exp-icon">⬢</div>
                    <div class="exp-title">Como foi construído</div>
                    <p class="exp-text">
                        O Laravel consome a <span class="hl">PokéAPI REST</span> via <span class="hl">HTTP Client</span>
                        e expõe os endpoints <span class="hl">GET /api/pokemon/random</span> e
                        <span class="hl">POST /api/battle/attack</span>. O frontend em Vue.js gerencia as
                        fases da batalha via <span class="hl">state machine</span> (idle → vs → battle → end),
                        com animações de dano, barra de HP dinâmica e log de batalha em tempo real.
                    </p>
                </div>

                <div class="exp-card">
                    <div class="exp-icon">⬡</div>
                    <div class="exp-title">Stack</div>
                    <div class="exp-tags">
                        <span class="exp-tag">PokéAPI</span>
                        <span class="exp-tag">Laravel HTTP Client</span>
                        <span class="exp-tag">Vue.js 3</span>
                        <span class="exp-tag">REST API</span>
                        <span class="exp-tag">State Machine</span>
                        <span class="exp-tag">Axios</span>
                        <span class="exp-tag">Async/Await</span>
                        <span class="exp-tag">CSS Animations</span>
                    </div>
                </div>
            </div>

            <div class="exp-flow">
                <div class="flow-step">
                    <span class="fs-label">Vue.js</span>
                    <span class="fs-sub">Axios</span>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step">
                    <span class="fs-label">GET /api</span>
                    <span class="fs-sub">Laravel Controller</span>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step">
                    <span class="fs-label">HTTP Client</span>
                    <span class="fs-sub">Laravel</span>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step">
                    <span class="fs-label">PokéAPI</span>
                    <span class="fs-sub">REST externa</span>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step highlight">
                    <span class="fs-label">batalha ⚡</span>
                    <span class="fs-sub">state machine</span>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import '../../css/pokemon.css'

const phase = ref('idle')
const loading = ref(false)
const player = ref(null)
const enemy = ref(null)
const playerHp = ref(0)
const enemyHp = ref(0)
const playerShaking = ref(false)
const enemyShaking = ref(false)
const playerFainted = ref(false)
const enemyFainted = ref(false)
const battleLog = ref([])
const winner = ref(null)

function barWidth(val, max) { return Math.round((val / max) * 100) + '%' }
function hpPercent(current, max) { return Math.max(0, Math.round((current / max) * 100)) }
function hpClass(current, max) {
    const pct = (current / max) * 100
    if (pct > 50) return 'green'
    if (pct > 20) return 'yellow'
    return 'red'
}
function addLog(text, type = 'normal') {
    battleLog.value.unshift({ text, type })
    if (battleLog.value.length > 8) battleLog.value.pop()
}
function sleep(ms) { return new Promise(r => setTimeout(r, ms)) }

async function loadPokemons() {
    loading.value = true
    phase.value = 'idle'
    try {
        const r1 = await axios.get('/api/pokemon/random')
        let r2
        do { r2 = await axios.get('/api/pokemon/random') } while (r2.data.name === r1.data.name)
        player.value = r1.data
        enemy.value = r2.data
        phase.value = 'vs'
    } finally {
        loading.value = false
    }
}

async function startBattle() {
    playerHp.value = player.value.hp
    enemyHp.value = enemy.value.hp
    playerFainted.value = false
    enemyFainted.value = false
    battleLog.value = []
    phase.value = 'battle'
    addLog(`${player.value.name} vs ${enemy.value.name} — que vença o melhor!`, 'event')
    await sleep(600)
    const playerFirst = player.value.speed >= enemy.value.speed
    addLog(`${playerFirst ? player.value.name : enemy.value.name} é mais rápido e ataca primeiro!`, 'event')
    await sleep(500)
    while (playerHp.value > 0 && enemyHp.value > 0) {
        if (playerFirst) {
            await attackTurn('player')
            if (enemyHp.value <= 0) break
            await sleep(400)
            await attackTurn('enemy')
        } else {
            await attackTurn('enemy')
            if (playerHp.value <= 0) break
            await sleep(400)
            await attackTurn('player')
        }
        await sleep(300)
    }
    await sleep(500)
    winner.value = playerHp.value > 0 ? player.value : enemy.value
    phase.value = 'end'
}

async function attackTurn(attacker) {
    const atk = attacker === 'player' ? player.value : enemy.value
    const defHp = attacker === 'player' ? enemyHp : playerHp
    const defPokemon = attacker === 'player' ? enemy.value : player.value
    try {
        const { data } = await axios.post('/api/battle/attack', {
            attacker: atk.name,
            defender: defPokemon.name,
        })
        defHp.value = Math.max(0, defHp.value - data.damage)
        if (attacker === 'player') { enemyShaking.value = true; setTimeout(() => enemyShaking.value = false, 500) }
        else { playerShaking.value = true; setTimeout(() => playerShaking.value = false, 500) }
        addLog(`${atk.name} atacou! ${data.isCritical ? '⭐ CRÍTICO! ' : ''}-${data.damage} HP`, attacker)
        if (defHp.value <= 0) {
            if (attacker === 'player') enemyFainted.value = true
            else playerFainted.value = true
            addLog(`${defPokemon.name} desmaiou!`, 'event')
        }
    } catch (e) {
        addLog('Erro no ataque!', 'event')
    }
    await sleep(600)
}
</script>

<style scoped>
/* Explanation — igual ao Chat */
.explanation { margin-top: 48px; }

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

.exp-flow { display: flex; align-items: center; justify-content: space-between; gap: 8px; background: var(--sidebar); border: 1px solid var(--border); border-radius: 8px; padding: 20px 32px; overflow-x: auto; }
.flow-step { display: flex; flex-direction: column; align-items: center; gap: 4px; flex-shrink: 0; }
.fs-label { font-size: 12px; font-weight: 700; color: var(--text-bright); font-family: 'JetBrains Mono', monospace; }
.fs-sub { font-size: 9px; color: var(--text-dim); letter-spacing: 0.3px; text-align: center; }
.flow-step.highlight .fs-label { color: var(--accent); }
.flow-step.highlight .fs-sub { color: var(--accent); opacity: 0.7; }
.flow-arrow { color: var(--text-dim); font-size: 16px; flex-shrink: 0; padding-bottom: 14px; }
</style>
