<template>
  <button
    @click="emit('click')"
    class="fixed bottom-5 right-5 bg-primary hover:bg-primary-hover text-white w-14 h-14 rounded-full shadow-lg text-2xl active:scale-95 transition-all duration-200 z-50 flex items-center justify-center"
    aria-label="Add new meal"
  >
    <slot>+</slot>
  </button>
</template>

<script setup>
const emit = defineEmits(['click'])
</script>
