<?php
session_start();
$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($password === '@Pegapalo22$$Core' && !empty($username)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = ucwords($username); 
        header("Location: dashboard.php");
        exit;
    } else {
        $error = 'Access Denied. Invalid credentials.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Secure Vault | Medios Core Systems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>body { background: #0f172a; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: sans-serif;}</style>
</head>
<body>
    <div class="card p-5 shadow-lg border-0" style="width: 400px; border-radius: 20px; background: white;">
        <div class="text-center mb-4">
            <i class="bi bi-hexagon-fill text-primary" style="font-size: 3rem;"></i>
            <h3 class="fw-bold mt-2 text-dark">System Authorization</h3>
            <p class="text-muted small">Medios Core Systems</p>
        </div>
        <?php if($error): ?><div class="alert alert-danger text-center fw-bold"><i class="bi bi-shield-lock-fill me-2"></i><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="fw-bold text-secondary small mb-1">YOUR NAME / COMPANY</label>
                <input type="text" name="username" class="form-control form-control-lg bg-light" placeholder="e.g. Ginedy, Maria, Prowork" required>
            </div>
            <div class="mb-4">
                <label class="fw-bold text-secondary small mb-1">SYSTEM KEY</label>
                <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="••••••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="border-radius: 10px;">Unlock Vault</button>
        </form>
    </div>
</body>
</html>
