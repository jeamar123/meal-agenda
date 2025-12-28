<template>
  <div>
    <div :class="wrapperClass">
      <label
        v-if="label"
        class="form-label"
        :class="[
          {
            'text-gray-500 cursor-not-allowed': readOnly,
          },
          labelClass,
        ]"
        :for="id"
        >{{ label }}<span v-if="required">*</span></label
      >
    </div>
    <div class="relative">
      <VueDatePicker
        v-model="initialValue"
        :ui="{
          input: `form-element ${inputClass} ${errors.length && 'form-element-error'}`,
        }"
        :auto-apply="autoApply"
        :hide-input-icon="true"
        :clearable="false"
        :enable-time-picker="timePicker"
        :format="dateFormat"
        :time-picker-inline="timePickerInline"
        @update:model-value="formatTextDate"
      />
    </div>
    <template v-if="errors.length">
      <div class="mt-1">
        <p v-for="error in errors" :key="error" class="form-error">
          {{ error }}
        </p>
      </div>
    </template>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
  id: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: () => false,
  },
  errors: {
    type: Array,
    default: () => [],
  },
  readOnly: {
    type: Boolean,
    default: () => false,
  },
  wrapperClass: {
    type: [String, Object, Array],
    default: '',
  },
  labelClass: {
    type: [String, Object, Array],
    default: '',
  },
  inputClass: {
    type: [String, Object, Array],
    default: '',
  },
  modelValue: {
    type: [String, Date, null],
    default: null,
  },
  dateFormat: {
    type: String,
    required: false,
    default: 'PP',
  },
  timePicker: {
    type: Boolean,
    default: () => false,
  },
  timePickerInline: {
    type: Boolean,
    default: () => false,
  },
  autoApply: {
    type: Boolean,
    default: () => false,
  },
})
const emit = defineEmits(['update:model-value'])

const initialValue = ref(props.modelValue)

const formatTextDate = (value) => {
  if (value) {
    initialValue.value = value
  }
  emit('update:model-value', value)
}
</script>
