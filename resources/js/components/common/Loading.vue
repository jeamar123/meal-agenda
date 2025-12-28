<template>
  <div class="z-50 flex h-full w-full items-center justify-center">
    <div class="rounded-md px-6 py-3 text-center text-xs">
      <slot name="icon"> </slot>
      <p :class="textClass">Loading...</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  textClass: {
    type: [String, Object, Array],
    default: '',
  },
})
</script>
