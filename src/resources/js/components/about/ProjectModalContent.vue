<template>
    <div>
        <div class="modal-label">// projeto</div>
        <h2 class="modal-title">{{ data.title }}</h2>
        <div class="modal-year">{{ data.year }}</div>
        <div class="modal-divider"></div>

        <div class="modal-section">
            <div class="msl">// descrição</div>
            <p class="modal-text">{{ data.objective }}</p>
        </div>

        <div class="modal-section modal-gains">
            <div class="msl">// ganhos</div>
            <p class="modal-text">{{ data.gains }}</p>
        </div>

        <div class="modal-section contrib">
            <div class="msl">// minhas contribuições</div>
            <ul class="modal-list">
                <li v-for="c in data.contributions" :key="c">{{ c }}</li>
            </ul>
        </div>

        <div class="modal-tags">
            <span class="tag" v-for="t in data.tags" :key="t">{{ t }}</span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    data: { type: Object, required: true },
})
</script>
