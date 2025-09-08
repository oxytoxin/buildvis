<div class="overflow-x-auto">
    <h3 class="text-lg font-semibold mb-2">Project Tasks</h3>
    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Task
            </th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Weight
            </th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Status
            </th>
            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Start Date
            </th>
            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                End Date
            </th>
        </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($tasks as $task)
            <tr>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $task->title }}</td>
                <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $task->weight }}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                    <span @class([
                                        'px-2 py-1 text-xs rounded-full',
                                        'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' => $task->status === \App\Enums\ProjectTaskStatuses::COMPLETED,
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' => $task->status !== \App\Enums\ProjectTaskStatuses::COMPLETED,
                                    ])>
                                        {{ $task->status === \App\Enums\ProjectTaskStatuses::COMPLETED ? 'Completed' : 'Pending' }}
                                    </span>
                </td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-right">{{ $task->start_date->format('M d, Y') }}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-right">{{ $task->end_date->format('M d, Y') }}</td>
            </tr>
            @foreach($task->children as $child)
                <tr>
                    <td class="px-12 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $child->title }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-900 dark:text-gray-100">{{ $child->weight }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                                    <span @class([
                                        'px-2 py-1 text-xs rounded-full',
                                        'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' => $child->status === \App\Enums\ProjectTaskStatuses::COMPLETED,
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' => $child->status !== \App\Enums\ProjectTaskStatuses::COMPLETED,
                                    ])>
                                        {{ $child->status === \App\Enums\ProjectTaskStatuses::COMPLETED ? 'Completed' : 'Pending' }}
                                    </span>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-right">{{ $child->start_date->format('M d, Y') }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-right">{{ $child->end_date->format('M d, Y') }}</td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="3" class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 text-center">No
                    tasks found
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
