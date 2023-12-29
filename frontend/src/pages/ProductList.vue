<template>
  <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-2 lg:max-w-7xl lg:px-8">
      <h2 class="sr-only">Products</h2>

      <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 xl:gap-x-8">
        <a v-for="book in books.data" :key="book.id" :href="book.href" class="group">
          <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
            <img :src="book.image" :alt="book.image" class="h-full w-full object-cover object-center group-hover:opacity-75" />
          </div>
          <h3 class="mt-4 text-sm text-gray-700">{{ book.name }}</h3>
          <p class="mt-1 text-lg font-medium text-gray-900">{{ book.author }}</p>
        </a>
      </div>

    </div>
    <div class="flex justify-center">
      <TailwindPagination
        class="mt-12 col-span-3"
        :data="books"
        @pagination-change-page="getResults"
      />
    </div>
  </div>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import { useRoute } from 'vue-router';
import { watchEffect } from 'vue';
import axiosClient from '../axios';

const route = useRoute();
const books = ref([]);

const getResults = async (page = 1) => {
    const response = await axiosClient.get('/books', {
                    params: {
                        page: page,
                        category_id: route.params.category_id,
                    },
                  });
    books.value = response.data;
    console.log(books);
  };

watchEffect(() => {
  getResults();
});

</script>