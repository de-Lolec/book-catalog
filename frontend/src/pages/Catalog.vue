<template>
  <div class="bg-white">
    <div>
      <!-- Mobile filter dialog -->
      <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog as="div" class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
          <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-black bg-opacity-25" />
          </TransitionChild>

          <div class="fixed inset-0 z-40 flex">
            <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                <div class="flex items-center justify-between px-4">
                  <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                  <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400" @click="mobileFiltersOpen = false">
                    <span class="sr-only">Close menu</span>
                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                  </button>
                </div>

                <!-- Filters -->
                <form class="mt-4 border-t border-gray-200">
                  <h3 class="sr-only">Categories</h3>
              
                  <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                    <li v-for="category in categories" :key="category.title">
                      <a :href="category.href" class="block px-2 py-3">{{ category.title }}</a>
                    </li>
                  </ul>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-baseline border-b border-gray-200 pb-6 pt-24">
          <h1 class="text-4xl font-bold tracking-tight text-gray-900">{{ findTitleById( $route.params.category_id) }}</h1>
          <BookForm
          :categories="categories"
          >
            <h4 v-if="user && user.is_admin" class="ml-10 cursor-pointer">Добавить книгу</h4>
          </BookForm>
          <AuthorForm>
            <h4 v-if="user && user.is_admin" class="ml-10 cursor-pointer">Добавить автора</h4>
          </AuthorForm>
          <div class="flex items-center">
            <button type="button" class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden" @click="mobileFiltersOpen = true">
              <span class="sr-only">Filters</span>
              Категории
            </button>
          </div>
        </div>

        <section aria-labelledby="products-heading" class="pb-24 pt-6">
          <h2 id="products-heading" class="sr-only">Products</h2>
          <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            <!-- Filters -->
            <form class="hidden lg:block">
              <h3 class="sr-only">Categories</h3>

              <ul role="list" class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">
                <CategoryForm 
                  v-if="user && user.is_admin"
                  @categoryUpdate="getCategories" 
                >
                  <h4 class="cursor-pointer mb-2">
                    Добавить категорию
                  </h4>
                </CategoryForm>
                <li v-for="category in categories" :key="category.title">
                  <CategoryForm 
                    v-if="user && user.is_admin"
                    :edit="true"
                    :id="category.id"
                    :editTitle="category.title"
                    :editDescription="category.description"
                    @categoryUpdate="getCategories" 
                  >
                    <PencilIcon 
                      v-if="user && user.is_admin" 
                      class="h4 w-4 inline cursor-pointer mr-2"
                    />
                  </CategoryForm>
                  
                  <TrashIcon 
                    v-if="user && user.is_admin" 
                    class="h4 w-4 inline cursor-pointer mr-2"
                    @click="deleteCategory(category.id)"
                  />
                  <router-link 
                    :to="`/catalog/category/${category.id}`">
                    {{ category.title }}
                  </router-link>
                </li>
              </ul>
            </form>
          
            <!-- Book grid -->
            <div class="lg:col-span-3">
              <product-list
              :categories="categories"
              />
            </div>
            <TailwindPagination
                :data="categories"
                @pagination-change-page="getResults"
            />
          </div>
        </section>
      </main>
    </div>
  </div>

</template>

<script setup>
import { ref } from 'vue';
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';
import { XMarkIcon, TrashIcon, PencilIcon } from '@heroicons/vue/24/outline';
import { useRoute } from 'vue-router';
import { useStore } from "vuex";
import { TailwindPagination } from 'laravel-vue-pagination';
import ProductList from './ProductList.vue';
import axiosClient from '../axios';
import { computed } from 'vue';
import CategoryForm from '../components/CategoryForm.vue';
import BookForm from '../components/BookForm.vue';
import AuthorForm from '../components/AuthorForm.vue';

const route = useRoute();
const store = useStore();

const categories = ref([]);

const getCategories = async() => {
  const response = await axiosClient.get("/categories");
  categories.value = response.data;
}


getCategories();

const findTitleById = (id) => {
  const category = categories.value.find(category => category.id == id);
  return category ? category.title : 'Каталог';
};

const user = computed(() => store.state.user.data);
console.log(user);

const deleteCategory = async (id) => {
  axiosClient.post(`/category/${id}/delete`, {
      id: id,
    })
    .then(response => {
      getCategories()
    }, error => {
      console.error('Error delete category:', error.message);
    });
};

const mobileFiltersOpen = ref(false)
</script>