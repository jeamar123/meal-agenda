<template>
  <div class="px-4 pt-4 border-b border-border">
    <div class="flex justify-between items-center mb-3">
      <button
        class="px-4 py-1 rounded bg-secondary border border-secondary-hover text-text-primary hover:bg-secondary-hover"
        @click="prevMonth"
      >
        Prev
      </button>
      <button
        v-if="selectedMonth"
        class="flex items-center gap-1 font-medium text-text-primary hover:text-primary transition-colors"
        @click="isMonthPickerOpen = true"
      >
        <span>
          {{ selectedMonth instanceof Date && !isNaN(selectedMonth)
            ? format(selectedMonth, 'MMMM yyyy')
            : '' }}
        </span>
        <ChevronDownIcon class="w-4 h-4" />
      </button>
      <button
        class="px-4 py-1 rounded bg-secondary border border-secondary-hover text-text-primary hover:bg-secondary-hover"
        @click="nextMonth"
      >
        Next
      </button>
    </div>

    <div ref="scrollerRef" class="flex gap-2 overflow-x-auto no-scrollbar pb-3">
      <button
        v-for="date in dates"
        :key="date.toISOString()"
        :data-selected="isSameDay(date, selectedDate)"
        @click="selectDate(date)"
        class="w-14 h-14 flex flex-col items-center justify-center rounded-xl border shrink-0 transition hover:bg-secondary hover:border-secondary-hover"
        :class="isToday(date)
          ? 'bg-primary hover:bg-primary! text-white border-primary'
          : isSameDay(date, selectedDate)
            ? 'bg-secondary text-text-primary border-secondary-hover'
            : 'bg-surface border-border text-text-muted'"
      >
        <span class="text-xs">{{ format(date, 'EEE') }}</span>
        <span class="font-semibold">{{ format(date, 'd') }}</span>
      </button>
    </div>

    <!-- Month Picker Modal -->
    <MonthPickerModal
      :show="isMonthPickerOpen"
      :current-month="selectedMonth"
      @close="isMonthPickerOpen = false"
      @select="handleMonthSelect"
    />
  </div>
</template>

<script setup>
import { ref, computed, watch, nextTick } from 'vue'
import { format, startOfMonth, endOfMonth, addDays, isToday, isSameDay } from 'date-fns'
import { ChevronDownIcon } from '@heroicons/vue/24/outline'
import MonthPickerModal from '@/Components/MonthPickerModal.vue'

const props = defineProps({
  modelValue: {
    type: Date,
    default: null,
  },
})

const emit = defineEmits(['update:modelValue'])

const selectedMonth = ref(new Date())
const selectedDate = ref(new Date())
const scrollerRef = ref(null)
const isLoading = ref(true)
const isMonthPickerOpen = ref(false)

// Computed property for v-model pattern
const internalSelectedDate = computed({
  get: () => props.modelValue || selectedDate.value,
  set: (value) => {
    if (props.modelValue !== undefined && props.modelValue !== null) {
      emit('update:modelValue', value)
    } else {
      selectedDate.value = value
    }
  }
})

// Generate all dates in the selected month
const dates = computed(() => {
  if (!(selectedMonth.value instanceof Date) || isNaN(selectedMonth.value)) return []
  const start = startOfMonth(selectedMonth.value)
  const end = endOfMonth(selectedMonth.value)
  const list = []
  let current = start
  while (current <= end) {
    list.push(new Date(current))
    current = addDays(current, 1)
  }
  return list
})

// Select a date
function selectDate(date) {
  internalSelectedDate.value = date
}

// Scroll the selected date into view
function scrollToSelected() {
  nextTick(() => {
    const el = scrollerRef.value?.querySelector('[data-selected="true"]')
    if (!el || !scrollerRef.value) return
    const container = scrollerRef.value
    const offset = el.offsetLeft - container.offsetWidth / 2 + el.offsetWidth / 2
    container.scrollTo({ left: offset, behavior: 'smooth' })
  })
}

// Prev/Next month functions
function prevMonth() {
  const date = selectedMonth.value
  if (!(date instanceof Date) || isNaN(date)) return
  const newMonth = new Date(date.getFullYear(), date.getMonth() - 1, 1)
  selectedMonth.value = newMonth
  internalSelectedDate.value = newMonth
}

function nextMonth() {
  const date = selectedMonth.value
  if (!(date instanceof Date) || isNaN(date)) return
  const newMonth = new Date(date.getFullYear(), date.getMonth() + 1, 1)
  selectedMonth.value = newMonth
  internalSelectedDate.value = newMonth
}

// Handle month selection from picker modal
function handleMonthSelect(newDate) {
  selectedMonth.value = startOfMonth(newDate)
  internalSelectedDate.value = newDate
}

// Watch for month change to simulate loading and scroll
watch(selectedMonth, () => {
  isLoading.value = true
  setTimeout(() => {
    isLoading.value = false
    scrollToSelected()
  }, 200)
})

// Watch for external modelValue changes
watch(() => props.modelValue, (newDate) => {
  if (newDate instanceof Date && !isNaN(newDate)) {
    selectedMonth.value = startOfMonth(newDate)
    selectedDate.value = newDate
  }
}, { immediate: true })

// Initial scroll to today
setTimeout(() => {
  isLoading.value = false
  scrollToSelected()
}, 600)
</script>