<x-splade-modal>
    <x-splade-form :default="$user" class="p-4 space-y-2" action="{{ route('admin.users.update', $user) }}"
        method="PUT">
        <x-splade-input name="name" label="Name" />
        <x-splade-input name="email" label="Email address" />
        <x-splade-input name="password" label="Password" />
        <x-splade-select name="role" :options="$roles" label="Role" option-label="role" option-value="role" />
        <x-splade-submit />
    </x-splade-form>
</x-splade-modal>