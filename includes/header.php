<link rel="stylesheet" href="../assets/style.css">
<header class="header">
    <span class="logo">Orion</span>
    <nav>
        <ul>
            <li> <a href="../views/index.php">Главная</a></li>
            <li><a href="../views/about.php">О нас</a></li>
            <li><a href="../views/tours.php">Туры</a></li>
            <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
                echo '<li><a href="../views/profile.php">Профиль</a></li>';
            } else {
                echo '<li class="btn-profile"><a href="../views/singin.php">Войти</a></li>';
            }
            ?>
            
        </ul>
    </nav>
    <div class="burger" id="burger">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>
<script>
    const burger = document.getElementById('burger');
    const header = document.querySelector('header');

    burger.addEventListener('click', () => {
        header.classList.toggle('nav-open');
    });
</script>
