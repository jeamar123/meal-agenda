<template>
  <Modal
    :show="show"
    variant="center"
    animation="scale"
    :show-header="false"
    :show-footer="false"
    panel-class="max-w-2xl"
    @close="emit('close')"
  >
    <h2 class="text-lg font-medium text-text-primary mb-4">
      {{ isEditMode ? 'Edit Recipe' : 'Create Recipe' }}
    </h2>

    <form @submit.prevent="handleSubmit" class="space-y-4">
      <!-- Name -->
      <TextInput
        v-model="form.name"
        label="Recipe Name"
        placeholder="E.g., Chicken Alfredo Pasta"
        required
        :error="errors.name"
      />

      <!-- Category & Difficulty -->
      <div class="grid grid-cols-2 gap-4">
        <SelectDropdown
          v-model="form.category"
          label="Category"
          :items="categoryOptions"
          keyValue="value"
          keyLabel="label"
          placeholder="Select category"
          :error="errors.category"
        />

        <SelectDropdown
          v-model="form.difficulty"
          label="Difficulty"
          :items="difficultyOptions"
          keyValue="value"
          keyLabel="label"
          placeholder="Select difficulty"
          :error="errors.difficulty"
        />
      </div>

      <!-- Description -->
      <TextInput
        v-model="form.description"
        label="Description"
        as="textarea"
        placeholder="Brief description of the recipe..."
        inputClass="resize-none h-20"
        :error="errors.description"
      />

      <!-- Ingredients -->
      <TextInput
        v-model="form.ingredients"
        label="Ingredients"
        as="textarea"
        placeholder="List ingredients (one per line)..."
        required
        inputClass="resize-none h-32"
        :error="errors.ingredients"
      />

      <!-- Instructions -->
      <TextInput
        v-model="form.instructions"
        label="Instructions"
        as="textarea"
        placeholder="Step-by-step cooking instructions..."
        inputClass="resize-none h-32"
        :error="errors.instructions"
      />

      <!-- Time & Servings -->
      <div class="grid grid-cols-3 gap-4">
        <TextInput
          v-model="form.prep_time"
          label="Prep Time (min)"
          type="number"
          placeholder="30"
          :error="errors.prep_time"
        />

        <TextInput
          v-model="form.cook_time"
          label="Cook Time (min)"
          type="number"
          placeholder="45"
          :error="errors.cook_time"
        />

        <TextInput
          v-model="form.servings"
          label="Servings"
          type="number"
          placeholder="4"
          :error="errors.servings"
        />
      </div>

      <!-- Calories -->
      <TextInput
        v-model="form.calories"
        label="Calories (per serving)"
        type="number"
        placeholder="450"
        :error="errors.calories"
      />

      <!-- Buttons -->
      <div class="flex gap-3 justify-end pt-2">
        <button
          type="button"
          @click="emit('close')"
          class="px-4 py-2 text-sm font-medium text-text-primary bg-secondary hover:bg-secondary-hover rounded-md transition"
        >
          Cancel
        </button>
        <button
          type="submit"
          :disabled="loading"
          class="px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary-hover rounded-md transition disabled:opacity-50"
        >
          {{ loading ? 'Saving...' : (isEditMode ? 'Update' : 'Create') }}
        </button>
      </div>
    </form>
  </Modal>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Modal } from '@/Components/common'
import TextInput from '@/Components/form/TextInput.vue'
import SelectDropdown from '@/Components/form/SelectDropdown.vue'

const props = defineProps({
  show: { type: Boolean, required: true },
  recipe: { type: Object, default: null },
})

const emit = defineEmits(['close', 'save'])

const loading = ref(false)
const errors = ref({})

const categoryOptions = [
  { value: 'breakfast', label: 'Breakfast' },
  { value: 'lunch', label: 'Lunch' },
  { value: 'dinner', label: 'Dinner' },
  { value: 'dessert', label: 'Dessert' },
  { value: 'snack', label: 'Snack' },
  { value: 'appetizer', label: 'Appetizer' },
]

const difficultyOptions = [
  { value: 'easy', label: 'Easy' },
  { value: 'medium', label: 'Medium' },
  { value: 'hard', label: 'Hard' },
]

const isEditMode = computed(() => !!props.recipe)

const form = ref({
  name: '',
  description: '',
  ingredients: '',
  instructions: '',
  prep_time: '',
  cook_time: '',
  servings: '',
  difficulty: '',
  category: '',
  calories: '',
})

watch(() => props.show, (newValue) => {
  if (newValue) {
    resetForm()
    if (props.recipe) {
      form.value = { ...props.recipe }
    }
  }
})

function resetForm() {
  form.value = {
    name: '',
    description: '',
    ingredients: '',
    instructions: '',
    prep_time: '',
    cook_time: '',
    servings: '',
    difficulty: '',
    category: '',
    calories: '',
  }
  errors.value = {}
}

function handleSubmit() {
  errors.value = {}

  if (!form.value.name) {
    errors.value.name = 'Recipe name is required'
    return
  }

  if (!form.value.ingredients) {
    errors.value.ingredients = 'Ingredients are required'
    return
  }

  loading.value = true
  emit('save', { ...form.value, id: props.recipe?.id })
}

defineExpose({
  setLoading: (value) => { loading.value = value },
  setErrors: (errs) => { errors.value = errs },
})
</script>
