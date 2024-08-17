<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import { IAccount } from '@/types';

    const props = defineProps<{
        selectedAccount: IAccount;
    }>();

    const emit = defineEmits(['close']);

    const form = useForm<{
        accountName: string;
        phone: string;
        website: string;
    }>({
        accountName: props.selectedAccount.Account_Name,
        phone: props.selectedAccount.Phone,
        website: props.selectedAccount.Website,
    });
</script>

<template>
    <div class="p-6">
        <h2 class="text-center text-lg font-medium text-gray-900">Updating an Account</h2>
        <form
            @submit.prevent="
                form.patch(route('accounts.update', selectedAccount.id), {
                    onSuccess: () => emit('close'),
                })
            "
        >
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="accountName">
                        Account Name
                    </label>
                    <input
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        id="accountName"
                        v-model="form.accountName"
                        type="text"
                    />
                    <InputError class="0 mt-2" :message="form.errors.accountName" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="phone">Phone</label>
                    <input
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        id="phone"
                        v-model="form.phone"
                        type="text"
                    />
                    <InputError class="0 mt-2" :message="form.errors.phone" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700" for="website">
                        Website
                    </label>
                    <input
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        id="website"
                        v-model="form.website"
                        type="text"
                    />
                    <InputError class="0 mt-2" :message="form.errors.website" />
                </div>
                <div class="flex justify-end">
                    <button
                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        type="submit"
                    >
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
