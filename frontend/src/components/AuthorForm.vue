<template>
  <div class="inline" @click="openModal">
    <slot></slot>
  </div>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
                Добавить автора
              </DialogTitle>
              <label for="name" class="block text-sm font-medium leading-6 text-gray-900 ">Имя:</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                  <input 
                  v-model="name" 
                  type="text" 
                  name="comment" 
                  id="comment" 
                  class="block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                </div>
              <label for="comment" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Комментарий:</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                  <textarea  
                  v-model="comment" 
                  type="text" 
                  name="comment" 
                  id="comment" 
                  class="h-24 block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                </div>
                  <label class="block text-sm font-medium leading-6 text-gray-900 mt-2">Страна:</label>
                  <select v-model="selectCountry" class="mt-4 bg-blue-100 border-blue-300 focus:ring-blue-200" >
                    <option disabled selected hidden value="">Выберите из списка</option>
                    <option
                      v-for="country in countries"
                      :key="country.value"
                      :value="country.name"
                    >
                      {{ country.name }}
                    </option>
                  </select>

              <div class="mt-4">
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="saveAuthor"
                >
                  Добавить
                </button>
                <button
                  type="button"
                  class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="closeModal"
                >
                Отмена
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import { countries } from '../data/CountryList.js'
import axiosClient from '../axios';

const name = ref('');
const comment = ref('');
const selectCountry = ref('');
const isOpen = ref(false);
const emit = defineEmits();

function closeModal() {
  isOpen.value = false
};
function openModal() {
  isOpen.value = true
};

const saveAuthor = async () => {
  axiosClient.post(`/author/create`, {
      name: name.value,
      comment: comment.value,
      country: selectCountry.value,
    })
    .then(response => {
      console.log(response);
      closeModal()
    }, error => {
      console.error('Error adding category:', error.message);
    });
}

</script>
