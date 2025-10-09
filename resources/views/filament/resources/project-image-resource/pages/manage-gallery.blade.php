<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Project Gallery Manager</h2>
                    <p class="text-sm text-gray-600">Drag and drop images to reorder them. Click on images to edit details.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                {{ $this->table }}
            </div>
        </div>
    </div>

    <style>
        .fi-ta-content-grid {
            display: grid !important;
            gap: 1rem;
        }
        
        .fi-ta-record {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            transition: all 0.2s;
        }
        
        .fi-ta-record:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .fi-ta-record img {
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
        }
        
        .sortable-ghost {
            opacity: 0.5;
        }
        
        .sortable-chosen {
            transform: scale(1.05);
        }
    </style>
</x-filament-panels::page>
