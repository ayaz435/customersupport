@extends('admin.layout.navbar')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
<style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
            --info-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        .main-content-wrap {
            padding: 15px 2px 0;
        }
        .col-12, .col-xl-11  {
            width: 100%;
            min-height: 1px;
            padding-right: 2px !important; 
            padding-left: 2px !important;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-section {
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stats-card.app::before { background: var(--info-gradient); }
        .stats-card.web::before { background: var(--success-gradient); }
        .stats-card.chat-app::before { background: var(--warning-gradient); }
        .stats-card.chat-web::before { background: var(--danger-gradient); }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
        }

        .stat-icon.app { background: var(--info-gradient); }
        .stat-icon.web { background: var(--success-gradient); }
        .stat-icon.chat-app { background: var(--warning-gradient); }
        .stat-icon.chat-web { background: var(--danger-gradient); }

        .nav-tabs {
            border: none;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 8px;
            margin-bottom: 30px;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 10px;
            padding: 15px 25px;
            margin: 0 5px;
            background: transparent;
            color: #6c757d;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-tabs .nav-link:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .nav-tabs .nav-link.active {
            /* background: var(--primary-gradient); */
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .user-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            animation: pulse-glow 2s infinite;
        }

        .status-inactive {
            background: linear-gradient(135deg, #ff6b6b, #feca57);
            color: white;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 5px rgba(17, 153, 142, 0.4); }
            50% { box-shadow: 0 0 20px rgba(17, 153, 142, 0.8); }
        }

        .activity-info {
            background: rgba(102, 126, 234, 0.05);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .refresh-btn {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .last-updated {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 8px 15px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }

        .tab-content {
            background: rgba(255, 255, 255, 0.5);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
        }

        .count-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 15px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .metric-value {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .metric-label {
            font-size: 0.9rem;
            font-weight: 500;
            opacity: 0.8;
            margin-bottom: 5px;
        }
</style>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <div class="dashboard-container">
                    <!-- Header Section -->
                    <div class="header-section">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="mb-2" style="font-size: 2.5rem; font-weight: 700;">
                                    <i class="fas fa-users-cog me-3"></i>
                                    User Activity Dashboard
                                </h1>
                                <p class="mb-0 opacity-75" style="font-size: 1.1rem;">
                                    Monitor real-time user engagement across all platforms
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="last-updated mb-3">
                                    <i class="fas fa-clock me-2"></i>
                                    Last updated: <span id="lastUpdated">{{ now()->setTimezone('Asia/Karachi')->format('M d, Y  h:i A') }}</span>
                                </div>
                                <button id="refreshBtn" class="refresh-btn">
                                    <i class="fas fa-sync-alt me-2"></i>
                                    Refresh Data
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <!-- Statistics Cards -->
                        <div class="row g-4 mb-5">
                            @php
                                $platforms = [
                                    'app' => ['name' => 'App Users', 'icon' => 'fas fa-mobile-alt', 'class' => 'app'],
                                    'web' => ['name' => 'Web Users', 'icon' => 'fas fa-globe', 'class' => 'web'],
                                    'chat_app' => ['name' => 'Chat App', 'icon' => 'fas fa-comments', 'class' => 'chat-app'],
                                    'chat_web' => ['name' => 'Chat Web', 'icon' => 'fas fa-comment-dots', 'class' => 'chat-web']
                                ];
                            @endphp

                            @foreach($platforms as $key => $platform)
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card {{ $platform['class'] }}">
                                    <div class="stat-icon {{ $platform['class'] }}">
                                        <i class="{{ $platform['icon'] }}"></i>
                                    </div>
                                    <h5 class="mb-3" style="font-weight: 600; color: #2d3748;">{{ $platform['name'] }}</h5>
                                    
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="metric-label text-success">Active</div>
                                            <div class="metric-value text-success" id="active-{{ $key }}">
                                                {{ $stats[$key]['active'] }}
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="metric-label text-danger">Inactive</div>
                                            <div class="metric-value text-danger" id="inactive-{{ $key }}">
                                                {{ $stats[$key]['inactive'] }}
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="metric-label text-primary">Total</div>
                                            <div class="metric-value text-primary" id="total-{{ $key }}">
                                                {{ $stats[$key]['total'] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                            @foreach($platforms as $key => $platform)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                        id="{{ $key }}-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#{{ $key }}-content" 
                                        type="button" 
                                        role="tab">
                                    <i class="{{ $platform['icon'] }} me-2"></i>
                                    {{ $platform['name'] }}
                                    <span class="count-badge" id="tab-count-{{ $key }}">
                                        {{ $stats[$key]['total'] }}
                                    </span>
                                </button>
                            </li>
                            @endforeach
                        </ul>

                        <!-- Tab Contents -->
                        <div class="tab-content" id="activityTabContent">
                            @foreach(['app', 'web', 'chat_app', 'chat_web'] as $key)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="{{ $key }}-content" 
                                 role="tabpanel">
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h3 style="font-weight: 600; color: #2d3748;">
                                        {{ ucwords(str_replace('_', ' ', $key)) }} Activity Details
                                    </h3>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-3">
                                            <i class="fas fa-circle pulse-dot me-1"></i>
                                            Active (last 10 min)
                                        </span>
                                        <span class="badge bg-danger">
                                            <i class="fas fa-circle me-1"></i>
                                            Inactive
                                        </span>
                                    </div>
                                </div>

                                @if($results[$key]->isNotEmpty())
                                <div class="row g-3">
                                    @foreach($results[$key] as $user)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="user-card">
                                            <div class="d-flex align-items-start justify-content-between mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-3 position-relative">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        @if($user->activity_status === 'active')
                                                            <span style="
                                                                position: absolute;
                                                                top: 0;
                                                                right: 0;
                                                                width: 20px;
                                                                height: 20px;
                                                                background-color: #38c172; /* Tailwind green-500 */
                                                                border-radius: 50%;
                                                                border: 2px solid white;
                                                            "></span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1" style="font-weight: 600; color: #2d3748;">
                                                            {{ $user->name }}
                                                        </h6>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="activity-info">
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Last Action</small>
                                                        <strong style="color: #4a5568;">
                                                            {{ ucwords(str_replace('_', ' ', $user->latest_field)) }}
                                                        </strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Time</small>
                                                        <strong style="color: #4a5568;">
                                                            {{ $user->latest_time->setTimezone('Asia/Karachi')->format('M d, Y h:i:s A') }}
                                                        </strong>
                                                    </div>
                                                    <div class="col-12 mt-2">
                                                        <small class="text-muted d-block">Minutes Ago</small>
                                                        <strong class="{{ $user->diff_in_minutes <= 10 ? 'text-success' : 'text-muted' }}">
                                                            <i class="fas fa-clock me-1"></i>
                                                            {{ $user->diff_in_minutes }} minutes
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <h4 style="font-weight: 600; color: #4a5568;">No Users Found</h4>
                                    <p class="text-muted">No users have activity data for this platform yet.</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.getElementById('refreshBtn');
            const lastUpdatedSpan = document.getElementById('lastUpdated');

            // Refresh functionality
            refreshBtn.addEventListener('click', function() {
                const originalContent = refreshBtn.innerHTML;
                refreshBtn.innerHTML = '<div class="loading-spinner me-2"></div>Refreshing...';
                refreshBtn.disabled = true;

                // Simulate refresh (replace with actual AJAX call)
                setTimeout(() => {
                    location.reload();
                }, 1500);
            });

            // Auto-refresh every 60 seconds
            setInterval(() => {
                updateUserActivity();
            }, 60000);

            // AJAX update function
            function updateUserActivity() {
                fetch('{{ route("admin.user-activity.ajax") }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update statistics
                    Object.keys(data.stats).forEach(key => {
                        const stats = data.stats[key];
                        document.getElementById(`active-${key}`).textContent = stats.active;
                        document.getElementById(`inactive-${key}`).textContent = stats.inactive;
                        document.getElementById(`total-${key}`).textContent = stats.total;
                        document.getElementById(`tab-count-${key}`).textContent = stats.total;
                    });

                    // Update timestamp
                    lastUpdatedSpan.textContent = data.timestamp;
                    
                    console.log('Dashboard updated successfully');
                })
                .catch(error => {
                    console.error('Error updating dashboard:', error);
                });
            }

            // Add smooth scrolling and animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                    }
                });
            });

            document.querySelectorAll('.user-card, .stats-card').forEach((el) => {
                observer.observe(el);
            });
        });

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
