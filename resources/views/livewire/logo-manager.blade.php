<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="space-y-4">
        @if($currentLogo)
            <div>
                <h3 class="text-lg font-medium">Current Logo</h3>
                <img src="{{ $currentLogo }}" alt="Company Logo" class="h-20 w-20">
            </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700">Upload New Logo</label>
            <input type="file" wire:model="logo" class="mt-1">
        </div>

        <button wire:click="saveLogo" class="bg-pink-500 text-white px-4 py-2 rounded">
            Save Logo
        </button>
    </div>
</div>