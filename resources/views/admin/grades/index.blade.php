<x-admin-layout>

        <div class="flex justify-between">
            <h1 class="text-2xl font-semibold p-4">Classes Index</h1>
            <div class="p-4">
                <Link href=""
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded text-white">New Grade</Link>
            </div>
        </div>
    
        <x-splade-table :for="$grades">
    
            
    
    
        </x-splade-table>
    
    
    
    </x-admin-layout>