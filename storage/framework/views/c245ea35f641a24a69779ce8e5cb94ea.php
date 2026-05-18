<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo e(asset('styles/consultations.css')); ?>">
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
                <div class="stat-value"><?php echo e($stats['total']); ?></div>
                <div class="stat-label">Всего консультаций</div>
            </div>
        </div>
        <div class="stat-card scheduled">
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['scheduled']); ?></div>
                <div class="stat-label">Запланировано</div>
            </div>
        </div>
        <div class="stat-card completed">
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['completed']); ?></div>
                <div class="stat-label">Завершено</div>
            </div>
        </div>
        <div class="stat-card cancelled">
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['cancelled']); ?></div>
                <div class="stat-label">Отменено</div>
            </div>
        </div>
    </div>

    <!-- Список консультаций -->
    <div class="consultations-list">
        <?php $__empty_1 = true; $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="consultation-card" data-id="<?php echo e($consultation->id); ?>">
            <div class="card-header">
                <div class="doctor-info">
                    <div class="doctor-avatar">
                        <?php if($consultation->doctor && $consultation->doctor->user && $consultation->doctor->user->avatar): ?>
                            <img src="<?php echo e(asset('images/avatars/' . $consultation->doctor->user->avatar)); ?>" alt="Doctor">
                        <?php else: ?>
                            <i class="fas fa-user-md"></i>
                        <?php endif; ?>
                    </div>
                    <div class="doctor-details">
                        <h3 class="doctor-name"><?php echo e($consultation->doctor->user->full_name ?? 'Врач не указан'); ?></h3>
                        <p class="doctor-specialty"><?php echo e($consultation->doctor->specialization->name ?? 'Специализация не указана'); ?></p>
                        <div class="doctor-experience">
                            <i class="fas fa-briefcase"></i> Стаж: <?php echo e($consultation->doctor->years_of_experience ?? 0); ?> лет
                        </div>
                    </div>
                </div>
                <div class="status-badge status-<?php echo e($consultation->status); ?>">
                    <?php if($consultation->status == 'scheduled'): ?>
                        <i class="fas fa-clock"></i> Запланирована
                    <?php elseif($consultation->status == 'completed'): ?>
                        <i class="fas fa-check-circle"></i> Завершена
                    <?php elseif($consultation->status == 'cancelled'): ?>
                        <i class="fas fa-ban"></i> Отменена
                    <?php elseif($consultation->status == 'in_progress'): ?>
                        <i class="fas fa-video"></i> В процессе
                    <?php else: ?>
                        <i class="fas fa-hourglass"></i> <?php echo e($consultation->status); ?>

                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                <div class="info-row">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span class="info-label">Дата и время:</span>
                        <span class="info-value">
                            <?php if($consultation->slot && $consultation->slot->slot_start): ?>
                                <?php echo e(\Carbon\Carbon::parse($consultation->slot->slot_start)->format('d.m.Y H:i')); ?>

                            <?php elseif($consultation->started_at): ?>
                                <?php echo e(\Carbon\Carbon::parse($consultation->started_at)->format('d.m.Y H:i')); ?>

                            <?php else: ?>
                                <?php echo e($consultation->created_at->format('d.m.Y H:i')); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-comment"></i>
                        <span class="info-label">Тип консультации:</span>
                        <span class="info-value">
                            <?php if($consultation->type == 'video'): ?>
                                <span class="type-badge"><i class="fas fa-video"></i> Видеозвонок</span>
                            <?php elseif($consultation->type == 'chat'): ?>
                                <span class="type-badge"><i class="fas fa-comment-dots"></i> Чат</span>
                            <?php else: ?>
                                <span class="type-badge"><i class="fas fa-phone"></i> Телефон</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-ruble-sign"></i>
                        <span class="info-label">Стоимость:</span>
                        <span class="info-value price"><?php echo e(number_format($consultation->final_price, 0)); ?> ₽</span>
                    </div>
                </div>

                <?php if($consultation->symptoms): ?>
                <div class="symptoms-box">
                    <h4><i class="fas fa-notes-medical"></i> Ваши жалобы / симптомы</h4>
                    <p><?php echo e($consultation->symptoms); ?></p>
                </div>
                <?php endif; ?>

                <?php if($consultation->diagnosis): ?>
                <div class="diagnosis-box">
                    <h4><i class="fas fa-diagnoses"></i> Диагноз</h4>
                    <p><?php echo e($consultation->diagnosis); ?></p>
                </div>
                <?php endif; ?>

                <?php if($consultation->doctor_notes): ?>
                <div class="notes-box">
                    <h4><i class="fas fa-sticky-note"></i> Рекомендации врача</h4>
                    <p><?php echo e($consultation->doctor_notes); ?></p>
                </div>
                <?php endif; ?>

                <?php if($consultation->meeting_link && $consultation->status == 'scheduled'): ?>
                <div class="meeting-link-box">
                    <a href="<?php echo e($consultation->meeting_link); ?>" target="_blank" class="btn-meeting">
                        <i class="fas fa-video"></i> Присоединиться к консультации
                    </a>
                </div>
                <?php endif; ?>

                <?php if($consultation->review): ?>
                <div class="review-box">
                    <div class="review-stars">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= $consultation->rating): ?>
                                <i class="fas fa-star"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span class="review-rating"><?php echo e($consultation->rating); ?>/5</span>
                    </div>
                    <p class="review-text">"<?php echo e($consultation->review); ?>"</p>
                </div>
                <?php endif; ?>

                <?php if($consultation->cancellation_reason): ?>
                <div class="cancellation-box">
                    <h4><i class="fas fa-info-circle"></i> Причина отмены</h4>
                    <p><?php echo e($consultation->cancellation_reason); ?></p>
                </div>
                <?php endif; ?>
            </div>

            <div class="card-footer">
                <!-- Кнопка подключения к консультации -->
                <?php if($consultation->type == 'video' && $consultation->status == 'scheduled'): ?>
                    <?php if($consultation->meeting_link): ?>
                        <a href="<?php echo e($consultation->meeting_link); ?>" target="_blank" class="btn-join-call">
                            <i class="fas fa-video"></i> Присоединиться
                        </a>
                    <?php else: ?>
                        <button class="btn-generate-link" onclick="generateMeetingLink(<?php echo e($consultation->id); ?>)">
                            <i class="fas fa-link"></i> Создать ссылку для звонка
                        </button>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if($consultation->status == 'scheduled'): ?>
                    <button class="btn-cancel-appointment" onclick="cancelConsultation(<?php echo e($consultation->id); ?>)">
                        <i class="fas fa-times"></i> Отменить запись
                    </button>
                    <button class="btn-reschedule" onclick="rescheduleConsultation(<?php echo e($consultation->id); ?>)">
                        <i class="fas fa-calendar-alt"></i> Перенести
                    </button>
                <?php endif; ?>
                
                <?php if($consultation->status == 'completed' && !$consultation->review): ?>
                    <button class="btn-review" onclick="leaveReview(<?php echo e($consultation->id); ?>)">
                        <i class="fas fa-star"></i> Оставить отзыв
                    </button>
                <?php endif; ?>
                
                <button class="btn-detail" onclick="showDetail(<?php echo e($consultation->id); ?>)">
                    <i class="fas fa-info-circle"></i> Подробнее
                </button>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h3>У вас пока нет консультаций</h3>
            <p>Запишитесь к врачу, чтобы получить квалифицированную помощь</p>
            <a href="<?php echo e(route('doctors.index')); ?>" class="btn-primary">
                <i class="fas fa-search"></i> Найти врача
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// CSRF токен



function generateMeetingLink(consultationId) {
    fetch(`/consultations/${consultationId}/generate-link`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
</html><?php /**PATH C:\OSPanel\domains\diplom-2026\resources\views/my-consultations.blade.php ENDPATH**/ ?>