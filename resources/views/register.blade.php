<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abstract UI - Registration</title>
    <link rel="stylesheet" href="{{asset('styles/reg.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <!-- Левая часть с изображением -->
        <div class="login-image-section">
            <img src="{{asset('images/doctor.jpg')}}" 
                 alt="Medical background" 
                 class="login-image">
        </div>

        <!-- Правая часть с формой -->
        <div class="login-form-section">
            <div class="login-form-wrapper">
                <!-- Логотип и заголовок -->
                <h1 class="login-title">Создайте аккаунт</h1>

                <!-- Форма регистрации -->
                <form class="login-form" action="{{route('registr')}}" method="POST">
                    @csrf
                    <!-- Поле ФИО -->
                    <div class="form-group">
                        <label class="form-label">ФИО</label>
                        <input type="text" 
                               placeholder="Введите ваше полное ФИО" 
                                name="full_name"
                               class="form-input" 
                               autofocus 
                               required>
                    </div>


                    <!-- Поле телефона -->
                    <div class="form-group">
                        <label class="form-label">Телефон</label>
                        <input type="tel" 
                               name="telephone"
                               placeholder="+7 (___) ___-__-__" 
                               class="form-input" 
                               required>
                    </div>
                    
                     <!-- Поле email -->
                    <div class="form-group">
                        <label class="form-label">Почта</label>
                        <input type="email" 
                               placeholder="example@mail.com" 
                               class="form-input" 
                                name="email"
                               autocomplete="email" 
                               required>
                    </div>

                    <!-- Поле пароля -->
                    <div class="form-group">
                        <label class="form-label">Пароль</label>
                        <input type="password" 
                               placeholder="Не менее 6 символов" 
                                name="password"
                               minlength="6" 
                               class="form-input" 
                               required>
                    </div>

                    <!-- Подтверждение пароля -->
                    <!-- <div class="form-group">
                        <label class="form-label">Подтвердите пароль</label>
                        <input type="password" 
                               placeholder="Повторите пароль" 
                               minlength="6" 
                               class="form-input" 
                               required>
                    </div> -->

                    <!-- Кнопка регистрации -->
                    <button type="submit" class="login-btn">Зарегистрироваться</button>
                </form>

                <!-- Разделитель -->
                <div class="login-divider">
                    <span>или продолжить с</span>
                </div>

                <!-- Кнопка Google -->
                <button type="button" class="google-btn">
                    <img width="20" height="20" src="https://img.icons8.com/color/48/google-logo.png" alt="google-logo"/>
                    Google
                </button>

                <!-- Ссылка на вход -->
                <p class="register-link">
                    Уже есть аккаунт?
                    <a href="{{route('autorisation')}}">Войти</a>
                </p>

                <!-- Футер -->
                <p class="login-footer">
                    &copy; 2026 Док.ру. Все права защищены.
                </p>
            </div>
        </div>
    </div>
    
</body>
</html>