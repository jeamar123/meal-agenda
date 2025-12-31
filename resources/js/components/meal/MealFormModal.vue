<template>
  <TransitionRoot appear :show="show" as="template">
    <Dialog as="div" class="relative z-50" @close="emit('close')">
      <!-- Backdrop -->
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/50" />
      </TransitionChild>

      <!-- Modal Container -->
      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-lg bg-surface p-6 shadow-xl transition-all">
              <DialogTitle class="text-lg font-medium text-text-primary mb-4">
                {{ isEditMode ? 'Edit Meal' : 'Create Meal' }}
              </DialogTitle>

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
                <TextInput
                  v-model="form.time"
                  label="Time"
                  type="time"
                  placeholder="12:30"
                  :error="errors.time"
                />

                <!-- Assigned To -->
                <SelectDropdown
                  v-model="form.assigned_to_id"
                  label="Assigned To"
                  :items="householdMemberOptions"
                  keyValue="id"
                  keyLabel="name"
                  placeholder="Select household member"
                  :error="errors.assigned_to_id"
                />

                <!-- Calories -->
                <TextInput
                  v-model="form.calories"
                  label="Calories"
                  type="number"
                  placeholder="450"
                  :error="errors.calories"
                />

                <!-- Notes -->
                <TextInput
                  v-model="form.notes"
                  label="Notes"
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
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import TextInput from '@/Components/form/TextInput.vue'
import SelectDropdown from '@/Components/form/SelectDropdown.vue'

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  meal: {
    type: Object,
    default: null,
  },
  householdMembers: {
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
    ...props.householdMembers,
  ]
})

const isEditMode = computed(() => !!props.meal)

const form = ref({
  name: '',
  meal_type: '',
  time: '',
  assigned_to_id: null,
  calories: '',
  notes: '',
  date: props.date,
})

watch(() => props.show, (newValue) => {
  if (newValue) {
    resetForm()
    if (props.meal) {
      form.value = {
        name: props.meal.name,
        meal_type: props.meal.meal_type,
        time: props.meal.time || '',
        assigned_to_id: props.meal.assigned_to?.id || null,
        calories: props.meal.calories || '',
        notes: props.meal.notes || '',
        date: props.meal.date,
      }
    } else {
      form.value.date = props.date
    }
  }
})

function resetForm() {
  form.value = {
    name: '',
    meal_type: '',
    time: '',
    assigned_to_id: null,
    calories: '',
    notes: '',
    date: props.date,
  }
  errors.value = {}
}

function handleSubmit() {
  errors.value = {}

  // Client-side validation
  if (!form.value.name) {
    errors.value.name = 'Meal name is required'
    return
  }

  if (!form.value.meal_type) {
    errors.value.meal_type = 'Meal type is required'
    return
  }

  loading.value = true

  // Emit the form data with meal ID if editing
  const data = {
    ...form.value,
    calories: form.value.calories ? parseInt(form.value.calories) : null,
  }

  if (isEditMode.value) {
    data.id = props.meal.id
  }

  emit('save', data)
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
