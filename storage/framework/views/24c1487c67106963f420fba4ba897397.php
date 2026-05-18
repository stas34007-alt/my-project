<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo e(asset('styles/detail.css')); ?>">
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
                    <li><a href="<?php echo e(route('Onas')); ?>">О нас</a></li>
                    <li><a href="/doctors">Врачи</a></li>
                     <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->user_type == 'doctor'): ?>
                            <li><a href="<?php echo e(route('doctor.diagnosis.index')); ?>">Мои пациенты</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo e(route('my.consultations')); ?>">Мои консультации</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?php echo e(route('my.consultations')); ?>">Мои консультации</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="header-actions">
                <a href="tel:+79174732572" class="phone">
                    <i class="fas fa-phone-alt"></i>
                    <span>+7 (917) 473-25-72</span>
                </a>
                
                <button class="btn-login">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('private')); ?>">
                            <i class="fas fa-user"></i>
                            <span><?php echo e(Auth::user()->name); ?></span>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('autorisation')); ?>" class="a" style="text-decoration: none;">
                            <i class="fas fa-user"></i>
                            <span>Войти</span>
                        </a>
                    <?php endif; ?>
                </button>
            </div>
        </div>
    </header>
    <div class="detail-container">
    <div class="detail-card">
        <div class="detail-header">
            <a href="<?php echo e(route('my.consultations')); ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Назад к консультациям
            </a>
            <h1>Консультация #<?php echo e($consultation->id); ?></h1>
        </div>

        <div class="detail-content">
            <!-- Врач -->
            <div class="doctor-section">
                <div class="doctor-avatar">
                    <?php if($consultation->doctor && $consultation->doctor->user && $consultation->doctor->user->avatar): ?>
                        <img src="<?php echo e(asset('images/avatars/' . $consultation->doctor->user->avatar)); ?>" alt="Doctor">
                    <?php else: ?>
                        <i class="fas fa-user-md"></i>
                    <?php endif; ?>
                </div>
                <div class="doctor-info">
                    <h2><?php echo e($consultation->doctor->user->full_name ?? 'Врач не указан'); ?></h2>
                    <p class="specialty"><?php echo e($consultation->doctor->specialization->name ?? 'Специализация не указана'); ?></p>
                    <p class="experience">Стаж: <?php echo e($consultation->doctor->years_of_experience ?? 0); ?> лет</p>
                </div>
            </div>

            <!-- Детали -->
            <div class="details-grid">
                <div class="detail-item">
                    <i class="fas fa-calendar"></i>
                    <strong>Дата:</strong>
                    <span><?php echo e($consultation->slot->slot_start ? \Carbon\Carbon::parse($consultation->slot->slot_start)->format('d.m.Y H:i') : 'Не указано'); ?></span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-comment"></i>
                    <strong>Тип:</strong>
                    <span><?php echo e($consultation->type == 'video' ? 'Видеозвонок' : ($consultation->type == 'chat' ? 'Чат' : 'Телефон')); ?></span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-ruble-sign"></i>
                    <strong>Стоимость:</strong>
                    <span><?php echo e(number_format($consultation->final_price, 0)); ?> ₽</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-clock"></i>
                    <strong>Статус:</strong>
                    <span class="status"><?php echo e($consultation->status); ?></span>
                </div>
            </div>

            <!-- Жалобы -->
            <?php if($consultation->symptoms): ?>
            <div class="section">
                <h3><i class="fas fa-notes-medical"></i> Ваши жалобы / симптомы</h3>
                <p><?php echo e($consultation->symptoms); ?></p>
            </div>
            <?php endif; ?>

            <!-- Диагноз -->
            <?php if($consultation->diagnosis): ?>
            <div class="section">
                <h3><i class="fas fa-diagnoses"></i> Диагноз</h3>
                <p><?php echo e($consultation->diagnosis); ?></p>
            </div>
            <?php endif; ?>

            <!-- Рекомендации -->
            <?php if($consultation->doctor_notes): ?>
            <div class="section">
                <h3><i class="fas fa-sticky-note"></i> Рекомендации врача</h3>
                <p><?php echo e($consultation->doctor_notes); ?></p>
            </div>
            <?php endif; ?>

            <!-- Отзыв -->
            <?php if($consultation->review): ?>
            <div class="section review">
                <h3><i class="fas fa-star"></i> Ваш отзыв</h3>
                <div class="stars">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <?php if($i <= $consultation->rating): ?>
                            <i class="fas fa-star"></i>
                        <?php else: ?>
                            <i class="far fa-star"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <p class="review-text"><?php echo e($consultation->review); ?></p>
            </div>
            <?php endif; ?>
        </div>
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
</html><?php /**PATH C:\OSPanel\domains\diplom-2026\resources\views/consultation-detail.blade.php ENDPATH**/ ?>