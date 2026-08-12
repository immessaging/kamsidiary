<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require_login();

$stmt = db()->prepare('SELECT id,title,entry_date,created_at FROM biography_entries WHERE user_id=? ORDER BY id DESC LIMIT 20');
$stmt->execute([$_SESSION['user_id']]);
$entries = $stmt->fetchAll();

$countStmt = db()->prepare('SELECT COUNT(*) FROM biography_entries WHERE user_id=?');
$countStmt->execute([$_SESSION['user_id']]);
$count = (int)$countStmt->fetchColumn();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>My Diary | Kamsi Diary</title>
<link rel="stylesheet" href="css/kamsi-pages.css">
</head>
<body>
<header class="site-header"><nav class="navbar">
<a class="brand" href="index.html"><span class="brand-mark">K<span>D</span></span><span class="brand-name">KAMSI <span>DIARY</span></span></a>
<ul class="nav-links" style="position:static;width:auto;height:auto;flex-direction:row;padding:0">
<li><a href="user-dashboard.php" class="active">MY DIARY</a></li>
<li><a href="biography.html">WRITE</a></li>
<li><a href="index.html">HOME</a></li>
<li><a href="logout.php" class="nav-cta">LOG OUT</a></li>
</ul>
</nav></header>
<main class="dashboard"><div class="container">
<div class="dashboard-head"><div><div class="eyebrow">YOUR PRIVATE SPACE</div><h1>Welcome, <?= e((string)$_SESSION['name']) ?>.</h1><p>Your story is worth keeping.</p></div><a class="btn" href="biography.html">+ WRITE A STORY</a></div>
<div class="stats">
<div class="stat"><strong><?= $count ?></strong><span>Stories saved</span></div>
<div class="stat"><strong>∞</strong><span>Legacy in progress</span></div>
<div class="stat"><strong>24/7</strong><span>Access</span></div>
<div class="stat"><strong>Private</strong><span>Your diary space</span></div>
</div>
<div class="table-wrap"><table><thead><tr><th>TITLE</th><th>ENTRY DATE</th><th>CREATED</th></tr></thead><tbody>
<?php if(!$entries): ?>
<tr><td colspan="3">No stories yet. Start writing your first chapter.</td></tr>
<?php else: foreach($entries as $row): ?>
<tr><td><?= e($row['title']) ?></td><td><?= e((string)$row['entry_date']) ?></td><td><?= e($row['created_at']) ?></td></tr>
<?php endforeach; endif; ?>
</tbody></table></div>
</div></main>
<footer class="footer"><div class="footer-inner"><div class="footer-brand">KAMSI <span>DIARY</span></div><div class="footer-copy">Your life is a story worth keeping.</div></div></footer>
</body>
</html>
