<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    courses: {
        type: Object,
    },
});
</script>

<template>
    <Head title="我的课程" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">我的课程</h2>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen bg-white py-8">
                <div class="bg-white shadow-sm sm:rounded-lg ">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-5">
                        <thead class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                课程名
                            </th>
                            <th scope="col" class="px-6 py-3">
                                教师
                            </th>
                            <th scope="col" class="px-6 py-3">
                                年月
                            </th>
                            <th scope="col" class="px-6 py-3">
                                费用
                            </th>
                        </tr>
                        <tr
                            class="bg-white text-sm border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            v-for="course in courses.data"
                            :key="course.id"
                        >
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{course.course_name}}
                            </th>
                            <td class="px-6 py-4">
                                {{course.teacher}}
                            </td>
                            <td class="px-6 py-4">
                                {{course.year_month}}
                            </td>
                            <td class="px-6 py-4">
                                {{course.course_fee}}
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
