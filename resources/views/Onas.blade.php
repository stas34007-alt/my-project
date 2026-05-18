<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас - Телемедицина</title>
    <link rel="stylesheet" href="{{ asset('styles/Onas.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <li><a href="/analyses">Анализы</a></li>
                    <li><a href="{{route('Onas')}}">О нас</a></li>
                    <li><a href="/doctors">Врачи</a></li>
                    <li><a href="{{route('my.consultations')}}">Мои консультации</a></li>
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
    <div class="container" style="margin-top: 25vh">
        <!-- Миссия -->
        <div class="mission-section">
            <div class="mission-icon">
                <i class="fas fa-heartbeat"></i>
            </div>
            <h2>Наша миссия</h2>
            <p>Сделать медицинскую помощь доступной, удобной и качественной для каждого человека, где бы он ни находился. Мы объединяем лучших врачей и современные технологии, чтобы забота о здоровье стала проще.</p>
        </div>
        
        <!-- Ценности -->
        <div class="values-section">
            <h2 class="section-title">Наши ценности</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-star-of-life"></i></div>
                    <h3>Качество</h3>
                    <p>Только проверенные врачи с многолетним опытом и актуальными сертификатами</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Безопасность</h3>
                    <p>Конфиденциальность данных и защита личной информации — наш приоритет</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-clock"></i></div>
                    <h3>Доступность</h3>
                    <p>Консультации 24/7 из любой точки мира без очередей и ожидания</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3>Забота</h3>
                    <p>Индивидуальный подход к каждому пациенту и внимание к деталям</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Команда -->
    <div class="team-section">
        <div class="container">
            <h2 class="section-title">Ключевые специалисты</h2>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar"><i class="fas fa-user-md"></i></div>
                    <h3>Алексей Васильев</h3>
                    <div class="team-position">Главный врач, кардиолог</div>
                    <div class="team-desc">Стаж 15 лет. Кандидат медицинских наук. Эксперт в области кардиологии и профилактики сердечно-сосудистых заболеваний.</div>
                </div>
                <div class="team-card">
                    <div class="team-avatar"><i class="fas fa-brain"></i></div>
                    <h3>Елена Соколова</h3>
                    <div class="team-position">Руководитель неврологии</div>
                    <div class="team-desc">Стаж 12 лет. Специализируется на лечении мигрени, невропатий и реабилитации после инсультов.</div>
                </div>
                <div class="team-card">
                    <div class="team-avatar"><i class="fas fa-child"></i></div>
                    <h3>Мария Крылова</h3>
                    <div class="team-position">Педиатр</div>
                    <div class="team-desc">Стаж 10 лет. Детский врач с современным подходом. Помогает родителям заботиться о здоровье детей.</div>
                </div>
                <div class="team-card">
                    <div class="team-avatar"><i class="fas fa-laptop-code"></i></div>
                    <h3>Дмитрий Волков</h3>
                    <div class="team-position">Технический директор</div>
                    <div class="team-desc">Обеспечивает бесперебойную работу платформы и защиту данных пациентов.</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Статистика -->
    <div class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div>
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Врачей на платформе</div>
                </div>
                <div>
                    <div class="stat-number">50 000+</div>
                    <div class="stat-label">Довольных пациентов</div>
                </div>
                <div>
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Поддержка</div>
                </div>
                <div>
                    <div class="stat-number">4.9 ★</div>
                    <div class="stat-label">Средний рейтинг</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <!-- Преимущества -->
        <div class="advantages-section">
            <h2 class="section-title">Почему выбирают нас</h2>
            <div class="advantages-grid">
                <div class="advantage-item">
                    <div class="advantage-icon"><i class="fas fa-video"></i></div>
                    <div class="advantage-text">
                        <h4>Онлайн-консультации</h4>
                        <p>Получайте помощь врача, не выходя из дома. Видеозвонки высокого качества.</p>
                    </div>
                </div>
                <div class="advantage-item">
                    <div class="advantage-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="advantage-text">
                        <h4>Электронные рецепты</h4>
                        <p>Удобное оформление и получение рецептов онлайн.</p>
                    </div>
                </div>
                <div class="advantage-item">
                    <div class="advantage-icon"><i class="fas fa-history"></i></div>
                    <div class="advantage-text">
                        <h4>История консультаций</h4>
                        <p>Все консультации и назначения хранятся в личном кабинете.</p>
                    </div>
                </div>
                <div class="advantage-item">
                    <div class="advantage-icon"><i class="fas fa-user-friends"></i></div>
                    <div class="advantage-text">
                        <h4>Подбор врача</h4>
                        <p>Поможем выбрать специалиста под вашу ситуацию.</p>
                    </div>
                </div>
                <div class="advantage-item">
                    <div class="advantage-icon"><i class="fas fa-lock"></i></div>
                    <div class="advantage-text">
                        <h4>Конфиденциальность</h4>
                        <p>Ваши данные защищены и не передаются третьим лицам.</p>
                    </div>
                </div>
                <div class="advantage-item">
                    <div class="advantage-icon"><i class="fas fa-headset"></i></div>
                    <div class="advantage-text">
                        <h4>Круглосуточная поддержка</h4>
                        <p>Операторы готовы помочь в любое время дня и ночи.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA -->
    <div class="cta-section">
        <div class="container">
            <h2>Готовы заботиться о вашем здоровье</h2>
            <p style="color: #64748b; max-width: 500px; margin: 15px auto;">Присоединяйтесь к тысячам пациентов, которые уже выбрали современный подход к медицине</p>
            <a href="#" class="cta-button">Записаться на консультацию</a>
        </div>
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