<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import LinkButton from "@/Components/LinkButton.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {watch} from "vue";

const props = defineProps({
    courses: {
        type: Array,
    },
});
const form = useForm({
    course : 0,
});
let students = []
watch(
    () => form.course,
    (course) => {
        for (let key in props.courses) {
            if(props.courses[key].id===course){
                students = props.courses[key].students
                break;
            }
        }
    }
)

const submit = () => {
    form.post(route('course-bill.store'));
};
</script>

<template>
    <Head title="账单创建" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">账单创建</h2>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen bg-white py-8">
                <div class="max-w-3xl mx-auto px-10 py-12">
                        <form @submit.prevent="submit" class="flex flex-col space-y-7">
                            <div>
                                <InputLabel for="course" value="选择课程" />
                                <div class="flex space-x-2 mt-2">
                                    <select
                                        v-model="form.course"
                                        id="course"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected>请选择</option>
                                        <option
                                            v-for="course in courses"
                                            :value="course.id">{{course.name}}</option>
                                    </select>
                                </div>

                                <InputError class="mt-2" :message="form.errors.course" />
                            </div>
                            <div v-if="form.course">
                                <div class="mb-2 text-gray-900 dark:text-white">参加课程的学生：</div>
                                <ul v-if="students.length > 0" class="max-w-md space-y-1 text-gray-500 list-disc list-inside">
                                    <li v-for="stu in students">{{stu.name}}</li>
                                </ul>
                                <div v-else>
                                    <div class="pl-5 text-red-500 text-sm">该课程没有添加学生</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    发送
                                </PrimaryButton>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
