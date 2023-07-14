<x-guest-layout>
    <x-auth-card>
        <x-splade-form action="{{ route('role-registration.store') }}" class="space-y-4">
            <x-splade-select name="role" :label="__('Select your Role')" >
                <option value="STUDENT">Student</option>
                <option value="TEACHER">Teacher</option>
            </x-splade-select>
            <x-splade-select name="grade" :options="$grades" :label="__('Select your Grade (Optional for Teacher)')" option-label="name"  option-value="id" />
            <div class="flex items-center justify-end">
                <x-splade-submit class="ml-4" :label="__('Finish Register')" />
            </div>
        </x-splade-form>
    </x-auth-card>
</x-guest-layout>