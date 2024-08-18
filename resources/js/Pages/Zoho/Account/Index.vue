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
            <h2 class="text-2xl font-semibold text-gray-800">Accounts</h2>
        </template>

        <Modal :show="isModalOpen" @close="closeModal">
            <div class="p-6">
                <EditAccountForm
                    v-if="selectedAccount"
                    :selected-account="selectedAccount"
                    @close="closeModal"
                />
            </div>
        </Modal>

        <div class="mx-auto max-w-7xl py-12 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <!-- Create Button -->
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Manage Your Accounts</h3>
                        <Link
                            class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-500 focus:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-blue-700"
                            :href="route('accounts.create')"
                        >
                            <v-icon class="mr-2" name="md-add" />
                            Create Account
                        </Link>
                    </div>

                    <div class="space-y-4">
                        <transition-group class="space-y-4" name="fade" tag="div">
                            <div
                                class="rounded-lg bg-gray-50 p-8 shadow-sm transition hover:bg-gray-100"
                                v-for="account in props.accounts"
                                :key="account.id"
                            >
                                <div class="justify flex items-center space-x-4">
                                    <!-- Account Name -->
                                    <h4
                                        class="w-1/4 text-center text-lg font-semibold text-gray-800"
                                    >
                                        {{ account.Account_Name }}
                                    </h4>

                                    <!-- Phone -->
                                    <p
                                        class="flex w-1/4 items-center justify-center text-sm text-gray-600"
                                    >
                                        <v-icon class="mr-2" name="md-call" />
                                        {{ account.Phone }}
                                    </p>

                                    <!-- Website -->
                                    <p
                                        class="flex w-1/4 items-center justify-center text-sm text-gray-600"
                                    >
                                        <v-icon class="mr-2" name="md-language" />
                                        {{ account.Website }}
                                    </p>

                                    <!-- Actions -->
                                    <div class="flex w-1/4 justify-center space-x-8">
                                        <button
                                            class="rounded-full border p-4 text-blue-600 transition duration-300 hover:bg-blue-600 hover:text-white"
                                            @click="openModal(account)"
                                        >
                                            <v-icon name="md-edit" />
                                        </button>
                                        <Link
                                            class="rounded-full border p-4 text-red-600 transition duration-300 hover:bg-red-600 hover:text-white"
                                            :href="route('accounts.destroy', account.id)"
                                            method="delete"
                                            as="button"
                                        >
                                            <v-icon name="md-delete" />
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </transition-group>
                    </div>
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
