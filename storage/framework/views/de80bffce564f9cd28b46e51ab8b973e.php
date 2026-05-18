<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <div style="max-width: 800px; margin: 80px auto 40px; padding: 0 20px; margin-top: 17vh;">
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden;">
            
            <!-- Заголовок -->
            <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 25px 30px; color: white;">
                <a href="<?php echo e(route('doctor.diagnosis.index')); ?>" style="color: #94a3b8; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                    <i class="fas fa-arrow-left"></i> Назад
                </a>
                <h1 style="font-size: 24px; margin: 0;">
                    <i class="fas fa-file-medical"></i> 
                    <?php echo e(isset($consultation->diagnosis) ? 'Редактировать диагноз' : 'Записать диагноз'); ?>

                </h1>
            </div>
            
            <!-- Информация о пациенте -->
            <div style="padding: 25px 30px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
                    <div style="width: 70px; height: 70px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-circle" style="font-size: 45px; color: #2c9c74;"></i>
                    </div>
                    <div>
                        <h3 style="margin-bottom: 5px;"><?php echo e($consultation->patient->user->full_name ?? 'Пациент'); ?></h3>
                        <p style="margin: 0; color: #64748b;">
                            <i class="fas fa-phone"></i> <?php echo e($consultation->patient->user->phone ?? '—'); ?>

                        </p>
                        <p style="margin: 0; color: #64748b;">
                            <i class="fas fa-envelope"></i> <?php echo e($consultation->patient->user->email ?? '—'); ?>

                        </p>
                    </div>
                </div>
                <?php if($consultation->symptoms): ?>
                    <div style="margin-top: 15px; padding: 12px; background: white; border-radius: 12px;">
                        <strong><i class="fas fa-notes-medical"></i> Жалобы пациента:</strong>
                        <p style="margin: 8px 0 0; color: #475569;"><?php echo e($consultation->symptoms); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
           <!-- Форма -->
