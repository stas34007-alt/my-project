<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('styles/consultations.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header class="header">
        <div class="header-container">
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
            
            <div class="header-actions">
                <a href="tel:+79174732572" class="phone">
                    <i class="fas fa-phone-alt"></i>
                    <span>+7 (917) 473-25-72</span>
                </a>
                
                <button class="btn-login">
                    @auth
                        <a href="{{route('private')}}">
                            <i class="fas fa-user"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    @else
                        <a href="{{route('autorisation')}}" class="a" style="text-decoration: none;">
                            <i class="fas fa-user"></i>
                            <span>Войти</span>
                        </a>
                    @endauth
                </button>
            </div>
        </div>
    </header>
<div class="my-consultations-container">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-calendar-check"></i> Мои консультации
        </h1>
        <p class="page-subtitle">История и статус ваших обращений к врачам</p>
    </div>

    <!-- Статистика -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Всего консультаций</div>
            </div>
        </div>
        <div class="stat-card scheduled">
            <div class="stat-info">
                <div class="stat-value">{{ $stats['scheduled'] }}</div>
                <div class="stat-label">Запланировано</div>
            </div>
        </div>
        <div class="stat-card completed">
            <div class="stat-info">
                <div class="stat-value">{{ $stats['completed'] }}</div>
                <div class="stat-label">Завершено</div>
            </div>
        </div>
        <div class="stat-card cancelled">
            <div class="stat-info">
                <div class="stat-value">{{ $stats['cancelled'] }}</div>
                <div class="stat-label">Отменено</div>
            </div>
        </div>
    </div>

    <!-- Список консультаций -->
    <div class="consultations-list">
        @forelse($consultations as $consultation)
        <div class="consultation-card" data-id="{{ $consultation->id }}">
            <div class="card-header">
                <div class="doctor-info">
                    <div class="doctor-avatar">
                        @if($consultation->doctor && $consultation->doctor->user && $consultation->doctor->user->avatar)
                            <img src="{{ asset('images/avatars/' . $consultation->doctor->user->avatar) }}" alt="Doctor">
                        @else
                            <i class="fas fa-user-md"></i>
                        @endif
                    </div>
                    <div class="doctor-details">
                        <h3 class="doctor-name">{{ $consultation->doctor->user->full_name ?? 'Врач не указан' }}</h3>
                        <p class="doctor-specialty">{{ $consultation->doctor->specialization->name ?? 'Специализация не указана' }}</p>
                        <div class="doctor-experience">
                            <i class="fas fa-briefcase"></i> Стаж: {{ $consultation->doctor->years_of_experience ?? 0 }} лет
                        </div>
                    </div>
                </div>
                <div class="status-badge status-{{ $consultation->status }}">
                    @if($consultation->status == 'scheduled')
                        <i class="fas fa-clock"></i> Запланирована
                    @elseif($consultation->status == 'completed')
                        <i class="fas fa-check-circle"></i> Завершена
                    @elseif($consultation->status == 'cancelled')
                        <i class="fas fa-ban"></i> Отменена
                    @elseif($consultation->status == 'in_progress')
                        <i class="fas fa-video"></i> В процессе
                    @else
                        <i class="fas fa-hourglass"></i> {{ $consultation->status }}
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="info-row">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span class="info-label">Дата и время:</span>
                        <span class="info-value">
                            @if($consultation->slot && $consultation->slot->slot_start)
                                {{ \Carbon\Carbon::parse($consultation->slot->slot_start)->format('d.m.Y H:i') }}
                            @elseif($consultation->started_at)
                                {{ \Carbon\Carbon::parse($consultation->started_at)->format('d.m.Y H:i') }}
                            @else
                                {{ $consultation->created_at->format('d.m.Y H:i') }}
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-comment"></i>
                        <span class="info-label">Тип консультации:</span>
                        <span class="info-value">
                            @if($consultation->type == 'video')
                                <span class="type-badge"><i class="fas fa-video"></i> Видеозвонок</span>
                            @elseif($consultation->type == 'chat')
                                <span class="type-badge"><i class="fas fa-comment-dots"></i> Чат</span>
                            @else
                                <span class="type-badge"><i class="fas fa-phone"></i> Телефон</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-ruble-sign"></i>
                        <span class="info-label">Стоимость:</span>
                        <span class="info-value price">{{ number_format($consultation->final_price, 0) }} ₽</span>
                    </div>
                </div>

                @if($consultation->symptoms)
                <div class="symptoms-box">
                    <h4><i class="fas fa-notes-medical"></i> Ваши жалобы / симптомы</h4>
                    <p>{{ $consultation->symptoms }}</p>
                </div>
                @endif

                @if($consultation->diagnosis)
                <div class="diagnosis-box">
                    <h4><i class="fas fa-diagnoses"></i> Диагноз</h4>
                    <p>{{ $consultation->diagnosis }}</p>
                </div>
                @endif

                @if($consultation->doctor_notes)
                <div class="notes-box">
                    <h4><i class="fas fa-sticky-note"></i> Рекомендации врача</h4>
                    <p>{{ $consultation->doctor_notes }}</p>
                </div>
                @endif

                @if($consultation->meeting_link && $consultation->status == 'scheduled')
                <div class="meeting-link-box">
                    <a href="{{ $consultation->meeting_link }}" target="_blank" class="btn-meeting">
                        <i class="fas fa-video"></i> Присоединиться к консультации
                    </a>
                </div>
                @endif

                @if($consultation->review)
                <div class="review-box">
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $consultation->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="review-rating">{{ $consultation->rating }}/5</span>
                    </div>
                    <p class="review-text">"{{ $consultation->review }}"</p>
                </div>
                @endif

                @if($consultation->cancellation_reason)
                <div class="cancellation-box">
                    <h4><i class="fas fa-info-circle"></i> Причина отмены</h4>
                    <p>{{ $consultation->cancellation_reason }}</p>
                </div>
                @endif
            </div>

            <div class="card-footer">
                <!-- Кнопка подключения к консультации -->
                @if($consultation->type == 'video' && $consultation->status == 'scheduled')
                    @if($consultation->meeting_link)
                        <a href="{{ $consultation->meeting_link }}" target="_blank" class="btn-join-call">
                            <i class="fas fa-video"></i> Присоединиться
                        </a>
                    @else
                        <button class="btn-generate-link" onclick="generateMeetingLink({{ $consultation->id }})">
                            <i class="fas fa-link"></i> Создать ссылку для звонка
                        </button>
                    @endif
                @endif

                @if($consultation->status == 'scheduled')
                    <button class="btn-cancel-appointment" onclick="cancelConsultation({{ $consultation->id }})">
                        <i class="fas fa-times"></i> Отменить запись
                    </button>
                    <button class="btn-reschedule" onclick="rescheduleConsultation({{ $consultation->id }})">
                        <i class="fas fa-calendar-alt"></i> Перенести
                    </button>
                @endif
                
                @if($consultation->status == 'completed' && !$consultation->review)
                    <button class="btn-review" onclick="leaveReview({{ $consultation->id }})">
                        <i class="fas fa-star"></i> Оставить отзыв
                    </button>
                @endif
                
                <button class="btn-detail" onclick="showDetail({{ $consultation->id }})">
                    <i class="fas fa-info-circle"></i> Подробнее
                </button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h3>У вас пока нет консультаций</h3>
            <p>Запишитесь к врачу, чтобы получить квалифицированную помощь</p>
            <a href="{{ route('doctors.index') }}" class="btn-primary">
                <i class="fas fa-search"></i> Найти врача
            </a>
        </div>
        @endforelse
    </div>
</div>

<script>
// CSRF токен



function generateMeetingLink(consultationId) {
    fetch(`/consultations/${consultationId}/generate-link`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Ошибка: ' + data.message);
        }
    })
    .catch(error => {
        alert('Ошибка при создании ссылки');
    });
}


// Отмена консультации
function cancelConsultation(id) {
    const reason = prompt('Укажите причину отмены:');
    if (reason === null) return;
    
    fetch(`/my-consultations/${id}/cancel`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Ошибка при отмене записи');
    });
}

// Перенос консультации
function rescheduleConsultation(id) {
    alert('Функция переноса в разработке');
}

// Оставить отзыв
function leaveReview(id) {
    const rating = prompt('Оцените консультацию (1-5):', '5');
    if (!rating) return;
    
    const review = prompt('Напишите ваш отзыв:');
    if (!review) return;
    
    fetch(`/consultations/${id}/review`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ rating: parseInt(rating), review: review })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
}

// Детали консультации
function showDetail(id) {
    window.location.href = `/my-consultations/${id}`;
}
</script>
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
</body>
</html>