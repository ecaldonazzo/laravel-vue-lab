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
        const [r1, r2] = await Promise.all([
            axios.get('/api/pokemon/random'),
            axios.get('/api/pokemon/random'),
        ])
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
