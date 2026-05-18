<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись диагноза | Врач</title>
    <link rel="stylesheet" href="{{asset('styles/diagnosis.css')}}">
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
    <div class="diagnosis-wrapper">
        <h1 class="page-title">
            <i class="fas fa-stethoscope"></i> 
            Запись диагноза
        </h1>
        
        @forelse($consultations as $consultation)
        <div class="patient-card">
            <div class="patient-info">
                <div class="patient-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="patient-details">
                    <h3 class="patient-name">{{ $consultation->patient->user->full_name ?? 'Пациент' }}</h3>
                    <div class="patient-date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $consultation->created_at->format('d.m.Y H:i') }}
                    </div>
                    
                    @if($consultation->status == 'in_progress')
                        <div class="status-badge status-in_progress" style="margin-top: 8px;">
                            <i class="fas fa-play-circle"></i> В процессе
                        </div>
                    @elseif($consultation->status == 'scheduled')
                        <div class="status-badge status-scheduled" style="margin-top: 8px;">
                            <i class="fas fa-clock"></i> Ожидает
                        </div>
                    @endif
                    
                    @if($consultation->symptoms)
                        <div class="patient-symptoms">
                            <i class="fas fa-notes-medical"></i>
                            <span>{{ Str::limit($consultation->symptoms, 80) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="patient-actions">
                @if($consultation->diagnosis)
                    <a href="{{ route('doctor.diagnosis.show', $consultation->id) }}" class="btn btn-view">
                        <i class="fas fa-eye"></i> Просмотр
                    </a>
                    <a href="{{ route('doctor.diagnosis.edit', $consultation->id) }}" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Редактировать
                    </a>
                @else
                    <a href="{{ route('doctor.diagnosis.form', $consultation->id) }}" class="btn btn-diagnosis">
                        <i class="fas fa-file-medical"></i> Записать диагноз
                    </a>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-smile-wink"></i>
            <h3>Нет активных приёмов</h3>
            <p>Когда пациенты запишутся к вам на приём, они появятся здесь</p>
        </div>
        @endforelse
        
        @if($consultations->hasPages())
        <div class="pagination-wrapper">
            {{ $consultations->links() }}
        </div>
        @endif
    </div>
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