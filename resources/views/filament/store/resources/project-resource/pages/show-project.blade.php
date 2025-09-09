<x-filament-panels::page>
    @php
        $tasks = $project->tasks()->with('children')->where('parent_id', -1)->orderBy('order')->get();
        $project_tasks = $project->tasks()->orderBy('parent_id')->orderBy('order')->get();
        $gantt_tasks = $project_tasks->where('parent_id', '!=', -1)->map(function(\App\Models\Task $task){
            return [
                'id' => $task->id,
                'name' => $task->title,
                'start' => $task->start_date->format('Y-m-d'),
                'end' => $task->end_date->format('Y-m-d'),
                'progress' => $task->status === \App\Enums\ProjectTaskStatuses::COMPLETED ? 100 : 50,
            ];
        })->values();
        $completed_tasks_count = $project->completed_tasks->count();
        $tasks_count = $project->tasks->count();
        $progress = $project->tasks->count() > 0 ? $project->completed_tasks->sum('weight') / $project->tasks->sum('weight') * 100 : 0;
    @endphp
    <div x-data="{activeTab:'details'}">
        <x-filament::card>
            <x-filament::tabs class="mb-4">
                <x-filament::tabs.item alpine-active="activeTab === 'details'" @click="activeTab = 'details'">
                    Project Details
                </x-filament::tabs.item>
                <x-filament::tabs.item alpine-active="activeTab === 'tasks'" @click="activeTab = 'tasks'">
                    Tasks
                </x-filament::tabs.item>
                <x-filament::tabs.item alpine-active="activeTab === 'gantt'" @click="activeTab = 'gantt'">
                    Gantt Chart
                </x-filament::tabs.item>
                <x-filament::tabs.item alpine-active="activeTab === 'documents'" @click="activeTab = 'documents'">
                    Documents
                </x-filament::tabs.item>

            </x-filament::tabs>
            <div class="flex gap-4 flex-col sm:flex-row">
                <div x-show="activeTab=='details'" class="flex-1 px-2">
                    @include('extras.project-tasks.project-progress-details')
                </div>
                <div x-show="activeTab=='tasks'" class="flex-1 px-2">
                    @include('extras.project-tasks.project-tasks-list')
                </div>
            </div>
            <div x-show="activeTab=='gantt'">
                @include('extras.project-tasks.gantt')
            </div>
            <div x-show="activeTab=='documents'">
                @include('extras.project-tasks.documents')
            </div>
        </x-filament::card>
    </div>
    <div>
        <h3 class="mt-4 mb-2 font-semibold text-lg">Budget Estimates</h3>
        {{ $this->table }}
    </div>

    <div class="flex flex-col gap-8 sm:flex-row mt-6">
        <div class="sm:w-1/2">
            <div class="space-y-4">
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Budget
                        (PHP)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">₱</span>
                        </div>
                        <input
                            class="w-full rounded-lg border-gray-300 pl-7 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="budget"
                            type="number"
                            wire:model="budget"
                            min="100000"
                            step="10000"
                            required
                        />
                    </div>
                    @error('budget')
                    <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lot Dimensions -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="lotLength" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Lot
                            Length (m)</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="lotLength"
                            type="number"
                            wire:model.blur="lotLength"
                            min="5"
                            max="100"
                            required
                        />
                        @error('lotLength')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="lotWidth" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Lot
                            Width (m)</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="lotWidth"
                            type="number"
                            wire:model.blur="lotWidth"
                            min="5"
                            max="100"
                            required
                        />
                        @error('lotWidth')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Floor Dimensions -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="floorLength" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Floor
                            Length (m)</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="floorLength"
                            type="number"
                            wire:model.blur="floorLength"
                            min="3"
                            max="50"
                            required
                        />
                        @error('floorLength')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="floorWidth" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Floor
                            Width (m)</label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="floorWidth"
                            type="number"
                            wire:model.blur="floorWidth"
                            min="3"
                            max="50"
                            required
                        />
                        @error('floorWidth')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Building Specifications -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="numberOfRooms" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Number of Rooms
                        </label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="numberOfRooms"
                            type="number"
                            wire:model.blur="numberOfRooms"
                            min="1"
                            max="20"
                            required
                        />
                        @error('numberOfRooms')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="numberOfStories" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Number of Stories
                        </label>
                        <input
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            id="numberOfStories"
                            type="number"
                            wire:model.blur="numberOfStories"
                            min="1"
                            max="5"
                            required
                        />
                        @error('numberOfStories')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Area Summary -->
                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Lot Area:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $lotLength * $lotWidth }} sq.m</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Floor Area:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $floorLength * $floorWidth }} sq.m</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Project Description
                    </label>
                    <textarea
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        rows="7"
                        required
                        placeholder="Describe your construction project in detail. Include lot size, floor dimensions, number of rooms, stories, and budget. The AI will automatically extract specifications from your description..."
                        wire:model.blur="description"
                    ></textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Tip: Describe your project naturally. The AI will extract specifications like "20x30 meter lot",
                        "3 bedrooms", "2-story house", or "₱2M budget" from your description.
                    </p>
                    @error('description')
                    <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    <x-filament::button
                        class="w-full"
                        wire:click="parseDescription"
                        wire:loading.attr="disabled"
                        color="info"
                    >
                    <span wire:loading.remove wire:target="parseDescription">
                        Extract Specifications with AI
                    </span>
                        <span wire:loading wire:target="parseDescription">
                        Analyzing...
                    </span>
                    </x-filament::button>

                    <x-filament::button
                        class="w-full"
                        wire:click="estimate"
                        wire:loading.attr="disabled"
                        color="primary"
                    >
                    <span wire:loading.remove wire:target="estimate">
                        Generate Estimate
                    </span>
                        <span wire:loading wire:target="estimate">
                        Generating...
                    </span>
                    </x-filament::button>
                </div>
            </div>
        </div>

        @include('filament.store.resources.project-resource.pages.budget-estimate-details')
    </div>
</x-filament-panels::page>
