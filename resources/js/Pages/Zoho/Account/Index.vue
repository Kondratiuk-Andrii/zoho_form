<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref, watchEffect } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import EditAccountForm from '@/Pages/Zoho/Account/Partials/EditAccountForm.vue';
    import { IAccount, IFlash } from '@/types';

    const props = defineProps<{
        accounts: IAccount[];
        flash: IFlash;
        isToken: boolean;
    }>();

    const selectedAccount = ref<IAccount | null>(null);

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
    /*
     */

    const isModalOpen = ref(false);

    const openModal = (account: IAccount) => {
        selectedAccount.value = account;
        isModalOpen.value = true;
    };

    const closeModal = () => {
        selectedAccount.value = null;
        isModalOpen.value = false;
    };
</script>

<template>
    <AuthenticatedLayout :is-token="props.isToken">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Accounts</h2>
        </template>
        
        <Modal :show="isModalOpen" @close="closeModal">
            <div>
                <EditAccountForm
                    v-if="selectedAccount"
                    :selected-account="selectedAccount"
                    @close="closeModal"
                />
            </div>
        </Modal>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="space-y-4 bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <!-- Create Button -->
                    <div class="flex justify-end">
                        <Link
                            class="rounded-xl bg-blue-500 px-4 py-2 text-white"
                            :href="route('accounts.create')"
                        >
                            Create Account
                        </Link>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Account Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Phone
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Website
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <transition-group name="fade" tag="tbody">
                            <tr v-for="account in props.accounts" :key="account.id">
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                    {{ account.Account_Name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                    {{ account.Phone }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                    {{ account.Website }}
                                </td>
                                <td
                                    class="flex space-x-4 whitespace-nowrap px-6 py-4 text-sm text-gray-900"
                                >
                                    <button
                                        class="text-blue-600 hover:text-blue-900"
                                        @click="openModal(account)"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 12H9m4 8H9m4-8H9m-4 4h10"
                                            />
                                        </svg>
                                        Edit
                                    </button>
                                    <Link
                                        class="text-red-600 hover:text-red-900"
                                        :href="route('accounts.destroy', account.id)"
                                        method="delete"
                                        as="button"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                        Delete
                                    </Link>
                                </td>
                            </tr>
                        </transition-group>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
        opacity: 0;
    }
</style>
