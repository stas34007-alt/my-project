<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Панель администратора | Телемедицина</title>
    <!-- Google Fonts + Font Awesome -->
    <link rel="stylesheet" href="{{ asset('styles/admin.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header class="header">
        <div class="header-container">
            <!-- Логотип и навигация -->
            <div class="logo">
                <a href="/" class="logo-brand">
                    <i class="fas fa-stethoscope"></i>
                    <span>БУДЬ<br>ЗДОРОВ</span>
                </a>
                
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <ul class="nav-links" id="navLinks">
                    <li><a href="{{route('Onas')}}">О нас</a></li>
                    <li><a href="/doctors">Врачи</a></li>
                     @auth
                        @if(Auth::user()->user_type == 'doctor')
                            <li><a href="{{ route('doctor.diagnosis.index') }}">Мои пациенты</a></li>
                        @else
                            <li><a href="{{ route('my.consultations') }}">Мои консультации</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('my.consultations') }}">Мои консультации</a></li>
                    @endauth
                </ul>
            </div>
            
            <!-- Контакты и вход -->
            <div class="header-actions">
                <a href="tel:+79174732572" class="phone">
                    <i class="fas fa-phone-alt"></i>
                    <span>+7 (917) 473-25-72</span>
                </a>
                
                <button class="btn-login">
                    <a href="{{route('private')}}"><i class="fas fa-user"></i></a>
                    @auth

                    @else
                        <a href="{{route('autorisation')}}"><span>Войти</span></a>
                    @endauth
            </button>
        </div>
    </div>
