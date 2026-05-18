<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Телемедицина - Поиск врача онлайн</title>
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

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
            
            <!-- Контакты и вход -->
            <div class="header-actions">
                <a href="tel:+79174732572" class="phone">
                    <i class="fas fa-phone-alt"></i>
                    <span>+7 (917) 473-25-72</span>
                </a>
                
                <button class="btn-login">
                    <a href="{{route('private')}}"><i class="fas fa-user"></i></a>
                    @auth

                    @else
                        <a href="{{route('autorisation')}}"><span>Войти</span></a>
                    @endauth
                </button>
            </div>
        </div>
    </header>
<main>
<div class="hero">
    <!-- СЛАЙДЕР ТОЛЬКО ДЛЯ ФОНА (меняются картинки, контент блока статичен) -->
    <div class="hero-splide splide" id="heroBackgroundSlider">
        <div class="splide__track">
            <ul class="splide__list" >
                <!-- Каждый слайд — фоновое изображение на медицинскую тему -->
               
               <!-- 1. Врач / стетоскоп (медицинская тематика) -->
                <li class="splide__slide" style="background-image: url('images/health.jpg');" ></li>

                <!-- 2. Технологии / цифры и мониторы (подходит под телемедицину) -->
                <li class="splide__slide" style="background-image: url('https://picsum.photos/id/0/1920/1080');"></li>

                <!-- 3. Природа и спокойствие (фон для успокаивающей атмосферы) -->
                <li class="splide__slide" style="background-image: url('https://picsum.photos/id/104/1920/1080');"></li>

                <!-- 4. Абстрактная чистота и минимализм (медицинский стерильный стиль) -->
                <li class="splide__slide" style="background-image: url('https://picsum.photos/id/20/1920/1080');"></li>

                <!-- 5. Современная техника / ноутбук (напоминает онлайн-консультацию) -->
                <li class="splide__slide" style="background-image: url('https://picsum.photos/id/1/1920/1080');"></li>
            </ul>
        </div>
    </div>

    <!-- Полупрозрачный оверлей для улучшения читаемости текста -->
    <div class="hero-overlay"></div>

    <!-- Статичное содержимое блока (не меняется) -->
    <div class="hero-content" style="margin-top: -103vh;">
        <div class="cont">
            <p class="subtitle">Консультации с лучшими врачами онлайн. Быстро, удобно, безопасно.</p>
            <h1 style="font-size: 20vh;"><span style="font-size: 27vh;">Б</span>УДЬ ЗДОРОВ</h1>
            <form class="search-form" action="#" method="post" onsubmit="event.preventDefault(); alert('Демо-поиск: ' + this.querySelector('input').value);">
                <input type="text" class="search-input" placeholder="Начните вводить специальность, ФИО врача или название анализа">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<section class="services-sec">
  <div class="container">
    <div class="services-extended__header">
      <h2>Что мы предлагаем</h2>
      <div class="tabs">
        <button class="tab active" data-tab="online">Онлайн-услуги</button>
        <button class="tab" data-tab="offline">Очные услуги</button>
        <button class="tab" data-tab="diagnostics">Диагностика</button>
      </div>
    </div>

    <div class="tab-content active" data-content="online">
      <div class="services-extended">
        <div class="service-category">
          <h3>Консультации</h3>
          <ul class="service-list">
            <li><a href="#">Видеоконсультация терапевта</a><span>от 990 ₽</span></li>
            <li><a href="#">Видеоконсультация педиатра</a><span>от 990 ₽</span></li>
            <li><a href="#">Видеоконсультация узкого специалиста</a><span>от 1 490 ₽</span></li>
            <li><a href="#">Семейный врач (абонемент)</a><span>от 3 900 ₽/мес</span></li>
          </ul>
          <a href="#" class="link-more">Все консультации →</a>
        </div>

        <div class="service-category">
          <h3>Документы и сервисы</h3>
          <ul class="service-list">
            <li><a href="#">Электронный рецепт</a><span>бесплатно</span></li>
            <li><a href="#">Справка для учебы/работы</a><span>от 500 ₽</span></li>
            <li><a href="#">Больничный лист онлайн</a><span>от 800 ₽</span></li>
            <li><a href="#">Расшифровка анализов</a><span>от 300 ₽</span></li>
          </ul>
          <a href="#" class="link-more">Все сервисы →</a>
        </div>

        <div class="service-category promo">
          <div class="promo-badge">🔥 Акция</div>
          <h3>Первая консультация</h3>
          <p class="promo-price">0 ₽ <span>вместо 1 490 ₽</span></p>
          <button class="btn-primary">Попробовать бесплатно</button>
        </div>
      </div>
    </div>

    <!-- Аналогично для других табов -->
  </div>
