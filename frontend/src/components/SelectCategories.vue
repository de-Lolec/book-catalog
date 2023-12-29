<template>
  <div class="top-16 w-72">
    <Combobox v-model="selectedCategories" multiple @change="changeOption">
      <div class="relative mt-4 mb-4 z-10">
        <p class="mb-2"  v-for="selectCategory in selectedCategories" :key="selectCategory.id">{{ selectCategory.title }}</p>
        <div
          class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
        >
          
          <ComboboxInput
            class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
            :displayValue="(category) => category.title"
            @change="query = $event.target.value"
          
          />
      
          <ComboboxButton
            class="absolute inset-y-0 right-0 flex items-center pr-2"
          >
            <ChevronUpDownIcon
              class="h-5 w-5 text-gray-400"
              aria-hidden="true"
            />
          </ComboboxButton>
        </div>
        <TransitionRoot
          leave="transition ease-in duration-100"
          leaveFrom="opacity-100"
          leaveTo="opacity-0"
          @after-leave="query = ''"

        >
          <ComboboxOptions
            class="absolute mt-1 max-h-40 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"

          >
            <div
              v-if="filteredCategories.length === 0 && query !== ''"
              class="relative cursor-default select-none px-4 py-2 text-gray-700"
            >
              Nothing found.
            </div>

            <ComboboxOption
              v-for="category in filteredCategories"
              as="template"
              :key="category.id"
              :value="category.id"

              v-slot="{ selected, active }"
            >
              <li
                class="relative cursor-default select-none py-2 pl-10 pr-4"
                :class="{
                  'bg-teal-600 text-white': active,
                  'text-gray-900': !active,
                }"
                @click="updateCategories"
              >
                <span
                  class="block truncate"
                  :class="{ 'font-medium': selected, 'font-normal': !selected }"
                >
                  {{ category.title }}
                </span>
                <span
                  v-if="selected"
                  class="absolute inset-y-0 left-0 flex items-center pl-3"
                  :class="{ 'text-white': active, 'text-teal-600': !active }"
                >
                  <CheckIcon class="h-5 w-5" aria-hidden="true" />
                </span>
              </li>
            </ComboboxOption>
          </ComboboxOptions>

        </TransitionRoot>
      </div>
    </Combobox>
  </div>
</template>

<script setup>
import { ref, computed, defineProps, defineEmits } from 'vue';
import {
  Combobox,
  ComboboxInput,
  ComboboxButton,
  ComboboxOptions,
  ComboboxOption,
  TransitionRoot,
} from '@headlessui/vue';
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid';

const { categories } = defineProps(['categories']);
const emit = defineEmits();

const selectedCategories = ref([]);
let query = ref('');

let filteredCategories = computed(() =>
  query.value === '' ? categories : categories.filter((category) =>
        category.title
          .toLowerCase()
          .replace(/\s+/g, '')
          .includes(query.value.toLowerCase().replace(/\s+/g, ''))
      ),
);

console.log(filteredCategories);

// const changeOption = () => {
//   emit('update:selectedCategories', selectedCategories.value);
//   console.log(selectedCategories);
// };


const updateCategories = () => {
  if(selectedCategories.value != undefined){
  emit('update:selectedCategories', selectedCategories.value);
  }
  console.log(selectedCategories);
};

</script>
