<template>
  <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-2 lg:max-w-7xl lg:px-8">
      <h2 class="sr-only">Products</h2>

      <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 xl:gap-x-8">
        <a v-for="book in books.data" :key="book.id" :href="book.href" class="group cursor-pointer">
        <router-link :to="`/catalog/book/${book.id}`" class="group cursor-pointer">
          <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
            <img :src="book.image" :alt="book.image" class="h-full w-full object-cover object-center group-hover:opacity-75" />
          </div>
          <h3 class="mt-4 text-m text-gray-700">{{ book.name }}</h3>
          <h4 class="mt-4 text-sm text-gray-700">{{ book.author.name }}</h4>
        </router-link>
        
          <BookForm
          :edit="true"
          :id="book.id"
          :editName="book.name"
          :editDescription="book.description"
          :editYear="book.year"
          :editImage="book.image"
          :editSelectAuthor="book.author"
          :categories="categories"
          v-if="user && user.is_admin"
          >
          <p class="cursor-pointer">Изменить</p>
          </BookForm>
          <p @click="deleteBook(book.id)" class="cursor-pointer" v-if="user && user.is_admin">Удалить</p>
        </a>
      </div>
    </div>
    <div class="flex justify-center">
      <TailwindPagination
        class="mt-12 col-span-3"
        :data="books"
        @pagination-change-page="getBooks"
      />
    </div>
  </div>

</template>

<script setup>
import { ref, computed } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import { useRoute } from 'vue-router';
import { useStore } from "vuex";
import { watchEffect } from 'vue';
import BookForm from '../components/BookForm.vue';
import axiosClient from '../axios';
const { categories } = defineProps(['categories']);

const store = useStore();
const route = useRoute();
const books = ref([]);

const user = computed(() => store.state.user.data);

const getBooks = async (page = 1) => {
  const response = await axiosClient.get('/books', {
                params: {
                  page: page,
                  category_id: route.params.category_id,
              },
            });
  books.value = response.data;
};

const deleteBook = async (id) => {
  axiosClient.post(`/book/${id}/delete`, {
      id: id,
    })
    .then(response => {
      getBooks()
    }, error => {
      console.error('Error delete book:', error.message);
    });
};

watchEffect(() => {
  getBooks();
});

</script>