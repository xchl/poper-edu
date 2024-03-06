<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, router,usePage } from '@inertiajs/vue3';
import { reactive } from 'vue'


const { version } = usePage();

defineProps({
    grandOptions: {
        type: Object,
    },
});

const form = reactive({
    grand: '',
    username: '',
    password: '',
    processing: false,
    errors: {
        grand: '',
        username: '',
        password: '',
    },
    errorMessage: '',
});

const submit = () => {
    form.processing = true;
    form.errorMessage = '';
    axios.post('oauth/token',{
        // headers: {
        //     'X-Inertia': true,
        //     'X-Inertia-Partial-Component': 'User/index',
        //     'X-Inertia-Partial-Data': 'users',
        //     'X-Inertia-Version': version.value,
        // },
        grand : form.grand,
        username : form.username,
        password : form.password,
    }).then((res) => {
        router.visit('/', { method: 'get' })
    }).catch((error) => {
        form.errorMessage = error.response.data.message;
    }).finally(()=>{
        form.processing = false;
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="form.errorMessage" class="mb-4 font-medium text-sm text-red-500">
            {{ form.errorMessage }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="" value="请选择" class="mb-1" />
                <div class="flex justify-between gap-2 mb-3">
                    <div
                        v-for="(value, key, index) in grandOptions"
                        :key="index"
                        class="flex w-1/2 items-center ps-4 border border-gray-200 rounded dark:border-gray-700"
                    >
                        <input :id="'bordered-radio-'+key" required v-model="form.grand" type="radio" :value="key" name="bordered-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label :for="'bordered-radio-'+key" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{value}}</label>
                    </div>
                </div>
            </div>

            <div>
                <InputLabel for="username" value="用户名" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="密码" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    登录
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
