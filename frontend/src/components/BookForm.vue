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
                class="mb-2 text-lg font-medium leading-6 text-gray-900"
              >
                Добавить книгу
              </DialogTitle>
              <label for="title" class="block text-sm font-medium leading-6 text-gray-900 ">Название:</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                  <input 
                  v-model="name" 
                  type="text" 
                  name="name" 
                  id="name" 
                  class="block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                </div>
              <label for="description" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Описание:</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                  <textarea   
                  v-model="description" 
                  type="text" 
                  name="description" 
                  id="description" 
                  class="h-24 block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                </div>
              <label for="categories" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Категории:</label>
              <div v-for="category in categories">
                <label>
                  <input 
                  type="checkbox" 
                  v-model="selectedCategories" 
                  :value="category.id" 
                  class="mb-1 bg-blue-100 border-blue-300 focus:ring-blue-200"/>
                  {{ category.title }}
                </label>
              </div>
              <div>
                <label class="block text-sm font-medium leading-6 text-gray-900 mt-2">Выберите автора:</label>
                  <select v-model="selectAuthor" class="mt-4 bg-blue-100 border-blue-300 focus:ring-blue-200" >
                  <option disabled selected hidden value="">Выберите из списка</option>
                  <option
                    v-for="author in authors"
                    :key="author.value"
                    :value="author.id"
                  >
                    {{ author.name }}
                  </option>
                  </select>
              </div>

              <label for="year" class="block text-sm font-medium leading-6 text-gray-900 mt-2">Год:</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                  <input 
                  v-model="year" 
                  @input="handleYear"
                  type="text" 
                  name="year" 
                  id="year" 
                  class="mb-4 block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                </div>
              <label for="year" class="block text-sm font-medium leading-6 text-gray-900 mt-2 mb-2">Добавить изображение:</label>
                <input type="file" 
                  class="block w-full text-sm text-slate-500
                  file:mr-4 file:py-2 file:px-4
                  file:rounded-full file:border-0
                  file:text-sm file:font-semibold
                  file:bg-violet-50 file:text-violet-700
                  hover:file:bg-violet-100" 
                  @change="handleFileChange" 
                />
              <div class="mt-4">
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="saveBook"
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
import axiosClient from '../axios';
import SelectCategories from './SelectCategories.vue';

const { editName, editDescription, editYear, editImage, editSelectAuthor, id, edit, categories } = 
defineProps(['editName', 'editDescription', 'editYear', 'editImage', 'editSelectedCategories', 'editSelectAuthor', 'id', 'edit', 'categories']);

const name = ref(editName || '');
const description = ref(editDescription || '');
const isOpen = ref(false);
const year = ref(editYear || '');
const image = ref(null);
const authors = ref('');
const selectedCategories = ref([]);
const selectAuthor = ref('');
const emit = defineEmits();

const handleFileChange = (event) => {
  image.value = event.target.files[0];
};

const handleYear = () => {
  year.value = year.value.replace(/\D/g, '').substring(0, 4);
};

function closeModal() {
  isOpen.value = false
};
function openModal() {
  isOpen.value = true
};

const getAuthors = async () => {
  const response = await axiosClient.get('/authors');
  authors.value = response.data;
};

getAuthors();

const saveBook = async () => {
  if (!image.value && !edit) {
    console.error('Файл не выбран');

    const allowedFormats = ['image/jpeg', 'image/png'];
    if (!allowedFormats.includes(image.value.type)) {
      console.error('Неверный формат файла. Допустимые форматы: JPG, JPEG, PNG.');
      return;
    }
  }

  const formData = new FormData();
  formData.append('image', image.value);
  formData.append('name', name.value);
  formData.append('description', description.value);
  formData.append('year', year.value);
  formData.append('author_id', selectAuthor.value);
  formData.append('categories', selectedCategories.value);

  if(edit){
    const response = axiosClient.post(`/book/${id}/edit`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
  } else {
    const response = axiosClient.post('/book/create', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
  }
  closeModal();

};
</script>
