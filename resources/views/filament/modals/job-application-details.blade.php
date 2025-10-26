<div class="p-4" id="modal-content-{{ $record->id }}" data-current-id="{{ $record->id }}"
    data-all-ids="{{ json_encode($allApplicationIds) }}">
    <!-- Navigation and Status Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex items-center justify-between mb-4">
            <!-- Navigation Arrows -->
            <div class="flex items-center gap-2">
                <button id="prev-application"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-all disabled:bg-gray-300 disabled:cursor-not-allowed"
                    style="background-color: #2563eb !important;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 px-3">
                    <span id="current-position"></span>
                </span>
                <button id="next-application"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-all disabled:bg-gray-300 disabled:cursor-not-allowed"
                    style="background-color: #2563eb !important;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <span class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-calendar-alt mr-1"></i>Applied {{ $record->created_at->format('M d, Y') }}
            </span>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    <i class="fas fa-tasks mr-2"></i>Application Status:
                </span>
                <select id="status-selector-{{ $record->id }}" data-record-id="{{ $record->id }}"
                    class="status-selector px-4 py-2 rounded-lg border-2 font-medium text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer
                        @if ($record->status === 'new') bg-blue-50 border-blue-300 text-blue-800 dark:bg-blue-900/30 dark:border-blue-600 dark:text-blue-200
                        @elseif($record->status === 'pending') bg-yellow-50 border-yellow-300 text-yellow-800 dark:bg-yellow-900/30 dark:border-yellow-600 dark:text-yellow-200
                        @elseif($record->status === 'accepted') bg-green-50 border-green-300 text-green-800 dark:bg-green-900/30 dark:border-green-600 dark:text-green-200
                        @else bg-red-50 border-red-300 text-red-800 dark:bg-red-900/30 dark:border-red-600 dark:text-red-200 @endif">
                    <option value="new" {{ $record->status === 'new' ? 'selected' : '' }}>New</option>
                    <option value="pending" {{ $record->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ $record->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ $record->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Job Information Card -->
    <div class="bg-blue-600 rounded-lg shadow-lg p-6 mb-10" ">
        <h3 class="text-2xl font-bold mb-3" style="color: black !important;">{{ $record->job->title }}</h3>
        <div class="flex flex-wrap gap-4" style="color: black !important;">
            <div class="flex items-center">
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>{{ $record->job->location }}</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-briefcase mr-2"></i>
                <span>{{ ucfirst(str_replace('-', ' ', $record->job->type)) }}</span>
            </div>
             @if ($record->job->salary_range)
        <div class="flex items-center">
            <i class="fas fa-dollar-sign mr-2"></i>
            <span>{{ $record->job->salary_range }}</span>
        </div>
        @endif
    </div>
</div>

<!-- Personal Information Card -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 mb-10">
    <div class="flex items-center mb-8">
        <div
            class="w-20 h-20 bg-blue-600 dark:bg-blue-700 rounded-full flex items-center justify-center text-white text-3xl font-bold mr-5 shadow-lg">
            {{ substr($record->full_name, 0, 1) }}
        </div>
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $record->full_name }}</h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Job Applicant</p>
        </div>
    </div>

    <!-- Contact Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Email Card -->
        <div
            class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-5 border-2 border-blue-300 dark:border-blue-600 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-2">
                <i class="fas fa-envelope text-blue-600 dark:text-blue-400 mr-2 text-lg"></i>
                <p class="text-xs font-bold text-blue-700 dark:text-blue-300 uppercase">Email</p>
            </div>
            <p class="text-sm font-semibold text-gray-900 dark:text-white break-all">{{ $record->email }}</p>
        </div>

        @if ($record->phone)
            <!-- Phone Card -->
            <div
                class="bg-green-50 dark:bg-green-900/30 rounded-lg p-5 border-2 border-green-300 dark:border-green-600 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-2">
                    <i class="fas fa-phone text-green-600 dark:text-green-400 mr-2 text-lg"></i>
                    <p class="text-xs font-bold text-green-700 dark:text-green-300 uppercase">Phone</p>
                </div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $record->phone }}</p>
            </div>
        @endif

        @if ($record->portfolio_link)
            <!-- Portfolio Card -->
            <div
                class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-5 border-2 border-purple-300 dark:border-purple-600 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-2">
                    <i class="fas fa-globe text-purple-600 dark:text-purple-400 mr-2 text-lg"></i>
                    <p class="text-xs font-bold text-purple-700 dark:text-purple-300 uppercase">Portfolio</p>
                </div>
                <a href="{{ $record->portfolio_link }}" target="_blank"
                    class="text-sm font-semibold text-purple-600 dark:text-purple-400 hover:underline flex items-center">
                    View Portfolio <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                </a>
            </div>
        @endif
    </div>
