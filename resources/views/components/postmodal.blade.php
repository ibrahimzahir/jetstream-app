<x-jet-dialog-modal wire:model="showModalForm">
    <x-slot name="title">Create Post</x-slot>
    <x-slot name="content">
        <div class="space-y-8 divide-y divide-gray-200  mt-10">
            <form enctype="multipart/form-data">
                <div class="sm:col-span-6">
                    <label for="title" class="block text-sm font-medium text-xl text-gray-700"> Post Title </label>
                    <div class="mt-1">
                        <input type="text" id="title" wire:model.lazy="title" name="title"
                            class="block w-full transition duration-150 ease-in-out appearance-none bg-white border-2 border-gray-300 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    @error('title') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="sm:col-span-6">
                    <div class="w-full m-2 p-2">
                        @if ($newImage)
                        Post Photo:
                        <img src="{{ asset('storage/photos/'. $newImage ) }}">
                        @endif
                        @if ($image)
                        Photo Preview:
                        <img src="{{ $image->temporaryUrl() }}">
                        @endif
                    </div>
                    <label for="title" class="block text-sm font-medium  text-xl text-gray-600"> Post Image </label>
                    <div class="mt-1">
                        <input type="file" id="image" wire:model="image" name="image"
                            class="block w-full transition duration-150 ease-in-out appearance-none bg-white border-2 border-gray-300 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    @error('image') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="sm:col-span-6 pt-5">
                    <label for="body" class="block text-sm font-medium text-xl text-gray-600">Body</label>
                    <div class="mt-1">
                        <textarea id="body" rows="3" wire:model.lazy="body"
                            class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border-2 border-gray-300 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                    @error('body') <span class="error">{{ $message }}</span> @enderror
                </div>
            </form>
        </div>
    </x-slot>
    <x-slot name="footer">
        @if($postId)
        <x-jet-button wire:click="updatePost">Update</x-jet-button>
        @else
        <x-jet-button wire:click="storePost">Store</x-jet-button>
        @endif
    </x-slot>
</x-jet-dialog-modal>