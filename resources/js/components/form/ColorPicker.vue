<template>
  <div>
    <div :class="wrapperClass">
      <label
        v-if="label"
        class="form-label"
        :class="[{ 'text-gray-500': readOnly }, labelClass]"
        :for="id"
        >{{ label }}<span v-if="required">*</span></label
      >
      <div
        class="relative flex items-center gap-x-2"
        :class="readOnly && 'pointer-events-none opacity-60'"
      >
        <input
          v-model="currentValue"
          type="text"
          class="form-element w-full"
          :class="[
            !readOnly ? 'form-element-focus' : '',
            errors.length ? 'form-element-error' : '',
            inputClass,
          ]"
        />

        <div>
          <ColorPicker
            :pure-color="modelValue || null"
            :format="format"
            :shape="shape"
            :use-type="pickerOption"
            lang="En"
            :disable-history="true"
            picker-type="chrome"
            @update:pure-color="
              (value) => {
                currentValue = value
                emit('update:model-value', value)
                emit('changed', { type: 'pure', value })
              }
            "
            @update:gradient-color="
              (value) => {
                emit('update:model-value', value)
                emit('changed', { type: 'gradient', value })
              }
            "
          />
        </div>
      </div>
    </div>
    <template v-if="errors.length">
      <div class="mt-1">
        <p
          v-for="error in errors"
          :key="error"
          class="text-red-500 block text-xs"
        >
          {{ error }}
        </p>
      </div>
    </template>
  </div>
</template>

<script setup>
import { ColorPicker } from 'vue3-colorpicker'
import 'vue3-colorpicker/style.css'
import { ref, watch } from 'vue'

const props = defineProps({
  id: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  modelValue: {
    type: String,
    default: () => '#00000000',
  },
  pureColorValue: {
    type: String,
    default: () => '#00000000',
  },
  gradientColorValue: {
    type: String,
    default: () => '',
  },
  format: {
    type: String,
    default: () => 'hex', // hex, hex8, rgb, rgba
  },
  shape: {
    type: String,
    default: () => 'square', // square, circle
  },
  pickerOption: {
    type: String,
    default: () => 'pure', // pure, gradient, both
  },
  readOnly: {
    type: Boolean,
    default: () => false,
  },
  required: {
    type: Boolean,
    default: () => false,
  },
  errors: {
    type: Array,
    default: () => [],
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
})

const emit = defineEmits(['changed', 'update:model-value'])

const currentValue = ref(props.modelValue)

watch(
  () => props.modelValue,
  (newValue) => {
    currentValue.value = newValue
  },
)

watch(
  () => currentValue.value,
  (newValue) => {
    emit('update:model-value', newValue)
  },
)
</script>

<style>
.vc-color-wrap {
  /* @apply rounded !shadow-none border; */
  margin-right: 0 !important;
  width: 41px !important;
  height: 41px !important;
}
</style>