</div>



<!-- Cover Letter Card -->
@if ($record->cover_letter)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 mb-10">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-5 flex items-center">
            <i class="fas fa-file-alt mr-3 text-indigo-600 dark:text-indigo-400 text-2xl"></i>
            Cover Letter
        </h3>
        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 border-l-4 border-indigo-500 dark:border-indigo-400">
            <p class="text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap text-base">
                {{ $record->cover_letter }}</p>
        </div>
    </div>
@endif

<!-- Resume Card -->
@if ($record->resume_path)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6 mb-10">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-5 flex items-center">
            <i class="fas fa-file-pdf mr-3 text-blue-600 dark:text-blue-400 text-2xl"></i>
            Resume & Documents
        </h3>

        <a href="{{ asset('storage/' . $record->resume_path) }}" target="_blank"
            class="inline-flex items-center px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5"
            style="background-color: #2563eb !important; color: white !important; font-weight: bold;">
            <i class="fas fa-download mr-3 text-xl" style="color: white !important;"></i>
            Download Resume
        </a>
    </div>
@endif
</div>

<script>
    (function() {
        // Navigation functionality
        let currentId = parseInt(document.querySelector('[data-current-id]')?.getAttribute('data-current-id'));
        let allIds = JSON.parse(document.querySelector('[data-all-ids]')?.getAttribute('data-all-ids') || '[]');
        let currentIndex = allIds.indexOf(currentId);

        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prev-application');
            const nextBtn = document.getElementById('next-application');
            const positionSpan = document.getElementById('current-position');

            if (prevBtn && nextBtn && positionSpan) {
                prevBtn.disabled = currentIndex <= 0;
                nextBtn.disabled = currentIndex >= allIds.length - 1;
                positionSpan.textContent = `${currentIndex + 1} / ${allIds.length}`;
            }
        }

        function loadApplication(id) {
            window.location.reload();
        }

        // Initialize navigation
        updateNavigationButtons();

        // Previous button
        document.getElementById('prev-application')?.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                currentId = allIds[currentIndex];
                loadApplication(currentId);
            }
        });

        // Next button
        document.getElementById('next-application')?.addEventListener('click', function() {
            if (currentIndex < allIds.length - 1) {
                currentIndex++;
                currentId = allIds[currentIndex];
                loadApplication(currentId);
            }
        });

        // Use event delegation to handle status changes
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('status-selector')) {
                const newStatus = e.target.value;
                const recordId = e.target.getAttribute('data-record-id');

                // Update the selector colors based on status
                e.target.className =
                    'status-selector px-4 py-2 rounded-lg border-2 font-medium text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer';

                if (newStatus === 'new') {
                    e.target.className +=
                        ' bg-blue-50 border-blue-300 text-blue-800 dark:bg-blue-900/30 dark:border-blue-600 dark:text-blue-200';
                } else if (newStatus === 'pending') {
                    e.target.className +=
                        ' bg-yellow-50 border-yellow-300 text-yellow-800 dark:bg-yellow-900/30 dark:border-yellow-600 dark:text-yellow-200';
                } else if (newStatus === 'accepted') {
                    e.target.className +=
                        ' bg-green-50 border-green-300 text-green-800 dark:bg-green-900/30 dark:border-green-600 dark:text-green-200';
                } else {
                    e.target.className +=
                        ' bg-red-50 border-red-300 text-red-800 dark:bg-red-900/30 dark:border-red-600 dark:text-red-200';
                }

                // Update status in database via AJAX
                fetch('/admin/job-applications/' + recordId + '/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Show success notification using Filament notification
                        new FilamentNotification()
                            .title('Status Updated Successfully')
                            .success()
                            .send();

                        console.log('Status updated successfully in database');
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                        // Show error notification
                        new FilamentNotification()
                            .title('Failed to Update Status')
                            .danger()
                            .body('Please try again.')
                            .send();
                    });
            }
        });
    })();
</script>
