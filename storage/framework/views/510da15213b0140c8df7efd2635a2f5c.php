<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись диагноза | Врач</title>
    <link rel="stylesheet" href="<?php echo e(asset('styles/diagnosis.css')); ?>">
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
    <div class="diagnosis-wrapper">
        <h1 class="page-title">
            <i class="fas fa-stethoscope"></i> 
            Запись диагноза
        </h1>
        
        <?php $__empty_1 = true; $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="patient-card">
            <div class="patient-info">
                <div class="patient-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="patient-details">
                    <h3 class="patient-name"><?php echo e($consultation->patient->user->full_name ?? 'Пациент'); ?></h3>
                    <div class="patient-date">
                        <i class="fas fa-calendar-alt"></i>
                        <?php echo e($consultation->created_at->format('d.m.Y H:i')); ?>

                    </div>
                    
                    <?php if($consultation->status == 'in_progress'): ?>
                        <div class="status-badge status-in_progress" style="margin-top: 8px;">
                            <i class="fas fa-play-circle"></i> В процессе
                        </div>
                    <?php elseif($consultation->status == 'scheduled'): ?>
                        <div class="status-badge status-scheduled" style="margin-top: 8px;">
                            <i class="fas fa-clock"></i> Ожидает
                        </div>
                    <?php endif; ?>
                    
                    <?php if($consultation->symptoms): ?>
                        <div class="patient-symptoms">
                            <i class="fas fa-notes-medical"></i>
                            <span><?php echo e(Str::limit($consultation->symptoms, 80)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="patient-actions">
                <?php if($consultation->diagnosis): ?>
                    <a href="<?php echo e(route('doctor.diagnosis.show', $consultation->id)); ?>" class="btn btn-view">
                        <i class="fas fa-eye"></i> Просмотр
                    </a>
                    <a href="<?php echo e(route('doctor.diagnosis.edit', $consultation->id)); ?>" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Редактировать
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('doctor.diagnosis.form', $consultation->id)); ?>" class="btn btn-diagnosis">
                        <i class="fas fa-file-medical"></i> Записать диагноз
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state">
            <i class="fas fa-smile-wink"></i>
            <h3>Нет активных приёмов</h3>
            <p>Когда пациенты запишутся к вам на приём, они появятся здесь</p>
        </div>
        <?php endif; ?>
        
        <?php if($consultations->hasPages()): ?>
        <div class="pagination-wrapper">
            <?php echo e($consultations->links()); ?>

        </div>
        <?php endif; ?>
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
</html><?php /**PATH C:\OSPanel\domains\diplom-2026\resources\views/doctor/diagnosis/index.blade.php ENDPATH**/ ?>