</section>

    <section class="how-it-works">
        <div class="section-header">
            <span class="section-badge">Простой путь к здоровью</span>
            <h2>Как получить консультацию</h2>
            <p class="section-description">Всего три шага отделяют вас от качественной медицинской помощи</p>
        </div>
        
        <div class="steps">
            <div class="step">
                <div class="step-icon-wrapper">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </div>
                </div>
                <h3>Выберите врача</h3>
                <p>Найдите подходящего специалиста по отзывам, рейтингу и специализации</p>
                <div class="step-feature">
                    <span class="feature-tag">800+ экспертов</span>
                    <span class="feature-tag">4.9 ★ рейтинг</span>
                </div>
            </div>
            
            <div class="step step-highlight">
                <div class="step-icon-wrapper">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <path d="M8 12h8M12 8v8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="12" cy="12" r="2" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
                <h3>Начните видеозвонок</h3>
                <p>Подключитесь через защищенное видеосоединение за 1 клик</p>
                <div class="step-feature">
                    <span class="feature-tag">HD качество</span>
                    <span class="feature-tag">Безопасно</span>
                </div>
            </div>
            
            <div class="step">
                <div class="step-icon-wrapper">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M20 12v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M12 2v8M9 7l3 3 3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <h3>Получите заключение</h3>
                <p>Врач поставит диагноз и выпишет электронный рецепт</p>
                <div class="step-feature">
                    <span class="feature-tag">Электронный рецепт</span>
                    <span class="feature-tag">24/7 доступ</span>
                </div>
            </div>
        </div>
        
        <div class="steps-connector">
            <div class="connector-line"></div>
            <div class="connector-line"></div>
        </div>
    </section>
    <section class="cta">
        <div class="cta-container">
            <div class="cta-badge">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L15 8L22 9L17 14L18 21L12 17.5L6 21L7 14L2 9L9 8L12 2Z" fill="currentColor"/>
                </svg>
                <span>Акция до конца месяца</span>
            </div>
            
            <h2>Попробуйте первую консультацию <span class="gradient-text">бесплатно</span></h2>
            <p class="cta-description">
                Зарегистрируйтесь и получите 15 минут бесплатной консультации терапевта
            </p>
            
            <div class="trust-badges">
                <div class="trust-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Без скрытых платежей</span>
                </div>
                <div class="trust-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span>Данные защищены</span>
                </div>
                <div class="trust-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M12 8v4l3 3M12 22a10 10 0 100-20 10 10 0 000 20z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span>Ответ за 5 минут</span>
                </div>
            </div>
            
            <form class="cta-form" id="consultationForm">
                <div class="input-group">
                    <div class="input-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.362 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0122 16.92z" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <input type="tel" class="cta-input" placeholder="+7 (___) ___-__-__" id="phoneInput">
                    <button type="submit" class="cta-button">
                        Получить консультацию
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                <div class="input-error" id="phoneError"></div>
            </form>
            
            <p class="cta-note">
                Нажимая кнопку, вы соглашаетесь с 
                <a href="#">политикой конфиденциальности</a> и 
                <a href="#">условиями обработки данных</a>
            </p>
            
            <div class="counter">
                <div class="counter-item">
                    <span class="counter-number">5000+</span>
                    <span class="counter-label">довольных пациентов</span>
                </div>
                <div class="counter-divider"></div>
                <div class="counter-item">
                    <span class="counter-number">98%</span>
                    <span class="counter-label">рекомендуют нас</span>
                </div>
                <div class="counter-divider"></div>
                <div class="counter-item">
                    <span class="counter-number">24/7</span>
                    <span class="counter-label">поддержка</span>
                </div>
            </div>
        </div>
</section>

        <!-- БЛОК FAQ - ТЕЛЕМЕДИЦИНА "БУДЬ ЗДОРОВ" -->
