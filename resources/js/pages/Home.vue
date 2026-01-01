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
      v-if="showMealModal"
      ref="mealFormModalRef"
      :show="true"
      :meal="selectedMeal"
      :household-members="householdMembers"
      :recipes="recipes"
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
import DateScroller from '@/Components/Meal/DateScroller.vue'
import MealList from '@/Components/Meal/MealList.vue'
import MealFormModal from '@/Components/Meal/MealFormModal.vue'
import DeleteMealModal from '@/Components/Meal/DeleteMealModal.vue'
import FAB from '@/Components/Meal/FAB.vue'

const props = defineProps({
  householdMembers: {
    type: Array,
    default: () => [],
  },
  recipes: {
    type: Array,
    default: () => [],
  },
})

console.log(props)

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
const fetchMeals = async () => {
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

const handleCreate = () => {
  selectedMeal.value = null
  showMealModal.value = true
}

const handleEdit = (meal) => {
  selectedMeal.value = meal
  showMealModal.value = true
}

const closeMealModal = () => {
  showMealModal.value = false
  selectedMeal.value = null
}

const handleSaveMeal = async (formData) => {
  if (mealFormModalRef.value) {
    mealFormModalRef.value.setLoading(true)
  }

  try {
    if (formData.id) {
      await axios.patch(`/meal/${formData.id}`, formData)
    } else {
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
      console.log('Failed to save meal. Please try again.')
    }
  } finally {
    if (mealFormModalRef.value) {
      mealFormModalRef.value.setLoading(false)
    }
  }
}

const handleDeleteClick = (meal) => {
  selectedMeal.value = meal
  showDeleteModal.value = true
}

const handleDeleteConfirm = async () => {
  if (!selectedMeal.value) return

  try {
    await axios.delete(`/meal/${selectedMeal.value.id}`)
    await fetchMeals()
    showDeleteModal.value = false
    selectedMeal.value = null
  } catch (error) {
    console.error('Error deleting meal:', error)
  }
}

const handleDuplicate = async (meal) => {
  try {
    await axios.post(`/meal/${meal.id}/duplicate`)
    await fetchMeals()
  } catch (error) {
    console.error('Error duplicating meal:', error)
  }
}

watch(selectedDate, () => {
  fetchMeals()
}, { immediate: false })

onMounted(() => {
  fetchMeals()
})
</script>
