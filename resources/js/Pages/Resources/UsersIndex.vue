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
            @click="confirmUserDeletion('delete')"
        >
            Delete Account
        </DangerButton>
        <DangerButton
            class=""
            @click="confirmUserDeletion('destroy')"
        >
            Destroy Account
        </DangerButton>
    </div>
    <Modal :show="confirmingUserDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ warningTitle }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ warningText }}
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <NavLink :href="actionValue" method="delete" as="button" class="ml-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Delete Account
                </NavLink>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import { ref } from "vue";
import NavLink from '@/Components/NavLink.vue';
import DangerButton from '@/Components/DangerButton.vue';
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
const actionValue = ref()
const warningText = ref()
const warningTitle = ref()

const deleteUser = () => {
    confirmingUserDeletion.value = false;
};

const destroyUser = () => {
    confirmingUserDeletion.value = false;
    route('user.destroy', [props.user.id])
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
};

const confirmUserDeletion = (action) => {
    handleAction(action)
    confirmingUserDeletion.value = true;
};

function handleAction(action) {
    switch (action) {
        case 'delete':
            warningTitle.value = "Are you sure you want to soft delete this account?"
            warningText.value = "This is a soft delete. Account's resources are not deleted"
            actionValue.value = route('user.delete', [props.user.id])
            confirmingUserDeletion.value = false
            break
        case 'destroy':
            warningTitle.value = "Are you sure you want to destroy this account?"
            warningText.value = "Once this account is destroyed, all of its resources and data will be permanently deleted"
            actionValue.value = route('user.destroy', [props.user.id])
            confirmingUserDeletion.value = false;
    }
}
</script>
