<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abstract UI - Login</title>
    <link rel="stylesheet" href="<?php echo e(asset('styles/login.css')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://img.icons8.com/color/48/google-logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="alert alert-danger"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <div class="login-container">
        <!-- Левая часть с изображением -->
        <div class="login-image-section">
            <img src="<?php echo e(asset('images/doctor.jpg')); ?>" 
                 alt="Abstract background" 
                 class="login-image">
        </div>

        <!-- Правая часть с формой -->
        <div class="login-form-section">
            <div class="login-form-wrapper">
                <!-- Логотип и заголовок -->
                <h1 class="login-title">Войдите в свой аккаунт</h1>

                <!-- Форма входа -->
                <form class="login-form" action="<?php echo e(route('authenticate')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <!-- Поле email -->
                    <div class="form-group">
                        <label class="form-label">Почта</label>
                        <input type="email" 
                        name="email"
                               placeholder="Enter Email Address" 
                               class="form-input" 
                               autofocus 
                               autocomplete="email" 
                               required>
                    </div>

                    <!-- Поле пароля -->
                    <div class="form-group">
                        <label class="form-label">Пароль</label>
                        <input type="password" 
                        name="password"
                               placeholder="Enter Password" 
                               minlength="6" 
                               class="form-input" 
                               required>
                    </div>

                    <!-- Ссылка "Забыли пароль?" -->
                    <div class="forgot-password">
                        <a href="#" class="forgot-link">Забыли пароль?</a>
                    </div>

                    <!-- Кнопка входа -->
                    <button type="submit" class="login-btn">Войти</button>
                </form>

                <!-- Разделитель -->
                <div class="login-divider">
                    <span>или продолжить с</span>
                </div>

                <!-- Кнопка Google -->
                <button type="button" class="google-btn">
                    <img width="25" height="25" src="https://img.icons8.com/color/48/google-logo.png" alt="google-logo"/>
                    Google
                </button>

                <!-- Ссылка на регистрацию -->
                <p class="register-link">
                    Ещё нету аккаунта?
                    <a href="<?php echo e(route('registration')); ?>">Зарегистрироваться</a>
                </p>

                <!-- Футер -->
                <p class="login-footer">
                    &copy; 2026 БУДЬ ЗДОРОВ. Все права защищены.
                </p>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\OSPanel\domains\diplom-2026\resources\views/auto.blade.php ENDPATH**/ ?>