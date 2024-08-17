<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';
    import { defineProps } from 'vue';
    import InputError from '@/Components/InputError.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { IAccount } from '@/types';

    const props = defineProps<{
        accounts: IAccount[];
        isToken: boolean;
    }>();

    const form = useForm<{
        dealName: string;
        stage: string;
        accountId: string;
    }>({
        dealName: '',
        stage: '',
        accountId: '',
    });
</script>

<template>
    <AuthenticatedLayout :is-token="props.isToken">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create Deal</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <form @submit.prevent="form.post(route('deals.store'))">
                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    for="dealName"
                                >
                                    Deal Name
                                </label>
                                <input
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    id="dealName"
                                    v-model="form.dealName"
                                    placeholder="Commercial Press"
                                    type="text"
                                />
                                <InputError class="mt-2" :message="form.errors.dealName" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="stage">
                                    Stage
                                </label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    id="stage"
                                    v-model="form.stage"
                                >
                                    <option value="" disabled>Select Stage</option>
                                    <option value="Qualification">Qualification</option>
                                    <option value="Needs Analysis">Needs Analysis</option>
                                    <option value="Value Proposition">Value Proposition</option>
                                    <option value="Identify Decision Makers">
                                        Identify Decision Makers
                                    </option>
                                    <option value="Proposal/Price Quote">
                                        Proposal/Price Quote
                                    </option>
                                    <option value="Negotiation/Review">Negotiation/Review</option>
                                    <option value="Closed Won">Closed Won</option>
                                    <option value="Closed Lost">Closed Lost</option>
                                    <option value="ClosedLost to Competition">
                                        ClosedLost to Competition
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.stage" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    for="accountName"
                                >
                                    Account Name
                                </label>
                                <select
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    id="accountName"
                                    v-model="form.accountId"
                                >
                                    <option value="" disabled>Select Account</option>
                                    <option
                                        v-for="account in props.accounts"
                                        :key="account.id"
                                        :value="account.id"
                                    >
                                        {{ account.Account_Name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.accountId" />
                            </div>

                            <div class="flex justify-end">
                                <button
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    type="submit"
                                >
                                    Create Deal
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
