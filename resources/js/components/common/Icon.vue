<template>
  <component :is="Heroicons[name]" />
</template>

<script setup>
import Heroicons from './Heroicons'

defineProps({
  name: {
    type: String,
    required: true,
  },
})
</script>
