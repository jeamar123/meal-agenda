<template>
  <label class="relative flex items-start gap-x-3 cursor-pointer w-max">
    <div
      class="w-[50px] h-[24px] relative flex rounded-full cursor-pointer items-center justify-between p-[2px] outline-none hover:ring-offset-0 hover:ring-1 hover:ring-primary transition-all"
      :class="modelValue !== trueValue ? 'bg-zinc-500' : 'bg-primary'"
    >
      <input
        type="checkbox"
        class="absolute top-0 left-0 w-full h-full z-0 cursor-pointer opacity-0"
        :value="modelValue"
        :checked="modelValue === trueValue"
        @change="
          ({ target }) => {
            emit('update:model-value', target.checked)
            emit('change', target.checked)
          }
        "
      />
      <div
        class="rounded-full w-5 h-5"
        :class="modelValue !== trueValue && 'bg-zinc-300'"
      ></div>
      <div
        class="rounded-full w-5 h-5"
        :class="modelValue === trueValue && 'bg-zinc-300'"
      ></div>
    </div>
    <slot name="label">
      <span class="leading-[1.7]">{{ label }}</span>
    </slot>
  </label>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    default: '',
  },
  labelClass: {
    type: [String, Object, Array],
    default: '',
  },
  modelValue: {
    type: [Boolean, String],
    default: () => false,
  },
  trueValue: {
    type: [Boolean, String],
    default: () => true,
  },
  falseValue: {
    type: [Boolean, String],
    default: () => false,
  },
})

const emit = defineEmits(['update:model-value', 'change'])
</script>
