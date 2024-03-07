<script setup>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import LinkButton from "@/Components/LinkButton.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    courseBills: {
        type: Object,
    },
});
const getBillStatus = (status) => {
    switch (status) {
        case 1:
            return '已创建';
        case 2:
            return '发送中';
        case 3:
            return '已发送';
        default:
            return '未知';
    }
}

</script>

<template>
    <Head title="账单管理" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">账单管理</h2>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen bg-white py-8">
                <div class="bg-white shadow-sm sm:rounded-lg ">
                    <div class="flex justify-end">
                        <LinkButton  :href="route('course-bill.create')">创建账单</LinkButton>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-5">
                        <thead class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                名称
                            </th>
                            <th scope="col" class="px-6 py-3">
                                状态
                            </th>
                            <th scope="col" class="px-6 py-3">
                            </th>
                        </tr>
                        <tr
                            class="bg-white text-sm border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            v-for="bill in courseBills.data"
                            :key="bill.id"
                        >
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{bill.name}}
                            </th>
                            <td class="px-6 py-4">
                                {{getBillStatus(bill.bill_status)}}
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-5">
                    <Pagination x-if :links="courseBills.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
