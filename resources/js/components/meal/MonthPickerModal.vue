<template>
  <Modal
    :show="show"
    variant="bottom-sheet"
    animation="slide"
    title="Select Month"
    :show-footer="false"
    @close="emit('close')"
  >
    <!-- Year Selector -->
    <div class="flex gap-2 mb-6">
      <button
        v-for="year in availableYears"
        :key="year"
        @click="selectedYear = year"
        class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-200"
        :class="selectedYear === year
          ? 'bg-primary text-white shadow-md'
          : 'bg-secondary text-text-primary hover:bg-secondary-hover'"
      >
        {{ year }}
      </button>
    </div>

    <!-- Month Grid -->
    <div class="grid grid-cols-3 md:grid-cols-4 gap-3 mb-6">
      <button
        v-for="(month, index) in months"
        :key="index"
        @click="selectMonth(index)"
        :aria-label="`${month} ${selectedYear}`"
        class="min-h-[44px] py-3 px-2 rounded-lg font-medium text-sm transition-all duration-200"
        :class="getMonthClasses(index)"
      >
        {{ month }}
      </button>
    </div>

    <!-- Jump to Today Button -->
    <button
      @click="jumpToToday"
      class="w-full py-3 px-4 rounded-lg border-2 border-primary text-primary font-medium hover:bg-primary hover:text-white transition-all duration-200"
    >
      Jump to Today
    </button>
  </Modal>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Modal } from '@/Components/common'

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  currentMonth: {
    type: Date,
    required: true,
  },
  yearRange: {
    type: Number,
    default: 1,
  },
})

const emit = defineEmits(['close', 'select'])

// State
const selectedYear = ref(new Date().getFullYear())
const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

// Computed
const availableYears = computed(() => {
  const current = new Date().getFullYear()
  const years = []
  for (let i = -props.yearRange; i <= props.yearRange; i++) {
    years.push(current + i)
  }
  return years
})

// Check if a month is the current month (today)
const isCurrentMonth = (monthIndex) => {
  const today = new Date()
  return today.getFullYear() === selectedYear.value &&
         today.getMonth() === monthIndex
}

// Check if a month is the selected month
const isSelectedMonth = (monthIndex) => {
  return props.currentMonth.getFullYear() === selectedYear.value &&
         props.currentMonth.getMonth() === monthIndex
}

// Get classes for month button
const getMonthClasses = (monthIndex) => {
  const classes = []

  if (isSelectedMonth(monthIndex)) {
    classes.push('bg-primary text-white')
  } else if (isCurrentMonth(monthIndex)) {
    classes.push('bg-secondary text-text-primary ring-2 ring-primary')
  } else {
    classes.push('bg-secondary text-text-primary hover:bg-secondary-hover')
  }

  return classes.join(' ')
}

// Methods
function selectMonth(monthIndex) {
  const newDate = new Date(selectedYear.value, monthIndex, 1)
  emit('select', newDate)
  emit('close')
}

function jumpToToday() {
  const today = new Date()
  selectedYear.value = today.getFullYear()
  emit('select', today)
  emit('close')
}

// Watch for currentMonth changes to sync selected year
watch(() => props.currentMonth, (newDate) => {
  if (newDate instanceof Date && !isNaN(newDate)) {
    selectedYear.value = newDate.getFullYear()
  }
}, { immediate: true })
</script>
