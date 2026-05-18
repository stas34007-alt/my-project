<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://img.icons8.com/color/48/google-logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('styles/doctor.css')); ?>">
    <title>Document</title>
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
            
            <!-- Контакты и вход -->
            <div class="header-actions">
                <a href="tel:+79174732572" class="phone">
                    <i class="fas fa-phone-alt"></i>
                    <span>+7 (917) 473-25-72</span>
                </a>
                
                <button class="btn-login">
                    <a href="<?php echo e(route('private')); ?>"><i class="fas fa-user"></i></a>
                    <?php if(auth()->guard()->check()): ?>

                    <?php else: ?>
                        <a href="<?php echo e(route('autorisation')); ?>"><span>Войти</span></a>
                    <?php endif; ?>
                </button>
            </div>
        </div>
    </header>
    <main style="margin-top: 20vh;">
        <div class="cont-doctor-card">
            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <div class="doctor-card">
                <div class="card-header">
                    <img src="<?php echo e(asset('images/' . $doctor->avatar)); ?>" 
                        alt="<?php echo e($doctor->user->full_name); ?>" 
                        class="doctor-photo">
                    
                    <div class="doctor-info">
                        <h2 class="doctor-name"><?php echo e($doctor->user->full_name); ?></h2>
                        <p class="doctor-specialty"><?php echo e($doctor->specialization->name); ?></p>
                        
                        <div class="doctor-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-score">4.9</span>
                            <span class="reviews-count">(147 отзывов)</span>
                        </div>
                    </div>
                </div>
                
                <div class="doctor-badges">
                    <span class="badge">👨‍⚕️ 12 лет опыта</span>
                    <span class="badge">🎓 Кандидат наук</span>
                    <span class="badge">💬 Отвечает за 1 час</span>
                </div>
                
                <div class="doctor-details">
                    <div class="detail-item">
                        <span class="detail-label">Следующий приём:</span>
                        <span class="detail-value">Сегодня, 18:30</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Среднее время приёма:</span>
                        <span class="detail-value">30 минут</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Пациентов в день:</span>
                        <span class="detail-value">15-20</span>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="price">
                        <?php echo e($doctor->online_consultation_price); ?>

                        <span class="price-label">первичный приём</span>
                    </div>
                    <a href="<?php echo e(route('show_doctor', $doctor->id)); ?>"><button class="btn-book">Записаться</button></a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
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
</body>
</html><?php /**PATH C:\OSPanel\domains\diplom-2026\resources\views/doctors.blade.php ENDPATH**/ ?>