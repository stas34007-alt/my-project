<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Личный кабинет - {{ $userType == 'patient' ? 'Пациент' : 'Врач' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{asset('styles/private_room.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="{{ $userType == 'patient' ? 'patient-design' : 'doctor-design' }}">
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
    <main class="main-content">
        {{-- Сообщения --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Приветственная секция --}}
        <div class="welcome-section">
            <div class="welcome-card">
                <div class="welcome-text">
                    <h1>Добро пожаловать, {{ $user->full_name }}! 👋</h1>
                    <p>Рады видеть вас в вашем личном кабинете {{ $userType == 'patient' ? 'пациента' : 'врача' }}</p>
                </div>
                <div class="welcome-badge">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->translatedFormat('j F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Основная сетка профиля --}}
        <div class="profile-grid">
            <!-- Левая колонка - информация о пользователе (общая) -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="avatar">
                        @if($user->avatar)
                            <img src="{{ asset('images/avatars/' . $user->avatar) }}" alt="Avatar" class="avatar-img">
                        @else
                            <i class="fas {{ $userType == 'patient' ? 'fa-user-injured' : 'fa-user-md' }}"></i>
                        @endif
                    </div>
                    <h2 class="profile-name">{{ $user->full_name }}</h2>
                    <span class="profile-role">
                        {{ $userType == 'patient' ? 'Пациент' : ($userType == 'doctor' ? 'Врач' : 'Администратор') }}
                    </span>
                </div>
                <div class="profile-info">
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <div class="info-content">
                            <div class="info-label">Телефон</div>
                            <div class="info-value">{{ $user->phone ?? 'Не указан' }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-cake-candles"></i></div>
                        <div class="info-content">
                            <div class="info-label">Дата рождения</div>
                            <div class="info-value">{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d.m.Y') : 'Не указана' }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-venus-mars"></i></div>
                        <div class="info-content">
                            <div class="info-label">Пол</div>
                            <div class="info-value">
                                @switch($user->gender)
                                    @case('M') Мужской @break
                                    @case('F') Женский @break
                                    @case('O') Другой @break
                                    @default Не указан
                                @endswitch
                            </div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <div class="info-label">Адрес</div>
                            <div class="info-value">{{ $user->address ?? 'Не указан' }}</div>
                        </div>
                    </div>
                    
                    {{-- Дополнительная информация для врачей --}}
                    @if($userType == 'doctor' && isset($doctor))
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-stethoscope"></i></div>
                        <div class="info-content">
                            <div class="info-label">Специализация</div>
                            <div class="info-value">{{$doctor->specialization->name ?? 'Не указана' }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="info-content">
                            <div class="info-label">Квалификация</div>
                            <div class="info-value">{{ $doctor->qualification ?? 'Не указана' }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Правая колонка - форма редактирования (общая) --}}
            <div class="edit-card">
                <div class="edit-header">
                    <h2><i class="fas fa-user-edit"></i> Редактирование профиля</h2>
                </div>
                <form class="edit-form" action="{{ route('private.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-user"></i> Полное имя</label>
                        <input type="text" name="full_name" class="form-input" value="{{ old('full_name', $user->full_name) }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-phone"></i> Телефон</label>
                            <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-cake-candles"></i> Дата рождения</label>
                            <input type="date" name="date_of_birth" class="form-input" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-venus-mars"></i> Пол</label>
                            <select name="gender" class="form-input">
                                <option value="">Не указан</option>
                                <option value="M" {{ $user->gender == 'M' ? 'selected' : '' }}>Мужской</option>
                                <option value="F" {{ $user->gender == 'F' ? 'selected' : '' }}>Женский</option>
                                <option value="O" {{ $user->gender == 'O' ? 'selected' : '' }}>Другой</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-map-marker-alt"></i> Адрес</label>
                        <input type="text" name="address" class="form-input" value="{{ old('address', $user->address) }}" placeholder="Ваш адрес проживания">
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-image"></i> Аватар</label>
                        <input type="file" name="avatar" class="form-input" accept="image/*">
                        <small style="color: var(--text-light); font-size: 0.7rem; margin-top: 5px; display: block;">Допустимые форматы: JPG, PNG. Максимальный размер: 2MB</small>
                    </div>

                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Сохранить изменения
                    </button>
                </form>
            </div>
        </div>

        {{-- Статистика для ПАЦИЕНТОВ --}}
        @if($userType == 'patient')
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number">{{ $consultationsCount ?? 0 }}</div>
                <div class="stat-label">Всего консультаций</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $appointmentsUpcoming ?? 0 }}</div>
                <div class="stat-label">Предстоящих приёмов</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $filesCount ?? 0 }}</div>
                <div class="stat-label">Медицинских файлов</div>
            </div>
        </div>
        
        {{-- Последние консультации для пациентов --}}
        @if(isset($recentConsultations) && $recentConsultations->count() > 0)
        <div class="appointments-section">
            <h3><i class="fas fa-history"></i> Последние консультации</h3>
            @foreach($recentConsultations as $consultation)
            <div class="appointment-item">
                <div class="appointment-time">
                    <i class="fas fa-calendar"></i> 
                    {{ $consultation->slot->slot_start ?? 'Дата не указана' }}
                </div>
                <div class="appointment-patient">
                    <i class="fas fa-user-md"></i> 
                    Врач: {{ $consultation->doctor->full_name ?? 'Не указан' }}
                </div>
                <div class="appointment-status">
                    <span class="badge badge-success">Завершено</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @endif

        {{-- Статистика для ВРАЧЕЙ --}}
        @if($userType == 'doctor')
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number">{{ $patientsCount ?? 0 }}</div>
                <div class="stat-label">Всего пациентов</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $appointmentsToday ?? 0 }}</div>
                <div class="stat-label">Приёмов сегодня</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $totalConsultations ?? 0 }}</div>
                <div class="stat-label">Всего консультаций</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $experienceYears ?? 0 }}</div>
                <div class="stat-label">Лет опыта</div>
            </div>
        </div>
        
        {{-- Сегодняшние приемы для врачей --}}
        @if(isset($todayAppointments) && $todayAppointments->count() > 0)
        <div class="appointments-section">
            <h3><i class="fas fa-calendar-day"></i> Приёмы на сегодня</h3>
            @foreach($todayAppointments as $appointment)
            <div class="appointment-item">
                <div class="appointment-time">
                    <i class="fas fa-clock"></i> 
                    {{ \Carbon\Carbon::parse($appointment->slot->slot_start)->format('H:i') ?? 'Время не указано' }}
                </div>
                <div class="appointment-patient">
                    <i class="fas fa-user-injured"></i> 
                    Пациент: {{ $appointment->patient->user->full_name ?? 'Не указан' }}
                </div>
                <div class="appointment-status">
                    <span class="badge badge-warning">Ожидает</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        {{-- Предстоящие приемы для врачей --}}
        @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
        <div class="appointments-section">
            <h3><i class="fas fa-calendar-week"></i> Предстоящие приёмы</h3>
            @foreach($upcomingAppointments as $appointment)
            <div class="appointment-item">
                <div class="appointment-time">
                    <i class="fas fa-calendar"></i> 
                    {{ \Carbon\Carbon::parse($appointment->slot->slot_start)->format('d.m.Y H:i') ?? 'Дата не указана' }}
                </div>
                <div class="appointment-patient">
                    <i class="fas fa-user-injured"></i> 
                    Пациент: {{ $appointment->patient->user->full_name ?? 'Не указан' }}
                </div>
                <div class="appointment-status">
                    <span class="badge badge-info">Запланирован</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @endif
    </main>
    <footer>
        <div class="container">
            <!-- основная сетка: больше информации, синий во всех оттенках -->
            <div class="footer-flex">
                <!-- колонка: бренд и описание -->
                <div class="logo-area">
                    <div class="about">
                        Круглосуточная телемедицина, запись к врачам, вызов на дом и электронные рецепты. Работаем с 2012 года.
                    </div>
                    <div class="social">
                        <a href="#" aria-label="Telegram">📱</a>
                        <a href="#" aria-label="VK">📘</a>
                        <a href="#" aria-label="WhatsApp">💬</a>
                        <a href="#" aria-label="YouTube">▶️</a>
                    </div>
                </div>
                <!-- колонка: пациентам -->
                <div class="footer-coll">
                    <h4>Пациентам</h4>
                    <a href="#">Найти врача</a>
                    <a href="#">Запись онлайн</a>
                    <a href="#">Анализы</a>
                    <a href="#">Вызов на дом</a>
                    <a href="#">Телемедицина</a>
                </div>
                <!-- колонка: о компании -->
                <div class="footer-coll">
                    <h4>О нас</h4>
                    <a href="#">Клиники и центры</a>
                    <a href="#">Врачи и специалисты</a>
                    <a href="#">Лицензии</a>
                    <a href="#">Вакансии</a>
                    <a href="#">Новости</a>
                </div>
                <!-- колонка: контакты + доп информация -->
                <div class="footer-col contacts">
                    <h4>Контакты</h4>
                    <p><i>📞</i> 8 (800) 550‑35‑25</p>
                    <p><i>✉️</i> support@medservice.ru</p>
                    <p><i>📍</i> Москва, ул. Сеченова, 12</p>
                    <p style="margin-top: 1.2rem; color: #b0d3f0;">📅 Ежедневно 8:00 – 22:00</p>
                </div>
            </div>

            <!-- нижний блок: копирайт, документы, лицензия -->
            <div class="bottom">
                <span>© 2026 ООО «МедСервис». Все права защищены.</span>
                <div class="bottom-links">
                    <a href="#">Политика конфиденциальности</a>
                    <a href="#">Пользовательское соглашение</a>
                    <a href="#">Лицензия ЛО‑77‑01‑023456</a>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Скрипт для header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 50 && header) {
                header.classList.add('scrolled');
            } else if (header) {
                header.classList.remove('scrolled');
            }
        });

        // Автоматическое скрытие сообщений через 5 секунд
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(-20px)';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>