</header>
<div class="admin-panel-root">
    <div class="admin-layout">
        <aside class="admin-sidebar">
        <div class="admin-nav-links">
            <div class="admin-nav-item active" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i> <span>Главная</span>
            </div>
            <div class="admin-nav-item" data-section="doctors">
                <i class="fas fa-user-md"></i> <span>Врачи</span>
            </div>
            <div class="admin-nav-item" data-section="consultations">
                <i class="fas fa-calendar-check"></i> <span>Консультации</span>
            </div>
            <div class="admin-nav-item" data-section="analytics">
                <i class="fas fa-chart-line"></i> <span>Добавление слотов</span>
            </div>
            <div class="admin-nav-item" data-section="settings">
                <i class="fas fa-cog"></i> <span>Настройки</span>
            </div>
        </div>
        <div class="admin-sidebar-footer">
            <div class="admin-logout-side" id="adminLogoutBtn">
                <i class="fas fa-sign-out-alt"></i> <span>Выйти</span>
            </div>
        </div>
    </aside>

        <!-- ОСНОВНОЙ КОНТЕНТ -->
        <main class="admin-main-content">
            <!-- Секция: Главная (dashboard) -->
            <div id="dashboard" class="dashboard-section active">
                <div class="admin-top-welcome">
                    <div class="admin-welcome-text">
                        <h1>Управление телемедициной</h1>
                        <p>Консультации с лучшими врачами онлайн. Быстро, удобно, безопасно.</p>
                    </div>
                    <div class="admin-profile">
                        <i class="fas fa-user-circle" style="font-size: 1.6rem; color:#2c9c74;"></i>
                        <span style="font-weight:600;">Екатерина А.</span>
                        <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                    </div>
                </div>

                <!-- 4 блока статистики -->
                <div class="admin-stats-grid">
                    <div class="admin-stat-card">
                        <div class="admin-stat-info">
                            <h3><i class="fas fa-calendar-check"></i> Всего консультаций</h3>
                            <div class="admin-stat-number" id="totalConsultCount">{{$consultations->count()}}</div>
                        </div>
                        <div class="admin-stat-icon"><i class="fas fa-head-side-medical"></i></div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="admin-stat-info">
                            <h3><i class="fas fa-clock"></i> В ожидании</h3>
                            <div class="admin-stat-number" id="pendingConsultCount">{{$panding_consultation->count()}}</div>
                        </div>
                        <div class="admin-stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="admin-stat-info">
                            <h3><i class="fas fa-user-md"></i> Активные врачи</h3>
                            <div class="admin-stat-number" id="activeDoctorsCount">{{$doctors->count()}}</div>
                        </div>
                        <div class="admin-stat-icon"><i class="fas fa-stethoscope"></i></div>
                    </div>
                    <div class="admin-stat-card">
                        <div class="admin-stat-info">
                            <h3><i class="fas fa-star"></i> Рейтинг платформы</h3>
                            <div class="admin-stat-number">4.9 ★</div>
                        </div>
                        <div class="admin-stat-icon"><i class="fas fa-smile-wink"></i></div>
                    </div>
                </div>

                <div class="admin-two-columns">
                    <!-- ЛЕВАЯ КОЛОНКА: консультации -->
                    <div class="admin-consultations-panel">
                        <div class="admin-section-card">
                            <div class="admin-card-header">
                                <h2><i class="fas fa-comments"></i> Последние обращения</h2>
                                <span><i class="fas fa-sync-alt"></i> реальное время</span>
                            </div>
                            <div style="overflow-x: auto;">
                                <table class="admin-table" id="consultationsTable">
                                    <thead>
                                        <tr><th>Пациент</th><th>Специальность</th><th>Время</th><th>Статус</th><th>Действие</th></tr>
                                    </thead>
                                    <tbody id="consultTbody">
                                        <!-- динамически -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ПРАВАЯ КОЛОНКА: Добавление врача + лист -->
                    
                </div>
            </div>

            <!-- Секция: Врачи -->
            <div id="doctors" class="dashboard-section">
                <div class="content-card">
                    <h2><i class="fas fa-user-md"></i> Врачи</h2>
                    <p>Список врачей, их специализации и статусы.</p>
                    
                    <div style="overflow-x: auto; margin-top: 20px;">
                        <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                                    <th style="padding: 12px; text-align: left;">ФИО</th>
                                    <th style="padding: 12px; text-align: left;">Специализация</th>
                                    <th style="padding: 12px; text-align: left;">Стаж (лет)</th>
                                    <th style="padding: 12px; text-align: left;">Цена конс.</th>
                                    <th style="padding: 12px; text-align: left;">Рейтинг</th>
                                    <th style="padding: 12px; text-align: left;">Отзывов</th>
                                    <th style="padding: 12px; text-align: left;">Онлайн</th>
                                    <th style="padding: 12px; text-align: left;">Вериф.</th>
                                    <th style="padding: 12px; text-align: center;">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctors as $doctor)
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px; font-weight: 500;">
                                        @if($doctor->user)
                                            {{ $doctor->user->full_name }}
                                        @else
                                            Нет данных
                                        @endif
                                    </td>
                                    <td style="padding: 12px;">
                                        @if($doctor->specialization)
                                            {{ $doctor->specialization->name }}
                                        @else
                                            Не указана
                                        @endif
                                    </td>
                                    <td style="padding: 12px;">{{ $doctor->years_of_experience ?? '—' }}</td>
                                    <td style="padding: 12px;">{{ number_format($doctor->online_consultation_price, 0) }} ₽</td>
                                    <td style="padding: 12px;">
                                        <span style="color: #f59e0b;">★</span> {{ number_format($doctor->rating, 1) }}
                                    </td>
                                    <td style="padding: 12px;">{{ $doctor->total_reviews }}</td>
                                    <td style="padding: 12px;">
                                        @if($doctor->is_available_online)
                                            <span style="background: #10b981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                                                <i class="fas fa-circle" style="font-size: 8px;"></i> Доступен
                                            </span>
                                        @else
                                            <span style="background: #ef4444; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                                                Недоступен
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px;">
                                        @if($doctor->is_verified)
                                            <span style="color: #10b981;"><i class="fas fa-check-circle"></i> Да</span>
                                        @else
                                            <span style="color: #ef4444;"><i class="fas fa-times-circle"></i> Нет</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <button class="admin-btn-small" style="background: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; margin-right: 5px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="admin-btn-small" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($doctors->count() == 0)
                        <div style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="fas fa-user-md" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                            Нет добавленных врачей
                        </div>
                    @endif
                </div>
                <div class="admin-doctor-panel">
                    <div class="admin-section-card">
                        <div class="admin-card-header">
                            <h2><i class="fas fa-plus-circle"></i> Добавить врача</h2>
                            <span><i class="fas fa-user-shield"></i> администратор</span>
                        </div>
                        
                        <form action="{{route('createDoctor')}}" method="POST"  id="addDoctorForm">
                            @csrf
                            
                            <div class="admin-add-doctor-form">
                                <!-- Поиск существующего пользователя -->
                                <div class="admin-form-group">
                                    <label><i class="fas fa-user"></i> Пользователь (ID)</label>
                                    <input type="text" name="user_identifier" id="userIdentifier" placeholder="Email или ID пользователя" required>
                                    <small>Пользователь уже должен быть зарегистрирован на сайте</small>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-stethoscope"></i> Специальность</label>
                                    <select name="specialty" id="docSpecialty" required>
                                        <option value="">-- Выберите специальность --</option>
                                        <option value="1">Кардиолог</option>
                                        <option value="2">Невролог</option>
                                        <option value="3">Хирург</option>
                                        <option value="4">Педиатр</option>
                                        <option value="5">Терапевт</option>
                                    </select>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-link"></i> Slug (уникальный идентификатор в URL)</label>
                                    <input type="text" name="slug" id="docSlug" placeholder="naprimer: smirnova-elena-viktorovna">
                                    <small>Оставьте пустым для автоматической генерации</small>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-id-card"></i> Номер лицензии</label>
                                    <input type="text" name="license_number" id="licenseNumber" placeholder="ЛО-77-01-123456" required>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-chart-line"></i> Стаж (лет)</label>
                                    <input type="number" name="years_of_experience" id="docExp" placeholder="например 8" value="5" min="0">
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-ruble-sign"></i> Цена онлайн-консультации (₽)</label>
                                    <input type="number" step="0.01" name="online_consultation_price" id="onlinePrice" placeholder="1500.00" value="0.00" min="0">
                                </div>

                                <!-- Рейтинг и отзывы (скрытые, заполняются автоматически) -->
                                <input type="hidden" name="rating" id="rating" value="0">
                                <input type="hidden" name="total_reviews" id="totalReviews" value="0">

                                <div class="admin-form-group">
                                    <label><i class="fas fa-graduation-cap"></i> Образование</label>
                                    <textarea name="education" id="education" rows="3" placeholder="МГМУ им. Сеченова, ординатура по терапии..."></textarea>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-briefcase"></i> Опыт работы</label>
                                    <textarea name="work_experience" id="workExperience" rows="3" placeholder="Городская поликлиника №1, 2015-2020..."></textarea>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-trophy"></i> Достижения и сертификаты</label>
                                    <textarea name="achievements" id="achievements" rows="2" placeholder="Кандидат медицинских наук, сертификат..."></textarea>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-address-card"></i> Биография</label>
                                    <textarea name="bio" id="bio" rows="4" placeholder="Краткая информация о враче..."></textarea>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-language"></i> Языки (JSON формат)</label>
                                    <input type="text" name="languages" id="languages" value='["Русский", "Английский"]'>
                                    <small>Формат: ["Русский", "Английский", "Немецкий"]</small>
                                </div>

                                <!-- Сертификаты (JSON) -->
                                <div class="admin-form-group">
                                    <label><i class="fas fa-certificate"></i> Сертификаты (JSON формат)</label>
                                    <input type="text" name="certificates" id="certificates" placeholder='["certificate1.pdf", "certificate2.pdf"]'>
                                    <small>Массив ссылок на файлы сертификатов</small>
                                </div>

                                <div class="admin-form-group">
                                    <label><i class="fas fa-image"></i> Аватар (URL или путь)</label>
                                    <input type="text" name="avatar" id="avatar" placeholder="/uploads/doctors/smirnova.jpg">
                                </div>

                                <div class="admin-form-group checkbox-group">
                                    <label>
                                        <input type="checkbox" name="is_verified" id="isVerified" value="1"> 
                                        <i class="fas fa-check-circle"></i> Верифицирован
                                    </label>
                                    <label>
                                        <input type="checkbox" name="is_available_online" id="isAvailableOnline" checked value="1"> 
                                        <i class="fas fa-video"></i> Доступен онлайн
                                    </label>
                                </div>

                                <div class="admin-form-actions">
                                    <button type="submit" class="admin-btn-primary" id="addDoctorBtn">
                                        <i class="fas fa-save"></i> Добавить врача
                                    </button>
                                    <button type="reset" class="admin-btn-secondary" id="clearFormBtn">
                                        <i class="fas fa-undo"></i> Очистить форму
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="admin-doctor-list-mini">
                            <h4><i class="fas fa-list-ul"></i> Штатные врачи (телемедицина)</h4>
                            <div id="doctorsListContainer"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Секция: Консультации -->
            <div id="consultations" class="dashboard-section">
                <div class="content-card">
                    <div class="consultations-header">
                        <h2 class="consultations-title">
                            <i class="fas fa-calendar-check"></i> Консультации
                        </h2>
                        <p class="consultations-subtitle">Управление запланированными и завершёнными консультациями.</p>
                    </div>

                    <!-- Фильтры -->
                        <form method="GET" action="{{ route('admin') }}" class="consultations-filters">
                            <div class="filter-group">
                                <label class="filter-label">Статус</label>
                                <select class="filter-select" name="status">
                                    <option value="">Все</option>
                                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Запланированы</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершены</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменены</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>В процессе</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label class="filter-label">Тип</label>
                                <select class="filter-select" name="type">
                                    <option value="">Все</option>
                                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Видео</option>
                                    <option value="chat" {{ request('type') == 'chat' ? 'selected' : '' }}>Чат</option>
                                    <option value="phone" {{ request('type') == 'phone' ? 'selected' : '' }}>Телефон</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label class="filter-label">Дата от</label>
                                <input type="date" class="filter-input" name="date_from" value="{{ request('date_from') }}">
                            </div>
                            
                            <div class="filter-group">
                                <label class="filter-label">Дата до</label>
                                <input type="date" class="filter-input" name="date_to" value="{{ request('date_to') }}">
                            </div>
                            
                            <button type="submit" class="btn-filter">
                                <i class="fas fa-search"></i> Применить
                            </button>
                            
                            <a href="{{ route('admin') }}" class="btn-reset">
                                <i class="fas fa-undo"></i> Сброс
                            </a>
                        </form>

                    <!-- Статистика -->
                    <div class="consultations-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ $consultations->count() }}</span>
                            <span class="stat-label">Всего</span>
                        </div>
                        <div class="stat-item stat-scheduled">
                            <span class="stat-value">{{ $consultations->where('status', 'scheduled')->count() }}</span>
                            <span class="stat-label">Запланировано</span>
                        </div>
                        <div class="stat-item stat-completed">
                            <span class="stat-value">{{ $consultations->where('status', 'completed')->count() }}</span>
                            <span class="stat-label">Завершено</span>
                        </div>
                        <div class="stat-item stat-cancelled">
                            <span class="stat-value">{{ $consultations->where('status', 'cancelled')->count() }}</span>
                            <span class="stat-label">Отменено</span>
                        </div>
                    </div>

                    <!-- Таблица консультаций -->
                    <div class="consultations-table-wrapper">
                        <table class="consultations-table">
                            <thead>
                                <tr>
                                    <th class="col-patient">Пациент</th>
                                    <th class="col-doctor">Врач</th>
                                    <th class="col-type">Тип</th>
                                    <th class="col-status">Статус</th>
                                    <th class="col-price">Цена</th>
                                    <th class="col-date">Дата</th>
                                    <th class="col-actions">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consultations as $consultation)
                                <tr class="consultation-row" data-status="{{ $consultation->status }}" data-type="{{ $consultation->type }}">
                                    <td class="cell-patient">
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <i class="fas fa-user-circle"></i>
                                            </div>
                                            <div class="patient-details">
                                                <span class="patient-name">{{ $consultation->patient->user->full_name ?? 'Не указан' }}</span>
                                                <small class="patient-email">{{ $consultation->patient->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cell-doctor">
                                        <div class="doctor-info">
                                            <div class="doctor-avatar">
                                                <i class="fas fa-user-md"></i>
                                            </div>
                                            <div class="doctor-details">
                                                <span class="doctor-name">{{ $consultation->doctor->user->full_name ?? 'Не указан' }}</span>
                                                <small class="doctor-specialty">{{ $consultation->doctor->specialization->name ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cell-type">
                                        @if($consultation->type == 'video')
                                            <span class="type-badge type-video"><i class="fas fa-video"></i> Видео</span>
                                        @elseif($consultation->type == 'chat')
                                            <span class="type-badge type-chat"><i class="fas fa-comment-dots"></i> Чат</span>
                                        @else
                                            <span class="type-badge type-phone"><i class="fas fa-phone"></i> Телефон</span>
                                        @endif
                                    </td>
                                    <td class="cell-status">
                                        @if($consultation->status == 'scheduled')
                                            <span class="status-badge status-scheduled"><i class="fas fa-clock"></i> Запланирована</span>
                                        @elseif($consultation->status == 'completed')
                                            <span class="status-badge status-completed"><i class="fas fa-check-circle"></i> Завершена</span>
                                        @elseif($consultation->status == 'cancelled')
                                            <span class="status-badge status-cancelled"><i class="fas fa-times-circle"></i> Отменена</span>
                                        @else
                                            <span class="status-badge status-warning">{{ $consultation->status }}</span>
                                        @endif
                                    </td>
                                    <td class="cell-price">
                                        <span class="price-value">{{ number_format($consultation->final_price, 0) }} ₽</span>
                                    </td>
                                    <td class="cell-date">
                                        <div class="date-info">
                                            <i class="far fa-calendar-alt"></i>
                                            <span>{{ $consultation->created_at->format('d.m.Y') }}</span>
                                            <br>
                                            <small><i class="far fa-clock"></i> {{ $consultation->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td class="cell-actions">
                                        <div class="action-buttons">
                                            <button class="action-btn btn-view" title="Просмотр" onclick="viewConsultation({{ $consultation->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($consultation->status == 'scheduled')
                                            <button class="action-btn btn-cancel" title="Отменить" onclick="cancelConsultation({{ $consultation->id }})">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            @endif
                                            @if($consultation->status == 'completed')
                                            <button class="action-btn btn-review" title="Отзыв" onclick="viewReview({{ $consultation->id }})">
                                                <i class="fas fa-star"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="empty-row">
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times"></i>
                                            <p>Нет консультаций</p>
                                            <span class="empty-hint">Консультации появятся после записи пациентов</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Пагинация -->
                    @if(method_exists($consultations, 'links'))
                    <div class="pagination-wrapper">
                        {{ $consultations->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Секция: добавления слотов -->
            <div id="analytics" class="dashboard-section">
                <div class="content-card">
                    <h2><i class="fas fa-calendar-plus"></i>Добавление слотов для записи</h2>
                    <p>Заполните расписание для врача на выбранную неделю</p>
                    
                    <form action="{{route('createSlots')}}" method="POST" id="slotsForm" style="margin-top: 24px;">
                        @csrf
                        <!-- Выбор врача -->
                        <div class="admin-form-group" style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">
                                <i class="fas fa-user-md"></i> Выберите врача
                            </label>
                            <select id="doctor_id" required name="doctor_id" style="width: 100%;  padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                <option value="">-- Выберите врача --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">
                                        @if($doctor->user)
                                            {{ $doctor->user->full_name }} - {{ $doctor->specialization->name ?? 'Нет специализации' }}
                                        @else
                                            Врач #{{ $doctor->id }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Настройки слота -->
                        <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                            <h4 style="margin-bottom: 16px;"><i class="fas fa-clock"></i> Настройки слота</h4>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                                <div>
                                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">
                                        <i class="fas fa-calendar-alt"></i> Дата и время начала
                                    </label>
                                    <input type="datetime-local" 
                                        name="slot_start" 
                                        required
                                        value="{{ old('slot_start', date('Y-m-d\TH:i', strtotime('+1 day 09:00'))) }}"
                                        min="{{ date('Y-m-d\TH:i') }}"
                                        max="{{ date('Y-m-d\TH:i', strtotime('+3 months')) }}"
                                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">
                                        <i class="fas fa-calendar-alt"></i> Дата и время окончания
                                    </label>
                                    <input type="datetime-local" 
                                        name="slot_end" 
                                        required
                                        value="{{ old('slot_end', date('Y-m-d\TH:i', strtotime('+1 day 09:30'))) }}"
                                        min="{{ date('Y-m-d\TH:i') }}"
                                        max="{{ date('Y-m-d\TH:i', strtotime('+3 months')) }}"
                                        style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                </div>
                            </div>
                            
                            <div style="margin-top: 12px; padding: 12px; background: #e0f2fe; border-radius: 8px;">
                                <p style="margin: 0; font-size: 13px; color: #0369a1;">
                                    <i class="fas fa-info-circle"></i> 
                                    Минимальная дата: <strong>{{ date('d.m.Y H:i') }}</strong> (сегодняшняя дата и время)<br>
                                    Максимальная дата: <strong>{{ date('d.m.Y H:i', strtotime('+3 months')) }}</strong> (через 3 месяца)
                                </p>
                            </div>
                        </div>

                        <!-- Валидация на стороне сервера (Laravel) -->
                        @push('scripts')
                        <script>
                            // Простая валидация перед отправкой (без синхронизации дат)
                            document.querySelector('form')?.addEventListener('submit', function(e) {
                                const start = document.querySelector('[name="slot_start"]').value;
                                const end = document.querySelector('[name="slot_end"]').value;
                                
                                if (start && end && start >= end) {
                                    e.preventDefault();
                                    alert('Дата и время окончания должны быть позже даты и времени начала');
                                    return false;
                                }
                            });
                        </script>
                        @endpush

                        <!-- Кнопки -->
                        <div style="display: flex; gap: 12px;">
                            <button type="submit" class="admin-btn-primary" style="background: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer;">
                                <i class="fas fa-save"></i> Создать слоты
                            </button>
                            <button type="button" id="clearFormBtn" style="background: #64748b; color: white; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer;">
                                <i class="fas fa-eraser"></i> Очистить
                            </button>
                        </div>

                        <!-- Результат создания -->
                        <div id="slotsResult" style="margin-top: 20px; display: none; padding: 12px; border-radius: 8px;"></div>
                    </form>

                    <!-- Просмотр существующих слотов -->
                    <div style="margin-top: 32px; border-top: 1px solid #e2e8f0; padding-top: 24px;">
                        <h4><i class="fas fa-list"></i> Существующие слоты (неделя)</h4>
                        <div style="overflow-x: auto; margin-top: 16px;">
                            <table id="slotsPreview" class="admin-table" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #f1f5f9;">
                                        <th style="padding: 10px;">ID</th>
                                        <th style="padding: 10px;">Врач</th>
                                        <th style="padding: 10px;">Дата и время начала</th>
                                        <th style="padding: 10px;">Дата и время окончания</th>
                                        <th style="padding: 10px;">Статус</th>
                                        <th style="padding: 10px;">Забронировал</th>
                                        <th style="padding: 10px;">Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($slots as $slot)
                                    <tr style="border-bottom: 1px solid #e2e8f0;">
                                        <td style="padding: 10px;">{{ $slot->id }}</td>
                                        <td style="padding: 10px; font-weight: 500;">
                                            @if($slot->doctor && $slot->doctor->user)
                                                {{ $slot->doctor->user->full_name }}
                                            @else
                                                Врач #{{ $slot->doctor_id }}
                                            @endif
                                            <br>
                                            <small style="color: #64748b;">
                                                @if($slot->doctor && $slot->doctor->specialization)
                                                    {{ $slot->doctor->specialization->name }}
                                                @endif
                                            </small>
                                        </td>
                                        <td style="padding: 10px;">
                                            {{ \Carbon\Carbon::parse($slot->slot_start)->format('d.m.Y H:i') }}
                                        </td>
                                        <td style="padding: 10px;">
                                            {{ \Carbon\Carbon::parse($slot->slot_end)->format('d.m.Y H:i') }}
                                        </td>
                                        <td style="padding: 10px;">
                                            @if($slot->is_booked)
                                                <span style="background: #ef4444; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                                                    <i class="fas fa-lock"></i> Забронирован
                                                </span>
                                            @else
                                                <span style="background: #10b981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                                                    <i class="fas fa-check-circle"></i> Свободен
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 10px;">
                                            @if($slot->booked_by)
                                                @if($slot->bookedBy)
                                                    {{ $slot->bookedBy->name }}
                                                @else
                                                    ID: {{ $slot->booked_by }}
                                                @endif
                                                <br>
                                                <small style="color: #64748b;">
                                                    {{ $slot->booked_at ? \Carbon\Carbon::parse($slot->booked_at)->format('d.m.Y H:i') : '' }}
                                                </small>
                                            @else
                                                <span style="color: #64748b;">—</span>
                                            @endif
                                        </td>
                                        <td style="padding: 10px; text-align: center;">
                                            @if(!$slot->is_booked)
                                                <a href="" 
                                                class="admin-btn-edit" 
                                                style="background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: inline-block; margin-right: 5px;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('destroy', $slot->id) }}" 
                                                    method="POST" 
                                                    style="display: inline-block;"
                                                    onsubmit="return confirm('Удалить слот?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span style="color: #64748b;">Недоступно</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                                            <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                                            Нет доступных слотов
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Пагинация -->
                            @if(method_exists($slots, 'links'))
                                <div class="pagination-container" style="margin-top: 20px;">
                                    {{ $slots->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <!-- Секция: Настройки -->
            <div id="settings" class="dashboard-section">
                <div class="content-card">
                    <h2>⚙️ Настройки</h2>
                    <p>Общие настройки системы, профиля и уведомлений.</p>
                    <label>🔔 Получать уведомления: <input type="checkbox" checked></label>
                </div>
            </div>
 
        </main>
    </div>
</div>

<script>
    // ПЕРЕКЛЮЧЕНИЕ РАЗДЕЛОВ (аналог первого примера с вкладками)
    document.querySelectorAll('.admin-nav-item').forEach(item => {
        item.addEventListener('click', function() {
            // Убираем класс active у всех пунктов меню
            document.querySelectorAll('.admin-nav-item').forEach(nav => nav.classList.remove('active'));
            // Добавляем класс active текущему пункту
            this.classList.add('active');

            // Получаем id раздела, который нужно показать
            const sectionId = this.getAttribute('data-section'); // "dashboard", "doctors" и т.д.

            // Скрываем все секции
            document.querySelectorAll('.dashboard-section').forEach(section => section.classList.remove('active'));
            // Показываем нужную секцию по id
            const activeSection = document.getElementById(sectionId);
            if (activeSection) {
                activeSection.classList.add('active');
            }
        });
    });

    // Обработчик для кнопки "Выйти" (просто демо)
    document.getElementById('adminLogoutBtn')?.addEventListener('click', () => {
        alert("Вы вышли из системы (демо-режим)");
        // Здесь можно добавить редирект или очистку сессии
    });
</script>

</body>
</html>