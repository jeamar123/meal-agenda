<template>
  <div>
    <div :class="wrapperClass">
      <label
        v-if="label"
        class="form-label"
        :class="[{ 'cursor-not-allowed': readOnly }, labelClass]"
        :for="id"
        >{{ label }}<span v-if="required">*</span></label
      >
      <Listbox
        v-model="selectedValue"
        as="div"
        class="min-w-16 cursor-pointer"
        :by="
          isItemObject(selectedValue) || isArrayOfObjects ? keyValue : undefined
        "
        :disabled="readOnly"
        @update:model-value="onChange"
      >
        <div class="relative">
          <ListboxButton
            class="form-element-dropdown select-dropdown-button relative w-full focus:outline-none min-h-11 border border-border block rounded-md px-3 py-2 outline-none transition-all text-left"
            :class="[
              error && '!border-red-500',
              readOnly && 'opacity-80 !bg-slate-50 cursor-not-allowed',
              !readOnly && 'focus:border-border',
              buttonClass,
            ]"
          >
            <span class="block truncate">
              {{ getLabel }}
            </span>
            <span
              class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
            >
              <ChevronUpDownIcon
                class="h-5 w-5"
                aria-hidden="true"
              />
            </span>
          </ListboxButton>

          <transition
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <ListboxOptions
              class="absolute border border-border w-full rounded-md z-5 outline-none text-sm bg-white"
              :class="[
                dropdownDirection === 'bottom'
                  ? 'md:top-11'
                  : 'bottom-11',
              ]"
            >
              <div v-if="search">
                <input
                  v-model="searchText"
                  class="w-full border-b border-form-border px-2 py-2 outline-none text-sm read-only:border-gray-200 read-only:text-gray-500 read-only:cursor-not-allowed block autofill:!bg-white transition-all"
                  placeholder="Search"
                />
              </div>
              <p
                v-if="!filteredItems.length"
                class="text-center italic py-2"
              >
                No items
              </p>
              
              <div class="max-h-60 overflow-auto">
                <ListboxOption
                  v-for="(item, index) in filteredItems"
                  :key="index"
                  :value="item"
                  as="template"
                >
                  <li
                    :class="[
                      (isItemObject(item) && item[keyValue] === modelValue) ||
                      item === modelValue
                        ? 'bg-primary text-white'
                        : 'hover:bg-primary hover:text-white',
                      'relative select-none p-2 border-b border-border outline-none',
                    ]"
                  >
                    {{
                      item === null ?
                        'Select option'
                      : isItemObject(item) || isArrayOfObjects
                        ? item[keyLabel]
                        : item
                    }}
                  </li>
                </ListboxOption>
              </div>
            </ListboxOptions>
          </transition>
        </div>
      </Listbox>
    </div>
    <p v-if="error" class="mt-1 form-error">
      {{ error }}
    </p>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'
import { ChevronUpDownIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  id: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  keyLabel: {
    // Think of a better key name
    type: String,
    default: 'label',
  },
  keyValue: {
    // Think of a better key name
    type: String,
    default: 'value',
  },
  placeholder: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: () => false,
  },
  error: {
    type: String,
    default: '',
  },
  readOnly: {
    type: Boolean,
    default: () => false,
  },
  wrapperClass: {
    type: [String, Object, Array],
    default: '',
  },
  buttonClass: {
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
  items: {
    type: Object,
    required: true,
  },
  modelValue: {
    type: [String, Boolean, Number, Object, null],
    default: null,
  },
  value: {
    type: [String, Boolean, Number, Object, null],
    default: null,
  },
  dropdownDirection: {
    type: String,
    default: 'bottom', // top, bottom
  },
  search: {
    type: Boolean,
    default: () => false,
  },
})

const emit = defineEmits(['update:model-value', 'change'])

const isArrayOfObjects = computed(() =>
  props.items.some((item) => item !== null && typeof item === 'object'),
)

const getLabel = computed(() => {
  let value = selectedValue.value

  if (value && isItemObject(value)) {
    return value[props.keyLabel]
  }
  if (value && isArrayOfObjects.value) {
    return (
      props.items.find((item) => item[props.keyValue] === value)?.[
        props.keyLabel
      ] || null
    )
  }
  if (!value && props.placeholder) {
    return props.placeholder
  }

  return value || null
})

const filteredItems = computed(() => {
  if (searchText.value) {
    return props.items.filter((item) => {
      if(isItemObject(item)){
        return item[props.keyLabel].toLowerCase().includes(searchText.value.toLowerCase())
      }
      if(!item || item === null) return false

      return item.toLowerCase().includes(searchText.value.toLowerCase())
    })
  }

  return props.items
})

const selectedValue = ref(props.modelValue || props.value)
const searchText = ref('')

const onChange = (value) => {
  emit(
    'update:model-value',
    isItemObject(value) ? value[props.keyValue] : value,
  )
}

const isItemObject = (value) => value !== null && typeof value === 'object'
watch(
  () => props.modelValue,
  async (newValue) => {
    selectedValue.value = newValue
  },
)
</script>
