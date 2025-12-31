<template>
  <div class="space-y-3">
    <MealCard
      v-for="meal in meals"
      :key="meal.id"
      :meal="meal"
      @edit="emit('edit', $event)"
      @delete="emit('delete', $event)"
      @duplicate="emit('duplicate', $event)"
    />
  </div>
</template>

<script setup>
import MealCard from './MealCard.vue'

defineProps({
  meals: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits(['edit', 'delete', 'duplicate'])
</script>
