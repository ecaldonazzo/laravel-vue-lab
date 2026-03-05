<template>
    <div class="about">
        <div class="page-header">
            <div class="page-tag">// sobre.mim</div>
            <h1 class="page-title">Esdras<span class="accent">_</span>Caldonazzo</h1>
            <p class="page-subtitle">Fullstack Developer & Systems Architect</p>
        </div>
        <div class="profile-intro">
            <div class="profile-photo-wrap">
                <div class="profile-photo">
                    <img :src="photos.profile" alt="Esdras" @error="e => e.target.style.display='none'" />
                </div>
                <div class="profile-glow"></div>
            </div>
            <div class="profile-text">
                <p class="profile-bio">
                    Sou Engenheiro de Software Full Stack & Arquiteto de Sistemas com mais de <span class="hl">9 anos</span> transformando
                    ideias em sistemas que realmente funcionam. Comecei com um projeto voluntário para levar história interativa
                    a crianças de escolas públicas, e fui construindo projetos — de estúdios de música a empresas SaaS — uma trajetória em
                    integrações, arquitetura de software e automação de operações complexas.
                </p>
                <div class="profile-stack">
                    <span class="stack-tag" v-for="tech in stack" :key="tech">{{ tech }}</span>
                </div>
            </div>
        </div>
        <div class="story-heading">
            <div class="sh-line"></div>
            <span class="sh-label">// minha história</span>
            <div class="sh-line"></div>
        </div>
        <div class="stories">
            <div
                v-for="(item, i) in timeline"
                :key="item.id"
                class="story-item"
                :class="{ reverse: i % 2 !== 0 }"
            >
                <div class="story-photo-wrap">
                    <div class="story-photo">
                        <img :src="photos[item.id]" :alt="item.title" @error="e => e.target.parentElement.classList.add('no-photo')" />
                        <div class="story-photo-overlay">
                            <span class="spo-year">{{ item.year }}</span>
                        </div>
                    </div>
                    <div class="story-photo-accent" :style="{ background: item.color }"></div>
                </div>
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
                <div class="story-connector" v-if="i < timeline.length - 1">
                    <div class="connector-line"></div>
                </div>
            </div>
        </div>
        <ProjectModal v-model="modalOpen" :data="modalData" />
        <div class="terminal-line">cd /lab/about <span class="cursor"></span></div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import ProjectModal      from '../components/about/ProjectModal.vue'
import { photos, stack } from '../data/about.js'
import { timeline }      from '../data/timeline.js'
import { projects }      from '../data/projects.js'
const modalOpen = ref(false)
const modalData = ref(null)

function openModal(key) {
    modalData.value = projects[key]
    modalOpen.value = true
}
</script>

<style src="../../css/about.css" />

