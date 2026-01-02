<template>
  <Card class="cursor-pointer hover:shadow-md transition-shadow">
    <div @click="router.visit(`/recipes/${recipe.id}`)">
      <h3 class="text-lg font-semibold text-text-primary mb-2">
        {{ recipe.name }}
      </h3>

      <p v-if="recipe.description" class="text-sm text-text-secondary mb-3 line-clamp-2">
        {{ recipe.description }}
      </p>

      <div class="flex flex-wrap gap-2 mb-3">
        <span v-if="recipe.category" class="text-xs px-2 py-1 bg-primary/10 text-primary rounded">
          {{ recipe.category }}
        </span>
        <span v-if="recipe.difficulty" class="text-xs px-2 py-1 bg-secondary text-text-primary rounded">
          {{ recipe.difficulty }}
        </span>
      </div>

      <div class="flex gap-4 text-xs text-text-secondary">
        <span v-if="recipe.prep_time">⏱️ Prep: {{ recipe.prep_time }}m</span>
        <span v-if="recipe.cook_time">🔥 Cook: {{ recipe.cook_time }}m</span>
        <span v-if="recipe.servings">🍽️ {{ recipe.servings }} servings</span>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-2 mt-4 pt-4 border-t border-border">
      <button
        @click.stop="emit('edit', recipe)"
        class="flex-1 py-2 text-sm font-medium text-primary hover:bg-primary/10 rounded transition"
      >
        Edit
      </button>
      <button
        @click.stop="emit('duplicate', recipe)"
        class="flex-1 py-2 text-sm font-medium text-secondary hover:bg-secondary/10 rounded transition"
      >
        Duplicate
      </button>
      <button
        @click.stop="emit('delete', recipe)"
        class="flex-1 py-2 text-sm font-medium text-error hover:bg-error/10 rounded transition"
      >
        Delete
      </button>
    </div>
  </Card>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { Card } from '@/Components/common'

defineProps({
  recipe: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['view', 'edit', 'delete', 'duplicate'])
</script>
