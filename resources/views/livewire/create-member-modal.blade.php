<div>
    @if($showModal)
        <div class="fixed inset-0 z-[9999] overflow-y-auto bg-black bg-opacity-50 backdrop-blur-sm">
            <div class="flex items-center justify-center min-h-screen p-4">
                <!-- Modal backdrop with click to close -->
                <div class="fixed inset-0" wire:click="closeModal"></div>

                <!-- Modal container -->
                <div class="relative bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all duration-300 ease-in-out">
                    <!-- Modal header -->
                    <div class="px-6 py-4 border-b bg-gray-50 rounded-t-xl">
                        <h3 class="text-xl font-semibold text-gray-800">New Member</h3>
                        <button wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="create">
                        <div class="px-6 py-4 space-y-4">
                            {{ $this->form }}
                        </div>

                        <!-- Modal footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t rounded-b-xl flex justify-end space-x-3">
                            <button 
                                type="button" 
                                wire:click="closeModal" 
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                            >
                                Create Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>