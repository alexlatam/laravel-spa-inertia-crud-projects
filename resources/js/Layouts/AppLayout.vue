<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import PrimaryNavigationMenu from '@/Components/PrimaryNavigationMenu.vue';
import ResponsiveNavigationMenu from '../Components/ResponsiveNavigationMenu.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <Head :title="title" />
        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <PrimaryNavigationMenu  :showingNavigationDropdown="showingNavigationDropdown" />

                <!-- Responsive Navigation Menu -->
                <ResponsiveNavigationMenu :showingNavigationDropdown="showingNavigationDropdown" />
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <!-- Aqui esta el elemento para las sesiones flash que indicaran success -->
                <!-- Esta propieddad flash fue agregada en el archivo AppServiceProvider -->
                <div class="py-4" v-if="$page.props.flash.success">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">                            <span class="block sm:inline">{{ $page.flahs.success }}</span>
                        </div>
                    </div>
                </div>
                <slot />
            </main>
        </div>
    </div>
</template>
