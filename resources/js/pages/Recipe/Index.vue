<template>
  <div class="container px-4 py-6 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-text-primary">Recipes</h1>

      <!-- Category Filter -->
      <SelectDropdown
        v-model="selectedCategory"
        :items="categoryFilterOptions"
        keyValue="value"
        keyLabel="label"
        placeholder="All Categories"
        class="w-48"
      />
    </div>

    <!-- Search -->
    <div class="mb-6">
      <TextInput
        v-model="searchQuery"
        placeholder="Search recipes..."
        inputClass="w-full"
      />
    </div>

    <!-- Recipe Grid -->
    <div v-if="filteredRecipes?.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <RecipeCard
        v-for="recipe in filteredRecipes"
        :key="recipe.id"
        :recipe="recipe"
        @edit="openEditModal"
        @delete="openDeleteModal"
        @duplicate="handleDuplicate"
      />
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12">
      <p class="text-text-secondary mb-4">No recipes found</p>
      <button
        @click="openCreateModal"
        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-hover transition"
      >
        Create Your First Recipe
      </button>
    </div>

    <!-- FAB -->
    <FAB @click="openCreateModal" />

    <!-- Modals -->
    <RecipeFormModal
      ref="recipeFormModalRef"
      :show="showRecipeModal"
      :recipe="selectedRecipe"
      @close="closeRecipeModal"
      @save="handleSaveRecipe"
    />

    <DeleteRecipeModal
      :show="showDeleteModal"
      :recipe="selectedRecipe"
      @close="showDeleteModal = false"
      @confirm="handleDeleteConfirm"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import RecipeCard from '@/Components/Recipe/RecipeCard.vue'
import RecipeFormModal from '@/Components/Recipe/RecipeFormModal.vue'
import DeleteRecipeModal from '@/Components/Recipe/DeleteRecipeModal.vue'
import FAB from '@/Components/Recipe/FAB.vue'
import TextInput from '@/Components/form/TextInput.vue'
import SelectDropdown from '@/Components/form/SelectDropdown.vue'

const props = defineProps({
  recipes: { type: [Array,Object], default: () => [] },
})

const searchQuery = ref('')
const selectedCategory = ref('')
const showRecipeModal = ref(false)
const showDeleteModal = ref(false)
const selectedRecipe = ref(null)
const recipeFormModalRef = ref(null)

const categoryFilterOptions = [
  { value: '', label: 'All Categories' },
  { value: 'breakfast', label: 'Breakfast' },
  { value: 'lunch', label: 'Lunch' },
  { value: 'dinner', label: 'Dinner' },
  { value: 'dessert', label: 'Dessert' },
  { value: 'snack', label: 'Snack' },
  { value: 'appetizer', label: 'Appetizer' },
]

const filteredRecipes = computed(() => {
  let filtered = props.recipes

  // Filter by category
  if (selectedCategory.value) {
    filtered = filtered.filter(r => r.category === selectedCategory.value)
  }

  // Filter by search
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(r =>
      r.name.toLowerCase().includes(query) ||
      r.description?.toLowerCase().includes(query)
    )
  }

  return filtered
})

function openCreateModal() {
  selectedRecipe.value = null
  showRecipeModal.value = true
}

function openEditModal(recipe) {
  selectedRecipe.value = recipe
  showRecipeModal.value = true
}

function openDeleteModal(recipe) {
  selectedRecipe.value = recipe
  showDeleteModal.value = true
}

function closeRecipeModal() {
  showRecipeModal.value = false
  selectedRecipe.value = null
}

function handleSaveRecipe(data) {
  const isEdit = !!data.id
  const url = isEdit ? `/recipe/${data.id}` : '/recipe'
  const method = isEdit ? 'patch' : 'post'

  router[method](url, data, {
    preserveScroll: true,
    onSuccess: () => {
      closeRecipeModal()
    },
    onError: (errors) => {
      recipeFormModalRef.value?.setErrors(errors)
      recipeFormModalRef.value?.setLoading(false)
    },
    onFinish: () => {
      recipeFormModalRef.value?.setLoading(false)
    },
  })
}

function handleDuplicate(recipe) {
  router.post(`/recipe/${recipe.id}/duplicate`, {}, {
    preserveScroll: true,
  })
}

function handleDeleteConfirm() {
  if (!selectedRecipe.value) return

  router.delete(`/recipe/${selectedRecipe.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false
      selectedRecipe.value = null
    },
  })
}
</script>
