<div>
    <style>
        /* External Navigation Arrows */
        .external-nav-arrow {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            z-index: 9999;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background: white;
            border: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        
        .external-nav-arrow:hover:not(:disabled) {
            background: #f9fafb;
            border-color: #d1d5db;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        
        .external-nav-arrow:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        .external-nav-arrow.left {
            left: 1rem;
        }
        
        .external-nav-arrow.right {
            right: 1rem;
        }
        
        /* Professional Status Select */
        .app-status-select {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
            color: #374151;
        }
        
        .app-status-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .app-status-select:hover {
            border-color: #9ca3af;
        }
        
        /* Professional Card Styles */
        .app-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        
        .app-card-header {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }
    </style>

    <!-- External Navigation Arrows -->
    <button type="button"
            wire:click="previousApplication" 
            class="external-nav-arrow left" 
            {{ $currentIndex <= 0 ? 'disabled' : '' }}>
        <svg style="width: 1.25rem; height: 1.25rem; color: #374151;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <button type="button"
            wire:click="nextApplication" 
            class="external-nav-arrow right" 
            {{ $currentIndex >= count($allApplicationIds) - 1 ? 'disabled' : '' }}>
        <svg style="width: 1.25rem; height: 1.25rem; color: #374151;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Status and Info Section -->
    <div class="app-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">
                    Application Status:
                </span>
                <select wire:model.live="application.status" 
                        wire:change="updateStatus"
                        class="app-status-select">
                    <option value="new">New</option>
                    <option value="pending">Pending</option>
                    <option value="accepted">Accepted</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 0.875rem; color: #6b7280;">
                    {{ $currentIndex + 1 }} / {{ count($allApplicationIds) }}
                </span>
                <span style="font-size: 0.875rem; color: #9ca3af;">•</span>
                <span style="font-size: 0.875rem; color: #6b7280;">
                    Applied {{ $application->created_at->format('M d, Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Job Information Card -->
    <div class="app-card">
        <div class="app-card-header">Job Details</div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <div style="padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: #6b7280; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span style="font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Position</span>
                </div>
                <p style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ $application->job->title }}</p>
            </div>
            
            <div style="padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: #6b7280; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span style="font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Location</span>
                </div>
                <p style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ $application->job->location }}</p>
            </div>
            
            <div style="padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: #6b7280; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span style="font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Type</span>
                </div>
                <p style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ ucfirst(str_replace('-', ' ', $application->job->type)) }}</p>
            </div>
            
            @if ($application->job->salary_range)
            <div style="padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: #6b7280; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span style="font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Salary</span>
                </div>
                <p style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ $application->job->salary_range }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Personal Information Card -->
    <div class="app-card">
        <div class="app-card-header">Applicant Information</div>
        
        <!-- Name with Avatar -->
        <div style="display: flex; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <div style="width: 4rem; height: 4rem; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <span style="font-size: 1.5rem; font-weight: 700; color: #6b7280;">{{ substr($application->full_name, 0, 1) }}</span>
            </div>
            <div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 0.25rem;">{{ $application->full_name }}</h3>
                <p style="font-size: 0.875rem; color: #6b7280;">Job Applicant</p>
            </div>
        </div>
        
        <!-- Contact Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <div style="padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: #6b7280; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span style="font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Email</span>
                </div>
                <p style="font-size: 0.875rem; font-weight: 500; color: #111827; word-break: break-all;">{{ $application->email }}</p>
            </div>
            
            @if ($application->phone)
            <div style="padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: #6b7280; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span style="font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Phone</span>
                </div>
                <p style="font-size: 0.875rem; font-weight: 500; color: #111827;">{{ $application->phone }}</p>
            </div>
            @endif
            
            @if ($application->portfolio_link)
            <div style="padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; color: #6b7280; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                    <span style="font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Portfolio</span>
                </div>
                <a href="{{ $application->portfolio_link }}" target="_blank" style="font-size: 0.875rem; font-weight: 500; color: #3b82f6; text-decoration: none; display: flex; align-items: center;">
                    View Portfolio
                    <svg style="width: 0.875rem; height: 0.875rem; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Cover Letter Card -->
    @if ($application->cover_letter)
    <div class="app-card">
        <div style="display: flex; align-items: center; margin-bottom: 1rem;">
            <svg style="width: 1.5rem; height: 1.5rem; color: #6b7280; margin-right: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827;">Cover Letter</h3>
        </div>
        <div style="padding: 1rem; background: #f9fafb; border-radius: 0.375rem; border: 1px solid #e5e7eb;">
            <p style="color: #374151; line-height: 1.625; white-space: pre-wrap; margin: 0;">{{ $application->cover_letter }}</p>
        </div>
    </div>
    @endif

    <!-- Resume Card -->
    @if ($application->resume_path)
    <div class="app-card">
        <div style="display: flex; align-items: center; margin-bottom: 1rem;">
            <svg style="width: 1.5rem; height: 1.5rem; color: #6b7280; margin-right: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827;">Resume & Documents</h3>
        </div>
        <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
            style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; border-radius: 0.375rem; background: #111827; color: white; font-weight: 500; text-decoration: none; transition: all 0.2s; font-size: 0.875rem; border: 1px solid #111827;" 
            onmouseover="this.style.background='#374151';" 
            onmouseout="this.style.background='#111827';">
            <svg style="width: 1.125rem; height: 1.125rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download Resume
        </a>
    </div>
    @endif
</div>
