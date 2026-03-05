<template>
    <Teleport to="body">
        <div class="modal-overlay" :class="{ open: modelValue }" @click.self="$emit('update:modelValue', false)">
            <div class="modal-box" v-if="modelValue && data">
                <button class="modal-close" @click="$emit('update:modelValue', false)">✕</button>

                <div v-if="data.sideImage" class="modal-layout">
                    <div class="modal-image-side">
                        <img :src="data.image" :alt="data.title" @error="e => e.target.parentElement.style.display='none'" />
                    </div>
                    <div class="modal-text-side">
                        <ProjectModalContent :data="data" />
                    </div>
                </div>

                <div v-else>
                    <div class="modal-project-image" v-if="data.image">
                        <img :src="data.image" :alt="data.title" @error="e => e.target.parentElement.style.display='none'" />
                    </div>
                    <ProjectModalContent :data="data" />
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { watch } from 'vue'
import ProjectModalContent from './ProjectModalContent.vue'

const props = defineProps({
    modelValue: { type: Boolean, required: true },
    data:       { type: Object,  default: null },
})

defineEmits(['update:modelValue'])

watch(() => props.modelValue, (open) => {
    document.body.style.overflow = open ? 'hidden' : ''
})
</script>
