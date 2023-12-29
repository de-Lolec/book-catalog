<template>
  <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
            <span class="absolute -inset-0.5" />
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div class="flex flex-shrink-0 items-center">
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />
          </div>
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <router-link 
              :to="`/catalog`"
              class='text-gray-300 hover:bg-gray-700 hover:text-white cursor-pointer'
              :class="[true ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" 
              >Каталог</router-link>
            </div>
          </div>
        </div>
        <div>
          <h2 class="text-white mr-4 inline" v-if="user">{{ user.name}}</h2>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
          <!-- Profile dropdown -->
          <Menu as="div" class="relative ml-3">
            <span class="sr-only">Open user menu</span>
              <div v-if="user">
                <h2 class="text-white inline" @click="logout">Выйти</h2>
              </div>
              <div v-else>
                <router-link :to="`/login`" class="text-white inline mr-10 cursor-pointer" >Войти</router-link>
                <router-link :to="`/register`" class="text-white inline cursor-pointer">Зарегистрироваться</router-link>
              </div>
          </Menu>
        </div>
      </div>
    </div>

    <DisclosurePanel class="sm:hidden">
      <div class="space-y-1 px-2 pb-3 pt-2">
        <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>
  
<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { computed } from 'vue';

const navigation = [
  { name: 'Каталог', href: '/catalog', current: true },
]

const store = useStore();
const router = useRouter();

const user = computed(() => store.state.user.data);

store.dispatch("getUser");

function logout() {
  store.dispatch("logout").then(() => {
    router.push({
      name: "Login",
    });
    store.dispatch("getUser");
  });
}
</script>