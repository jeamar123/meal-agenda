<template>
  <Modal
    :show="show"
    variant="center"
    animation="scale"
    :show-header="false"
    :show-footer="false"
    wrapper-class="lg:w-100!"
    @close="emit('close')"
  >
    <h2 class="text-lg font-medium text-text-primary mb-4">
      {{ isEditMode ? 'Edit Meal' : 'Create Meal' }}
    </h2>

    <form @submit.prevent="handleSubmit" class="space-y-4">
      <!-- Meal Name -->
      <TextInput
        v-model="form.name"
        label="Meal Name"
        placeholder="E.g., Chicken Salad"
        required
        :error="errors.name"
      />

      <!-- Meal Type -->
      <SelectDropdown
        v-model="form.meal_type"
        label="Meal Type"
        :items="mealTypeOptions"
        keyValue="value"
        keyLabel="label"
        placeholder="Select meal type"
        required
        :error="errors.meal_type"
      />

      <!-- Time -->
      <TimePickerInput
        v-model="form.time"
        label="Time"
        type="time"
        placeholder="12:30"
        :error="errors.time"
      />

      <!-- Assigned To -->
      <SelectDropdown
        v-model="form.assigned_to_id"
        label="Assigned (Optional)"
        :items="householdMemberOptions"
        keyValue="id"
        keyLabel="name"
        placeholder="Select household member"
        :error="errors.assigned_to_id"
      />

      <!-- Recipe -->
      <SelectDropdown
        v-model="form.recipe_id"
        label="Recipe (Optional)"
        :items="recipeOptions"
        keyValue="id"
        keyLabel="name"
        placeholder="Select a recipe"
        :error="errors.recipe_id"
      />

      <!-- Calories -->
      <TextInput
        v-model="form.calories"
        label="Calories (Optional)"
        type="number"
        placeholder="450"
        :error="errors.calories"
      />

      <!-- Notes -->
      <TextInput
        v-model="form.notes"
        label="Notes (Optional)"
        as="textarea"
        placeholder="Additional notes about the meal..."
        :error="errors.notes"
        inputClass="resize-none h-20"
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
          class="px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary-hover rounded-md transition disabled:opacity-50 disabled:cursor-not-allowed"
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
import { TextInput, TimePickerInput, SelectDropdown } from '@/Components/form'
import { usePage, useForm } from '@inertiajs/vue3'
import { useRoute } from '@/composables/route'

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  meal: {
    type: Object,
    default: () => ({}),
  },
  members: {
    type: Array,
    default: () => [],
  },
  recipes: {
    type: Array,
    default: () => [],
  },
  date: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['close', 'save'])

const loading = ref(false)
const errors = ref({})

const mealTypeOptions = [
  { value: 'breakfast', label: 'Breakfast' },
  { value: 'lunch', label: 'Lunch' },
  { value: 'dinner', label: 'Dinner' },
  { value: 'snack', label: 'Snack' },
]

const householdMemberOptions = computed(() => {
  return [
    { id: null, name: 'No one' },
    ...props.members,
  ]
})

const recipeOptions = computed(() => {
  return [
    { id: null, name: 'No recipe' },
    ...props.recipes,
  ]
})

const isEditMode = computed(() => !!props.meal)

const form = useForm({
  name: '',
  meal_type: '',
  time: '',
  assigned_to_id: null,
  recipe_id: null,
  calories: '',
  notes: '',
  date: props.date,

  ...props.meal
})

const resetForm = () => {
  form.reset()
  errors.value = {}
}

const handleSubmit = () => {
  errors.value = {}

  // Client-side validation
  if (!form.name) {
    errors.value.name = 'Meal name is required'
    return
  }

  if (!form.meal_type) {
    errors.value.meal_type = 'Meal type is required'
    return
  }

  loading.value = true

  // Emit the form data with meal ID if editing

  form.calories = form.calories ? parseInt(form.calories) : null

  if (isEditMode.value) {
    form.id = props.meal.id
  }

  // emit('save', data)
  handleSaveMeal()
}

const handleSaveMeal = async () => {
  if (form.id) {
    form.patch(useRoute('meal.update', { meal: formData.id }))
  } else {
    form.post(useRoute('meal.create'))
  }
  loading.value = false
  emit('close')
}

// Expose setLoading method for parent component
defineExpose({
  setLoading: (value) => {
    loading.value = value
  },
  setErrors: (errs) => {
    errors.value = errs
  },
})
</script>
