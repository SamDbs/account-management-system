<template>
    <div class="m-10">
        <table class="w-full w-fulltext-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr class="text-center">
                    <th scope="col" class="w-30 text-center p-3">
                        Id
                    </th>
                    <th scope="col" class="w-30 text-center">
                        Name
                    </th>
                    <th scope="col" class="w-30 text-center">
                        Email
                    </th>
                    <th scope="col" class="w-20 text-center">
                        Description
                    </th>
                    <th scope="col" class="w-30 text-center">
                        Phone
                    </th>
                    <th scope="col" class="w-30 text-center">
                        Deleted
                    </th>
                    <th scope="col" class="w-30 text-center">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b text-center">
                    <td class="py-4"> {{ user.id }} </td>
                    <td class="py-4"> {{ user.name }} </td>
                    <td class="py-4"> {{ user.email }} </td>
                    <td class="py-4 break-words"> {{ user.description ?? 'No description' }} </td>
                    <td class="py-4"> {{ user.phone }} </td>
                    <td class="py-4"> {{ user.deleted_at }} </td>
                    <td class="py-4 flex justify-center">
                        <!-- Edit link -->
                        <NavLink :href="route('user.edit', [user.id])" method="get" as="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit
                        </NavLink>

                        <!-- Delete modal -->
                        <DangerButton @click="confirmUserDeletion('delete')">
                            Delete Account
                        </DangerButton>

                        <!-- Destroy modal -->
                        <DangerButton @click="confirmUserDeletion('destroy')">
                            Destroy Account
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
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
                    Confirm
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
