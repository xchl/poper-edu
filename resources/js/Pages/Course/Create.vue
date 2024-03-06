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

defineProps({
    students: {
        type: Array,
    },
});
const form = useForm({
    name : '',
    year_month : '',
    course_fee : '',
    students : [],
});
const submit = () => {
    form.post(route('course.store'));
};
</script>

<template>
    <Head title="课程创建" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">课程创建</h2>
        </template>

        <div class="px-12 py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen bg-white py-8">
                <div class="max-w-3xl mx-auto px-10 py-12">
                        <form @submit.prevent="submit" class="flex flex-col space-y-7">
                            <div>
                                <InputLabel for="name" value="课程名" />

                                <TextInput
                                    id="username"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="year_month" value="年月(示例：202405)" />

                                <TextInput
                                    id="year_month"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.year_month"
                                    required
                                    autofocus
                                />

                                <InputError class="mt-2" :message="form.errors.year_month" />
                            </div>
                            <div>
                                <InputLabel for="course_fee" value="费用" />

                                <TextInput
                                    id="course_fee"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.course_fee"
                                    required
                                    autofocus
                                />

                                <InputError class="mt-2" :message="form.errors.course_fee" />
                            </div>
                            <div>
                                <InputLabel for="students" value="学生" />
                                <div class="flex space-x-2 mt-2">
                                    <Checkbox
                                        v-for="student in students"
                                        v-model:checked="form.students" :label="student.name" :value="student.id" />
                                </div>

                                <InputError class="mt-2" :message="form.errors.students" />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    保存
                                </PrimaryButton>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
