@extends('admin.layout.navbar')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --dark-bg: #0a0e27;
            --card-bg: rgba(255, 255, 255, 0.95);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: rgba(255, 255, 255, 0.2);
            --shadow-light: 0 8px 32px rgba(0, 0, 0, 0.1);
            --shadow-heavy: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--dark-bg);
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .floating-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            top: 20%;
            left: 10%;
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 50%;
            animation-delay: -2s;
        }

        .shape:nth-child(2) {
            top: 60%;
            right: 10%;
            width: 120px;
            height: 120px;
            background: var(--secondary-gradient);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: -4s;
        }

        .shape:nth-child(3) {
            bottom: 20%;
            left: 20%;
            width: 100px;
            height: 100px;
            background: var(--success-gradient);
            border-radius: 20px;
            animation-delay: -1s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .main-container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            width: 100%;
            max-width: 1200px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            box-shadow: var(--shadow-heavy);
            border: 1px solid var(--border-color);
            overflow: hidden;
            position: relative;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .form-header {
            background: var(--primary-gradient);
            color: white;
            padding: 60px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .form-header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .form-header p {
            font-size: 1.3rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
            font-weight: 300;
        }

        .form-body {
            padding: 60px 40px;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            margin-bottom: 50px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary-gradient);
            border-radius: 3px;
            width: 33%;
            animation: progressFill 0.8s ease-out;
        }

        @keyframes progressFill {
            0% { width: 0%; }
            100% { width: 33%; }
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .form-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid var(--border-color);
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .form-card:hover::before {
            transform: scaleX(1);
        }

        .form-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-heavy);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .card-icon {
            width: 56px;
            height: 56px;
            background: var(--primary-gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 16px;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .card-subtitle {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .form-group {
            margin-bottom: 28px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
        }

        .options-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .option-item {
            background: rgba(255, 255, 255, 0.6);
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .option-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .option-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .option-item.selected {
            background: var(--primary-gradient);
            color: white;
            border-color: #667eea;
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
        }

        .option-item input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .option-icon {
            font-size: 2rem;
            margin-bottom: 12px;
            display: block;
            position: relative;
            z-index: 1;
        }

        .option-label {
            font-weight: 600;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .full-width-card {
            grid-column: 1 / -1;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid var(--border-color);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .full-width-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--secondary-gradient);
        }

        .textarea-container {
            position: relative;
        }

        .form-textarea {
            width: 100%;
            min-height: 140px;
            padding: 20px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            resize: vertical;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.95);
        }

        .char-counter {
            position: absolute;
            bottom: 16px;
            right: 20px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .submit-container {
            text-align: center;
            margin-top: 50px;
            padding-top: 40px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .btn-submit {
            background: var(--primary-gradient);
            border: none;
            border-radius: 50px;
            padding: 20px 60px;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(-2px);
        }

        .required-indicator {
            color: #f56565;
            font-size: 0.85rem;
            margin-left: 4px;
        }

        .form-hint {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 8px;
            font-style: italic;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success-gradient);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            transform: translateX(400px);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
        }

        .notification.show {
            transform: translateX(0);
        }

        @media (max-width: 768px) {
            .form-header {
                padding: 40px 20px;
            }
            
            .form-header h1 {
                font-size: 2.5rem;
            }
            
            .form-body {
                padding: 40px 20px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .form-card {
                padding: 24px;
            }
            
            .options-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 20px 10px;
            }
            
            .form-header h1 {
                font-size: 2rem;
            }
            
            .form-body {
                padding: 30px 16px;
            }
        }
    </style>
<div class="main-content">
    @if(session('success'))
    <div id="flash-message" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="breadcrumb">
        <h1>Task Assign Form</h1>
    </div>
<div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="main-container">
        <div class="form-container">
            <div class="form-header">
                <h1><i class="fas fa-rocket"></i> Task Assignment</h1>
                <p>Create, assign, and track tasks with modern efficiency</p>
            </div>

            <div class="form-body">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>

                <form method="post" action="{{route('admin.followupformsubmit')}}">
                    @csrf
                    <input type="hidden" name="cid" value="{{$id}}" id="modalId">
                    <input type="hidden" name="a" value="{{$a}}">
                    <input type="hidden" name="phone" value="{{$phone}}">
                    <input type="hidden" name="team" id="teamName">

                    <div class="form-grid">
                        <!-- Company Information -->
                        <div class="form-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Company</h3>
                                    <p class="card-subtitle">Client information</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control" name="company" value="{{$cname}}" id="modalCname" readonly>
                                <div class="form-hint">Pre-filled from client data</div>
                            </div>
                        </div>

                        <!-- Task Details -->
                        <div class="form-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Task</h3>
                                    <p class="card-subtitle">Define the task</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Task Name <span class="required-indicator">*</span></label>
                                <input type="text" class="form-control" name="task" placeholder="Enter task name" required>
                                <div class="form-hint">Be specific and clear</div>
                            </div>
                        </div>

                        <!-- Team Assignment -->
                        <div class="form-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Assignment</h3>
                                    <p class="card-subtitle">Choose team member</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Assign to <span class="required-indicator">*</span></label>
                                <select class="form-select" name="team_id" required>
                                    <option value="">Select team member</option>
                                    @foreach($activeUsers as $user)
                                    <option value="{{$user['id']}}" data-team="{{$user['name']}}">{{$user['name']}}</option>
                                    @endforeach
                                </select>
                                <div class="form-hint">Choose the best fit for this task</div>
                            </div>
                        </div>

                        <!-- Priority Selection -->
                        <div class="form-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-flag"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Priority</h3>
                                    <p class="card-subtitle">Set urgency level</p>
                                </div>
                            </div>
                            <div class="options-container">
                                <div class="option-item">
                                    <input type="radio" value="Urgent" name="priority" required>
                                    <i class="fas fa-exclamation-triangle option-icon"></i>
                                    <div class="option-label">Urgent</div>
                                </div>
                                <div class="option-item">
                                    <input type="radio" value="Normal" name="priority" required>
                                    <i class="fas fa-clock option-icon"></i>
                                    <div class="option-label">Normal</div>
                                </div>
                            </div>
                        </div>

                        <!-- Communication Methods -->
                        <div class="form-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Communication</h3>
                                    <p class="card-subtitle">Preferred methods</p>
                                </div>
                            </div>
                            <div class="options-container">
                                <div class="option-item">
                                    <input type="checkbox" name="communication[]" value="Phone">
                                    <i class="fas fa-phone option-icon"></i>
                                    <div class="option-label">Phone</div>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" name="communication[]" value="Chat">
                                    <i class="fas fa-message option-icon"></i>
                                    <div class="option-label">Chat</div>
                                </div>
                                <div class="option-item">
                                    <input type="checkbox" name="communication[]" value="Email">
                                    <i class="fas fa-envelope option-icon"></i>
                                    <div class="option-label">Email</div>
                                </div>
                            </div>
                        </div>

                        <!-- Task Details -->
                        <div class="full-width-card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <h3 class="card-title">Task Details</h3>
                                    <p class="card-subtitle">Comprehensive description and requirements</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Detailed Description</label>
                                <div class="textarea-container">
                                    <textarea class="form-textarea" name="detail" placeholder="Provide detailed task description, requirements, deadlines, and any special instructions..." maxlength="1000"></textarea>
                                    <div class="char-counter">0/1000</div>
                                </div>
                                <div class="form-hint">Include all relevant information for successful task completion</div>
                            </div>
                        </div>
                    </div>

                    <div class="submit-container">
                        <button type="submit" name="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            Create Task Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        Task created successfully!
    </div>

    <script>
        // Team member selection
        document.querySelector('select[name="team_id"]').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('teamName').value = selectedOption.getAttribute('data-team');
        });

        // Option selection handlers
        document.querySelectorAll('.option-item').forEach(item => {
            item.addEventListener('click', function() {
                const input = this.querySelector('input');
                
                if (input.type === 'radio') {
                    document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
                        radio.closest('.option-item').classList.remove('selected');
                    });
                    input.checked = true;
                    this.classList.add('selected');
                } else if (input.type === 'checkbox') {
                    input.checked = !input.checked;
                    this.classList.toggle('selected', input.checked);
                }
            });
        });

        // Character counter
        const textarea = document.querySelector('.form-textarea');
        const charCounter = document.querySelector('.char-counter');
        
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            charCounter.textContent = `${count}/1000`;
            
            if (count > 800) {
                charCounter.style.color = '#f56565';
            } else if (count > 600) {
                charCounter.style.color = '#ed8936';
            } else {
                charCounter.style.color = '#718096';
            }
        });

        // Form validation and submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const taskName = document.querySelector('input[name="task"]').value.trim();
            const teamMember = document.querySelector('select[name="team_id"]').value;
            const priority = document.querySelector('input[name="priority"]:checked');
            
            if (!taskName || !teamMember || !priority) {
                e.preventDefault();
                
                // Show notification
                const notification = document.getElementById('notification');
                notification.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Please fill in all required fields';
                notification.style.background = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)';
                notification.classList.add('show');
                
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 3000);
                
                return false;
            }
        });

        // Initialize selected states
        document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked').forEach(input => {
            input.closest('.option-item').classList.add('selected');
        });

        // Add floating animation to form cards
        document.querySelectorAll('.form-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.animation = 'fadeInUp 0.6s ease forwards';
        });

        // Add CSS animation keyframes
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
</div>




@endsection