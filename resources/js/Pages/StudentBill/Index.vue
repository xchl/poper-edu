<script setup>

import LinkButton from "@/Components/LinkButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";


defineProps({
    courses: {
        type: Object,
    },
});
const form = useForm({
    courseId : 0,
});
const pay = (courseId) => {
    form.courseId = courseId;
    form.post(route('student-bill.pay'));
}
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
    <Head title="我的账单" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">我的账单</h2>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen bg-white py-8">
                <div class="bg-white shadow-sm sm:rounded-lg ">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-5">
                        <thead class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                账单 ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                课程名
                            </th>
                            <th scope="col" class="px-6 py-3">
                                教师
                            </th>
                            <th scope="col" class="px-6 py-3">
                                费用
                            </th>
                            <th scope="col" class="px-6 py-3">
                                付款状态
                            </th>
                            <th scope="col" class="px-6 py-3">
                            </th>
                        </tr>
                        <tr
                            class="bg-white text-sm border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            v-for="course in courses.data"
                            :key="course.id"
                        >
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{course.id}}
                            </th>
                            <td class="px-6 py-4">
                                {{course.course_name}}
                            </td>
                            <td class="px-6 py-4">
                                {{course.teacher}}
                            </td>
                            <td class="px-6 py-4">
                                {{course.course_fee}}
                            </td>
                            <td class="px-6 py-4">
                                {{getBillStatus(course.bill_status)}}
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    v-if="course.need_pay"
                                    v-on:click="pay(course.id)"
                                    type="button"
                                    :disabled="form.processing"
                                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                                >付款</button>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-5">
                    <Pagination x-if :links="courses.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
