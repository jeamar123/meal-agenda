<template>
  <div class="container px-4 py-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <button
        @click="router.visit(route('recipes.index'))"
        class="flex items-center text-text-secondary hover:text-text-primary transition"
      >
        <Icon name="ChevronLeftIcon" class="w-5 h-5 mr-1" />
        Back to Recipes
      </button>

      <div class="flex gap-2">
        <button
          @click="handleEdit"
          class="px-4 py-2 text-sm font-medium text-primary hover:bg-primary/10 rounded transition"
        >
          Edit
        </button>
        <button
          @click="handleDuplicate"
          class="px-4 py-2 text-sm font-medium text-secondary hover:bg-secondary/10 rounded transition"
        >
          Duplicate
        </button>
        <button
          @click="handleDelete"
          class="px-4 py-2 text-sm font-medium text-error hover:bg-error/10 rounded transition"
        >
          Delete
        </button>
      </div>
    </div>

    <!-- Recipe Details -->
    <Card class="p-6">
      <h1 class="text-3xl font-bold text-text-primary mb-4">
        {{ recipe.name }}
      </h1>

      <div class="flex flex-wrap gap-2 mb-6">
        <span v-if="recipe.category" class="px-3 py-1 bg-primary/10 text-primary rounded">
          {{ recipe.category }}
        </span>
        <span v-if="recipe.difficulty" class="px-3 py-1 bg-secondary text-text-primary rounded">
          {{ recipe.difficulty }}
        </span>
      </div>

      <p v-if="recipe.description" class="text-text-secondary mb-6">
        {{ recipe.description }}
      </p>

      <!-- Metadata -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 pb-6 border-b border-border">
        <div v-if="recipe.prep_time">
          <p class="text-xs text-text-muted">Prep Time</p>
          <p class="text-lg font-semibold">{{ recipe.prep_time }}m</p>
        </div>
        <div v-if="recipe.cook_time">
          <p class="text-xs text-text-muted">Cook Time</p>
          <p class="text-lg font-semibold">{{ recipe.cook_time }}m</p>
        </div>
        <div v-if="recipe.servings">
          <p class="text-xs text-text-muted">Servings</p>
          <p class="text-lg font-semibold">{{ recipe.servings }}</p>
        </div>
        <div v-if="recipe.calories">
          <p class="text-xs text-text-muted">Calories</p>
          <p class="text-lg font-semibold">{{ recipe.calories }}</p>
        </div>
      </div>

      <!-- Ingredients -->
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-3">Ingredients</h2>
        <div class="whitespace-pre-wrap text-text-secondary">
          {{ recipe.ingredients }}
        </div>
      </div>

      <!-- Instructions -->
      <div v-if="recipe.instructions">
        <h2 class="text-xl font-semibold mb-3">Instructions</h2>
        <div class="whitespace-pre-wrap text-text-secondary">
          {{ recipe.instructions }}
        </div>
      </div>
    </Card>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import Card from '@/Components/common/Card.vue'
import Icon from '@/Components/common/Icon.vue'
import { route } from '@/composables/route'

const props = defineProps({
  recipe: {
    type: Object,
    required: true,
  },
})

function handleEdit() {
  // Navigate back to index with edit modal
  router.visit(route('recipes.index'), {
    data: { edit: props.recipe.id },
    preserveState: true,
  })
}

function handleDuplicate() {
  router.post(`/recipe/${props.recipe.id}/duplicate`, {}, {
    onSuccess: () => {
      router.visit(route('recipes.index'))
    },
  })
}

function handleDelete() {
  if (confirm('Are you sure you want to delete this recipe?')) {
    router.delete(`/recipe/${props.recipe.id}`, {
      onSuccess: () => {
        router.visit(route('recipes.index'))
      },
    })
  }
}
</script>