<div class="faq-section">
    <div class="faq-container">
        <!-- Заголовок секции -->
        <div class="faq-header">
            <span class="faq-badge">❓ ПОМОЩЬ</span>
            <h2>Часто задаваемые вопросы</h2>
            <p class="faq-subtitle">Ответы на главные вопросы о телемедицине</p>
        </div>

        <!-- Список вопросов -->
        <dl class="faq-list">
            <!-- Вопрос 1 -->
            <dt class="faq-question">Законна ли телемедицина?</dt>
            <dd class="faq-answer">
                <p>Да. Телемедицина в России работает на основании <strong>ФЗ №242</strong>. Врач даёт заключение с электронной подписью — оно имеет юридическую силу, как и обычный приём.</p>
            </dd>

            <!-- Вопрос 2 -->
            <dt class="faq-question">Можно ли получить больничный онлайн?</dt>
            <dd class="faq-answer">
                <p>Первичный больничный лист — только при очном визите. А вот <strong>продлить</strong> уже открытый больничный можно онлайн. Обычные рецепты тоже выписываем дистанционно.</p>
            </dd>

            <!-- Вопрос 3 -->
            <dt class="faq-question">Когда телемедицина не поможет?</dt>
            <dd class="faq-answer">
                <p>При болях за грудиной, потере сознания, кровотечениях, судорогах — немедленно звоните <strong>103 или 112</strong>. При простуде, хронических болезнях, расшифровке анализов — телемедицина отлично работает.</p>
            </dd>

            <!-- Вопрос 4 -->
            <dt class="faq-question">Что нужно для консультации?</dt>
            <dd class="faq-answer">
                <p>Смартфон или компьютер с камерой, интернет, паспорт и полис (показать в камеру). Всё остальное сделает врач.</p>
            </dd>

            <!-- Вопрос 5 -->
            <dt class="faq-question">Сколько стоит приём?</dt>
            <dd class="faq-answer">
                <p>Чат-консультация — от 300 ₽, видео-приём (30 мин) — от 1 200 ₽. Короткий вопрос вроде «какую мазь выбрать?» часто бесплатный.</p>
            </dd>

            <!-- Вопрос 6 -->
            <dt class="faq-question">Как записать ребёнка?</dt>
            <dd class="faq-answer">
                <p>Родитель оформляет заявку и во время приёма находится рядом с ребёнком. Врач попросит показать документы в камеру.</p>
            </dd>

            <!-- Вопрос 7 -->
            <dt class="faq-question">Что если пропал интернет или врач не вышел?</dt>
            <dd class="faq-answer">
                <p>Переподключитесь к сети. Если не получилось — перенесём приём без штрафа. Если врач опоздал на 15+ минут — вернём деньги или проведём приём бесплатно.</p>
            </dd>
        </dl>

        <!-- Дополнительный блок с контактами поддержки -->
        <div class="faq-support">
            <div class="support-icon">💬</div>
            <div class="support-text">
                <strong>Не нашли ответ?</strong> Напишите нам в чат — ответим за 5 минут
            </div>
            <a href="#" class="support-btn">Написать</a>
        </div>
    </div>
</div>
<section>
    <div class="outerdiv">
        <div class="innerdiv">
            <!-- div1 - Отзыв пациента с хроническим заболеванием -->
            <div class="div1 eachdiv">
                <div class="userdetails">
                    <div class="imgbox">
                        <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-daniel.jpg" alt="Фото пациента">
                    </div>
                    <div class="detbox">
                        <p class="name">Михаил Волков</p>
                        <p class="designation">Пациент с диабетом, 3 года наблюдения</p>
                    </div>
                </div>
                <div class="review">
                    <h4>Благодаря телемедицине я держу диабет под контролем, не выходя из дома</h4>
                    <p>«Раньше мне приходилось каждый месяц ездить к эндокринологу в другой город — это отнимало целый день. Сейчас я созваниваюсь с врачом онлайн, скидываю показатели глюкометра, и мы корректируем лечение за 15 минут. Уровень сахара стабилизировался, а качество жизни выросло в разы. Огромное спасибо команде "Будь здоров"!»</p>
                </div>
            </div>

            <!-- div2 - Отзыв молодой мамы -->
            <div class="div2 eachdiv">
                <div class="userdetails">
                    <div class="imgbox">
                        <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-jonathan.jpg" alt="Фото пациентки">
                    </div>
                    <div class="detbox">
                        <p class="name">Анна Морозова</p>
                        <p class="designation">Молодая мама</p>
                    </div>
                </div>
                <div class="review">
                    <h4>Педиатр онлайн — настоящее спасение, когда ребёнок болеет ночью</h4>
                    <p>«У дочки поднялась температура под утро, а ехать в больницу с малышом — стресс. За 10 минут я получила консультацию педиатра, который дал чёткие рекомендации и выписал рецепт. Лекарство привезли из ближайшей аптеки. Сейчас я только так и лечу ОРВИ — быстро, безопасно и без очередей.»</p>
                </div>
            </div>

            <!-- div3 - Отзыв пенсионерки (длинный, эмоциональный) -->
            <div class="div3 eachdiv">
                <div class="userdetails">
                    <div class="imgbox">
                        <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-kira.jpg" alt="Фото пациентки">
                    </div>
                    <div class="detbox">
                        <p class="name dark">Елена Петровна</p>
                        <p class="designation dark">Пациентка, 68 лет</p>
                    </div>
                </div>
                <div class="review dark">
                    <h4>Я боялась компьютера, а теперь сама записываюсь к врачу онлайн</h4>
                    <p>«Мне 68, и раньше я думала, что телемедицина — это не для меня. Но дочка установила приложение "Будь здоров", и теперь я сама могу позвонить кардиологу, не выходя из дома. Врач всегда внимательный, объясняет простыми словами. Даже рецепты выписывают электронные — прямо в аптеку отправляют. Никакой волокиты. Спасибо, что заботитесь о пожилых!»</p>
                </div>
            </div>

            <!-- div4 - Отзыв пациента с кожным заболеванием -->
            <div class="div4 eachdiv">
                <div class="userdetails">
                    <div class="imgbox">
                        <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-jeanette.jpg" alt="Фото пациента">
                    </div>
                    <div class="detbox">
                        <p class="name dark">Дмитрий Кузнецов</p>
                        <p class="designation dark">Пациент дерматолога</p>
                    </div>
                </div>
                <div class="review dark">
                    <h4>Отправил фото сыпи — через час получил диагноз и лечение</h4>
                    <p>«Появилась странная сыпь на руке, записываться к дерматологу — неделя ожидания. Через сервис "Будь здоров" загрузил фото, и врач буквально через час дал заключение и выписал мазь. Через 3 дня всё прошло. Экономия времени и нервов — колоссальная.»</p>
                </div>
            </div>

            <!-- div5 - Отзыв врача (неожиданный ракурс) -->
            <div class="div5 eachdiv">
                <div class="userdetails">
                    <div class="imgbox">
                        <img src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-patrick.jpg" alt="Фото врача">
                    </div>
                    <div class="detbox">
                        <p class="name">Др. Сергей Владимирович</p>
                        <p class="designation">Врач-терапевт, стаж 12 лет</p>
                    </div>
                </div>
                <div class="review">
                    <h4>Как врач, я вижу в телемедицине не замену, а мощное дополнение к очному приёму</h4>
                    <p>«Когда пациент может прислать анализы или фото симптомов заранее — мы экономим время на приёме и быстрее ставим диагноз. Особенно удобно наблюдать хронических больных. Платформа "Будь здоров" интуитивно понятна даже пожилым, а техническая поддержка работает отлично. Я рекомендую телемедицину всем своим пациентам как удобный инструмент.»</p>
                </div>
            </div>
        </div>
    </div>
