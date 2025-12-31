<template>
  <div
    @click="emit('edit', meal)"
    class="bg-surface border border-border rounded-md p-4 active:scale-[0.98] transition cursor-pointer hover:border-primary"
  >
    <div class="flex justify-between items-start">
      <div class="flex-1">
        <p class="font-medium text-text-primary">{{ meal.name }}</p>
        <p class="text-text-muted text-sm mt-0.5">
          {{ mealTypeLabel }}
          <span v-if="meal.time"> • {{ meal.time }}</span>
          <span v-if="meal.calories"> • {{ meal.calories }} cal</span>
        </p>
      </div>

      <div class="relative">
        <button
          @click.stop="isMenuOpen = !isMenuOpen"
          class="text-text-muted text-lg w-8 h-8 flex items-center justify-center rounded hover:bg-secondary transition"
          aria-label="Meal options"
        >
          ⋮
        </button>

        <!-- Actions Menu -->
        <div
          v-if="isMenuOpen"
          @click.stop
          class="absolute right-0 mt-1 w-40 bg-surface border border-border rounded-md shadow-lg py-1 z-10"
        >
          <button
            @click="handleEdit"
            class="w-full text-left px-4 py-2 text-sm hover:bg-secondary transition"
          >
            Edit
          </button>
          <button
            @click="handleDuplicate"
            class="w-full text-left px-4 py-2 text-sm hover:bg-secondary transition"
          >
            Duplicate
          </button>
          <button
            @click="handleDelete"
            class="w-full text-left px-4 py-2 text-sm text-error hover:bg-secondary transition"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <!-- Assigned Person & Notes -->
    <div v-if="meal.assigned_to || meal.notes" class="mt-3 flex flex-col gap-2">
      <span
        v-if="meal.assigned_to"
        class="text-xs px-2 py-1 rounded inline-block w-fit"
        :style="{ backgroundColor: meal.assigned_to.color + '20', color: meal.assigned_to.color }"
      >
        {{ meal.assigned_to.name }}
      </span>
      <p v-if="meal.notes" class="text-sm text-text-muted line-clamp-2">
        {{ meal.notes }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  meal: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['edit', 'delete', 'duplicate'])

const isMenuOpen = ref(false)

const mealTypeLabel = computed(() => {
  const labels = {
    breakfast: 'Breakfast',
    lunch: 'Lunch',
    dinner: 'Dinner',
    snack: 'Snack',
  }
  return labels[props.meal.meal_type] || props.meal.meal_type
})

function handleEdit() {
  isMenuOpen.value = false
  emit('edit', props.meal)
}

function handleDuplicate() {
  isMenuOpen.value = false
  emit('duplicate', props.meal)
}

function handleDelete() {
  isMenuOpen.value = false
  emit('delete', props.meal)
}

function handleClickOutside(event) {
  if (isMenuOpen.value) {
    isMenuOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
