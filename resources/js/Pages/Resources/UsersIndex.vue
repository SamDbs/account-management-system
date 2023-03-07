<template>
    <div class="flex">
        {{ user.id }}
        {{ user.name }}
        {{ user.email }}
        {{ user.description }}
        {{ user.phone }}
        <NavLink :href="route('user.edit', [user.id])" method="get" as="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Edit
        </NavLink>
        <DangerButton
            class=""
            @click="confirmUserDeletion"
        >
            Delete Account
        </DangerButton>
        <PrimaryButton>
            Destroy
        </PrimaryButton>
    </div>
    <Modal :show="confirmingUserDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Are you sure you want to delete this account?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will be permanently deleted. Please
                enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="deleteUser"
                >
                    Delete Account
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from '@/Components/NavLink.vue';
import DangerButton from '@/Components/DangerButton.vue';
import {nextTick, ref} from "vue";
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    status: {
        type: String,
        default: '',
    }
});

const confirmingUserDeletion = ref(false);

const deleteUser = () => {
    confirmingUserDeletion.value = false;
    route('user.destroy', [props.user.id])
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
};

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};
</script>
