<x-admin-layout>
    <x-splade-form :default="$user" class="p-4 space-y-2">
        <x-splade-input name="name" label="Name" />
        <x-splade-input name="email" label="Email address" /> 
        <x-splade-input name="password" label="Password" /> 
        <x-splade-select name="role" :options="$userRole" label="Role"  option-label="role" option-value="id"  />
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
