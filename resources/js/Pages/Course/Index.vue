<script setup>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import LinkButton from "@/Components/LinkButton.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    courses: {
        type: Object,
    },
});
</script>

<template>
    <Head title="课程管理" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">课程管理</h2>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen bg-white py-8">
                <div class="bg-white shadow-sm sm:rounded-lg ">
                    <div class="flex justify-end">
                        <LinkButton  :href="route('course.create')">创建课程</LinkButton>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-5">
                        <thead class="text-xl text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                课程名称
                            </th>
                            <th scope="col" class="px-6 py-3">
                                年月
                            </th>
                            <th scope="col" class="px-6 py-3">
                                费用
                            </th>
                            <th scope="col" class="px-6 py-3">
                                学生
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            v-for="course in courses.data"
                            :key="course.id"
                        >
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{course.name}}
                            </th>
                            <td class="px-6 py-4">
                                {{course.year_month}}
                            </td>
                            <td class="px-6 py-4">
                                {{course.course_fee}}
                            </td>
                            <td class="px-6 py-4">
                                {{course.students.join(',')}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-5">
                    <Pagination :links="courses.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
