<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DataDate</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<header>
    <h1>DataDate</h1>
</header>
    <nav>
        <?php if (isset($user)): ?>
            <div>
                <a class="button" href="/profile">My profile</a>
            </div>
            <div>
                <a class="button" href="/signout">Sign out</a>
            </div>
        <?php elseif ($uri === '/signup'): ?>
            <div>
                <a class="button" href="/signin">Sign in</a>
            </div>
        <?php else: ?>
            <div>
                <a class="button" href="/signup">Sign up</a>
            </div>
        <?php endif; ?>
    </nav>
<div class="content">
    <?= $content ?>
</div>
</body>
</html>

