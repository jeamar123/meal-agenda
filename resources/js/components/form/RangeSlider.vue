<template>
  <slider
    v-model="sliderValue"
    color="#0e94e9"
    track-color="#ddd"
    tooltip-color="#f2f2f2"
    :min="min"
    :max="max"
    :tooltip="true"
    @dragging="
      (value) => {
        emit('update:model-value', value)
        emit('change', value)
      }
    "
  />
</template>

<script setup>
import slider from 'vue3-slider'
import { ref } from 'vue'

const props = defineProps({
  modelValue: {
    type: Number,
    default: 0,
  },
  min: {
    type: Number,
    default: 0,
  },
  max: {
    type: Number,
    default: 100,
  },
})

const emit = defineEmits(['update:model-value', 'change'])

const sliderValue = ref(props.modelValue)
</script>
