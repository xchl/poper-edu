<script setup>

import LinkButton from "@/Components/LinkButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";


defineProps({
    details: {
        type: Object,
    },
});
const getBillStatus = (status) => {
    switch (status) {
        case 1:
            return '待付款';
        case 2:
            return '付款成功';
        case 3:
            return '付款中';
        default:
            return '未知';
    }
}
</script>

<template>
    <Head title="账单明细" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">账单明细</h2>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen bg-white py-8">
                <div class="bg-white shadow-sm sm:rounded-lg ">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-5">
                        <thead class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                学生账单 ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                课程名
                            </th>
                            <th scope="col" class="px-6 py-3">
                                费用
                            </th>
                            <th scope="col" class="px-6 py-3">
                                学生
                            </th>
                            <th scope="col" class="px-6 py-3">
                                付款状态
                            </th>
                        </tr>
                        <tr
                            class="bg-white text-sm border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            v-for="detail in details.data"
                            :key="detail.id"
                        >
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{detail.id}}
                            </th>
                            <td class="px-6 py-4">
                                {{detail.course_name}}
                            </td>
                            <td class="px-6 py-4">
                                {{detail.course_fee}}
                            </td>
                            <td class="px-6 py-4">
                                {{detail.student_name}}
                            </td>
                            <td class="px-6 py-4">
                                {{getBillStatus(detail.bill_status)}}
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-5">
                    <Pagination x-if :links="details.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
