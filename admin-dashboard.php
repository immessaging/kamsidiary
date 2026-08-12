<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require_admin();

$users = (int)db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
$stories = (int)db()->query('SELECT COUNT(*) FROM biography_entries')->fetchColumn();
$messages = (int)db()->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn();
$pending = (int)db()->query("SELECT COUNT(*) FROM testimonials WHERE status='pending'")->fetchColumn();

$recent = db()->query('SELECT id,name,email,role,created_at FROM users ORDER BY id DESC LIMIT 8')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Dashboard | Kamsi Diary</title>
<link rel="stylesheet" href="css/kamsi-pages.css">
</head>
<body>
<header class="site-header"><nav class="navbar">
<a class="brand" href="index.html"><span class="brand-mark">K<span>D</span></span><span class="brand-name">KAMSI <span>DIARY</span></span></a>
<ul class="nav-links" style="position:static;width:auto;height:auto;flex-direction:row;padding:0">
<li><a href="admin-dashboard.php" class="active">ADMIN DASHBOARD</a></li>
<li><a href="index.html">VIEW SITE</a></li>
<li><a href="logout.php" class="nav-cta">LOG OUT</a></li>
</ul>
</nav></header>
<main class="dashboard"><div class="container">
<div class="dashboard-head"><div><div class="eyebrow">ADMINISTRATION</div><h1>Kamsi Diary Control Center</h1><p>Welcome, <?= e((string)$_SESSION['name']) ?>.</p></div></div>
<div class="stats">
<div class="stat"><strong><?= $users ?></strong><span>Registered users</span></div>
<div class="stat"><strong><?= $stories ?></strong><span>Biography entries</span></div>
<div class="stat"><strong><?= $messages ?></strong><span>Contact messages</span></div>
<div class="stat"><strong><?= $pending ?></strong><span>Pending testimonials</span></div>
</div>
<div class="table-wrap"><table><thead><tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>ROLE</th><th>CREATED</th></tr></thead><tbody>
<?php foreach($recent as $row): ?>
<tr><td><?= (int)$row['id'] ?></td><td><?= e($row['name']) ?></td><td><?= e($row['email']) ?></td><td><span class="badge"><?= e($row['role']) ?></span></td><td><?= e($row['created_at']) ?></td></tr>
<?php endforeach; ?>
</tbody></table></div>
</div></main>
<footer class="footer"><div class="footer-inner"><div class="footer-brand">KAMSI <span>DIARY</span></div><div class="footer-copy">Administration • Secure session</div></div></footer>
</body>
</html>
