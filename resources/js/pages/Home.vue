<template>
  <div class="container px-0">
    <DateScroller v-model="selectedDate" />

    <div class="p-4">
      <!-- Empty State -->
      <div
        v-if="!loading && meals.length === 0"
        class="text-center py-12 text-text-muted"
      >
        <p class="text-lg mb-2">No meals planned for this date</p>
        <p class="text-sm">Tap the + button to add your first meal</p>
      </div>

      <!-- Meal List -->
      <MealList
        v-else
        :meals="meals"
        @edit="handleEdit"
        @delete="handleDeleteClick"
        @duplicate="handleDuplicate"
      />

      <!-- Loading Spinner -->
      <div v-if="loading" class="text-center py-8">
        <p class="text-text-muted">Loading meals...</p>
      </div>

      <!-- FAB -->
      <FAB @click="handleCreate" />
    </div>

    <!-- Meal Form Modal -->
    <MealFormModal
      ref="mealFormModalRef"
      :show="showMealModal"
      :meal="selectedMeal"
      :household-members="householdMembers"
      :date="formattedSelectedDate"
      @close="closeMealModal"
      @save="handleSaveMeal"
    />

    <!-- Delete Confirmation Modal -->
    <DeleteMealModal
      :show="showDeleteModal"
      :meal="selectedMeal"
      @close="showDeleteModal = false"
      @confirm="handleDeleteConfirm"
    />
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import axios from 'axios'
import { format } from 'date-fns'
import DateScroller from '@/Components/DateScroller.vue'
import MealList from '@/Components/meal/MealList.vue'
import MealFormModal from '@/Components/meal/MealFormModal.vue'
import DeleteMealModal from '@/Components/meal/DeleteMealModal.vue'
import FAB from '@/Components/common/FAB.vue'

const props = defineProps({
  householdMembers: {
    type: Array,
    default: () => [],
  },
})

// State
const selectedDate = ref(new Date())
const meals = ref([])
const loading = ref(false)
const showMealModal = ref(false)
const showDeleteModal = ref(false)
const selectedMeal = ref(null)
const mealFormModalRef = ref(null)

// Computed
const formattedSelectedDate = computed(() => {
  return format(selectedDate.value, 'yyyy-MM-dd')
})

// Methods
async function fetchMeals() {
  loading.value = true
  try {
    const response = await axios.get('/meal', {
      params: {
        date: formattedSelectedDate.value,
      },
    })
    meals.value = response.data.data
  } catch (error) {
    console.error('Error fetching meals:', error)
    // alert('Failed to load meals. Please try again.')
  } finally {
    loading.value = false
  }
}

function handleCreate() {
  selectedMeal.value = null
  showMealModal.value = true
}

function handleEdit(meal) {
  selectedMeal.value = meal
  showMealModal.value = true
}

function closeMealModal() {
  showMealModal.value = false
  selectedMeal.value = null
}

async function handleSaveMeal(formData) {
  if (mealFormModalRef.value) {
    mealFormModalRef.value.setLoading(true)
  }

  try {
    if (formData.id) {
      // Update existing meal
      await axios.patch(`/meal/${formData.id}`, formData)
    } else {
      // Create new meal
      await axios.post('/meal', formData)
    }

    await fetchMeals()
    closeMealModal()
  } catch (error) {
    console.error('Error saving meal:', error)

    if (error.response?.data?.errors) {
      if (mealFormModalRef.value) {
        mealFormModalRef.value.setErrors(error.response.data.errors)
      }
    } else {
      // alert('Failed to save meal. Please try again.')
    }
  } finally {
    if (mealFormModalRef.value) {
      mealFormModalRef.value.setLoading(false)
    }
  }
}

function handleDeleteClick(meal) {
  selectedMeal.value = meal
  showDeleteModal.value = true
}

async function handleDeleteConfirm() {
  if (!selectedMeal.value) return

  try {
    await axios.delete(`/meal/${selectedMeal.value.id}`)
    await fetchMeals()
    showDeleteModal.value = false
    selectedMeal.value = null
  } catch (error) {
    console.error('Error deleting meal:', error)
    // alert('Failed to delete meal. Please try again.')
  }
}

async function handleDuplicate(meal) {
  try {
    await axios.post(`/meal/${meal.id}/duplicate`)
    await fetchMeals()
  } catch (error) {
    console.error('Error duplicating meal:', error)
    // alert('Failed to duplicate meal. Please try again.')
  }
}

// Watchers
watch(selectedDate, () => {
  fetchMeals()
}, { immediate: false })

// Lifecycle
onMounted(() => {
  fetchMeals()
})
</script>
