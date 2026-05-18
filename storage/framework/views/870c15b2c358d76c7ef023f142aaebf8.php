<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Личный кабинет - <?php echo e($userType == 'patient' ? 'Пациент' : 'Врач'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?php echo e(asset('styles/private_room.css')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="<?php echo e($userType == 'patient' ? 'patient-design' : 'doctor-design'); ?>">
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
    <main class="main-content">
        
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <div class="welcome-section">
            <div class="welcome-card">
                <div class="welcome-text">
                    <h1>Добро пожаловать, <?php echo e($user->full_name); ?>! 👋</h1>
                    <p>Рады видеть вас в вашем личном кабинете <?php echo e($userType == 'patient' ? 'пациента' : 'врача'); ?></p>
                </div>
                <div class="welcome-badge">
                    <i class="fas fa-calendar-alt"></i>
                    <span><?php echo e(now()->translatedFormat('j F Y')); ?></span>
                </div>
            </div>
        </div>

        
        <div class="profile-grid">
            <!-- Левая колонка - информация о пользователе (общая) -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="avatar">
                        <?php if($user->avatar): ?>
                            <img src="<?php echo e(asset('images/avatars/' . $user->avatar)); ?>" alt="Avatar" class="avatar-img">
                        <?php else: ?>
                            <i class="fas <?php echo e($userType == 'patient' ? 'fa-user-injured' : 'fa-user-md'); ?>"></i>
                        <?php endif; ?>
                    </div>
                    <h2 class="profile-name"><?php echo e($user->full_name); ?></h2>
                    <span class="profile-role">
                        <?php echo e($userType == 'patient' ? 'Пациент' : ($userType == 'doctor' ? 'Врач' : 'Администратор')); ?>

                    </span>
                </div>
                <div class="profile-info">
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?php echo e($user->email); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <div class="info-content">
                            <div class="info-label">Телефон</div>
                            <div class="info-value"><?php echo e($user->phone ?? 'Не указан'); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-cake-candles"></i></div>
                        <div class="info-content">
                            <div class="info-label">Дата рождения</div>
                            <div class="info-value"><?php echo e($user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d.m.Y') : 'Не указана'); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-venus-mars"></i></div>
                        <div class="info-content">
                            <div class="info-label">Пол</div>
                            <div class="info-value">
                                <?php switch($user->gender):
                                    case ('M'): ?> Мужской <?php break; ?>
                                    <?php case ('F'): ?> Женский <?php break; ?>
                                    <?php case ('O'): ?> Другой <?php break; ?>
                                    <?php default: ?> Не указан
                                <?php endswitch; ?>
                            </div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <div class="info-label">Адрес</div>
                            <div class="info-value"><?php echo e($user->address ?? 'Не указан'); ?></div>
                        </div>
                    </div>
                    
                    
                    <?php if($userType == 'doctor' && isset($doctor)): ?>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-stethoscope"></i></div>
                        <div class="info-content">
                            <div class="info-label">Специализация</div>
                            <div class="info-value"><?php echo e($doctor->specialization->name ?? 'Не указана'); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="info-content">
                            <div class="info-label">Квалификация</div>
                            <div class="info-value"><?php echo e($doctor->qualification ?? 'Не указана'); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="edit-card">
                <div class="edit-header">
                    <h2><i class="fas fa-user-edit"></i> Редактирование профиля</h2>
                </div>
                <form class="edit-form" action="<?php echo e(route('private.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-user"></i> Полное имя</label>
                        <input type="text" name="full_name" class="form-input" value="<?php echo e(old('full_name', $user->full_name)); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-input" value="<?php echo e(old('email', $user->email)); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-phone"></i> Телефон</label>
                            <input type="tel" name="phone" class="form-input" value="<?php echo e(old('phone', $user->phone)); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-cake-candles"></i> Дата рождения</label>
                            <input type="date" name="date_of_birth" class="form-input" value="<?php echo e(old('date_of_birth', $user->date_of_birth)); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-venus-mars"></i> Пол</label>
                            <select name="gender" class="form-input">
                                <option value="">Не указан</option>
                                <option value="M" <?php echo e($user->gender == 'M' ? 'selected' : ''); ?>>Мужской</option>
                                <option value="F" <?php echo e($user->gender == 'F' ? 'selected' : ''); ?>>Женский</option>
                                <option value="O" <?php echo e($user->gender == 'O' ? 'selected' : ''); ?>>Другой</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-map-marker-alt"></i> Адрес</label>
                        <input type="text" name="address" class="form-input" value="<?php echo e(old('address', $user->address)); ?>" placeholder="Ваш адрес проживания">
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

        
        <?php if($userType == 'patient'): ?>
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number"><?php echo e($consultationsCount ?? 0); ?></div>
                <div class="stat-label">Всего консультаций</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($appointmentsUpcoming ?? 0); ?></div>
                <div class="stat-label">Предстоящих приёмов</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($filesCount ?? 0); ?></div>
                <div class="stat-label">Медицинских файлов</div>
            </div>
        </div>
        
        
        <?php if(isset($recentConsultations) && $recentConsultations->count() > 0): ?>
        <div class="appointments-section">
            <h3><i class="fas fa-history"></i> Последние консультации</h3>
            <?php $__currentLoopData = $recentConsultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="appointment-item">
                <div class="appointment-time">
                    <i class="fas fa-calendar"></i> 
                    <?php echo e($consultation->slot->slot_start ?? 'Дата не указана'); ?>

                </div>
                <div class="appointment-patient">
                    <i class="fas fa-user-md"></i> 
                    Врач: <?php echo e($consultation->doctor->full_name ?? 'Не указан'); ?>

                </div>
                <div class="appointment-status">
                    <span class="badge badge-success">Завершено</span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        
        <?php if($userType == 'doctor'): ?>
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-number"><?php echo e($patientsCount ?? 0); ?></div>
                <div class="stat-label">Всего пациентов</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($appointmentsToday ?? 0); ?></div>
                <div class="stat-label">Приёмов сегодня</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($totalConsultations ?? 0); ?></div>
                <div class="stat-label">Всего консультаций</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($experienceYears ?? 0); ?></div>
                <div class="stat-label">Лет опыта</div>
            </div>
        </div>
        
        
        <?php if(isset($todayAppointments) && $todayAppointments->count() > 0): ?>
        <div class="appointments-section">
            <h3><i class="fas fa-calendar-day"></i> Приёмы на сегодня</h3>
            <?php $__currentLoopData = $todayAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="appointment-item">
                <div class="appointment-time">
                    <i class="fas fa-clock"></i> 
                    <?php echo e(\Carbon\Carbon::parse($appointment->slot->slot_start)->format('H:i') ?? 'Время не указано'); ?>

                </div>
                <div class="appointment-patient">
                    <i class="fas fa-user-injured"></i> 
                    Пациент: <?php echo e($appointment->patient->user->full_name ?? 'Не указан'); ?>

                </div>
                <div class="appointment-status">
                    <span class="badge badge-warning">Ожидает</span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
        
        
        <?php if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0): ?>
        <div class="appointments-section">
            <h3><i class="fas fa-calendar-week"></i> Предстоящие приёмы</h3>
            <?php $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="appointment-item">
                <div class="appointment-time">
                    <i class="fas fa-calendar"></i> 
                    <?php echo e(\Carbon\Carbon::parse($appointment->slot->slot_start)->format('d.m.Y H:i') ?? 'Дата не указана'); ?>

                </div>
                <div class="appointment-patient">
                    <i class="fas fa-user-injured"></i> 
                    Пациент: <?php echo e($appointment->patient->user->full_name ?? 'Не указан'); ?>

                </div>
                <div class="appointment-status">
                    <span class="badge badge-info">Запланирован</span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
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
</html><?php /**PATH C:\OSPanel\domains\diplom-2026\resources\views/private_room.blade.php ENDPATH**/ ?>