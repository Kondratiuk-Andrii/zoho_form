<script setup lang="ts">
    import { Head } from '@inertiajs/vue3';
    import { Link } from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { onMounted, watchEffect } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { IFlash } from '@/types';

    const props = defineProps<{
        flash: IFlash;
        isToken: boolean;
    }>();

    watchEffect(() => {
        if (props.flash.message) {
            Swal.fire({
                title: props.flash.message.title,
                icon: props.flash.message.icon,
                toast: true,
                timer: 2500,
                position: 'top',
                timerProgressBar: true,
                showConfirmButton: false,
            });
        }
    });
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout :is-token="props.isToken">
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Welcome Section -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium">Welcome Back!</h3>
                        <p class="mt-1 text-sm text-gray-600">You're logged in successfully.</p>
                    </div>
                </div>

                <!-- Zoho Authorization Section -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium">Get Started with Zoho CRM</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Authorize your Zoho account to begin using the CRM features.
                        </p>
                        <a
                            class="mt-4 inline-block rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            v-if="!isToken"
                            href="http://localhost:8000/zoho/authorize"
                        >
                            Go to Zoho
                        </a>
                        <div class="flex items-center justify-between gap-5" v-else>
                            <p class="mt-4 text-sm text-gray-600">You are already authorized.</p>
                            <Link
                                class="mt-4 inline-block rounded-lg bg-red-500 px-4 py-2 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                :href="route('zoho.logout')"
                            >
                                Logout
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
