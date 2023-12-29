<template>
  <div class="bg-white">
    <div class="pt-6">

      <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
        <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
          <img :src="book.image" :alt="book.image" class="h-full w-full object-cover object-center" />
        </div>
      </div>

      <div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
        <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
          <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ book.name }}</h1>
        </div>
        <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
          <div>
            <h2 class="text-2xl">Категории:</h2>
            <p v-for="category in book.categories">{{ category.title }}</p>
            <h2 class="text-2xl">Описание:</h2>
            <div class="space-y-6">
              <p class="text-base text-gray-900">{{ book.description }}</p>
            </div>
            <p class="mt-4 italic">Автор: {{ book.author.name }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axiosClient from '../axios';
import { useRoute } from 'vue-router';

const route = useRoute();
const book = ref('');
const book_id = ref(route.params.book_id);

const getBook = async () => {
  const response = await axiosClient.get(`/book/${book_id.value}`);
  book.value = response.data;
};

getBook();
</script>