</section>
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

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация слайдера фона
    initBackgroundSlider();

    // Настройка шапки при скролле
    setupHeaderScroll();

    // Обработка FAQ
    setupFAQ();
    // Обработка поиска и кнопок специализаций
    setupSearchAndTabs();
});

// Функция для инициализации слайдера фона
document.addEventListener('DOMContentLoaded', function() {
    const splideElement = document.getElementById('heroBackgroundSlider');
    if (!splideElement) return;

    // Принудительно устанавливаем высоту
    function setHeight() {
        const hero = document.querySelector('.hero');
        if (hero) {
            const height = hero.offsetHeight;
            splideElement.style.height = height + 'px';
            const track = splideElement.querySelector('.splide__track');
            if (track) track.style.minHeight = height + 'px';
        }
    }

    setHeight();
    window.addEventListener('resize', setHeight);

    const backgroundSlider = new Splide(splideElement, {
        type: 'loop',
        perPage: 1,
        perMove: 1,
        autoplay: true,
        interval: 4500,
        pauseOnHover: true,
        pauseOnFocus: true,
        arrows: false,
        pagination: true,
        speed: 800,
        rewind: true,
        waitForTransition: true
    });
    
    backgroundSlider.mount();
});

// Функция для обработки скролла шапки
window.addEventListener('scroll', function() {
        const header = document.querySelector('.header');
        if (header) {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    });


// Функция для настройки FAQ
function setupFAQ() {
    const questions = document.querySelectorAll('.faq-question');

    questions.forEach(question => {
        question.addEventListener('click', function() {
            // Закрываем все открытые ответы
            const currentlyActive = document.querySelector('.faq-question.active');
            if (currentlyActive && currentlyActive !== question) {
                currentlyActive.classList.remove('active');
                currentlyActive.nextElementSibling.classList.remove('active');
            }

            // Переключаем состояние текущего вопроса
            this.classList.toggle('active');
            this.nextElementSibling.classList.toggle('active');
        });
    });
}

// Функция для поиска и кнопок специализаций
function setupSearchAndTabs() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const searchInput = document.querySelector('.search-input');
    const searchForm = document.querySelector('.search-form');

    // Обработчик кнопок специализаций
    tabBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const specialty = btn.innerText.trim();
            if (searchInput) {
                searchInput.value = specialty;
                searchInput.focus();
            }
            // Фидбек нажатия
            btn.style.transform = 'scale(0.96)';
            setTimeout(() => {
                btn.style.transform = '';
            }, 150);
        });
    });

    // Обработчик формы поиска
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const query = searchInput?.value.trim() || '';

            if (!query) {
                alert('Введите запрос для поиска врача, анализа или специальности');
            } else {
                alert(`🔍 Поиск: "${query}". (Демонстрационный режим)\nВ реальном проекте здесь будет переход к результатам.`);
            }
        });
    }
}

</script>


</body>
</html>