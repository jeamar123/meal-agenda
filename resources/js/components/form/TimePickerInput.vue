<template>
  <div>
    <div :class="wrapperClass">
      <label
        v-if="label"
        class="form-label"
        :class="[{ 'text-gray-500 cursor-not-allowed': readOnly }, labelClass]"
        :for="id"
        >{{ label }}<span v-if="required">*</span></label
      >
      <component
        :is="as"
        :id="id"
        :value="modelValue"
        :type="type"
        :placeholder="placeholder"
        class="form-element w-full"
        :class="[
          !readOnly ? 'focus:border-gray-900' : '',
          error ? 'form-element-error border-red-500' : '',
          inputClass,
        ]"
        min="0"
        :readonly="readOnly"
        @input="(e) => emit('update:model-value', e.target.value)"
      />
    </div>

    <p v-if="error" class="mt-1 form-error">
      {{ error }}
    </p>
  </div>
</template>

<script setup>
defineProps({
  as: {
    type: String,
    default: 'input', // input, textarea
  },
  id: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  type: {
    type: String,
    default: 'text', // text, number, date, password
  },
  modelValue: {
    type: [String, Number],
    default: '',
  },
  placeholder: {
    type: String,
    default: '',
  },
  readOnly: {
    type: Boolean,
    default: () => false,
  },
  required: {
    type: Boolean,
    default: () => false,
  },
  error: {
    type: String,
    default: '',
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

const emit = defineEmits(['update:model-value'])
</script>