<form method="POST" action="<?php echo e(isset($consultation->diagnosis) ? route('doctor.diagnosis.update', $consultation->id) : route('doctor.diagnosis.store', $consultation->id)); ?>" style="padding: 30px;">
    <?php echo csrf_field(); ?>
    <?php if(isset($consultation->diagnosis)): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <!-- Диагноз -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-diagnoses"></i> Диагноз <span style="color: #ef4444;">*</span>
        </label>
        <textarea name="diagnosis" rows="4" 
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit; resize: vertical;"
            required><?php echo e(old('diagnosis', $consultation->diagnosis)); ?></textarea>
        <?php $__errorArgs = ['diagnosis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Заметки врача / Рекомендации -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-sticky-note"></i> Заметки / Рекомендации
        </label>
        <textarea name="doctor_notes" rows="6" 
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit; resize: vertical;"
            placeholder="Рекомендации, назначения, план лечения..."><?php echo e(old('doctor_notes', $consultation->doctor_notes)); ?></textarea>
        <?php $__errorArgs = ['doctor_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- ТИП КОНСУЛЬТАЦИИ -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-comment-dots"></i> Тип консультации
        </label>
        <select name="type" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px;">
            <option value="video" <?php echo e(old('type', $consultation->type) == 'video' ? 'selected' : ''); ?>>
                <i class="fas fa-video"></i> Видеозвонок
            </option>
            <option value="chat" <?php echo e(old('type', $consultation->type) == 'chat' ? 'selected' : ''); ?>>
                <i class="fas fa-comment-dots"></i> Чат
            </option>
            <option value="phone" <?php echo e(old('type', $consultation->type) == 'phone' ? 'selected' : ''); ?>>
                <i class="fas fa-phone"></i> Телефонный звонок
            </option>
        </select>
        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- ССЫЛКА НА КОНСУЛЬТАЦИЮ (MEETING LINK) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-link"></i> Ссылка на консультацию
        </label>
        <input type="url" name="meeting_link" value="<?php echo e(old('meeting_link', $consultation->meeting_link)); ?>"
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit;"
            placeholder="https://zoom.us/... или https://meet.google.com/...">
        <small style="color: #64748b; font-size: 12px;">Ссылка для подключения пациента к консультации</small>
        <?php $__errorArgs = ['meeting_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- ID КОНСУЛЬТАЦИИ (MEETING ID) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-id-card"></i> ID консультации
        </label>
        <input type="text" name="meeting_id" value="<?php echo e(old('meeting_id', $consultation->meeting_id)); ?>"
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit;"
            placeholder="Уникальный идентификатор консультации">
        <small style="color: #64748b; font-size: 12px;">ID для идентификации консультации в системе</small>
        <?php $__errorArgs = ['meeting_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- СТОИМОСТЬ (FINAL PRICE) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-ruble-sign"></i> Стоимость консультации
        </label>
        <input type="number" name="final_price" value="<?php echo e(old('final_price', $consultation->final_price)); ?>" step="0.01"
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit;"
            placeholder="0.00">
        <small style="color: #64748b; font-size: 12px;">Итоговая стоимость консультации</small>
        <?php $__errorArgs = ['final_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- ДАТА НАЧАЛА (STARTED_AT) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-play-circle"></i> Дата и время начала
        </label>
        <input type="datetime-local" name="started_at" 
            value="<?php echo e(old('started_at', $consultation->started_at ? \Carbon\Carbon::parse($consultation->started_at)->format('Y-m-d\TH:i') : '')); ?>"
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit;">
        <?php $__errorArgs = ['started_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- ДАТА ОКОНЧАНИЯ (ENDED_AT) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-stop-circle"></i> Дата и время окончания
        </label>
        <input type="datetime-local" name="ended_at" 
            value="<?php echo e(old('ended_at', $consultation->ended_at ? \Carbon\Carbon::parse($consultation->ended_at)->format('Y-m-d\TH:i') : '')); ?>"
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit;">
        <?php $__errorArgs = ['ended_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- ОЦЕНКА (RATING) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-star"></i> Оценка пациента
        </label>
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <?php for($i = 1; $i <= 5; $i++): ?>
            <label style="display: inline-flex; align-items: center; gap: 5px; cursor: pointer;">
                <input type="radio" name="rating" value="<?php echo e($i); ?>" 
                    <?php echo e(old('rating', $consultation->rating) == $i ? 'checked' : ''); ?>

                    style="width: auto; margin-right: 5px;">
                <?php for($j = 1; $j <= $i; $j++): ?> ★ <?php endfor; ?>
                <?php for($j = $i+1; $j <= 5; $j++): ?> ☆ <?php endfor; ?>
            </label>
            <?php endfor; ?>
        </div>
        <small style="color: #64748b; font-size: 12px;">Оценка пациента от 1 до 5</small>
        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- ОТЗЫВ (REVIEW) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-comment"></i> Отзыв пациента
        </label>
        <textarea name="review" rows="4" 
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit; resize: vertical;"
            placeholder="Отзыв пациента о консультации..."><?php echo e(old('review', $consultation->review)); ?></textarea>
        <?php $__errorArgs = ['review'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- ПРИЧИНА ОТМЕНЫ (CANCELLATION REASON) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-ban"></i> Причина отмены
        </label>
        <input type="text" name="cancellation_reason" value="<?php echo e(old('cancellation_reason', $consultation->cancellation_reason)); ?>"
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit;"
            placeholder="Причина, по которой была отменена консультация">
        <?php $__errorArgs = ['cancellation_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- СТАТУС КОНСУЛЬТАЦИИ -->
    <?php if(!isset($consultation->diagnosis)): ?>
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-check-circle"></i> Статус
        </label>
        <select name="status" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px;">
            <option value="scheduled" <?php echo e(old('status', $consultation->status) == 'scheduled' ? 'selected' : ''); ?>>Запланирована</option>
            <option value="in_progress" <?php echo e(old('status', $consultation->status) == 'in_progress' ? 'selected' : ''); ?>>В процессе</option>
            <option value="completed" <?php echo e(old('status', $consultation->status) == 'completed' ? 'selected' : ''); ?>>Завершена</option>
            <option value="cancelled" <?php echo e(old('status', $consultation->status) == 'cancelled' ? 'selected' : ''); ?>>Отменена</option>
        </select>
        <small style="color: #64748b; font-size: 12px;">Текущий статус консультации</small>
    </div>
    <?php endif; ?>

    <!-- ЗАМЕТКИ ПАЦИЕНТА (PATIENT_NOTES) -->
    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 10px; font-weight: 600;">
            <i class="fas fa-user-edit"></i> Заметки пациента
        </label>
        <textarea name="patient_notes" rows="4" 
            style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit; resize: vertical;"
            placeholder="Заметки пациента (видит только врач)..." readonly><?php echo e(old('patient_notes', $consultation->patient_notes)); ?></textarea>
        <small style="color: #64748b; font-size: 12px;">Поле доступно только для чтения, заполняется пациентом</small>
        <?php $__errorArgs = ['patient_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="color: #ef4444; font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Кнопки -->
    <div style="display: flex; gap: 15px; margin-top: 30px;">
        <button type="submit" 
            style="background: #2c9c74; color: white; padding: 12px 30px; border: none; border-radius: 12px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-save"></i> Сохранить изменения
        </button>
        <a href="<?php echo e(route('doctor.diagnosis.index')); ?>" 
            style="background: #64748b; color: white; padding: 12px 30px; border-radius: 12px; text-decoration: none; font-weight: 600;">
            <i class="fas fa-times"></i> Отмена
        </a>
    </div>
</form>
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

<?php /**PATH C:\OSPanel\domains\diplom-2026\resources\views/doctor/diagnosis/form.blade.php ENDPATH**/ ?>