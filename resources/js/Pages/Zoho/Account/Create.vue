<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

    const props = defineProps<{
        isToken: boolean;
    }>();

    const form = useForm<{
        accountName: string;
        phone: string;
        website: string;
    }>({
        accountName: '',
        phone: '',
        website: '',
    });
</script>

<template>
    <AuthenticatedLayout :is-token="props.isToken">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create Account</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <form @submit.prevent="form.post(route('accounts.store'))">
                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    for="accountName"
                                >
                                    Account Name
                                </label>
                                <input
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    id="accountName"
                                    v-model="form.accountName"
                                    placeholder="Commercial Press (Sample)"
                                    type="text"
                                />
                                <InputError class="0 mt-2" :message="form.errors.accountName" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="phone">
                                    Phone
                                </label>
                                <input
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    id="phone"
                                    v-model="form.phone"
                                    placeholder="+1234567891"
                                    type="text"
                                />
                                <InputError class="0 mt-2" :message="form.errors.phone" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    for="website"
                                >
                                    Website
                                </label>
                                <input
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    id="website"
                                    v-model="form.website"
                                    placeholder="https://example.com"
                                    type="text"
                                />
                                <InputError class="0 mt-2" :message="form.errors.website" />
                            </div>
                            <div class="flex justify-end">
                                <button
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    type="submit"
                                >
                                    Create Account
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
