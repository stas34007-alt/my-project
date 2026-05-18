

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доктор Иван Петров | Медицинский портал</title>
    <link rel="stylesheet" href="<?php echo e(asset('styles/showDoctor.css')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>


<?php if(session('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo e(session('success')); ?>

        <button class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
<?php endif; ?>
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
    <div class="doctor-container">
        <!-- Шапка профиля врача -->
        <div class="doctor-header">
            <div class="doctor-avatar">
                <img src="<?php echo e(asset('images/' . $doctor->avatar)); ?>" alt="<?php echo e($doctor->user->full_name); ?>">
            </div>
            <div class="doctor-info">
                <h1 class="doctor-name"><?php echo e($doctor->user->full_name); ?></h1>
                <span class="doctor-specialty"><?php echo e($doctor->specialization->name); ?></span>
                
                <div class="doctor-stats">
                    <div class="stat">
                        <div class="stat-value">15 лет</div>
                        <div class="stat-label">опыта</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">4.8</div>
                        <div class="stat-label">рейтинг</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">147</div>
                        <div class="stat-label">отзывов</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">3 250</div>
                        <div class="stat-label">пациентов</div>
                    </div>
                </div>
                
                <div class="doctor-price">
                    Стоимость приёма: <span><?php echo e($doctor->online_consultation_price); ?></span>
                </div>
                
                <div class="doctor-bio">
                    <?php echo e($doctor->bio); ?>

                </div>
            </div>
        </div>

        <!-- Контент -->
        <div class="doctor-content">
            <!-- Вкладки -->
            <div class="tabs">
                <button class="tab active" data-tab="schedule">📅 Расписание</button>
                <button class="tab" data-tab="about">📋 О враче</button>
                <button class="tab" data-tab="reviews">⭐ Отзывы</button>
            </div>

            <!-- Вкладка: Расписание -->
            <div class="tab-content active" id="schedule">

                <!-- День 1: Сегодня -->
                <div class="date-group">
                    <div class="date-title">
                        <?php
                            \Carbon\Carbon::setLocale('ru');
                        ?>
                        <p>Сегодня, <?php echo e(now()->translatedFormat('j F Y')); ?></p>
                        <span class="date-badge">Доступно <?php echo e($todaySlots->count()); ?> слотов</span>
                    </div>
                    <div class="slots-grid">
                        <?php $__currentLoopData = $todaySlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route('consultations', $slot->id)); ?>" method="post" class="slot-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="slot_id" value="<?php echo e($slot->id); ?>">
                                <button type="button" onclick="confirmBooking(this.form)" style="border: none;
    background: none;   width: 9vw;"  class="slot-button">
                                    <div class="slot-card">
                                        <div class="slot-time">
                                            <?php echo e($slot->slot_start->format('G:i')); ?> - <?php echo e($slot->slot_end->format('G:i')); ?>

                                        </div>
                                        <div class="slot-price"><?php echo e(number_format($doctor->online_consultation_price, 2)); ?> ₽</div>
                                    </div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- День 2: Завтра -->
                <div class="date-group">
                    <div class="date-title">
                        Завтра, <?php echo e(now()->addDay()->translatedFormat(' j F Y')); ?>

                        <span class="date-badge">Доступно <?php echo e($tomorrowSlots->count()); ?> слотов</span>
                    </div>
                    <div class="slots-grid">
                        <?php $__currentLoopData = $tomorrowSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $AddSlot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route('consultations', $AddSlot->id)); ?>" method="post" class="slot-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="slot_id" value="<?php echo e($AddSlot->id); ?>">
                                <button type="button" onclick="confirmBooking(this.form)" style="border: none;
    background: none;   width: 9vw;"  class="slot-button">
                                    <div class="slot-card">
                                        <div class="slot-time"><?php echo e($AddSlot->slot_start->format('G:i')); ?> - <?php echo e($AddSlot->slot_end->format('G:i')); ?></div>
                                        <div class="slot-price"><?php echo e($doctor->online_consultation_price); ?>₽</div>
                                    </div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- День 3 -->
                <div class="date-group">
                    <div class="date-title">
                        <?php echo e(now()->addDay(2)->translatedFormat('l, j F Y')); ?>

                        <span class="date-badge">Доступно <?php echo e($afterTomorrowSlots->count()); ?> слотов</span>
                    </div>
                    <div class="slots-grid">
                        <?php $__currentLoopData = $afterTomorrowSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Add2Slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route('consultations', $Add2Slot->id)); ?>" method="post" class="slot-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="slot_id" value="<?php echo e($Add2Slot->id); ?>">
                                <button type="button" onclick="confirmBooking(this.form)" style="border: none;
    background: none;   width: 8vw;"  class="slot-button">
                                    <div class="slot-card">
                                        <div class="slot-time"><?php echo e($Add2Slot->slot_start->format('G:i')); ?> - <?php echo e($Add2Slot->slot_end->format('G:i')); ?></div>
                                        <div class="slot-price"><?php echo e($doctor->online_consultation_price); ?>₽</div>
                                    </div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- День 4 -->
                <div class="date-group">
                    <div class="date-title">
                        <?php echo e(now()->addDay(3)->translatedFormat('l, j F Y')); ?>

                        <span class="date-badge">Доступно <?php echo e($ForTomorrowSlots->count()); ?> слотов</span>
                    </div>
                    <div class="slots-grid">
                        <?php $__currentLoopData = $ForTomorrowSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Add3Slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route('consultations', $Add3Slot->id)); ?>" method="post" class="slot-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="slot_id" value="<?php echo e($Add3Slot->id); ?>">
                                <button type="button" onclick="confirmBooking(this.form)" style="border: none;
    background: none;   width: 8vw;"  class="slot-button">
                                    <div class="slot-card">
                                        <div class="slot-time"><?php echo e($Add3Slot->slot_start->format('G:i')); ?> - <?php echo e($Add3Slot->slot_end->format('G:i')); ?></div>
                                        <div class="slot-price"><?php echo e($doctor->online_consultation_price); ?>₽</div>
                                    </div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- День 5 -->
                <div class="date-group">
                    <div class="date-title">
                        <?php echo e(now()->addDay(4)->translatedFormat('l, j F Y')); ?>

                        <span class="date-badge">Доступно <?php echo e($FiveTomorrowSlots->count()); ?> слотов</span>
                    </div>
                    <div class="slots-grid">
                        <?php $__currentLoopData = $FiveTomorrowSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Add4Slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route('consultations', $Add4Slot->id)); ?>" method="post" class="slot-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="slot_id" value="<?php echo e($Add4Slot->id); ?>">
                                <button type="button" onclick="confirmBooking(this.form)" style="border: none;
    background: none;   width: 8vw;"  class="slot-button">
                                    <div class="slot-card">
                                        <div class="slot-time"><?php echo e($Add4Slot->slot_start->format('G:i')); ?> - <?php echo e($Add4Slot->slot_end->format('G:i')); ?></div>
                                        <div class="slot-price"><?php echo e($doctor->online_consultation_price); ?>₽</div>
                                    </div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- День 6 -->
                <div class="date-group">
                    <div class="date-title">
                        <?php echo e(now()->addDay(5)->translatedFormat('l, j F Y')); ?>

                        <span class="date-badge">Доступно <?php echo e($SixTomorrowSlots->count()); ?> слотов</span>
                    </div>
                    <div class="slots-grid">
                        <?php $__currentLoopData = $SixTomorrowSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Add5Slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route('consultations', $Add5Slot->id)); ?>" method="post" class="slot-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="slot_id" value="<?php echo e($Add5Slot->id); ?>">
                                <button type="button" onclick="confirmBooking(this.form)" style="border: none;
    background: none;   width: 8vw;"  class="slot-button">
                                    <div class="slot-card">
                                        <div class="slot-time"><?php echo e($Add5Slot->slot_start->format('G:i')); ?> - <?php echo e($Add5Slot->slot_end->format('G:i')); ?></div>
                                        <div class="slot-price"><?php echo e($doctor->online_consultation_price); ?>₽</div>
                                    </div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- День 7 -->
                <div class="date-group">
                    <div class="date-title">
                        <?php echo e(now()->addDay(6)->translatedFormat('l, j F Y')); ?>

                        <span class="date-badge">Доступно <?php echo e($SevenTomorrowSlots->count()); ?> слотов</span>
                    </div>
                    <div class="slots-grid">
                        <?php $__currentLoopData = $SevenTomorrowSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Add6Slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route('consultations', $Add6Slot->id)); ?>" method="post" class="slot-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="slot_id" value="<?php echo e($Add6Slot->id); ?>">
                                <button type="button" onclick="confirmBooking(this.form)" style="border: none;
    background: none;   width: 8vw;"  class="slot-button">
                                    <div class="slot-card">
                                        <div class="slot-time"><?php echo e($Add6Slot->slot_start->format('G:i')); ?> - <?php echo e($Add6Slot->slot_end->format('G:i')); ?></div>
                                        <div class="slot-price"><?php echo e($doctor->online_consultation_price); ?>₽</div>
                                    </div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            

            <!-- Вкладка: О враче -->
            <div class="tab-content" id="about">
                <div class="info-card">
                    <div class="info-title">📚 Образование</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">🎓</div>
                            <div class="info-text">
                                <strong>Московский государственный медицинский университет</strong>
                                Лечебное дело, 2009
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">📜</div>
                            <div class="info-text">
                                <strong>Ординатура по кардиологии</strong>
                                МГМУ им. Сеченова, 2011
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">🏅</div>
                            <div class="info-text">
                                <strong>Кандидат медицинских наук</strong>
                                Диссертация по кардиологии, 2015
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-title">💼 Опыт работы</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">🏥</div>
                            <div class="info-text">
                                <strong>Городская клиническая больница №1</strong>
                                Врач-кардиолог (2011-2018)
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">⭐</div>
                            <div class="info-text">
                                <strong>Медицинский центр "Здоровье"</strong>
                                Заведующий кардиологическим отделением (2018-настоящее время)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-title">📜 Сертификаты и достижения</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">📄</div>
                            <div class="info-text">
                                <strong>Сертификат по кардиологии</strong>
                                Действителен до 2027
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">📄</div>
                            <div class="info-text">
                                <strong>Сертификат по функциональной диагностике</strong>
                                Действителен до 2026
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">🌍</div>
                            <div class="info-text">
                                <strong>Владение языками</strong>
                                Русский, Английский
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Вкладка: Отзывы -->
            <div class="tab-content" id="reviews">
                <div class="reviews-list">
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar">А</div>
                            <div>
                                <div class="review-name">Анна Смирнова</div>
                                <div class="review-date">5 апреля 2026</div>
                            </div>
                        </div>
                        <div class="review-stars">★★★★★</div>
                        <div class="review-text">
                            Отличный врач! Внимательный, профессиональный. Назначил правильное лечение, 
                            состояние улучшилось уже через неделю. Рекомендую!
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar">М</div>
                            <div>
                                <div class="review-name">Михаил Иванов</div>
                                <div class="review-date">28 марта 2026</div>
                            </div>
                        </div>
                        <div class="review-stars">★★★★★</div>
                        <div class="review-text">
                            Очень грамотный специалист. Всё подробно объяснил, ответил на все вопросы. 
                            Благодарен за помощь!
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar">Е</div>
                            <div>
                                <div class="review-name">Елена Петрова</div>
                                <div class="review-date">15 марта 2026</div>
                            </div>
                        </div>
                        <div class="review-stars">★★★★☆</div>
                        <div class="review-text">
                            Хороший врач, но пришлось немного подождать в очереди. 
                            Но консультация была полезной, лечение помогло.
                        </div>
                    </div>
                </div>
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

    <script>
        // Переключение вкладок
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Убираем активный класс у всех вкладок
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                // Добавляем активный класс текущей вкладке
                tab.classList.add('active');
                
                // Скрываем все контенты
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                // Показываем нужный контент
                const tabId = tab.getAttribute('data-tab');
                if (tabId === 'schedule') {
                    document.getElementById('schedule').classList.add('active');
                } else if (tabId === 'about') {
                    document.getElementById('about').classList.add('active');
                } else if (tabId === 'reviews') {
                    document.getElementById('reviews').classList.add('active');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmBooking(form) {
    Swal.fire({
        title: 'Подтверждение записи',
        text: 'Вы хотите записаться на этот прием?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Да, записаться',
        cancelButtonText: 'Отмена'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // Отправляем форму
        }
    });
}
</script>
</body>
</html><?php /**PATH C:\OSPanel\domains\diplom-2026\resources\views/showDoctor.blade.php ENDPATH**/ ?>