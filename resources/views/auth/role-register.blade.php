<x-guest-layout>
    <x-auth-card>
        <x-splade-form action="{{ route('role-registration.store') }}" class="space-y-4">
            <x-splade-select name="role" :label="__('Select your Role')" >
                <option value="STUDENT">Student</option>
                <option value="TEACHER">Teacher</option>
            </x-splade-select>
            <x-splade-select name="grade" :label="__('Select your Grade (Optional for Teacher)')">
                <option value="1">Grade-I</option>
                <option value="2">Grade-II</option>
                <option value="3">Grade-III</option>
                <option value="4">Grade-IV</option>
                <option value="5">Grade-V</option>
            </x-splade-select>
            <div class="flex items-center justify-end">
                <x-splade-submit class="ml-4" :label="__('Finish Register')" />
            </div>
        </x-splade-form>
    </x-auth-card>
</x-guest-layout>